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
    $adminhtml = '
    <tr>
      <th scope="col">Degree</th>
      <td>'.$row['deg'].'</td>
    </tr>
    <tr>
      <th scope="col">Course</th>
      <td>'.$row['crs'].'</td>
    </tr>
    <tr>
      <th scope="col">Assigned To</th>
      <td>'.$asgn.'</td>
    </tr>
    ';
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
<div class="row">
  <div class="col-12">
    <div class="card">
    <div class="card-body">
<h5 class="card-title m-b-0">Complaint Information</h5>
</div>
<table class="table table-striped table-bordered dataTable">
    <tr>
      <th scope="col">Name</th>
      <td><?=$row['name']?></td>
    </tr>
    <?=$adminhtml?>
    <tr>
      <th scope="col">Rollnumber</th>
      <td><?=$row['roll']?></td>
    </tr>
    <tr>
      <th scope="col">Department</th>
      <td><?=$row2['dept']?></td>
    </tr>
    <tr>
      <th scope="col">Complaint</th>
      <td><?=$row2['complaint']?></td>
    </tr>
    <tr>
      <th scope="col">Status</th>
      <td><?=$status?></td>
    </tr>
    <tr>
      <th scope="col">Room and Tower</th>
      <td><?=$row['room']?> / T<?=$row['tower']?></td>
    </tr>
</table>
<div class="card-body">
<h4 class="card-title m-b-0">Take Action</h5>

  <form method="post" id="done" name="done" style="max-width:100px">
  </form>
    <button form="done" type="submit" name="submit" class="btn btn-default">Mark as done</button>

  <?=$asign?>
  <button type="button" class="btn btn-danger">Decline</button>

</div>
<br><br>

<?php
include "footer.php";

} else {
  header("Location: dashboard.php");
  die();
}
?>
