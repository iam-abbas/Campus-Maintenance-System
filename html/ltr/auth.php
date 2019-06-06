<?php
header('Content-type: application/json');
$response = array();

if(isset($_GET['userid']) && isset($_GET['password'])) {

    require_once 'config.php';

    $userid = $_GET['userid'];
    $pwd = $_GET['password'];

    $sql = "SELECT * FROM `users` WHERE `roll` = '{$userid}' AND `password` = '{$pwd}' LIMIT 1";
    $result = mysqli_query($con, $sql);
    
    if(mysqli_num_rows($result) == 1) {
        $response['success'] = True;

    } else {
        $response['success'] = False;
    }

    echo json_encode($response);

}
