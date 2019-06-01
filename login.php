<?php
require_once "inc.php";
require_once "config.php";

?>

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</head>
<?php

if(isset($_POST["submit"])) {
  $user_id = $_POST["login_id"];
  $user_pass =  $_POST["login_pass"];
  $sql_query = "SELECT * FROM `users` WHERE `roll` = '{$user_id}' AND `password` = '{$user_pass}'";
  $result = mysqli_query($con,$sql_query);
  if(mysqli_num_rows($result) > 0 )
  {
    $row = mysqli_fetch_assoc($result);
    $name =$row["name"];
    session_start();
    $_SESSION['name'] = $name;
    $_SESSION['id'] = $row['id'];
    if($row['admin'] == 1) {
      $_SESSION['admin'] = True;
    }
    redirect("dashboard.php");
  }
  else
  {
    echo "Login Failed.......Try Again..";
  }
}

?>
<div class="container">
  <nav class="navbar navbar-dark bg-dark">
    <span class="navbar-brand mb-0 h1">SRM AP HOSTEL MANAGEMENT</span>
  </nav>
<div class="row">
  <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
    <div class="card card-signin my-5">
      <div class="card-body">
        <h5 class="card-title text-center">Log In</h5>
        <div class="form-label-group">

          <form method="post" autocomplete="off" action="" class="form-signin">
            <table><tr>
              <div class="form-label-group">
                <td>  <label for="uname"><b>User ID</b></label> </td>
                <td>  <input lass="form-control" type="text" placeholder="User ID" name="login_id" required>
                </div></td>
              </tr><tr><td>
                <div class="form-label-group">

                  <label for="psw"><b>Password</b></label></td><td>
                    <input lass="form-control" type="password" placeholder="Enter Password" name="login_pass" required></td></tr>
                  </table>
                </div>
                <button class="btn btn-lg btn-primary btn-block text-uppercase" name="submit" type="submit">Log in</button>   <label>
                </label>
              </div></div></div></div>
            </div>

          </form>



</div>
