<?php

require_once 'inc.php';
require_once 'config.php';



if(!isset($_SESSION['name'])) {
  header("Location: login.php");
  die();
}


$time = time();


if(!isset($_GET['cid'])) {
  header("Location: dashboard.php");
  die();
}

include('html.php');
$id = $_SESSION['id'];
sethead("View Complaint");
$asign = '';
$adminhtml = '';
$done = '';
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
if(!isAdmin($id, $con) && !isWork($id, $con)) {
  $done = '<button form="done" type="submit" name="submit" class="btn btn-default">Mark as done</button>';
  if(isset($_POST['submit'])) {
    $sql_query3 = mysqli_query($con, "UPDATE `complaints` SET `completed` = '1', `completed_date` = '{$time}' WHERE `id` = {$cid}");
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
  if($row2['assigned'] == 0) {
    $asign = '<a href="assign.php?cid='.$cid.'"><button class="btn btn-primary">Assign The Work</button></a>';
  } else {
    $asign = '<a href="assign.php?cid='.$cid.'"><button class="btn btn-primary">Re-assign The Work</button></a>';
    
  }
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
$del ='';

if($row2['completed'] == 1) {
  $status = "Completed";
} else if($row2['assigned'] == 1) {
  $status = "Assigned";
  
} else {
  $status = "Pending";
  $del = '<button type="button" class="btn btn-danger">Delete/Decline</button>';
}

if($row2['accepted'] == 1) {
  $status = "Work under progress.";
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
          <?=$done?>
          <?=$asign?>
          <?=$del?>
          
        </div>
      </div>
    </div>
  </div>
  
  
  
  <?php
  
  if(isset($_POST['post-comment'])) {
    $by_id = $id;
    $comment = $_POST['comment'];
    $comp_id = $cid;
    $time = time();
    
    $get_sql ="SELECT * FROM `comments` WHERE `comp_id` = '{$comp_id}' ORDER BY `id` DESC LIMIT 1";
    $get_result = mysqli_query($con, $get_sql);
    $get_row = mysqli_fetch_assoc($get_result);
    
    if(!isAdmin($id, $con)) {
      $previous_comment = $get_row['time'];
      $new_time = time() - $previous_comment;
      $time_left = (60*5)-$new_time;
      echo '  <div class="modal fade" id="Modal1" tabindex="-1" style="display: none;">
      <div class="modal-dialog" role="document ">
      <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Slowdown !</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true ">×</span>
      </button>
      </div>
      <div class="modal-body">
      Wait for '.timeLeft($time_left).' before you can comment again.
      </div>
      </div>
      </div>
      </div>';
      
      if($new_time < (5*60)) {
        echo '
        <script>
        var modal = document.getElementById("Modal1");
        modal.style.display = "block";
        modal.className = "modal fade show";
        document.body.className = "modal-open";
        </script>
        ';
        
      } else {
        $sql_query = "INSERT INTO `comments` (`comment`, `comp_id`, `by_id`, `time`)
        VALUES ('{$comment}', '{$comp_id}', '{$by_id}', '{$time}')";
        $result = mysqli_query($con, $sql_query);
      }
      
    } else {
      $sql_query = "INSERT INTO `comments` (`comment`, `comp_id`, `by_id`, `time`)
      VALUES ('{$comment}', '{$comp_id}', '{$by_id}', '{$time}')";
      $result = mysqli_query($con, $sql_query);
    }
    
    
    
  }
  $sql = "SELECT * FROM `comments` WHERE `comp_id` = '{$cid}'";
  $result = mysqli_query($con, $sql);
  $btn = '';
  if(mysqli_num_rows($result) > 0) {
    echo '
    <div class="card">
    <div class="card-body">
    <h4 class="card-title">Comments</h4>
    </div>
    <div class="comment-widgets scrollable ps-container ps-theme-default" data-ps-id="2bf68fec-07af-68ca-cf25-65b819c23210">
    ';
    
    while($row = mysqli_fetch_assoc($result)) {
      $name = getName($row['by_id'], $con);
      $comment = $row['comment'];
      $span = '';
      if(isAdmin($row['by_id'], $con)) {
        $span = "<span style='color:#ff0000'> (Admin)</span>";
      }
      
      echo '
      <div class="d-flex flex-row comment-row">
      <div class="comment-text active w-100">
      <h6 class="font-medium">'.$name.' '.$span.'</h6>
      <span class="m-b-15 d-block">'.$comment.' </span>
      <div class="comment-footer">
      <span class="text-muted float-right">'.timeago($row['time']).'</span> 
      </div>
      </div>
      </div>
      ';
      
    }
    
    echo '                            
    <div class="card-body border-top">
    <div class="row">
    <div class="col-9">
    <form method="post">
    <div class="input-field m-t-0 m-b-0">
    <textarea id="textarea1" placeholder="Type and enter" name="comment" class="form-control border-0" required></textarea>
    </div>
    </div>
    <div class="col-3">
    
    <button type="submit" style="border:none" name="post-comment" class="btn-circle btn-lg btn-cyan float-right text-white"><i class="fas fa-paper-plane"></i></button>
    </form>
    </div>
    </div>
    </div>
    </div>';
  } else {
    echo '
    <div class="card">
    <div class="card-body">
    <h4 class="card-title">Comments</h4>
    </div>
    <div class="comment-widgets scrollable ps-container ps-theme-default" data-ps-id="2bf68fec-07af-68ca-cf25-65b819c23210">
    <div class="d-flex flex-row comment-row">
    <div class="comment-text active w-100">
    <center>No Comments Yet..</center>
    </div>
    </div>
    <div class="card-body border-top">
    <div class="row">
    <div class="col-9">
    <form method="post">
    <div class="input-field m-t-0 m-b-0">
    <textarea id="textarea1" placeholder="Type and enter" name="comment" class="form-control border-0" required></textarea>
    </div>
    </div>
    <div class="col-3">
    
    <button type="submit" style="border:none" name="post-comment" class="btn-circle btn-lg btn-cyan float-right text-white"><i class="fas fa-paper-plane"></i></button>
    </form>
    </div>
    </div>
    </div>
    </div>
    
    
    
    
    ';
  }
  include "footer.php";
  
?>
