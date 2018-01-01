<?php
include "../../core/init.php";
?>

<form  action="" method="post" style="">
<div class="container">
  <div class="col-xs-6 col-xs-offset-3">
      <div class="form-wrap">
        <h2 class="text-center" style="margin-bottom: 50px;">Edit Category</h2>
        <?php 
          if(isset($_GET['edit'])){
            $categories_edit_id = $_GET['edit'];
            $query = "SELECT * FROM categories WHERE categories_id = $categories_edit_id ";
            $select_categories_id = mysqli_query($connection, $query);
            
            while($row = mysqli_fetch_assoc($select_categories_id)){
              $category_id = $row['categories_id'];
              $category_title = $row['categories_category'];
            ?>
            <input id="update_brand_id_button" value="<?php if(isset($category_title)){echo $category_title;} ?>" type="text" class="form-control" name="category_title">
            <?php
            }
          }
        ?>
        <?php
        //UPDATE QUERY
         if(isset($_POST['update_category'])){
            $get_category_title = $_POST['category_title'];
            $query = "UPDATE categories SET categories_category = '{$get_category_title}' WHERE categories_id = {$category_id} ";
            $update_query = mysqli_query($connection, $query);
            
            if(!$update_query){
              die("QUERY FAILED" . mysqli_error($connection));
            }
            sleep(3);
            echo "<script type='text/javascript'>window.top.location='categories.php';</script>"; exit;
          }
        ?>
      <div class="">
        <input class="btn btn-custom btn-lg btn-block categoryUpdate" style="margin-top: 10px; background-color: black; color: white;" type="submit" name="update_category" value="Update Category"/>
      </div>
    </div>
  </div>
</div>
<br><br><br>

</form>