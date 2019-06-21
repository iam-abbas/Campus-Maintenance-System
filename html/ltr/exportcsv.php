<?php 

require_once "inc.php";
require_once "config.php";


if(isset($_GET['userid'])) {
$userid = $_GET['userid'];
$sql_query = "SELECT * FROM `complaints` WHERE `comp_by` = '{$userid}' ORDER BY `id` ASC";
$query = mysqli_query($con,$sql_query);

  if(mysqli_num_rows($query) > 0){
    $delimiter = ",";
    $filename = $userid."_" . date('Y-m-d') . ".csv";
    
    //create a file pointer
    $f = fopen('php://memory', 'w');
    
    //set column headers
    $fields = array('S.No', 'Complaints', 'Department', 'Date and Time', 'Status', 'Assigned To', 'Assigned On', 'Completed On');
    fputcsv($f, $fields, $delimiter);
    $count = 0;
    //output each row of the data, format line as csv and write to file pointer
    while($row = mysqli_fetch_assoc($query)){
        $count = $count+1;
        $completed_on = "Not Completed";
        $assigned_on = "Not Assigned";

        $assigned_to = "Not Assigned";

        if($row['completed'] == 1) {
            $status = "Completed";
            $completed_on = DateAndTime($row['completed_date']);
            $assigned_on = DateAndTime($row['assigned_date']);
            $accepted_on = DateAndTime($row['accepted_date']);
        } else if($row['accepted'] == 1) {
            $status = "Accepted";
            $accepted_on = DateAndTime($row['accepted_date']);
            $assigned_on = DateAndTime($row['assigned_date']);
        } else if($row['assigned'] == 1) {
            $status = "Assigned";
            $assigned_on = DateAndTime($row['assigned_date']);
        } else if($row['deleted'] == 1) {
            $status = "Deleted";
        } else if($row['decline'] == 1) {
            $status = "Declined";
        } else {
            $status = "Pending";
        }

        $user_query = "SELECT * FROM `users` WHERE `id` = '{$row['asgn_to']}' ";
        $result = mysqli_query($con, $user_query);
        $user_data = mysqli_fetch_assoc($result);

        $lineData = array($count, $row['complaint'], $row['dept'], DateAndTime($row['date']), $status, $user_data['roll'], $assigned_on, $completed_on);
        fputcsv($f, $lineData, $delimiter);
    }
    
    //move back to beginning of file
    fseek($f, 0);
    
    //set headers to download file rather than displayed
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');
    
    //output all remaining data on a file pointer
    fpassthru($f);
}  
}

if(isset($_GET['workerid'])) {
    $userid = $_GET['workerid'];
    $sql_query = "SELECT * FROM `complaints` WHERE `asgn_to` = '{$userid}' ORDER BY `id` ASC";

$query = mysqli_query($con,$sql_query);

  if(mysqli_num_rows($query) > 0){
    $delimiter = ",";
    $filename = $userid."_" . date('Y-m-d') . ".csv";
    
    //create a file pointer
    $f = fopen('php://memory', 'w');
    
    //set column headers
    $fields = array('S.No', 'Complaints', 'Department', 'Date and Time', 'Status', 'Accepted On', 'Assigned On', 'Completed On');
    fputcsv($f, $fields, $delimiter);
    $count = 0;
    //output each row of the data, format line as csv and write to file pointer
    while($row = mysqli_fetch_assoc($query)){
        $count = $count+1;

        $completed_on = "Not Completed";
        $assigned_on = "Not Assigned";
        $accepted_on = "Not Accepted";

        if($row['completed'] == 1) {
            $status = "Completed";
            $completed_on = DateAndTime($row['completed_date']);
            $assigned_on = DateAndTime($row['assigned_date']);
            $accepted_on = DateAndTime($row['accepted_date']);
        } else if($row['accepted'] == 1) {
            $status = "Accepted";
            $accepted_on = DateAndTime($row['accepted_date']);
            $assigned_on = DateAndTime($row['assigned_date']);
        } else if($row['assigned'] == 1) {
            $status = "Assigned";
            $assigned_on = DateAndTime($row['assigned_date']);
        } else if($row['deleted'] == 1) {
            $status = "Deleted";
        } else if($row['decline'] == 1) {
            $status = "Declined";
        } else {
            $status = "Pending";
        }

        $user_query = "SELECT * FROM `users` WHERE `id` = '{$row['asgn_to']}' ";
        $result = mysqli_query($con, $user_query);
        $user_data = mysqli_fetch_assoc($result);

        $lineData = array($count, $row['complaint'], $row['dept'], DateAndTime($row['date']), $status, $accepted_on, $assigned_on, $completed_on);
        fputcsv($f, $lineData, $delimiter);
    }
    
    //move back to beginning of file
    fseek($f, 0);
    
    //set headers to download file rather than displayed
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');
    
    //output all remaining data on a file pointer
    fpassthru($f);
}  
}


if(isset($_GET['from']) && isset($_GET['to'])) {


    $from = $_GET['from'];
    $to = $_GET['to'];

    $sql_query = "SELECT * FROM `complaints` WHERE `date` BETWEEN '{$from}' AND '{$to}' ";
    $query = mysqli_query($con,$sql_query);

  if(mysqli_num_rows($query) > 0){
    $delimiter = ",";
    $filename = date('Y-m-d', $from)."_".date('Y-m-d', $to) . ".csv";
    
    //create a file pointer
    $f = fopen('php://memory', 'w');
    
    //set column headers
    $fields = array('S.No', 'Complaints', 'Department', 'Date and Time', 'Status', 'Accepted On', 'Assigned On', 'Completed On');
    fputcsv($f, $fields, $delimiter);
    $count = 0;
    //output each row of the data, format line as csv and write to file pointer
    while($row = mysqli_fetch_assoc($query)){
        $count = $count+1;

        $completed_on = "Not Completed";
        $assigned_on = "Not Assigned";
        $accepted_on = "Not Accepted";

        if($row['completed'] == 1) {
            $status = "Completed";
            $completed_on = DateAndTime($row['completed_date']);
            $assigned_on = DateAndTime($row['assigned_date']);
            $accepted_on = DateAndTime($row['accepted_date']);
        } else if($row['accepted'] == 1) {
            $status = "Accepted";
            $accepted_on = DateAndTime($row['accepted_date']);
            $assigned_on = DateAndTime($row['assigned_date']);
        } else if($row['assigned'] == 1) {
            $status = "Assigned";
            $assigned_on = DateAndTime($row['assigned_date']);
        } else if($row['deleted'] == 1) {
            $status = "Deleted";
        } else if($row['decline'] == 1) {
            $status = "Declined";
        } else {
            $status = "Pending";
        }

        $user_query = "SELECT * FROM `users` WHERE `id` = '{$row['asgn_to']}' ";
        $result = mysqli_query($con, $user_query);
        $user_data = mysqli_fetch_assoc($result);

        $lineData = array($count, $row['complaint'], $row['dept'], DateAndTime($row['date']), $status, $accepted_on, $assigned_on, $completed_on);
        fputcsv($f, $lineData, $delimiter);
    }
    
    //move back to beginning of file
    fseek($f, 0);
    
    //set headers to download file rather than displayed
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');
    
    //output all remaining data on a file pointer
    fpassthru($f);
}      


}

?>