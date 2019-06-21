<?php

$id = $_SESSION['id'];
$sql_query = "SELECT * FROM `users` WHERE `id` = '{$id}'";
$result = mysqli_query($con,$sql_query);
$row = mysqli_fetch_assoc($result);
$name = $row['name'];

include 'update.php';

if(isAdmin($id, $con)) {
    $html = '
    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="admin-dashboard.php" aria-expanded="false"><i class="fas fa-chart-pie"></i><span class="hide-menu">Dashboard</span></a></li>
    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="dashboard.php" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Complaints</span></a></li>
    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="admin-comp.php" aria-expanded="false"><i class="fas fa-search"></i><span class="hide-menu">User Stats</span></a></li>
    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="manpow.php" aria-expanded="false"><i class="fas fa-users"></i><span class="hide-menu"> Manpower Stats</span></a></li>
    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="admin-data.php" aria-expanded="false"><i class="fas fa-database"></i><span class="hide-menu">Complaint Database</span></a></li>
    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="news.php" aria-expanded="false"><i class="far fa-newspaper"></i><span class="hide-menu">Update News</span></a></li>
    ';
} else if(isWork($id, $con)) {
    $html = '
    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="dashboard.php" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span></a></li>
    ';
} else {
    $html = '
    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="dashboard.php" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span></a></li>
    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="new.php" aria-expanded="false"><i class="fas fa-edit"></i><span class="hide-menu">New Complaint</span></a></li>
    ';
}
echo '
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <!-- Favicon icon -->
  <link rel="icon" type="image/png" sizes="16x16" href="https://srmap.edu.in/file/2017/04/cropped-SRM-LogoR-1-32x32.png">
  <title>SRM Maintenance</title>
  <!-- Custom CSS -->
  <link href="../../assets/libs/flot/css/float-chart.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link href="../../dist/css/style.min.css" rel="stylesheet">
  <link href="../../dist/css/custom-style.css" rel="stylesheet">
  <link href="../../assets/libs/toastr/build/toastr.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="../../assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">


</head>

<body>
  <!-- ============================================================== -->
  <!-- Preloader - style you can find in spinners.css -->
  <!-- ============================================================== -->
  
  <!-- ============================================================== -->
  <!-- Main wrapper - style you can find in pages.scss -->
  <!-- ============================================================== -->
  <div id="main-wrapper">
    <!-- ============================================================== -->
    <!-- Topbar header - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <header class="topbar" data-navbarbg="skin5">
      <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <div class="navbar-header" data-logobg="skin5">
          <!-- This is for the sidebar toggle which is visible on mobile only -->
          <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
          <!-- ============================================================== -->
          <!-- Logo -->
          <!-- ============================================================== -->
          <a class="navbar-brand" href="dashboard.php">
            <!-- Logo icon -->
            <b class="logo-icon p-l-10">
              <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
              <!-- Dark Logo icon -->
              <!-- <img src="../../assets/images/logo-icon.png" alt="homepage" class="light-logo" />-->
              
            </b>
            <!--End Logo icon -->
            <!-- Logo text -->
            <span class="logo-text">
              <!-- dark Logo text -->
              <img src="../../assets/images/logo-text.png" alt="homepage" style="height:60px;" class="light-logo" />
              
            </span>
            <!-- Logo icon -->
            <!-- <b class="logo-icon"> -->
            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
            <!-- Dark Logo icon -->
            <!-- <img src="../../assets/images/logo-text.png" alt="homepage" class="light-logo" /> -->
            
            <!-- </b> -->
            <!--End Logo icon -->
          </a>
          <!-- ============================================================== -->
          <!-- End Logo -->
          <!-- ============================================================== -->
          <!-- ============================================================== -->
          <!-- Toggle which is visible on mobile only -->
          <!-- ============================================================== -->
          <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
          <!-- ============================================================== -->
          <!-- toggle and nav items -->
          <!-- ============================================================== -->
          <ul class="navbar-nav float-left mr-auto">
            <li class="nav-item d-none d-md-block"><a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>
            <!-- ============================================================== -->
            <!-- create new -->
            <!-- ============================================================== -->
            
          </ul>
          
          <div class="float-left" style="
          padding: 18px; color: #fff;
          "><h4>Welcome Back, '.$name.'</h4></div>
          <!-- ============================================================== -->
          <!-- Right side toggle and nav items -->
          <!-- ============================================================== -->
        </div>
      </nav>
    </header>
    
    <aside class="left-sidebar" data-sidebarbg="skin5">
      <!-- Sidebar scroll-->
      <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
          <ul id="sidebarnav" class="p-t-30">
            
            '.$html.'
            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="logout.php" aria-expanded="false"><i class="fas fa-sign-out-alt"></i><span class="hide-menu">Logout</span></a></li>

          </ul>
        </nav>
        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
    </aside>
    <!-- ============================================================== -->
    <!-- End Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
      <!-- ============================================================== -->
      <!-- Bread crumb and right sidebar toggle -->
      <!-- ============================================================== -->

';

?>



