<?php

session_start();

require_once "inc.php";
require_once "config.php";

if (!isset($_SESSION['name'])) {
  header("Location: login.php");
  die();
}

include("admin-html.php");
$id = $_SESSION['id'];
 
sethead("Complaint Information");
?>

<form method="post" action="" class="form-horizontal">
<div class="card">
  <div class="card-body">
    <h5 class="card-title">Student Specific Complaints</h5>
    <div class="form-group row">    
      <label class="col-md-3 m-t-15">Enter Student ID</label>
      <div class="col-md-9">
        <input type="text" name="id" class="form-control">
      </div>
    </div>
  </div>
  <div class="border-top">
    <div class="card-body">
    <button value="Register New Complaint" type="submit" name="submit" class="btn btn-primary">Submit</button>
    </div>
  </div>
</div>
</form>


<?php
if(isset($_POST['submit'])) {
    echo '
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Recent Complaints</h4>
        </div>
        <div class="comment-widgets scrollable">
  ';
    $uid = $_POST['id'];
    $sql = "SELECT * FROM `users` WHERE `roll` = '{$uid}'";
    $res = mysqli_query($con, $sql);
    $user_row = mysqli_fetch_assoc($res);
    $sql_query = "SELECT * FROM `complaints` WHERE `comp_by` = '{$user_row['id']}' ORDER BY `id` ASC";
    $result = mysqli_query($con,$sql_query);
    
    while($row = mysqli_fetch_assoc($result)) {

        if($row['assigned'] == 1) {
            $status = "assigned";
          } else if ($row['completed'] == 1) {
            $status = "completed";
          } else {
            $status = "pending";
          }

          //name of the user
  $comp_by = $row['comp_by'];
  $sql_query5 = "SELECT * FROM `users` WHERE `id` = '{$comp_by}' ";
  $qr = mysqli_query($con, $sql_query5);
  $namerow = mysqli_fetch_assoc($qr);

          echo '
  <div class="d-flex flex-row comment-row '.$status.' m-t-0 ">
  <div class="p-2"><img src="../../assets/images/users/1.jpg" alt="user" width="50" class="rounded-circle"></div>
  <div class="comment-text w-100">
    <h6 class="font-medium">'.$namerow['name'].'</h6>
    <span class="m-b-15 d-block">' . $row['complaint'] . ' </span>
    <div class="comment-footer">
      <span class="text-muted float-right">' . date('Y-m-d', $row['date']) . '</span> 
      <button type="button" class="btn btn-cyan btn-sm">Edit</button>
      <button type="button" class="btn btn-success btn-sm">Mark as done</button>
      <button type="button" class="btn btn-danger btn-sm">Delete</button>
    </div>
  </div>
</div>

  ';

    }

} 
include 'footer.php';
?>
