<?php 
include ('connection.php');
include "header.php";
$count = 0;
?> 

<?php include "dashboard.php"; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Information</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">DataTables</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Users Table</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>S/N</th>
                    <th>Username</th>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Email</th>
                    <th>Delete</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $query = "SELECT * FROM users";
                    $select_users = mysqli_query($conn, $query) or die(mysqli_error($conn));
                    if (mysqli_num_rows($select_users) > 0) {
                      while ($row = mysqli_fetch_array($select_users)) {
                        $count++;
                        $user_id = $row['id'];
                        $username = $row['username'];
                        $user_firstname = $row['firstname'];
                        $user_lastname = $row['lastname'];
                        $user_email = $row['email'];
                        echo "<tr>";
                        echo "<td>$count</td>";
                        echo "<td>$username</td>";
                        echo "<td>$user_firstname</td>";
                        echo "<td>$user_lastname</td>";
                        echo "<td>$user_email</td>";
                        echo "<td><a class='btn btn-danger' onClick=\"javascript: return confirm('Are you sure you want to delete this user?')\" href='users.php?delete=$user_id'>Delete</a></td>";
                        echo "</tr>";
                      }
                    }
                  ?>
                </tbody>
              </table>
             
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
     <!-- Main row -->
     <div class="row">
          
          </div>
          <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
  
    <?php
      if (isset($_GET['del'])) {
        $record_del = mysqli_real_escape_string($conn, $_GET['del']);
        $del_query = "DELETE FROM users WHERE id='$record_del'";
        $run_del_query = mysqli_query($conn, $del_query) or die (mysqli_error($conn));
        if (mysqli_affected_rows($conn) > 0) {
          echo "<script>alert('Record deleted successfully'); window.location.href='records.php';</script>";
        } else {
          echo "<script>alert('Error occurred. Try again!');</script>";   
        }
      }
    ?>
  
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <strong>Copyright &copy;</strong>
      All rights reserved.
    </footer>
  
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  
    <?php
    
  include("footer.php");
  
  ?>