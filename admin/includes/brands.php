<?php 
include "admin_header.php";
include "admin_navigation.php";
include "../../core/init.php";
include "../../includes/functions.php"; 
include "../../modals/m_brands_update.php";
include "../../modals/m_brands_create_fail.php";
include "../../modals/m_brands_create_suc.php";
include "../../modals/m_brands_delete.php";
include "../../modals/m_brands_multiple_deletion.php";
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
         $query = "DELETE FROM brands WHERE brands_id = {$checkBox_post_id} ";
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

<h1 class="text-center" style="margin-bottom: 100px; margin-top: 12%">All Brands</h1>
<h4 style="margin-left: 10px;">Selector for deletion:</h4>

<form action="" method="post" >
  <table class="table table-bordered table-hover">
    <div id="bulkOptionContainer" class="col-xs-4" style="margin-bottom: 20px; padding:0px;">
      <select class="form-control" name="bulk_options" id="">
        <option value="">Select Options</option>
        <option value="Delete">Delete</option>
      </select>
    </div>
    
    <div class="col-xs-4">
      <input type="submit" name="multiple_apply" class="btn btn-success" value="Apply">
      <a class="btn btn-primary" href="#new_brand_id">Add New Brand</a>
    </div>

    <thead>
      <tr>
        <th><input id="select_all_boxes" type="checkbox"></th>
        <th>Id</th>
        <th>Name</th>
      </tr>
    </thead>
    <tbody>
      <?php 
        show_all_brands();
        delete_brand();
      ?>
    </tbody>
  </table>
</form>
<div id="edit_here"></div>
<?php 
    //UPDATE AND INCLUD QUERY
    if(isset($_GET['edit'])){
      $brand_edit_id = $_GET['edit'];
      include "brands_edit.php";
    }
?>
<div id="new_brand_id" class="container" style="margin-top: 19%;">
    <div class="row">
        <div class="col-xs-6 col-xs-offset-3">
            <div class="form-wrap">
            <h2 class="text-center" style="margin-bottom: 50px;">New Brand</h2>
                <form role="form" action="brands.php" method="post" id="login-form" autocomplete="off">
                    <div class="form-group">
                        <label for="brand_name">Brand Name: </label>
                        <input type="text" name="brand_name" id="brand_name" class="form-control">
                    </div>
                    <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block newBrand" value="Create" style="background-color: black; color: white;">
                </form>
              <?php $return = new_brand(); ?>
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

            $('#brand_create_modal_id').modal('show');

    }
    
    if(check == 2){

            $('#brand_create_fail_modal_id').modal('show');

    }
    
    $(document).ready(function(){
      $(".brandUpdate").on('click', function(){
        $('#brand_updated_modal_id').modal('show');
      });
    });
    
    if(check2 == 1){
        $('#multiple_deletion_modal_id').modal('show');
    }
    
    $(document).ready(function(){
    $(".delete_brand_link_class").on('click', function(){
      var id = $(this).attr("rel");
      var delete_url = "brands.php?delete="+ id +"";
      $(".brand_delete_link").attr("href", delete_url);
      $('#deleteBrand').modal('show');
    });
  });
</script>