<?php
include "admin_header.php"; 
include "admin_navigation.php";
include "../../core/init.php";
include "../../includes/functions.php";
include "../../modals/m_product_update.php";
include "../../modals/m_product_fail.php";
include "../../modals/m_product_suc.php";
include "../../modals/m_product_delete.php";
include "../../modals/m_product_multiple_deletion.php";
include "../../modals/m_product_noimage.php";
session_start();
?>

<?php 
if($_SESSION['user_role'] != 'Admin'){  
  header("Location: ../index.php");
}
?>

<?php 

if(isset($_POST['checkBoxArray'])){
    foreach($_POST['checkBoxArray'] as $checkBox_post_id){
     $bulk_options = $_POST['bulk_options'];
     switch ($bulk_options) {
         
       case 'Delete':
         $query = "DELETE FROM products WHERE products_id = {$checkBox_post_id} ";
         $delete_query = mysqli_query($connection, $query);
         confirm($delete_query);
         break;
       
       default:
         // code...
         break;
     }
    }
    $check = 1;
  }


?>



  <h1 class="text-center" style="margin-bottom: 40px; margin-top: 12%">All Products</h1>
  <table class="table table-bordered table-hover">
    <form role="form" action="products.php" method="post">
      <div class="text-center">
          <input type="submit" name="show_all_products_button" class="btn btn-success" value="Show All Products">
      </div><br><br>
    </form>
    <h4 style="margin-left: 10px;">Filter Options (You don't need to use all of them, but you can combine them): </h4>
    <form role="form" action="products.php" method="post">
      <div id="bulkOptionContainer" class="col-xs-4" style="margin-bottom: 20px; padding:0px;">
        <select class="form-control" name="filter_sex" onchange="catsex_filter(this);">
          <option value="">--Select SEX, if you wish, not necessary</option>
          <option value="1">Men</option>
          <option value="2">Women</option>
        </select>
      </div>
      <script>
        function catsex_filter(that) {
          if (that.value == '1') {
              document.getElementById("displayMen_filer").style.display = "block";
              document.getElementById("displayWomen_filer").style.display = "none";
          }else if(that.value == ''){
              document.getElementById("displayWomen_filer").style.display = "none";
              document.getElementById("displayMen_filer").style.display = "none";
          }else {
              document.getElementById("displayWomen_filer").style.display = "block";
              document.getElementById("displayMen_filer").style.display = "none";
          }
       }
      </script>
      <div id="displayMen_filer" class="col-xs-3" style="margin-bottom: 20px; padding:0px; margin-left: 5px; display: none;">
        <select class="form-control" name="filter_category_m" id="">
          <?php
            $query = "SELECT * FROM categories WHERE categories_parent = 1 ORDER BY categories_category";
            $select_categories = mysqli_query($connection, $query);
            confirm($select_categories);
            
            echo "<option disabled selected value> --Select a CATEGORY if you wish, not necessary</option>";
            
            while($row = mysqli_fetch_assoc($select_categories)){
              $categories_id = $row['categories_id'];
              $categories_category = $row['categories_category'];
              echo "<option value='$categories_id'>{$categories_category}</option>";
            }  
          ?>
        </select>
      </div>
      <div id="displayWomen_filer" class="col-xs-3" style="margin-bottom: 20px; padding:0px; margin-left: 5px; display: none;">
        <select class="form-control" name="filter_category_w" id="">
          <?php
            $query = "SELECT * FROM categories WHERE categories_parent = 2 ORDER BY categories_category";
            $select_categories = mysqli_query($connection, $query);
            confirm($select_categories);
            
            echo "<option disabled selected value> --Select a CATEGORY if you wish, not necessary</option>";
            
            while($row = mysqli_fetch_assoc($select_categories)){
              $categories_id = $row['categories_id'];
              $categories_category = $row['categories_category'];
              echo "<option value='$categories_id'>{$categories_category}</option>";
            }  
          ?>
        </select>
      </div>
      <div id="" class="col-xs-3" style="margin-bottom: 20px; padding:0px; margin-left: 5px;">
        <select class="form-control" name="brand_filter" id="">
          <?php
            $query = "SELECT * FROM brands ORDER BY brands_brand";
            $select_categories = mysqli_query($connection, $query);
            confirm($select_categories);
            
            echo "<option disabled selected value> --Select a BRAND if you wish, not necessary</option>";
            
            while($row = mysqli_fetch_assoc($select_categories)){
              $brands_id = $row['brands_id'];
              $brands_brand = $row['brands_brand'];
              echo "<option value='$brands_id'>{$brands_brand}</option>";
            }  
          ?>
        </select>
      </div>
      <div class="col-xs-1">
        <input type="submit" name="submit_filter" class="btn btn-success" value="Apply">
      </div>
      
      <?php $return = products_filter();
      $return_2 = show_all_products();
      ?>
    
    
    <br><br><br>
    <h4 style="margin-left: 10px;">All selector for deletion:</h4>
    <div id="bulkOptionContainer" class="col-xs-4" style="margin-bottom: 20px; padding:0px;">
      <select class="form-control" name="bulk_options" id="">
        <option value="">Select Options</option>
        <option value="Delete">Delete</option>
      </select>
    </div>
    
    <div class="col-xs-4">
      
        <input type="submit" name="submit" class="btn btn-success" value="Apply">
      
      <a class="btn btn-primary" href="#new_product_id">Add New</a>
    </div>
    </form>
    <?php if($return == 2 || $return_2 == 2){
      echo "<br><br><h1 class='text-center' style='margin-top: 100px;'> Nothing found </h1>";
    }
    
    if($return == 1 || $return_2 == 1){
    echo "<thead>";
      echo "<tr>";
        echo "<th><input id='select_all_boxes' type='checkbox'></th>";
        echo "<th>Id</th>";
        echo "<th>Title</th>";
        echo "<th>Price</th>";
        echo "<th>List Price</th>";
        echo "<th>Brand</th>";
        echo "<th>Category</th>";
        echo "<th>Image</th>";
        echo "<th>Description</th>";
        echo "<th>Featured</th>";
        echo "<th>Sizes</th>";
      echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
      
      
        //delete_products();
      
    echo "</tbody>";
    }
  ?>
  </table>


<?php
//UPDATE AND INCLUD QUERY
  if(isset($_GET['edit'])){
    $product_edit_id = $_GET['edit'];
    include "products_edit.php";
  }
?>

<div id="new_product_id" class="">
        <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1 class="text-center" style="margin-top: 200px; margin-bottom: 30px;">New Product</h1>
                </h1>
                    <form role="form" action="products.php" method="post" autocomplete="off" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="product_name">Product Name</label>
                            <input type="text" name="product_name" id="product_name" class="form-control" placeholder="Product Name: ">
                        </div>
                        <div class="form-group">
                          <label for="price">Featured</label>
                          <select class="form-control" name="featured" onchange="yesnoCheck(this);">
                            <option value=''>Select</option>
                            <option value='1'>Yes<?php $featured_sel = 1; ?></option>
                            <option value='0'>No<?php $featured_sel = 2; ?></option>
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
                            <input type="text" name="price" id="price" class="form-control" placeholder="Price: ">
                        </div>
                        <div id="ifYes" class="form-group" style="display: none;">
                            <label for="list_price" style="color: red;">List Price</label>
                            <input type="text" name="list_price" id="list_price" class="form-control" placeholder="List Price: ">
                        </div>
                        <div class="form-group">
                          <label for="post_category">Sex</label>
                          <select class="form-control" name="category_sex" onchange="catsex(this);">
                            <option value=''>--Select SEX</option>
                            <option value='1'>Men<?php $sex_sel = 1; ?></option>
                            <option value='0'>Women<?php $sex_sel = 2; ?></option>
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
                        <div id="displayMen" class="form-group" style="display: none;">
                          <label for="post_category" style="color: blue;">Category</label>
                          <select class="form-control" name="category_id" id="">
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
                          <div style="margin-bottom: 10px;">
                            <a target="_blank" href="categories.php#edit_here">New Category</a>
                          </div>
                        </div>
                        <div id="displayWomen" class="form-group" style="display: none;">
                          <label for="post_category" style="color: blue;">Category</label>
                          <select class="form-control" name="category_id" id="">
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
                          <div style="margin-bottom: 10px;">
                            <a target="_blank" href="categories.php#edit_here">New Category</a>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="post_category">Brand</label>
                          <select class="form-control" name="brand" id="">
                            <?php
                              $query = "SELECT * FROM brands";
                              $select_brands = mysqli_query($connection, $query);
                              
                              confirm($select_brands);
                              echo "<option>--Select a BRAND</option>";
                              while($row = mysqli_fetch_assoc($select_brands)){
                                $brand_id = $row['brands_id'];
                                $brand_name = $row['brands_brand'];
                                echo "<option value='$brand_id'>{$brand_name}</option>";
                              }  
                            ?>
                          </select>
                        </div>
                        <div style="margin-top: -13px; margin-bottom: 10px;">
                          <a target="_blank" href="brands.php#new_brand_id">New Brand</a>
                        </div>
                        <div class="form-group">
                            <label for="product_description">Product Description: </label>
                            <textarea class="form-control" name="product_description" id="product_description" cols="30" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="product_sizes">Sizes: (input format: size:qtd,size:qtd,size:qtd - e.g. S:4,M:4,L:2)</label>
                            <input type="text" name="product_sizes" id="product_sizes" class="form-control">
                        </div>
                        <div class="form-group">
                          <input type="file" name="image" />
                        </div>
                        
                        <input type="submit" name="new_product" id="btn-login" class="btn btn-custom btn-lg btn-block registerProduct" style="background-color: black; color:white;" value="Register">
                    </form>
                 <?php
                 $return = new_product();
                 delete_product();
                 ?>
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</div>
</div>

</div>
    </div>
    <br><br><br><br><br>
   
   <?php include "admin_footer.php"; ?>
    
    
</body>
</html>

<script>
   var check = '<?php echo $return; ?>';
   var check2 = '<?php echo $check; ?>';

   $('#select_all_boxes').click(function () {    
      $(':checkbox.checkBoxes').prop('checked', this.checked);    
    });

    if(check == 1){
      
            $('#product_create_modal_id').modal('show');
         
    }
    
    if(check == 2){
      
            $('#product_create_fail_modal_id').modal('show');
         
    }
    
    if(check == 3){
      
            $('#m_noimage_error').modal('show');
         
    }
    
    if(check2 == 1){
        $('#multiple_prod_deletion_modal_id').modal('show');
    }

    function yesnoCheck(that) {
        if (that.value == '1') {
            document.getElementById("ifYes").style.display = "block";
        } else {
            document.getElementById("ifYes").style.display = "none";
        }
    }
    
    $(document).ready(function(){
      $(".editProduct").on('click', function(){
        $('#product_updated_modal_id').modal('show');
      });
    });
    
    $(document).ready(function(){
    $(".delete_product_link_class").on('click', function(){
      var id = $(this).attr("rel");
      var delete_url = "products.php?delete="+ id +"";
      $(".product_delete_link").attr("href", delete_url);
      $('#deleteProduct').modal('show');
    });
  });
</script>