<?php 
include "admin_header.php";
include "admin_navigation.php";
include "../../core/init.php";
include "../../includes/functions.php"; 
include "../../modals/m_categories_update.php";
include "../../modals/m_categories_create_fail.php";
include "../../modals/m_categories_create_suc.php";
include "../../modals/m_categories_delete.php";
include "../../modals/m_categories_multiple_deletion.php";
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
         $query = "DELETE FROM categories WHERE categories_id = {$checkBox_post_id} ";
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

<h1 class="text-center" style="margin-bottom: 100px; margin-top: 12%">All Categories</h1>

      <form role="form" action="" method="post">
        <div class="col-md-8" style="margin-top: 100px; margin-bottom: 30px;"> 
          <select class="form-control" name="filter_sex" onchange="catsex_filter2(this);">
            <?php
              $categories_query = "SELECT * FROM categories WHERE categories_parent = 0";
              $categories_query_result = mysqli_query($connection, $categories_query);
              echo "<option disabled selected value> --Select a CATEGORY</option>";
              while($row = mysqli_fetch_assoc($categories_query_result)){
                $categories_id = $row['categories_id'];
                $categories_category = $row['categories_category'];
                echo "<option value='$categories_id'>{$categories_category}</option>";
              }
            ?>
          </select>
        </div>
        <div id="edit_button_cat" class="col-md-1" style="margin-left: 45px; margin-top: 100px; margin-bottom: 30px; display: none;">
          <a id="edit_link" class="btn btn-success" href='#'>Edit Category</a>
        </div>
      </form>
      <div class="col-md-1" style=" margin-top: 100px; margin-bottom: 30px;">
          <a class="btn btn-primary" href="#edit_here">Add New Category</a>
      </div>
      <form action="" method="post">
      <div id="bulkOptionContainer" class="col-xs-4" style="margin-left: 16px; margin-bottom: 20px; padding:0px;">
        <h4 style="margin-left: 10px;">Selector for deletion:</h4>
      <select class="form-control" name="bulk_options" id="">
        <option value="">Select Options</option>
        <option value="Delete">Delete</option>
      </select>
    </div>
    
    <div class="col-xs-4">
      <h4 style="margin-left: 10px; visibility: hidden;">Selector for deletion:</h4>
      <input type="submit" name="submit" class="btn btn-success" value="Apply">
    </div>
      <?php 
          //UPDATE AND INCLUD QUERY
          if(isset($_GET['edit'])){
            $category_edit_id = $_GET['edit'];
            include "categories_edit.php";
          }
      ?>
      <script>
        function catsex_filter2(that) {
          if (that.value == '1') {
              document.getElementById("displayMen_filer").style.visibility = "";
              document.getElementById("edit_button_cat").style.display = "block";
              document.getElementById("displayWomen_filer").style.visibility = "hidden";
              document.getElementById("edit_link").href="categories.php?edit=1"; 
          }else if(that.value == ''){
              document.getElementById("displayWomen_filer").style.visibility = "hidden";
              document.getElementById("displayMen_filer").style.visibility = "hidden";
              document.getElementById("edit_button_cat").style.display = "none";
              document.getElementById("edit_link").href="#"; 
          }else {
              document.getElementById("displayWomen_filer").style.visibility = "";
              document.getElementById("edit_button_cat").style.display = "block";
              document.getElementById("displayMen_filer").style.visibility = "hidden";
              document.getElementById("edit_link").href="categories.php?edit=2";
          }
       }
      </script>
<br><br><br><br>


<table id="displayMen_filer" style="visibility: hidden;" class="table table-bordered table-hover">
  <thead>
    <tr>
      <th><input id="select_all_boxes" type="checkbox"></th>
      <th class="text-center">Id</th>
      <th class="text-center">Name</th>
    </tr>
  </thead>
  <tbody>
        <?php
          $child_query = "SELECT * FROM categories WHERE categories_parent = 1 ORDER BY categories_category";
          $child_query_result = mysqli_query($connection, $child_query);
          $count2 = mysqli_num_rows($child_query_result);
          
          if($count2 > 0){
            while($row = mysqli_fetch_assoc($child_query_result)){
              $category_id = $row['categories_id'];
              $category_name = $row['categories_category'];
              
              echo "<tr>";
                ?>
                 <td style='width: 30px;'><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $category_id?>'></td>
                <?php
                echo "<td class='text-center' style='width: 70px;'>{$category_id}</td>";
                echo "<td class='text-center'>{$category_name}</td>";
                echo "<td class='text-center'><a href='categories.php?edit={$category_id}'>Edit</a></td>";
                echo "<td class='text-center'><a rel='$category_id' href='javascript:void(0)' class='delete_m_category_link_class' >Delete</a></td>";
              echo "</tr>";
            }
          }else{
            
          }
        ?>
  </tbody>
