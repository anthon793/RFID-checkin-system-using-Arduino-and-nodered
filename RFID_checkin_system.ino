#include <Wire.h>
#include <LiquidCrystal_I2C.h>
#include <MFRC522.h>
#include <Servo.h>

#define SS_PIN 10   // Slave Select pin for RFID reader
#define RST_PIN 9   // Reset pin for RFID reader
#define LCD_ADDR 0x27   // I2C address of the LCD
#define SERVO_PIN 6   // Pin connected to the servo motor
#define BUZZER_PIN 5 // Pin connected to the buzzer
#define GREEN_LED_PIN 7 // Pin connected to the green LED
#define RED_LED_PIN 4  // Pin connected to the red LED

MFRC522 mfrc522(SS_PIN, RST_PIN);   // Create MFRC522 instance
LiquidCrystal_I2C lcd(LCD_ADDR, 16, 2);   // Create LCD instance
Servo servoMotor;   // Create Servo instance

struct User {
  String name;
  String matricNumber;
  String cardID;
};

User users[] = {
  //enter the name of your choice, student number and the id from your cards(RFID) here respectively
  {"John Doe", "BNG/22/7766", "133a5fad"},
  {"Jane Doe", "BNG/22/8923", "9446b028"},
  {"Johnny Doe", "BNG/22/9130", "83809c16"}
};

void setup() {
  Serial.begin(9600);
  Wire.begin();
  lcd.begin();
  servoMotor.attach(SERVO_PIN);   // Attach servo to the specified pin
  pinMode(BUZZER_PIN, OUTPUT);    // Set the buzzer pin as an output
  pinMode(GREEN_LED_PIN, OUTPUT); // Set the green LED pin as an output
  pinMode(RED_LED_PIN, OUTPUT);   // Set the red LED pin as an output

  SPI.begin();
  mfrc522.PCD_Init();

  lcd.print("Welcome");
  delay(2000);
  lcd.clear();
  lcd.print("Ready to scan");
  delay(3000);
  lcd.clear();
}

void loop() {
  if (mfrc522.PICC_IsNewCardPresent() && mfrc522.PICC_ReadCardSerial()) {
    String cardID = getCardID();
    handleCard(cardID);
    mfrc522.PICC_HaltA();
  }
}

String getCardID() {
  String cardID = "";
  for (byte i = 0; i < mfrc522.uid.size; i++) {
    cardID += String(mfrc522.uid.uidByte[i], HEX);
  }
  return cardID;
}

void handleCard(String cardID) {
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("CardID: " + cardID);

  bool validUser = false;
  for (User user : users) {
    if (cardID.equals(user.cardID)) {
      displayUserInfo(user);
      rotateServo();
      logUserAccess(user);
      indicateSuccess();
      validUser = true;
      break;
    }
  }

  if (!validUser) {
    lcd.setCursor(0, 1);
    lcd.print("Invalid User");
    activateBuzzer();
    indicateFailure();
  }
  
  delay(2000);   // Delay to stabilize the display
}

void displayUserInfo(User user) {
  lcd.setCursor(0, 1);
  lcd.print("Name: " + user.name);
  delay(3000);
  lcd.clear();
  lcd.print("Access granted!");
  delay(1000);
  lcd.clear();
}

void logUserAccess(User user) {
  Serial.print("{");
  Serial.print("\"Name\": \"" + user.name + "\", ");
  Serial.print("\"MatricNumber\": \"" + user.matricNumber + "\", ");
  Serial.print("\"CardID\": \"" + user.cardID + "\"");
  Serial.println("}");
}

void rotateServo() {
  servoMotor.write(180);
  delay(1000);
  servoMotor.write(0);
}

void activateBuzzer() {
  int alarmDuration = 2000; // Total duration of the alarm in milliseconds
  int toneDuration = 200; // Duration of each tone in milliseconds
  long endTime = millis() + alarmDuration;

  while (millis() < endTime) {
    tone(BUZZER_PIN, 1000); // Play a tone at 1000 Hz
    delay(toneDuration); // Wait for toneDuration milliseconds
    tone(BUZZER_PIN, 1500); // Play a tone at 1500 Hz
    delay(toneDuration); // Wait for toneDuration milliseconds
  }
  noTone(BUZZER_PIN); // Ensure the buzzer is turned off at the end
}

void indicateSuccess() {
  digitalWrite(GREEN_LED_PIN, HIGH); // Turn on green LED
  delay(1000);
  digitalWrite(GREEN_LED_PIN, LOW);  // Turn off green LED
}

void indicateFailure() {
  digitalWrite(RED_LED_PIN, HIGH);   // Turn on red LED
  delay(2000);                       // delay display for 2 seconds
  digitalWrite(RED_LED_PIN, LOW);    // Turn off red LED
  lcd.clear();
  lcd.print("Access denied!");
  delay(3000);
  lcd.clear();
}
