<?php
session_start();

require_once 'inc.php';
require_once 'config.php';

if(!isset($_SESSION['name'])) {
  header("Location: login.php");
  die();
}
include('html.php');
$id = $_SESSION['id'];
sethead("View Complaint");

if(isset($_GET['cid'])) {

  $cid = $_GET['cid'];
  if(isset($_POST['submit'])) {

    $wid = $_POST['wid'];
    $sql_query = mysqli_query($con, "UPDATE `complaints` SET `assigned` = '1', `asgn_to` = {$wid} WHERE `id` = {$cid} ");
    header('Refresh: 2; URL=dashboard.php');
    echo '<div class="alert alert-success">
    <strong>Success!</strong> Work assigned.
  </div>';

  }
  $sql_query2 = "SELECT * FROM `users` WHERE `man_pow` = '1'";
  $result2 = mysqli_query($con,$sql_query2);

  $sql_query3 = "SELECT * FROM `complaints` WHERE `id` = {$cid}";
  $result3 = mysqli_query($con,$sql_query3);
  $row = mysqli_fetch_assoc($result3);

  $sql_query4 = "SELECT * FROM `users` WHERE `id` = '{$row['comp_by']}'";
  $result4 = mysqli_query($con,$sql_query4);
  $row3 = mysqli_fetch_assoc($result4);

  if($row['assigned'] == 1) {
    $sql_query5 = "SELECT * FROM `users` WHERE `id` = '{$row['asgn_to']}'";
    $result5 = mysqli_query($con,$sql_query5);
    $row4 = mysqli_fetch_assoc($result5);

    $asgn = $row4['name'];
  } else {
    $asgn = "Not Assigned";
  }
?>

<table class="table">
  <thead class="thead-dark">
    <tr>
      <th>Name</th>
      <td><?=$row3['name']?></td>
    </tr>
    <tr>
      <th>Rollnumber</th>
      <td><?=$row3['roll']?></td>
    </tr>
    <tr>
      <th>Department</th>
      <td><?=$row['dept']?></td>
    </tr>
    <tr>
      <th>Complaint</th>
      <td><?=$row['complaint']?></td>
    </tr>
    <tr>
      <th>Room and Tower</th>
      <td><?=$row3['room']?> / T<?=$row3['tower']?></td>
    </tr>
    <tr>
      <th>Assigned To</th>
      <td><?=$asgn?></td>
    </tr>
  </thead>
</table>
<?php
  echo '
  <br><br><center>
  <form action="" method="post">
  <strong> ASSIGN WORKER</strong><br>
    <div class="form-group col-md-4">
      <select name="wid" id="inputState" class="form-control" required>
      <option value="">Choose One</option>
      ';
      while($row2 = mysqli_fetch_assoc($result2)) {
      echo '<option value="'.$row2['id'].'">'.$row2['name'].'</option>';
      }
      echo '
      </select>
    </div>

    <button value="Register New Complaint" type="submit" name="submit" class="btn btn-default">Assign The Work</button>
  </form>

  <a href="dashboard.php">Go Back To Home</a>
  </center>
  ';

}



?>
