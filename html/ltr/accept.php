<?php

require_once 'inc.php';
require_once 'config.php';
require_once 'fcm.php';

if(!isWork($_SESSION['id'], $con)) {
  redirect('dashboard.php');
  die();
}

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
  $id = $_SESSION['id'];
  $cid = $_GET['cid'];
  
  $sql_query = "SELECT * FROM `complaints` WHERE `id` = '{$cid}' LIMIT 1 ";
  $result = mysqli_query($con, $sql_query);


  if(mysqli_num_rows($result) < 1) {
    redirect($url);
    exit(0);
  }

  $time = time();
  $row = mysqli_fetch_assoc($result);
  $query =  "UPDATE `complaints` SET  `accepted` = '1', `accepted_date` ='{$time}' WHERE `id` = '{$cid}' LIMIT 1";
  $exec = mysqli_query($con, $query);
  redirect($url);
}
?>