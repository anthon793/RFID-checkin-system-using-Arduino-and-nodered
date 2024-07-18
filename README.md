RFID Based Check-in System using Arduino, RFID MFRC522 Module, and Node-RED

Introduction
Traditional check-in systems often rely on manual processes that are prone to errors and time-consuming. To overcome these challenges, we developed an RFID Based Checkin System using Arduino, RFID MFRC522 Module, and Node-RED. This system automates the check-in process using RFID cards issued to users.

What is RFID?
RFID (Radio Frequency Identification) is a technology where digital data stored in RFID tags is captured by a reader via radio waves, facilitating quick and contactless identification.

Components Used
Arduino Uno Board
RFID MFRC522 module
Node-RED (flow-based development tool)
SD card module
Real Time Clock (RTC) module (DS1307 or DS3231)
LCD display (20x4) with I2C module
Components Wiring to Arduino Uno
RFID MFRC522
Pin	Wiring to Arduino Uno
SDA	Digital 10
SCK	Digital 13
MOSI	Digital 11
MISO	Digital 12
IRQ	Unconnected
GND	GND
RST	Digital 9
3.3V	3.3V
Caution: Ensure the device is powered at 3.3V.

Real Time Clock (RTC) Module
Pin	Wiring to Arduino Uno
SCL	A5
SDA	A4
VCC	5V
GND	GND
SD Card Module
Pin	Wiring to Arduino Uno
VCC	3.3V or 5V (check datasheet)
CS	4
MOSI	11
CLK	13
MISO	12
GND	GND
I2C Module (Character LCD)
Pin	Wiring to Arduino Uno
GND	GND
VCC	5V
SDA	A4
SCL	A5
Integration with Node-RED
Node-RED is used to enhance the functionality of the Checkin System:

Real-time Data Processing: Utilize Node-RED flows to process and analyze check-in data from the RFID reader.
Dashboard Visualization: Create a web-based dashboard to display real-time check-in information.
Automation: Automate notifications or alerts based on check-in events using email or SMS nodes in Node-RED.
Database Integration: Store check-in records in a database for further reporting and analysis.
To integrate with Node-RED:

Install Node-RED on your computer or a server.
Utilize MQTT or HTTP nodes to communicate with the Arduino board.
Develop flows to handle and process check-in data received from the RFID reader.
Implement dashboard nodes to visualize check-in information and statistics.
For more information on Node-RED, visit Node-RED website.

Usage
Setup: Connect all components as per the wiring instructions.
Upload Code: Upload the provided Arduino sketch to your Arduino board.
Node-RED Integration: Configure Node-RED flows to enhance functionality as described above.
Operation: The system will display "Ready to scan" on the LCD. Users can scan their RFID cards to check-in.
Logging: Check-in data can be logged to an SD card and displayed on the LCD