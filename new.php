<?php
session_start();

require_once 'inc.php';
require_once 'config.php';

if(!isset($_SESSION['name'])) {
  header("Location: login.php");
  die();
}

include('html.php');
$id = $_SESSION['id'];
sethead("Submit a new complaint.");
if(isset($_POST['submit'])) {

$date = time();
$complaint = $_POST['complaint'];
$dept = $_POST['dept'];

$sql_query = "INSERT INTO `complaints` (`comp_by`, `date`, `complaint`, `dept`)
VALUES ('{$id}', '{$date}', '{$complaint}', '{$dept}')";
$result = mysqli_query($con,$sql_query);
if($result) {
  header('Refresh: 2; URL=dashboard.php');
  echo '<div class="alert alert-success">
  <strong>Success!</strong> Your complaint has been registered.
</div>';

 }

} else {
  echo '
  <form action="" method="post">
  <div class="form-group col-md-4">
      <label >Enter your Complaint:</label>
      <textarea rows="4" cols="50" name="complaint" class="form-control" required></textarea>
    </div>
    <div class="form-group col-md-4">
      <label for="inputState">State</label>
      <select name="dept" id="inputState" class="form-control" required>
      <option value="">Choose One</option>
      <option value="HVAC">HVAC</option>
      <option value="ELECTRICAL">ELECTRICAL</option>
      <option value="PLUMBING">PLUMBING</option>
      <option value="CARPENTRY AND CIVIL">CARPENTRY AND CIVIL</option>
      <option value="HOUSE KEEPING">HOUSE KEEPING</option>
      <option value="OTHER FACILITY REALTED">OTHER FACILITY RELATED</option>
      </select>
    </div>
    <button value="Register New Complaint" type="submit" name="submit" class="btn btn-default">Submit</button>
  </form>
  ';
}
include('footer.php');


?>
