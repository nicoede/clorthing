<?php 
include "../../core/init.php";
session_start(); ?>

<?php
$query = "SELECT user_image FROM users WHERE username = '{$_SESSION['username']}'";
$query_result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($query_result);
$userimage = $row['user_image'];
?>

<nav id="p_nav" class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
    	<span class="icon-bar"></span>
    	<span class="icon-bar"></span>
    	<span class="icon-bar"></span>                        
      </button>
      <a class="active navbar-brand" href="../index.php" >ADMIN AREA</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
      	<li><a href="brands.php">Brands</a><li>
  	    <li><a href="categories.php">Categories</a></li>
  	    <li><a href="products.php">Products</a></li>
  	    <li><a href="users.php">Users</a></li>
      </ul>
      <?php if($_SESSION['username'] == ''){ ?>
      <ul class="nav navbar-nav navbar-right" style="margin-right: 20px;">
        <li><a href="signup.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
        <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
      </ul>
      <?php
      }
      if($_SESSION['username'] != ''){
      ?>
      <ul class="nav navbar-nav navbar-right" style="margin-right: 10px;">
          <li><a href="../../index.php">HOME SITE</a></li>
          <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo "<img height='36' style='margin-right: 5px; margin-top: -10px; margin-bottom: -10px;' src='https://s3-ap-southeast-1.amazonaws.com/nicoedeimages/clothing/{$userimage}' alt='image'>"; ?><?php echo $_SESSION['username']; ?> </b> <b class="caret" style="color:#999;"></b></a>
              <ul class="dropdown-menu">
                  <li>
                    <?php if($_SESSION['user_role'] == 'Admin'){ ?>
                      <a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                    <?php }elseif($_SESSION['user_role'] == 'Subscriber'){ ?>
                      <a href="../../profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                    <?php } ?>
                  </li>
                  <li class="divider"></li>
                  <li>
                      <a href="../../includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                  </li>
              </ul>
          </li>
      </ul>
      <?php } ?>
    </div>
</nav>