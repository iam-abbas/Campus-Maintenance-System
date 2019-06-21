<?php

require_once "inc.php";
require_once "config.php";

if (!isset($_SESSION['name'])) {
  header("Location: login.php");
  die();
}


include("html.php");
$id = $_SESSION['id'];


if (!isAdmin($id, $con)) {
  header("Location: dashboard.php");
  die();
}

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
  
  $uid = $_POST['id'];
  $sql = "SELECT * FROM `users` WHERE `roll` = '{$uid}'";
  $res = mysqli_query($con, $sql);
  $user_row = mysqli_fetch_assoc($res);
  $sql_query = "SELECT * FROM `complaints` WHERE `comp_by` = '{$user_row['id']}' ORDER BY `id` ASC";
  $result = mysqli_query($con,$sql_query);
  if(mysqli_num_rows($res) == 1) {
    echo '
    <div class="row">
    <div class="col-lg-12">
    <div class="card">
    <div class="card-body">
    <div class="float-right"><a href="exportcsv.php?userid='.$user_row['id'].'"><button type="button" class="btn btn-cyan btn-sm"><i class="fas fa-download"></i> Export as CSV File</button></a></div><br>
    <h4 class="card-title">All Complaints</h4>
    </div>
    <div class="comment-widgets scrollable">
    ';
    while($row = mysqli_fetch_assoc($result)) {
      
        //check status of the work
        if ($row['completed'] == 1) {
          $status = '<span class="float-right" style="color:#5e7fff;"><i class="fa fa-check" aria-hidden="true"></i> Completed</span>';
          } else if ($row['accepted'] == 1) {
          $status = '<span class="float-right" style="color:#68a3ff;"><i class="fas fa-check-square"></i> Accepted</span>';
          } else   if($row['assigned'] == 1) {
           $status = '<span class="float-right" style="color:#10e210;"><i class="fa fa-user" aria-hidden="true"></i> Assigned</span>';
          } else if($row['deleted'] == 1) {
          $status = '<span class="float-right" style="color:gray;"><i class="far fa-trash-alt"></i> Deleted</span>';
          } else {
          $status = '<span class="float-right" style="color:#ff2c2c;"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Pending</span>';
          }


  //name of the user
  $comp_by = $row['comp_by'];
  $sql_query5 = "SELECT * FROM `users` WHERE `id` = '{$comp_by}' ";
  $qr = mysqli_query($con, $sql_query5);
  $namerow = mysqli_fetch_assoc($qr);

  echo '
  <a style="color:inherit;text-decoration:none;" href="comps.php?cid='.$row['id'].'"><div class="d-flex flex-row comment-row m-t-0 ">
  <div class="comment-text w-100">
    '.$status.'
    <h6 class="font-medium">'.$namerow['name'].' - '.$namerow['room'].' / T'.$namerow['tower'].'</h6>
    <span class="m-b-15 d-block">' . $row['complaint'] . ' </span>
    <div class="comment-footer">
      <span class="text-muted float-right">' . date('Y-m-d', $row['date']) . '</span> 
      <button type="button" class="btn btn-cyan btn-sm">View</button>
    </div>
  </div>
</div></a>
';
      
    }
  }
} 
include 'footer.php';
?>
