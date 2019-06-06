<?php
require_once 'config.php';

$_SESSION = array();
session_regenerate_id(true);

header("location:login.php");
exit();
?>
