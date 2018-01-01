<?php
include "../../core/init.php";
?>

<?php
include "../../s3/init.php";

  if(isset($_GET['edit'])){
    $the_product_id = $_GET['edit'];
    
    $query = "SELECT * FROM products WHERE products_id = $the_product_id ";
    $select_product_by_id = mysqli_query($connection, $query);
    
    while($row = mysqli_fetch_assoc($select_product_by_id)){
      $product_title = $row['products_title'];
      $product_price = $row['products_price'];
      $product_list_price = $row['products_list_price'];
      $product_brand = $row['products_brand'];
      $product_category_id = $row['products_categories'];
      $product_image = $row['products_image'];
      $product_description = $row['products_description'];
      $product_featured = $row['products_featured'];
      $product_sizes = $row['products_sizes'];
    }
    $product_image_1 = $product_image;
  }

  if(isset($_POST['udpate_product'])){
    $file = $_FILES['image'];
  
    $name = $file['name'];
    if($name !== ''){
      $file = $_FILES['image'];
  
      $name = $file['name'];
      $tmp_name = $file['tmp_name'];
      
      $ext = explode('.', $name);
      $ext = strtolower(end($ext));
      
      $key = md5(uniqid());
      
      $temp_file_name = "{$key}.{$ext}";
      
      $temp_file_path = "clothing/{$temp_file_name}";
      
      move_uploaded_file($tmp_name, $temp_file_path);
      
      try {
        // Upload data.
        $result = $s3->putObject(array(
           'Bucket'=> $config['s3']['bucket'],
            'Key'   => "clothing/{$name}",
            'Body'  => fopen($temp_file_path, 'rb'),
            'ACL'   => 'public-read'
       ));
      
        // Print the URL to the object.
      } catch (S3Exception $e) {
          echo $e->getMessage() . "\n";
      }
      unlink($temp_file_path);
      $product_image = $_FILES['image']['name'];
      $product_image_tmp = $_FILES['image']['tmp_name'];
    }else{
      $product_image = $product_image_1;
    }
    
    $product_title = $_POST['product_name'];
    $product_featured = $_POST['featured'];
    $product_price = $_POST['price'];
    $product_list_price = $_POST['list_price'];
    $product_brand = $_POST['brand'];
    $product_category = $_POST['category_id'];
    $product_description = $_POST['product_description'];
    $product_sizes = $_POST['product_sizes'];
    
    
    
    if($product_featured == 1){
      $query = "UPDATE products SET products_title = '{$product_title}', products_featured = {$product_featured}, products_price = {$product_price}, ";
      $query .= "products_list_price = {$product_list_price}, products_brand = {$product_brand}, products_categories = {$product_category}, ";
      $query .= "products_image = '{$product_image}', products_description = '{$product_description}', products_sizes = '{$product_sizes}' WHERE products_id = $the_product_id ";
      $query_result = mysqli_query($connection, $query);
    }else{
      $query = "UPDATE products SET products_title = '{$product_title}', products_featured = {$product_featured}, products_price = {$product_price}, ";
      $query .= "products_brand = {$product_brand}, products_categories = {$product_category}, products_image = '{$product_image}', ";
      $query .= "products_description = '{$product_description}', products_sizes = '{$product_sizes}' WHERE products_id = $the_product_id ";
      $query_result = mysqli_query($connection, $query);
    }
    
    confirm($query_result);
    
    header("Refresh: 0.1; url=products.php");
  }
  
?>

