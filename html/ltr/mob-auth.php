<?php


if(isset($_GET['userid']) && isset($_GET['password']) && isset($_GET['token'])) {

    require_once 'config.php';

    $userid = $_GET['userid'];
    $pwd = $_GET['password'];
    $token = $_GET['token'];

    $sql = "SELECT * FROM `users` WHERE `roll` = '{$userid}' AND `password` = '{$pwd}' LIMIT 1";
    $result = mysqli_query($con, $sql);
    
    if(mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $sql_query = mysqli_query($con, "UPDATE `users` SET `fcm-token` = '{$token}' WHERE `id` = {$row['id']}");
        $name =$row["name"];
        $_SESSION['name'] = $name;
        $_SESSION['id'] = $row['id'];
        if($row['admin'] == 1) {
          $_SESSION['admin'] = True;
        }
    }

    header('location:login.php');


}
?>