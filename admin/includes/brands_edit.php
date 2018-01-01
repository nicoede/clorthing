<?php
include "../../core/init.php";
?>
<form  action="" method="post" style="margin-top: 15%;">
<div class="container">
<div class="col-xs-6 col-xs-offset-3">
  <div class="form-wrap">
  <h2 class="text-center" style="margin-bottom: 50px;">Edit Brand</h2>
  <?php 
    if(isset($_GET['edit'])){
      $brands_edit_id = $_GET['edit'];
      $query = "SELECT * FROM brands WHERE brands_id = $brands_edit_id ";
      $select_brands_id = mysqli_query($connection, $query);
      
      while($row = mysqli_fetch_assoc($select_brands_id)){
        $brand_id = $row['brands_id'];
        $brand_title = $row['brands_brand'];
      ?>
      <input id="update_brand_id_button" value="<?php if(isset($brand_title)){echo $brand_title;} ?>" type="text" class="form-control" name="brand_title">
      <?php
      }
    }
  ?>
  <?php
  //UPDATE QUERY
   if(isset($_POST['update_brand'])){
      $get_brand_title = $_POST['brand_title'];
      $query = "UPDATE brands SET brands_brand = '{$get_brand_title}' WHERE brands_id = {$brand_id} ";
      $update_query = mysqli_query($connection, $query);
      
      if(!$update_query){
        die("QUERY FAILED" . mysqli_error($connection));
      }
      sleep(3);
      echo "<script type='text/javascript'>window.top.location='brands.php';</script>"; exit;
    }
  ?>
<div class="">
  <input class="btn btn-custom btn-lg btn-block brandUpdate" style="margin-top: 10px; background-color: black; color: white;" type="submit" name="update_brand" value="Update Brand"/>
</div>
</div>
</div>
</div>
<br><br><br>

</form>