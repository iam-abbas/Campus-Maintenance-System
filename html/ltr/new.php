<?php
require_once 'inc.php';
require_once 'config.php';

if (!isset($_SESSION['name'])) {
  header("Location: login.php");
  die();
}

include('html.php');

$id = $_SESSION['id'];
sethead("New Complaint");
if (isset($_POST['submit'])) {
  $date = time();
  $complaint = $_POST['complaint'];
  if(checkForBadwords($complaint)) {
    echo '<div class="alert alert-danger" role="alert">
    Bad Words detected in your input please refrain from using such words.
    </div>';
  } else { 
    $dept = $_POST['dept'];
    $sql_query = "INSERT INTO `complaints` (`comp_by`, `date`, `complaint`, `dept`)
    VALUES ('{$id}', '{$date}', '{$complaint}', '{$dept}')";
    $result = mysqli_query($con, $sql_query);
    if ($result) {
      echo '<div class="alert alert-success" role="alert">
      <h4 class="alert-heading">Success!</h4>
      <p>Your complaint has been succesfully submited. Our men have been notified. Thank You for informing us.</p>
      <hr>
      <p class="mb-0">If you have anymore complaints. <a href="new.php">Let us know now.</a></p>
      </div>';
    }
  }
  
  
  
} else {
  echo '
  <form method="post" action="" class="form-horizontal">
  <div class="card">
  <div class="card-body">
  <h5 class="card-title">Submit Your Complaint.</h5>
  <div class="form-group row">    
  <label class="col-md-3 m-t-15">Enter Your Complaint</label>
  <div class="col-md-9">
  <textarea name="complaint" id="complaint" onkeyup="checkProfanity()" class="form-control" required></textarea>
  </div>
  </div>
  <div class="form-group row">    
  <label class="col-md-3 m-t-15">Department</label>
  <div class="col-md-9">
  <select name="dept" class="select2 form-control custom-select" style="width: 100%; height:36px;" required>
  <option value="">Select</option>
  <optgroup label="Department">
  <option value="HVAC">HVAC</option>
  <option value="ELECTRICAL">ELECTRICAL</option>
  <option value="PLUMBING">PLUMBING</option>
  <option value="CARPENTRY AND CIVIL">CARPENTRY AND CIVIL</option>
  <option value="HOUSE KEEPING">HOUSE KEEPING</option>
  <option value="OTHER FACILITY RELATED">OTHER FACILITY RELATED</option>
  </optgroup>
  </select>
  </div>
  </div> 
  </div>
  <div class="border-top">
  <div class="card-body">
  <button value="Register New Complaint" type="submit" onsubmit="return Message();" name="submit" class="btn btn-primary">Submit</button>
  </div>
  </div>
  </div>
  </form>
  ';

  echo '  <div class="modal fade" id="Modal1" tabindex="-1" style="display: none;">
  <div class="modal-dialog" role="document ">
  <div class="modal-content">
  <div class="modal-header">
  <h5 class="modal-title" id="exampleModalLabel">Badwords Detected</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true ">×</span>
  </button>
  </div>
  <div class="modal-body">
  Please do not use fould words or there will be an action.
  </div>
  </div>
  </div>
  </div>';
}

include('footer.php');

?>



