<?php 
include "core/init.php"; 
session_start();
?>

<?php
$query = "SELECT user_image FROM users WHERE username = '{$_SESSION['username']}'";
$query_result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($query_result);
$userimage = $row['user_image'];
?>

<nav id="p_nav" class="navbar navbar-inverse navbar-fixed-top" >
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
    	<span class="icon-bar"></span>
    	<span class="icon-bar"></span>
    	<span class="icon-bar"></span>                        
      </button>
      <a style="vertical-align: middle; display: inline-block;" class="active navbar-brand" href="index.php">Nico's Boutique</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul id="ul_menu" class="nav navbar-nav">
      <?php
      $categories_query = "SELECT * FROM categories WHERE categories_parent = 0";
      $categories_query_result = mysqli_query($connection, $categories_query);
      while($row = mysqli_fetch_assoc($categories_query_result)){
        $parent_id = $row['categories_id'];
        $category = $row['categories_category'];
        
        $child_query = "SELECT * FROM categories WHERE categories_parent = $parent_id ORDER BY categories_category";
        $child_query_result = mysqli_query($connection, $child_query);
      ?>  
    	<li class="dropdown">
    	    <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $category; ?><span class="caret"></span></a>
    	    <ul class="dropdown-menu" role="menu">
    	      <?php while($row2 = mysqli_fetch_assoc($child_query_result)){ 
    	              $categories2 = $row2['categories_category'];
    	      ?>
    	        
    	        <li><a href="includes/<?php echo strtolower($category); ?>_<?php echo strtolower($categories2); ?>.php#<?php echo strtolower($categories2); ?>"><?php echo $categories2; ?></a></li>
    	      <?php } ?>
    	    </ul>
    	    
    	</li>
    	
    	<?php } ?>
      <li><a href="#featured">Featured</a><li>
    	
      </ul>
      
      <?php if($_SESSION['username'] == ''){ ?>
      <ul class="nav navbar-nav navbar-right" style="margin-right: 20px;">
        <li><a style="vertical-align: middle;" href="signup.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
        <li><a style="vertical-align: middle;" href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
      </ul>
      <?php
      }
      if($_SESSION['username'] != ''){
      ?>
      <ul class="nav navbar-nav navbar-right" style="margin-right: 10px;">
        <?php if($_SESSION['user_role'] == 'Admin'){ ?>
          <li style="vertical-align: middle;"><a href="admin/">ADMIN</a><li>
            <?php } ?>
          <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo "<img height='36' style='margin-right: 5px; margin-top: -10px; margin-bottom: -10px;' src='https://s3-ap-southeast-1.amazonaws.com/nicoedeimages/clothing/{$userimage}' alt='image'>"; ?><?php echo $_SESSION['username']; ?> </b> <b class="caret" style="color:#999;"></b></a>
              <ul class="dropdown-menu">
                  <li>
                    <?php if($_SESSION['user_role'] == 'Admin'){ ?>
                    <a href="../admin/includes/profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                    <?php }elseif($_SESSION['user_role'] == 'Subscriber'){ ?>
                      <a href="includes/profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                    <?php } ?>
                  </li>
                  <li class="divider"></li>
                  <li>
                      <a href="../includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                  </li>
              </ul>
          </li>
      </ul>
      <?php } ?>
    </div>
</nav>