</table>
      
<table  id="displayWomen_filer" style="margin-top: -422px; visibility: hidden;" class="table table-bordered table-hover">
    <thead>
      <tr>
        <th><input id="select_all_boxes" type="checkbox"></th>
        <th class="text-center">Id</th>
        <th class="text-center">Name</th>
      </tr>
    </thead>
      <tbody>
          <?php
            $child_query = "SELECT * FROM categories WHERE categories_parent = 2 ORDER BY categories_category";
            $child_query_result = mysqli_query($connection, $child_query);
            $count2 = mysqli_num_rows($child_query_result);
            
            if($count2 > 0){
              while($row = mysqli_fetch_assoc($child_query_result)){
                $category_id = $row['categories_id'];
                $category_name = $row['categories_category'];
                
                echo "<tr>";
                ?>
                 <td style='width: 30px;'><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $category_id?>'></td>
                <?php
                  echo "<td class='text-center' style='width: 70px;'>{$category_id}</td>";
                  echo "<td class='text-center'>{$category_name}</td>";
                  echo "<td class='text-center'><a href='categories.php?edit={$category_id}'>Edit</a></td>";
                  echo "<td class='text-center'><a rel='$category_id' href='javascript:void(0)' class='delete_w_category_link_class' >Delete</a></td>";
                echo "</tr>";
              }
            }else{
              
            }
          ?>
    </tbody>
</table>

<div id="edit_here"></div>
      
<div  class="container" style="margin-top: 14%;">
    <div class="row">
        <div class="col-xs-6 col-xs-offset-3">
            <div class="form-wrap">
            <h2  class="text-center" style="margin-bottom: 50px;">New Category For:</h2>
                <form role="form" action="categories.php" method="post" id="login-form" autocomplete="off">
                  <div style="margin-bottom: 20px;"> 
                    <select class="form-control" name="filter_sex_for_creation">
                      <?php
                        $categories_query = "SELECT * FROM categories WHERE categories_parent = 0";
                        $categories_query_result = mysqli_query($connection, $categories_query);
                        echo "<option disabled selected value> --Select SEX</option>";
                        while($row = mysqli_fetch_assoc($categories_query_result)){
                          $categories_id = $row['categories_id'];
                          $categories_category = $row['categories_category'];
                          echo "<option value='$categories_id'>{$categories_category}</option>";
                        }
                      ?>
                    </select>
                  </div>
                    <div class="form-group">
                        <label for="category_name">Category Name: </label>
                        <input type="text" name="category_name" id="category_name" class="form-control">
                    </div>
                    <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block newCategory" value="Create" style="background-color: black; color: white;">
                </form>
             <?php $return = new_category();
             delete_category();
             ?>
            </div>
        </div> <!-- /.col-xs-12 -->
    </div> <!-- /.row -->
</div> <!-- /.container -->

<?php include "admin_footer.php"; ?>

<script>
   var check = '<?php echo $return; ?>';
   var check2 = '<?php echo $check; ?>';

   $('#select_all_boxes').click(function () {    
      $(':checkbox.checkBoxes').prop('checked', this.checked);    
    });

    if(check == 1){
      
            $('#category_create_suc_modal_id').modal('show');
         
    }
    
    if(check == 2){
      
            $('#category_create_fail_modal_id').modal('show');
         
    }
    
    $(document).ready(function(){
      $(".categoryUpdate").on('click', function(){
        $('#category_updated_modal_id').modal('show');
      });
    });
    
    if(check2 == 1){
        $('#multiple_cat_deletion_modal_id').modal('show');
    }
    
    $(document).ready(function(){
    $(".delete_w_category_link_class").on('click', function(){
      var id = $(this).attr("rel");
      var delete_url = "categories.php?delete="+ id +"";
      $(".category_delete_link").attr("href", delete_url);
      $('#deleteCat').modal('show');
    });
  });
  
  $(document).ready(function(){
    $(".delete_m_category_link_class").on('click', function(){
      var id = $(this).attr("rel");
      var delete_url = "categories.php?delete="+ id +"";
      $(".category_delete_link").attr("href", delete_url);
      $('#deleteCat').modal('show');
    });
  });
</script>