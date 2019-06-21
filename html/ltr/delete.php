<?php

require_once 'inc.php';
require_once 'config.php';
require_once 'fcm.php';

if(isset($_GET['url'])) {
  $url = $_GET['url'];
} else {
  $url = "dashboard.php";
}
if(!isset($_SESSION['name'])) {
  header("Location: login.php");
  die();
}


if(isset($_GET['cid'])) {
  
  include('html.php');
  $id = $_SESSION['id'];
  $cid = $_GET['cid'];
  
  $sql_query = "SELECT * FROM `complaints` WHERE `id` = '{$cid}' LIMIT 1 ";
  $result = mysqli_query($con, $sql_query);
  if(mysqli_num_rows($result) < 1) {
    
    redirect($url);
    exit(0);
  }
  $row = mysqli_fetch_assoc($result);
    if($row['comp_by'] == $id || isAdmin($id, $con) || isWork($id, $con)) {
      if(isset($_GET['action']) && $_GET['action'] == 'decline') {
        $query =  "UPDATE `complaints` SET  `deleted` = '1' WHERE `id` = '{$cid}' LIMIT 1";
        if(isWork($id, $con)) {
            $tokens = getAdminTokens($con);
            $query =  "UPDATE `complaints` SET  `decline` = '1', `assigned` ='0', `asgn_to` = '' WHERE `id` = '{$cid}' LIMIT 1";
            sendFCM("Work Declined by ".$_SESSION['name']."!", "Click here to Re-assign", $tokens);
        } 
      } else {
        if($row['completed'] == 0 && $row['assigned'] == 0) {
        $query =  "UPDATE `complaints` SET  `deleted` = '1' WHERE `id` = '{$cid}' LIMIT 1";
        }
      }
      $exec = mysqli_query($con, $query);
      redirect($url);
    } else {
     redirect($url);
    }

  
}
?>