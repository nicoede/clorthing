<?php 
include "../core/init.php"; 
session_start();
?>

<?php
$userimage = $_SESSION['user_image'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="../images/logo_t.png">
    <!-- CSS -->
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link href="https://fonts.googleapis.com/css?family=Piedra" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/nico.css">
    <!-- Jquery -->
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.js"></script>
    <script src="../js/scripts.js"></script>
    <title>Nico's ADMIN</title>
</head>
<body>
      
<?php 
if($_SESSION['user_role'] != 'Admin'){  
  header("Location: ../index.php");
}
?>

<nav id="p_nav" class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-header" >
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
    	<span class="icon-bar"></span>
    	<span class="icon-bar"></span>
    	<span class="icon-bar"></span>                        
      </button>
      <a class="active navbar-brand" href="index.php">ADMIN AREA</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
      	<li><a href="includes/brands.php">Brands</a><li>
  	    <li><a href="includes/categories.php">Categories</a></li>
  	    <li><a href="includes/products.php">Products</a></li>
  	    <li><a href="users.php">Users</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right" style="margin-right: 10px;">
          <li><a href="../index.php">HOME SITE</a></li>
          <li class="dropdown">
             <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo "<img height='36' style='margin-right: 5px; margin-top: -10px; margin-bottom: -10px;' src='https://s3-ap-southeast-1.amazonaws.com/nicoedeimages/clothing/{$userimage}' alt='image'>"; ?><?php echo $_SESSION['username']; ?> </b> <b class="caret" style="color:#999;"></b></a>
              <ul class="dropdown-menu">
                  <li>
                      <a href="includes/profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                  </li>
                  <li class="divider"></li>
                  <li>
                      <a href="../../includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                  </li>
              </ul>
          </li>
      </ul>
    </div>
</nav>
<div class="form-wrap" style="margin-top: 12%;">
  <div class="col-md-6 col-md-offset-3">
    <h1 class="text-center" >Welcome <?php echo $_SESSION['username']; ?>!</h1>
    <h2 class="text-center" style="margin-bottom: 50px;" >Would You Like to Do Something Related to... :</h2>
    <a class="btn btn-success btn-lg btn-block" href="includes/brands.php">Brands</a><br>
    <a class="btn btn-warning btn-lg btn-block" href="includes/categories.php">Categories</a><br>
    <a class="btn btn-primary btn-lg btn-block" href="includes/products.php">Products</a>
    <a class="btn btn-danger btn-lg btn-block" style="margin-top: 22px;" href="includes/users.php">Users</a>
  </div>
  <p class="col-text" style="margin-left:20px; visibility: hidden;">&copy; Edenilson Jonatas dos Passosssss 2017</p>
</div>

<div class="footer" style="margin-top: 500px;">
  <hr class="style-two">
  <p class="col-text" style="margin-left:20px;">&copy; Edenilson Jonatas dos Passos 2017</p>
</div>

</body>
</html>