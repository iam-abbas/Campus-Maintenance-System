<?php
require_once "config.php";
require_once "inc.php";

if (!isset($_SESSION['name'])) {
  redirect("login.php");
}

include("html.php");
$id = $_SESSION['id'];

/* Do not touch above this */

$sql_query = "SELECT * FROM `users` WHERE `id` = '{$id}'";
$result = mysqli_query($con, $sql_query);
$row = mysqli_fetch_assoc($result);

//let's do pagination
if (isset($_GET['pageno'])) {
  $pageno = $_GET['pageno'];
} else {
  $pageno = 1;
}

if($pageno < 1) {
  $pageno = 1;
}
$no_of_records_per_page = 5;
$offset = ($pageno-1) * $no_of_records_per_page;

$extrabtn = '';
$del = '';
$priority = '';
//Check if user is admin/worker/student
if ($row['admin'] == 1) {
  $total_pages_sql = "SELECT COUNT(*) FROM `complaints` WHERE `completed` = '0' AND `deleted` = '0' ";
  $result = mysqli_query($con, $total_pages_sql);
  $total_rows = mysqli_fetch_array($result)[0];
  $total_pages = ceil($total_rows / $no_of_records_per_page);
  $sql_query2 = "SELECT * FROM `complaints` WHERE `completed` = '0' AND `deleted` = '0' ORDER BY `id` DESC LIMIT $offset, $no_of_records_per_page ";
  $result2 = mysqli_query($con, $sql_query2);
} else if ($row['man_pow'] == 1) {
  $total_pages_sql = "SELECT COUNT(*) FROM `complaints` WHERE `asgn_to` = '{$id}' AND `accepted` = '0'";
  $result = mysqli_query($con, $total_pages_sql);
  $total_rows = mysqli_fetch_array($result)[0];
  $total_pages = ceil($total_rows / $no_of_records_per_page);
  $sql_query2 = "SELECT * FROM `complaints` WHERE `asgn_to` = '{$id}' AND `accepted` = '0' LIMIT $offset, $no_of_records_per_page ";
  $result2 = mysqli_query($con, $sql_query2);
} else {
  $total_pages_sql = "SELECT COUNT(*) FROM `complaints` WHERE `comp_by` = '{$id}' AND `completed` = '0' AND `deleted` = '0' ";
  $result = mysqli_query($con, $total_pages_sql);
  $total_rows = mysqli_fetch_array($result)[0];
  $total_pages = ceil($total_rows / $no_of_records_per_page);
  $sql_query2 = "SELECT * FROM `complaints` WHERE `comp_by` = '{$id}' AND `completed` = '0' AND `deleted` = '0' ORDER BY `id` DESC LIMIT $offset, $no_of_records_per_page ";
  $result2 = mysqli_query($con, $sql_query2); 
}
//heading of the page
sethead("Dashboard");



//basic html intiation
echo '
<div class="row">
<div class="col-lg-12">
<div class="card">
<div class="card-body">
<h4 class="card-title">Recent Complaints</h4>
</div>
<div class="comment-widgets scrollable">
';

//finding all the complaints
while ($row2 = mysqli_fetch_assoc($result2)) {
  
  if(isAdmin($id, $con)) {
    $prty = $row2['priority'];
    if($prty > 0) {
    $priority = '<span style="color: #ff0000;padding-left: 10px;"><i class="fas fa-arrow-up"></i> '.$prty.'</span>';
    }  
  }
 

  if($row2['completed'] == '1') {
    $priority = '';
    $status = '<span class="float-right" style="color:#5e7fff;"><i class="fa fa-check" aria-hidden="true"></i> Completed</span>';
  } else if($row2['accepted'] == '1') {
    $status = '<span class="float-right" style="color:#68a3ff;"><i class="fas fa-check-square"></i> Accepted</span>';
    $extrabtn = '';
    $del = '';
  } else if($row2['assigned'] == '1') {
    $status = '<span class="float-right" style="color:#10e210;"><i class="fa fa-user" aria-hidden="true"></i> Assigned</span>';
    if(isWork($id, $con)) {
      $del = '<a href="delete.php?cid='.$row2['id'].'&action=decline&url=dashboard.php"><button type="button" class="btn btn-danger btn-sm">Decline</button></a>';
      $extrabtn = '<a href="accept.php?cid='.$row2['id'].'&url=dashboard.php"><button type="button" class="btn btn-primary btn-sm">Accept</button></a>';
    }
  } else {
    if(isAdmin($id, $con)) {
 
      $del = ' <a href="delete.php?cid='.$row2['id'].'&action=decline&url=dashboard.php"><button type="button" class="btn btn-danger btn-sm">Decline</button></a>';
    } else {
      $del = '<a href="delete.php?cid='.$row2['id'].'&action=delete&url=dashboard.php"><button type="button" class="btn btn-danger btn-sm">Delete</button></a>';
    }
    $status = '<span class="float-right" style="color:#ff2c2c;"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Pending</span>';
  }
  

  
  //name of the user
  $comp_by = $row2['comp_by'];
  $sql_query5 = "SELECT * FROM `users` WHERE `id` = '{$comp_by}' ";
  $qr = mysqli_query($con, $sql_query5);
  $namerow = mysqli_fetch_assoc($qr);
  
  echo '
  <a style="color:inherit;text-decoration:none;" href="comps.php?cid='.$row2['id'].'"><div class="d-flex flex-row comment-row m-t-0 ">
  <div class="comment-text w-100">
  '.$status.'
  <h6 class="font-medium">'.$namerow['name'].' - '.$namerow['room'].' / T'.$namerow['tower'].' '.$priority.'</h6>
  <span class="m-b-15 d-block">' . $row2['complaint'] . ' </span>
  <div class="comment-footer">
  <span class="text-muted float-right">' . date('Y-m-d', $row2['date']) . '</span> 
  <button type="button" class="btn btn-cyan btn-sm">View</button>
  '.$extrabtn.'
  '.$del.'
  </div>
  </div>
  </div></a>
  ';
}
//if there are no complaints
if (mysqli_num_rows($result2) < 1) {
  echo '<center>You do not have any complaints</center>';
}

