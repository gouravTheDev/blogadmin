<?php
$link = new mysqli(MYSQL_HOST,MYSQL_USER,MYSQL_PASS,MYSQL_DB);
$link->set_charset("utf8");

if(mysqli_connect_error()){
   die("ERROR: UNABLE TO CONNECT: ".mysqli_connect_error());
}
  $userId = $_SESSION['userId'];

 $sql = "SELECT * FROM BLOG_ADMIN WHERE USER_ID = '$userId'";

 $result = mysqli_query($link,$sql);

 if($result){
      if(mysqli_num_rows($result)>0){
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        $userName = $row["NAME"];
        $email = $row["EMAIL"];
        $phone = $row["PHONE"];
        $name = explode(" ", $userName);
        $userFirst = $name[0];
      }
  }
 ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="/CSS/DIZ.css" >
    <link rel="stylesheet" href="/CSS/style.css" >
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">

     <link rel="stylesheet" href="/CSS/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/CSS/dist/css/adminlte.css">
    <!-- overlayScrollbars -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- <link rel="stylesheet" href="/CSS/video.css" > -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="/JS/vue.min.js"></script>
    <script type="text/javascript" src="/JS/ckeditor/ckeditor.js"></script>


    <title>Code With Bogo - Blog Admin Panel</title>
  </head>
  <body class="hold-transition  layout-top-nav">
    <div class="wrapper">

  <!-- NAVBAR STARTS -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
      <?php if ($_SESSION['LoggedIn']): ?>
        <ul class="navbar-nav">
          <li class="nav-item" style="margin-right: 5px;">
            <a href="/" class="btn btn-outline-success">All Blogs</a>
          </li>
          <li class="nav-item" style="margin-right: 5px;">
            <a href="createBlog" class="btn btn-outline-success">Create Blog</a>
          </li>
        </ul>
      <?php endif; ?>

      </div>
     

      <!-- Right navbar links -->
      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
      <?php if ($_SESSION['LoggedIn']): ?>
       <li class="nav-item dropdown">
          <a class="btn btn-warning" data-toggle="dropdown" href="#">
            <?php echo $userFirst; ?> &nbsp;<i class="fa fa-caret-down"></i>
            <span class="badge badge-warning navbar-badge"></span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <a href="signOut" class="nav-link">Sign Out</a>
            <div class="dropdown-divider"></div>
          </div>
        </li>
        
        <?php else: ?>
          <li class="nav-item">
            <a href="signIn" class="btn btn-outline-success">Sign In</a>
          </li>
        <?php endif; ?>

      </ul>
       
      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </nav>
  <!-- /.navbar -->

   
  
  <div class="content-wrapper">
  <section class="content">
    <br>
  