<div id="edit_product" class="">
        <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h2 class="text-center" style="margin-bottom: 50px;">Edit Product</h2>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="product_name">Product Name</label>
                            <input value="<?php echo $product_title; ?>" type="text"class="form-control" name="product_name"/>
                        </div>
                        <div class="form-group">
                          <label for="price">Featured</label>
                          <select class="form-control" name="featured" onchange="yesnoCheck(this);">
                            <option value="<?php echo $product_featured; ?>"><?php if($product_featured == 1){ echo 'Yes'; }else{ echo 'No'; }?></option>
                            <?php
                              if($product_featured == 1){
                                echo "<option value='0'>No</option>";
                              }else{
                                echo "<option value='1'>Yes</option>";
                              }
                            ?>
                          </select>
                        </div>
                        <script>
                          function yesnoCheck(that) {
                              if (that.value == '1') {
                                  document.getElementById("ifYes").style.display = "block";
                              } else {
                                  document.getElementById("ifYes").style.display = "none";
                              }
                          }
                        </script>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="text" name="price" id="price" class="form-control" value="<?php echo $product_price; ?>">
                        </div>
                        <?php if($product_featured == 1){ $display = 'block'; }else{  $display='none'; }?>
                        <div id="ifYes" class="form-group" style="display: <?php echo $display;  ?>;">
                            <label for="list_price" style="color: red;">List Price</label>
                            <input type="text" name="list_price" id="list_price" class="form-control" value="<?php echo $product_list_price; ?>">
                        </div>
                        <div class="form-group">
                          <label for="post_category">Sex</label>
                          <select class="form-control" name="category_sex" onchange="catsex(this);">
                            <?php 
                            $query = "SELECT * FROM categories WHERE categories_id = $product_category_id";
                            $query_result = mysqli_query($connection, $query);
                            while($row3 = mysqli_fetch_assoc($query_result)){
                              $categoryId = $row3['categories_id'];
                              $categoryName= $row3['categories_category'];
                              $categoryParent = $row3['categories_parent'];
                            }
                            ?>
                            <option value="<?php echo $categoryParent; ?>"><?php if($categoryParent == 1){ echo 'Men'; }else{ echo 'Women'; } ?></option>
                             <?php
                              if($categoryParent == 1){
                                echo "<option value='2'>Women</option>";
                              }else{
                                echo "<option value='1'>Men</option>";
                              }
                            ?>
                          </select>
                        </div>
                        <script>
                          function catsex(that) {
                              if (that.value == '1') {
                                  document.getElementById("displayMen").style.display = "block";
                                  document.getElementById("displayWomen").style.display = "none";
                              }else if(that.value == ''){
                                  document.getElementById("displayWomen").style.display = "none";
                                  document.getElementById("displayMen").style.display = "none";
                              }else {
                                  document.getElementById("displayWomen").style.display = "block";
                                  document.getElementById("displayMen").style.display = "none";
                              }
                          }
                        </script>
                        <?php if($categoryParent == 1){ $display1 = 'block'; $display2='none'; }else{  $display1='none'; $display2='none';}?>
                        <div id="displayMen" class="form-group" style="display: <?php echo $display1; ?>;">
                          <label for="post_category" style="color: blue;">Category</label>
                          <select class="form-control" name="category_id" id="">
                            <option value="<?php echo $product_category_id; ?>"><?php echo $categoryName; ?></option>
                            <?php
                              $query = "SELECT * FROM categories WHERE categories_parent = 1 ORDER BY categories_category";
                              $select_categories = mysqli_query($connection, $query);
                              
                              confirm($select_categories);
                              
                              while($row = mysqli_fetch_assoc($select_categories)){
                                $categories_id = $row['categories_id'];
                                $categories_category = $row['categories_category'];
                                echo "<option value='$categories_id'>{$categories_category}</option>";
                              }  
                            ?>
                          </select>
                        </div>
                        <?php if($categoryParent == 2){ $display2 = 'block'; $display1 = 'none'; }else{  $display2='none'; $display1 = 'none'; }?>
                        <div id="displayWomen" class="form-group" style="display: <?php echo $display2; ?>;">
                          <label for="post_category" style="color: blue;">Category</label>
                          <select class="form-control" name="category_id" id="">
                            <option value="<?php echo $product_category_id; ?>"><?php echo $categoryName; ?></option>
                            <?php
                              $query = "SELECT * FROM categories WHERE categories_parent = 2 ORDER BY categories_category";
                              $select_categories = mysqli_query($connection, $query);
                              
                              confirm($select_categories);
                              
                              while($row = mysqli_fetch_assoc($select_categories)){
                                $categories_id = $row['categories_id'];
                                $categories_category = $row['categories_category'];
                                echo "<option value='$categories_id'>{$categories_category}</option>";
                              }  
                            ?>
                          </select>
                        </div>
                        </div>
                        <div class="form-group">
                          <label for="post_category">Brand</label>
                          <select class="form-control" name="brand" id="">
                            <?php
                              $query_1 = "SELECT * FROM brands where brands_id = $product_brand ";
                              $select_brand_id = mysqli_query($connection, $query_1);
                              
                              confirm($select_brand_id);
                              while($row = mysqli_fetch_assoc($select_brand_id)){
                                $brand_id_1 = $row['brands_id'];
                                $brand_name_1 = $row['brands_brand'];
                              }  
                            ?>
                            <option value='<?php echo $brand_id_1; ?>'><?php echo $brand_name_1; ?></option>
                            <?php
                              $query = "SELECT * FROM brands";
                              $select_brands = mysqli_query($connection, $query);
                              
                              confirm($select_brands);
                              while($row = mysqli_fetch_assoc($select_brands)){
                                $brand_id = $row['brands_id'];
                                $brand_name = $row['brands_brand'];
                                echo "<option value='$brand_id'>{$brand_name}</option>";
                              }  
                            ?>
                          </select>
                        </div>
                        <div class="form-group">
                            <label for="product_description">Product Description: </label>
                            <textarea class="form-control" name="product_description" id="product_description" cols="30" rows="3"><?php echo $product_description; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="product_sizes">Sizes: (input format: size:qtd,size:qtd,size:qtd - e.g. S:4,M:4,L:2)</label>
                            <input type="text" name="product_sizes" id="product_sizes" class="form-control" value="<?php echo $product_sizes; ?>">
                        </div>
                        <div class="form-group">
                          <input type="file" name="image" />
                        </div>
                        
                        <input type="submit" name="udpate_product" id="btn-login" class="btn btn-custom btn-lg btn-block editProduct" style="background-color: black; color:white;" value="Update">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</div>