//pagenation


echo '
<div class="col-md-4 mx-auto float-right">
<nav aria-label="...">
<ul class="pagination  float-right">
<li class="page-item">
<a class="page-link" href="?pageno='.($pageno-1).'" >Previous</a>
</li>';

for ($i=1; $i<=$total_pages; $i++) {
  if($pageno == $i) {
    echo'<li class="page-item active"><a class="page-link" href="?pageno='.$i.'">'.$i.'</a></li>';
  } else {
    echo'<li class="page-item"><a class="page-link" href="?pageno='.$i.'">'.$i.'</a></li>';
  }
}
echo '
<li class="page-item">
<a class="page-link" href="?pageno='.($pageno+1).'">Next</a>
</li>
</ul>
</nav>
</div>
</div></div></div></div>
';


if(isWork($id, $con)) {
  
  //basic html intiation
  echo '
  <div class="row">
  <div class="col-lg-12">
  <div class="card">
  <div class="card-body">
  <h4 class="card-title">Accepted Jobs</h4>
  </div>
  <div class="comment-widgets scrollable">
  ';
  
  $sql_worker = "SELECT * FROM `complaints` WHERE `asgn_to` = '{$id}' AND `accepted` = '1' ";
  $result_worker = mysqli_query($con, $sql_worker);
  if(mysqli_num_rows($result_worker) < 1) {
    echo '
    <div class="card-body"><center>You have no Pending Jobs to Complete !</center></div>';
  }
  
  //finding all the complaints
  
  $status = '<span class="float-right" style="color:#68a3ff;"><i class="fas fa-check-square"></i> Accepted</span>';
  
  //name of the user
  
  
  while ($row2 = mysqli_fetch_assoc($result_worker)) {
    $comp_by = $row2['comp_by'];
    $sql_query5 = "SELECT * FROM `users` WHERE `id` = '{$comp_by}' ";
    $qr = mysqli_query($con, $sql_query5);
    $namerow = mysqli_fetch_assoc($qr);
    $prty = $row2['priority'];
    if($prty > 0) {
    $priority = '<span style="color: #ff0000;padding-left: 10px;"><i class="fas fa-arrow-up"></i> '.$prty.'</span>';
    }  
    echo '
    <a style="color:inherit;text-decoration:none;" href="comps.php?cid='.$row2['id'].'"><div class="d-flex flex-row comment-row m-t-0 ">
    <div class="comment-text w-100">
    '.$status.'
    <h6 class="font-medium">'.$namerow['name'].' - '.$namerow['room'].' / T'.$namerow['tower'].' '.$priority.'</h6>
    <span class="m-b-15 d-block">' . $row2['complaint'] . ' </span>
    <div class="comment-footer">
    <span class="text-muted float-right">' . date('Y-m-d', $row2['date']) . '</span> 
    <button type="button" class="btn btn-cyan btn-sm">View</button>
    </div>
    </div>
    </div></a>
    ';
  }
  echo '</div></div></div></div>';
}



//news

if(!isAdmin($id, $con)) {
echo '
<div class="card">
  <div class="card-body">
    <h4 class="card-title m-b-0">News Updates</h4>
  </div>
  <ul class="list-style-none">
';

$sql_news = mysqli_query($con, "SELECT * FROM `news_feed` ORDER BY `id` DESC LIMIT 6");
while($row = mysqli_fetch_assoc($sql_news)) {

    echo '
    <li class="d-flex no-block card-body">
    <i class="fas fa-chevron-circle-right w-30px m-t-5"></i>
    <div>
        <a href="#" class="m-b-0 font-medium p-0">'.$row['title'].'</a>
        <span class="text-muted">'.$row['feed'].'</span>
    </div>
    <div class="ml-auto">
        <div class="tetx-right">
        <h5 class="text-muted m-b-0">'.date('j', $row['time']).'</h5>
        <span class="text-muted font-16" style="font-weight: 600;" >'.date('M', $row['time']).'</span>
        </div>
    </div>
    </li>
    ';
}

echo '
  </ul>
</div>
';
}

include("footer.php")

?>
