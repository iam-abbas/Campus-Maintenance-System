<?php
require_once 'inc.php';
require_once 'config.php';
require_once 'fcm.php';

if(!isAdmin($_SESSION['id'], $con)){
  header("Location: login.php");
  die();
  }

$time = time();

if(!isset($_SESSION['name'])) {
  header("Location: login.php");
  die();
}

include('html.php');
$id = $_SESSION['id'];
sethead("View Complaint");

if(isset($_GET['cid'])) {

  $cid = $_GET['cid'];
  if(isset($_POST['submit'])) {

    $wid = $_POST['wid'];
    $sql_query = mysqli_query($con, "UPDATE `complaints` SET `assigned` = '1', `assigned_date` = '{$time}', `asgn_to` = {$wid} WHERE `id` = {$cid} ");
    $sql = "SELECT * FROM `users` WHERE `id` = '{$wid}'";
    $result_work = mysqli_query($con, $sql);
    $row_work = mysqli_fetch_assoc($result_work);
    if(!empty($row_work['fcm-token'])) {
    sendFCM("You have recieved a Job", "Click here to view", $row_work['fcm-token']);
    }
    echo '<div class="alert alert-success" role="alert">
    <h4 class="alert-heading">Success!</h4>
    <p>Worker has been successfully Assigned. Worker has been notified if he/she doesn\'t accept the work. You will Get a Notofocation</p>
    <hr>
    <p class="mb-0"><a href="dashboard.php">Return to Dashboard</a></p>
  </div>';

  }
  $sql_query2 = "SELECT * FROM `users` WHERE `man_pow` = '1'";
  $result2 = mysqli_query($con,$sql_query2);

  $sql_query3 = "SELECT * FROM `complaints` WHERE `id` = {$cid}";
  $result3 = mysqli_query($con,$sql_query3);
  $row = mysqli_fetch_assoc($result3);

  $sql_query4 = "SELECT * FROM `users` WHERE `id` = '{$row['comp_by']}'";
  $result4 = mysqli_query($con,$sql_query4);
  $row3 = mysqli_fetch_assoc($result4);

  if($row['assigned'] == 1) {
    $sql_query5 = "SELECT * FROM `users` WHERE `id` = '{$row['asgn_to']}'";
    $result5 = mysqli_query($con,$sql_query5);
    $row4 = mysqli_fetch_assoc($result5);

    $asgn = $row4['name'];
  } else {
    $asgn = "Not Assigned";
  }
?>
<div class="row">
  <div class="col-12">
    <div class="card">
    <div class="card-body">
<h5 class="card-title m-b-0">Complaint Information</h5>
</div>
<table class="table table-striped table-bordered dataTable">
    <tr>
      <th scope="col">Name</th>
      <td><?=$row3['name']?></td>
    </tr>
    <tr>
      <th scope="col">Rollnumber</th>
      <td><?=$row3['roll']?></td>
    </tr>
    <tr>
      <th scope="col">Department</th>
      <td><?=$row['dept']?></td>
    </tr>
    <tr>
      <th scope="col">Complaint</th>
      <td><?=$row['complaint']?></td>
    </tr>
    <tr>
      <th scope="col">Room and Tower</th>
      <td><?=$row3['room']?> / T<?=$row3['tower']?></td>
    </tr>
    <tr>
      <th scope="col">Assigned To</th>
      <td><?=$asgn?></td>
    </tr>
  </thead>
</table>
<?php
  echo '
      <div class="card-body">
        <form action="" method="post"  class="form-horizontal">
        <div class="form-group row">    
        <label class="col-md-3 m-t-15">Assign Someone</label>
        <div class="col-md-9">
      <select name="wid" id="inputState" class="select2 form-control custom-select" style="width: 100%; height:36px;" required>
      <option value="">Choose One</option>
      ';
      while($row2 = mysqli_fetch_assoc($result2)) {
      echo '<option value="'.$row2['id'].'">'.$row2['name'].'</option>';
      }
      echo '
      </select>
      </div>

      <div class="card-body">
      <button value="Assign Work" type="submit" name="submit" class="btn btn-primary">Assign The Work</button>
      </div>
  </form>
  </div>
  </div>


  ';

}

include "footer.php";

?>
