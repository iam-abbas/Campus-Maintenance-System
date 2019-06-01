<?php
session_start();

require_once "inc.php";
require_once "config.php";

if(!isset($_SESSION['name'])) {
  header("Location: login.php");
  die();
}

include("html.php");
$id = $_SESSION['id'];

$sql_query = "SELECT * FROM `users` WHERE `id` = '{$id}'";
$result = mysqli_query($con,$sql_query);
$row = mysqli_fetch_assoc($result);

if($row['admin'] == 1) {
  $sql_query2 = "SELECT * FROM `complaints` WHERE `completed` = '0'  ORDER BY `assigned` ASC";
  $result2 = mysqli_query($con,$sql_query2);
} else if($row['man_pow'] == 1) {
  $sql_query2 = "SELECT * FROM `complaints` WHERE `asgn_to` = '{$id}' ";
  $result2 = mysqli_query($con,$sql_query2);
} else {
  $sql_query2 = "SELECT * FROM `complaints` WHERE `comp_by` = '{$id}' AND `completed` = '0' ";
  $result2 = mysqli_query($con,$sql_query2);

}
$butn = '<a href="new.php"><button style="border-radius:0; width:100%;" type="button" class="btn btn-primary"><i class="fas fa-plus"></i> New Complaint</button></a><br><br>';
if($row['admin'] == 1 || $row['man_pow'] == 1) {
  $butn = '';
}

sethead("Dashboard");
echo $butn;
echo '
<div class="table-responsive">
<table class="table table-striped">
<thead>
<tr>
<th>Date</th>
<th>Complaint</th>
<th>Status</th>
</tr>
</thead>
<tbody>
';
while($row2 = mysqli_fetch_assoc($result2)) {
  if($row2['assigned'] == 1) {
    $status = "Assigned";
  } else if($row2['completed'] == 1) {
    $status = "Completed";
  } else {
    $status = "Pending";
  }
  echo "<tr>";
  echo "<td>".date('Y-m-d', $row2['date'])."</td>";
  echo '<td><a href="comps.php?cid='.$row2['id'].'">'.$row2['complaint'].'</a></td>';
  echo "<td>".$status."</td>";

  echo "</tr>";
}
echo "</table></div>";
if(mysqli_num_rows($result2) < 1) { echo '<center>You do not have any complaints</center>';}

include("footer.php");


?>
