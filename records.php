<?php 
include 'header.php';
include 'connection.php';
$count = 0;
?> 
<?php include 'dashboard.php';?>
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
              <h3 class="card-title">Records Table</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>S/N</th>
                    <th>Name</th>
                    <th>Matric Number</th>
                    <th>Card ID</th>
                    <th>Timestamp</th>
                    <th>Delete</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $query = "SELECT * FROM records ORDER BY id DESC";
                    $run_query = mysqli_query($conn, $query) or die(mysqli_error($conn));
                    if (mysqli_num_rows($run_query) > 0) {
                      while ($row = mysqli_fetch_array($run_query)) {
                        $count++;
                        $id = $row['id'];
                        $name = $row['name'];
                        $matricnum = $row['matricnum'];
                        $cardid = $row['cardid'];
                        $timestamp = $row['timestamp'];

                        echo "<tr>";
                        echo "<td>$count</td>";
                        echo "<td>$name</td>";
                        echo "<td>$matricnum</td>";
                        echo "<td>$cardid</td>";
                        echo "<td>$timestamp</td>";
                        echo "<td><a class= 'btn btn-danger btn-sm' onClick=\"javascript: return confirm('Are you sure you want to delete this post?')\" href='?del=$id'>Delete</a></td>";
                        echo "</tr>";
                      }
                    } else {
                      echo "<script>alert('No records found!'); window.location.href= 'publish.php';</script>";
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
      <!-- /.row -->
        
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
      $del_query = "DELETE FROM records WHERE id='$record_del'";
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