<?php
function redirect($url)
{
   header('Location: ' . $url);
   die();
}

function isAdmin($id, $con) {
  $sql_query = "SELECT * FROM `users` WHERE `id` = '{$id}'";
  $result = mysqli_query($con,$sql_query);
  $row = mysqli_fetch_assoc($result);
  if($row['admin'] == 1) {
    return true;
  } else {
    return false;
  }
}
function sethead($str) {
  echo '<div class="jumbotron"><h2>'.$str.'</h2></div>';
}
?>
