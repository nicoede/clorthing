<?php 
include "header.php";
include "../core/init.php"; 
include "navigation_inc.php";
?>

<nav id="p_nav" class="navbar navbar-inverse navbar-fixed-top" style="margin-bottom: -20px;">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
    	<span class="icon-bar"></span>
    	<span class="icon-bar"></span>
    	<span class="icon-bar"></span>                        
      </button>
      <a class="active navbar-brand" href="../index.php" >Nico's Boutique</a>
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
    	        
    	        <li><a href="<?php echo strtolower($category); ?>_<?php echo strtolower($categories2); ?>.php#<?php echo strtolower($categories2); ?>"><?php echo $categories2; ?></a></li>
    	      <?php } ?>
    	    </ul>
    	    
    	</li>
    	<?php } ?>
    	
      </ul>
      <ul class="nav navbar-nav navbar-right" style="margin-right: 20px;">
        <li><a href="../signup.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
        <li><a href="../login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
      </ul>
    </div>
</nav>

  <section id="home">
    <div id="headerWrapper">
        <div id="back-flower"></div>
        <div id="logotext"></div>
        <div id="fore-flower"></div>
    </div>
  </section>
  
  
  <section id="shoes">
    <div class="container-fluid font">
      <div class="col-md-2"></div>
      <div class="col-md-8">
          <div class="row">
              <h2 class="text-center" style="margin-bottom: 40px; margin-top: 100px;"><b> Female Shoes </b></h2>
    <?php 
    $acessories_query = "SELECT * FROM products JOIN categories WHERE products_categories = categories_id AND categories_category LIKE '%Shoes%' AND categories_parent = 2 ";
    $accessories_query_result = mysqli_query($connection, $acessories_query);
    $count = mysqli_num_rows($accessories_query_result);
    if($count == 0){
      echo "<h2 class='text-center' style='margin-bottom: 40px;'><b> There are no products registered in this section </b></h2>";
    }else{
    while($row = mysqli_fetch_assoc($accessories_query_result)){
      $products_id = $row['products_id'];
      $products_title = $row['products_title'];
      $products_price = $row['products_price'];
      $products_list_price = $row['products_list_price'];
      $products_brand = $row['products_brand'];
      $products_categories = $row['products_categories'];
      $products_image = $row['products_image'];
      $products_description = $row['products_description'];
      $products_featured = $row['products_featured'];
      $products_sizes = $row['products_sizes'];
      
      
    ?>
    
    <div class="col-md-3" style="margin-top: 40px;">
      <h4 font-family: 'Trade Winds', cursive; ><?php echo $products_title; ?></h4>
      <img src="https://s3-ap-southeast-1.amazonaws.com/nicoedeimages/clothing/<?php echo $products_image; ?>" alt="<?php echo $products_title; ?>" width="120px" height="140px"/>
      <p class="list-price text-danger">List Price: <s>$<?php echo $products_list_price; ?></s></p>
      <p class="price">Our Price: $<?php echo $products_price; ?></p>
       <button type="button" class="btn btn-md btn-success" style="background-color: black; border: black;" onclick='detailsmodal(<?php echo $products_id; ?>)'>Details</button>
    </div>
    
    <?php } ?>
      </div>
  </div>
  
  <div class="col-md-2"></div>
            
            
        <?php  
            }
        ?>
        </div>
    
    </div>
  </section>
    
  <?php include "footer.php"; ?>