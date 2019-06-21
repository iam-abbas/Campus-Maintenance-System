<?php
require_once 'inc.php';
require_once 'config.php';

if (!isset($_SESSION['name'])) {
  header("Location: login.php");
  die();
}

if(!isAdmin($_SESSION['id'], $con)){
    header("Location: login.php");
    die();
    }
    
include('html.php');

$id = $_SESSION['id'];
sethead("Update News");

if (isset($_POST['submit'])) {


    $title = $_POST['title'];
    $feed = $_POST['feed'];
    $date = time();

    $sql_query = "INSERT INTO `news_feed` (`title`, `feed`, `time`)
    VALUES ('{$title}', '{$feed}', '{$date}')";
    $result = mysqli_query($con, $sql_query);
    if ($result) {
        echo '<div class="alert alert-success" role="alert">
        <h4 class="alert-heading">Success!</h4>
        <p>Successfully added to News Feed.</p>
        </div>';
    }
  
  
  
  
} else {
  echo '
  <form method="post" action="" class="form-horizontal">
  <div class="card">
  <div class="card-body">
  <h5 class="card-title">Add to News Feed.</h5>
  <div class="form-group row">    
  <label class="col-md-3 m-t-15">Enter Title</label>
  <div class="col-md-9">
  <input type="text" name="title" id="title" class="form-control" required>
  </div>
  </div>
  <div class="form-group row">    
  <label class="col-md-3 m-t-15">Enter Body of News</label>
  <div class="col-md-9">
  <textarea name="feed" id="feed" class="form-control" required></textarea>
  </div>
  </div>
  </div>
  <div class="border-top">
  <div class="card-body">
  <button value="Add to News" type="submit"  name="submit" class="btn btn-primary">Submit</button>
  </div>
  </div>
  </div>
  </form>
  ';
}

include('footer.php');

?>



