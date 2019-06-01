<?php
session_start();

require_once 'inc.php';
require_once 'config.php';

if(!isset($_SESSION['name'])) {
  header("Location: login.php");
  die();
}



if(isset($_GET['cid'])) {

  include('html.php');
  $id = $_SESSION['id'];
  sethead("View Complaint");
  $asign = '';
  $adminhtml = '';
  $cid = $_GET['cid'];
  $sql_query2 = "SELECT * FROM `complaints` WHERE `id` = '{$cid}' LIMIT 1 ";
  $result2 = mysqli_query($con, $sql_query2);
  $row2 = mysqli_fetch_assoc($result2);
  if(!isAdmin($id, $con) && !isWork($id, $con)) {
    if($id != $row2['comp_by']) {
      header("Location: dashboard.php");
      die();
    }
  }
  $sql_query = "SELECT * FROM `users` WHERE `id` = '{$row2['comp_by']}'";
  $result = mysqli_query($con,$sql_query);
  $row = mysqli_fetch_assoc($result);
  $asgn = "Not Assigned";
  if($row2['assigned'] == 1) {
    $sql_query5 = "SELECT * FROM `users` WHERE `id` = '{$row2['asgn_to']}'";
    $result5 = mysqli_query($con,$sql_query5);
    $row4 = mysqli_fetch_assoc($result5);

    $asgn = $row4['name'];
  }

  if(isAdmin($id, $con)) {
    $asign = '<a href="assign.php?cid='.$cid.'"><button class="btn btn-primary">Assign The Work</button></a>';
    $adminhtml = "
    <tr>
      <th>Degree</th>
      <td>".$row['deg']."</td>
    </tr>
    <tr>
      <th>Course</th>
      <td>".$row['crs']."</td>
    </tr>
    <tr>
      <th>Assigned To</th>
      <td>".$asgn."</td>
    </tr>
    ";
  }
  if(isset($_POST['submit'])) {
    $sql_query3 = mysqli_query($con, "UPDATE `complaints` SET `completed` = '1' WHERE `id` = {$cid}");
    header("Location: dashboard.php");
    die();
  }
  if($row2['completed'] == 1) {
    $status = "Completed";
  } else {
    $status = "Pending";
  }
?>

<table class="table">
  <thead class="thead-dark">
    <tr>
      <th>Name</th>
      <td><?=$row['name']?></td>
    </tr>
    <?=$adminhtml?>
    <tr>
      <th>Rollnumber</th>
      <td><?=$row['roll']?></td>
    </tr>
    <tr>
      <th>Department</th>
      <td><?=$row2['dept']?></td>
    </tr>
    <tr>
      <th>Complaint</th>
      <td><?=$row2['complaint']?></td>
    </tr>
    <tr>
      <th>Status</th>
      <td><?=$status?></td>
    </tr>
    <tr>
      <th>Room and Tower</th>
      <td><?=$row['room']?> / T<?=$row['tower']?></td>
    </tr>
  </thead>
</table>
<center>
  <form method="post" name="done">
    <button  type="submit" name="submit" class="btn btn-default">Mark as done</button>
  </form>
  <?=$asign?>
<br><br>
  <a href="dashboard.php">Go Back</a>
</center>
<?php
} else {
  header("Location: dashboard.php");
  die();
}
?>
