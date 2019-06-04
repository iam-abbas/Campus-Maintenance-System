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

function isWork($id, $con) {
  $sql_query = "SELECT * FROM `users` WHERE `id` = '{$id}'";
  $result = mysqli_query($con,$sql_query);
  $row = mysqli_fetch_assoc($result);
  if($row['man_pow'] == 1) {
    return true;
  } else {
    return false;
  }
}

function sethead($str) {
echo '
  <div class="page-breadcrumb">
  <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
          <h4 class="page-title">'.$str.'</h4>
          <div class="ml-auto text-right">
              <nav aria-label="breadcrumb">
              </nav>
          </div>
      </div>
  </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
  ';
}
?>
