<?php
session_start();

require_once "inc.php";
require_once "config.php";

if (!isset($_SESSION['name'])) {
  header("Location: login.php");
  die();
}
if (!isAdmin($_SESSION['id'], $con)) {
    header("Location: login.php");
    die();
}


include("admin-html.php");
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





  $total_pages_sql = "SELECT COUNT(*) FROM `complaints` WHERE `completed` = '0'";
  $result = mysqli_query($con, $total_pages_sql);
  $total_rows = mysqli_fetch_array($result)[0];
  $total_pages = ceil($total_rows / $no_of_records_per_page);
  
  $sql_query2 = "SELECT * FROM `complaints` WHERE `completed` = '0' ORDER BY `assigned` ASC LIMIT $offset, $no_of_records_per_page ";
  $result2 = mysqli_query($con, $sql_query2);

//heading of the page
sethead("Admin Dashboard");



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

  //check status of the work
  if ($row2['assigned'] == 1) {
    $status = "assigned";
  } else if ($row2['completed'] == 1) {
    $status = "completed";
  } else {
    $status = "pending";
  }

  //name of the user
  $comp_by = $row2['comp_by'];
  $sql_query5 = "SELECT * FROM `users` WHERE `id` = '{$comp_by}' ";
  $qr = mysqli_query($con, $sql_query5);
  $namerow = mysqli_fetch_assoc($qr);

  echo '
  <a style="color:inherit;text-decoration:none;" href="comps.php?cid='.$row2['id'].'"><div class="d-flex flex-row comment-row '.$status.' m-t-0">
  <div class="p-2"><img src="../../assets/images/users/1.jpg" alt="user" width="50" class="rounded-circle"></div>
  <div class="comment-text w-100">
    <h6 class="font-medium">'.$namerow['name'].'</h6>
    <span class="m-b-15 d-block">' . $row2['complaint'] . ' </span>
    <div class="comment-footer">
      <span class="text-muted float-right">' . date('Y-m-d', $row2['date']) . '</span> 
      <button type="button" class="btn btn-cyan btn-sm">Appoint Worker</button>
      <button type="button" class="btn btn-danger btn-sm">Decline</button>
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
<div class="col-sm-12 col-md-7">
<nav aria-label="...">
<ul class="pagination">
  <li class="page-item ">
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
include("footer.php")

?>
