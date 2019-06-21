<?php
ob_start();
@session_save_path("tmp");
@session_start();

$db_name = "comp_sys";
$mysql_user = "root";
$mysql_pass = "";
$server_name = "localhost";
$con = mysqli_connect($server_name,$mysql_user,$mysql_pass,$db_name);


date_default_timezone_set('Asia/Kolkata');


?>
