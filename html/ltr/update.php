<?php

require_once 'inc.php';
require_once 'config.php';
require_once 'fcm.php';

$sql = "SELECT * FROM `complaints` WHERE `assigned` = '1' AND `accepted` != '1'";
$result = mysqli_query($con, $sql);

while($row = mysqli_fetch_assoc($result)) {
  $pre_date = (3600 + $row['assigned_date']);
  
  $time = time();
  if($time >= $pre_date) {
    $sql_update = "UPDATE `complaints` SET `assigned` = '0', `assigned_date` = '', `asgn_to` = '' WHERE `id` = '{$row['id']}'";
    $exec = mysqli_query($con, $sql_update);
    
    $user_sql = "SELECT * FROM `users` WHERE `id` = '{$row['asgn_to']}'";
    $row_user = mysqli_fetch_assoc(mysqli_query($con, $user_sql));
    
    $tokens = getAdminTokens($con);
    foreach($tokens as $token) {
      sendFCM("".$row_user['name']."Failed to Accept the Job", "Click here to assign to someone else", $token);
    }
  }
}

$sql_p = "SELECT * FROM `complaints` WHERE `accepted` = '1' AND `completed` = '0'";
$result = mysqli_query($con, $sql_p);
while($row = mysqli_fetch_assoc($result)) {
  $pre_date = ((3600*24)*($row['priority']+1) + $row['assigned_date']);
  $time = time();
  if($time >= $pre_date) {
    $prty = $row['priority']+1;
    $sql_update = "UPDATE `complaints` SET `priority` = '{$prty}' WHERE `id` = '{$row['id']}'";
    $exec = mysqli_query($con, $sql_update);
  }
}

?>