<?php
include "../modals/m_future_error.php";
include "../core/init.php";
include "cfg.php";
session_start();


$product_id = $_POST['id'];
$query = "SELECT * FROM products WHERE products_id = $product_id";
$query_result = mysqli_query($connection, $query);
$product = mysqli_fetch_assoc($query_result);
$brand = $product['products_brand'];
$size_string = $product['products_sizes'];
$size_array = explode(',', $size_string);
                    
        $select_category = "SELECT brands_brand FROM brands WHERE brands_id = $brand ";
        $select_category_result = mysqli_query($connection, $select_category);
        $row2 = mysqli_fetch_assoc($select_category_result);
        $category = $row2['brands_brand'];
?>
<?php ob_start(); ?>
<div class="modal fade details-1" id="details-modal" tabindex="-1" role="dialog" aria-labelledby="details-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h2 class="modal-title text-center"><?php echo $product['products_title']; ?></h2>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                          <span id="modal_errors" class="db-danger"></span>
                            <div class="col-sm-6">
                                <div class="center-block">
                                    <img src="https://s3-ap-southeast-1.amazonaws.com/nicoedeimages/clothing/<?php echo $product['products_image'];; ?>" alt="<?php echo $product['title'];; ?>"  class="details img-responsive">
                                </div>
                            </div>
                            <div class="col-sm-6" style="font-size: large;">
                               <h4>Details</h4>
                               <p><?php echo $product['products_description'];; ?></p>
                               <hr>
                               <p>Price: $<?php echo $product['products_price'];; ?></p>
                               <p>Brand: <?php echo $category; ?></p>
                               <form action="add_cart.php" method="post" id="add_product_form">
                                   <input type='hidden' name='product_id' value='<?=$product_id?>'>
                                   <input type='hidden' name='available' id='available' value=''>
                                   <div class="form-group">
                                       <div><label style="float:left;" for="quantity">Quantity:</label>
                                       <input class="form-control" type='number' max='9' min='1' id='quantity' name='quantity' value='1' /></div>
                                   </div>
                                   <div class="form-group">
                                       <label for="size" style="float:left;">Size:</label>
                                       <select name="size" id="size" class="form-control">
                                           <option value="">--Select a Size</option>
                                           <?php
                                               foreach($size_array as $string){
                                                   $string_array = explode(':', $string);
                                                   $size = $string_array[0];
                                                   $available = $string_array[1];
                                                   echo '<option value="'.$size.' " data-available="'.$available.'">'.$size. " " . '('. $available. " " .' Available)</option>';
                                               }
                                           ?>
                                       </select>
                                   </div>
                               </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" onclick="closeModal()">Close</button>
                    <?php if($_SESSION['username'] != ''){ ?>
                      <button class="btn btn-primary futureFunction" onclick='add_to_cart(); return false'><span class="glyphicon glyphicon-shopping-cart"></span>Add To Cart</button>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
  
  function add_to_cart(id){
    jQuery('#modal_errors').html;
      var size = jQuery('#size').val();
      var quantity = jQuery('#quantity').val();
      var available = jQuery('#available').val();
      var error = '';
      var data = jQuery('#add_product_form').serialize();
      if(size == '' || quantity == '' || quantity == 0){
      	error += '<p class="text-danger text-center">You must choose a size and quantity</p>';
      	jQuery('#modal_errors').html(error);
      	return;
      }else if(quantity > available){
        error += '<p class="text-danger text-center">There are only '+available+' available</p>';
        jQuery('#modal_errors').html(error);
        return;
      }else{
        jQuery.ajax({
        // 	//url : '/admin/parsers/add_cart.php',
        // 	method : 'post',
        // 	data : data,
        // 	success : function(){
        // 	    //location.reload();
        // 	},
        	error : function(){
        		alert('This function will be available soon! ');
  	      }
        });
      }
    }
    
  
  jQuery('#size').change(function(){
    var available = jQuery('#size option:selected').data("available");
    jQuery('#available').val(available);
  });
  
  function closeModal(){
    jQuery('#details-modal').modal('hide');
    setTimeout(function(){
  	  jQuery('#details-modal').remove();
    },500);
  }
  
  $(document).ready(function(){
    $(".futureFunction").on('click', function(){
      $('#future_modal_id').modal('show');
    });
  });
</script>
<?php echo ob_get_clean(); ?>