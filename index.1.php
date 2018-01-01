<?php include "includes/header.php" ;?>
<?php include "includes/navigation.php"; ?>
    

<section id="home">
    <div id="headerWrapper">
        <div id="back-flower"></div>
        <div id="logotext"></div>
        <div id="fore-flower"></div>
    </div>
</section>
    
<section id="featured" style="background-color: white; ">
    <div class="font">
        <div class="container-fluid">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="row">
                    <h2 class="text-center" style="margin-bottom: 40px;"><b> Featured Products </b></h2>
                    
                    <?php
                    $select_all_products_query = "SELECT * FROM products WHERE products_featured = 1";
                    $select_all_products_query_result = mysqli_query($connection, $select_all_products_query);
                    
                    while($row = mysqli_fetch_assoc($select_all_products_query_result)){
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
                        <button type="button" class="btn btn-md btn-success" style="background-color: black; border: black;" data-toggle="modal" data-target="#details-<?php echo $products_id; ?>">Details</button>
                    </div>
                    
                    <?php } ?>
                </div>
            </div>
            
            
            <div class="col-md-2"></div>
            
            <?php
                $select_all_products_query = "SELECT * FROM products WHERE products_featured = 1";
                $select_all_products_query_result = mysqli_query($connection, $select_all_products_query);
                
                while($row = mysqli_fetch_assoc($select_all_products_query_result)){
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
                    
                    $select_category = "SELECT brands_brand FROM brands WHERE brands_id = $products_brand ";
                    $select_category_result = mysqli_query($connection, $select_category);
                    $row2 = mysqli_fetch_assoc($select_category_result);
                    $category = $row2['brands_brand'];
            ?>
        
            <div class="modal fade details-<?php echo $products_id; ?>" id="details-<?php echo $products_id; ?>" tabindex="-1" role="dialog" aria-labelledby="details-<?php echo $products_id; ?>" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title text-center"><?php echo $products_title; ?></h4>
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="center-block">
                                                <img src="https://s3-ap-southeast-1.amazonaws.com/nicoedeimages/clothing/<?php echo $products_image; ?>" alt="<?php echo $products_title; ?>"  class="details img-responsive">
                                            </div>
                                        </div>
                                        <div class="col-sm-6" style="font-size: large;">
                                           <h4>Details</h4>
                                           <p><?php echo $products_description; ?></p>
                                           <hr>
                                           <p>Price: $<?php echo $products_price; ?></p>
                                           <p>Brand: <?php echo $category; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-default" data-dismiss="modal">Close</button>
                                <?php if($_SESSION['user_name'] != ''){ ?>
                                  <button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-shopping-cart"></span>Add To Cart</button>
                                <? } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        </div>
    
    </div>
    
</section>
    
   
    </div>
    </div>
    <br><br><br><br><br>
    <?php include "includes/footer.php"; ?>
    
    
</body>
</html>

<script>
    $('.carousel.carousel-slider').carousel({fullWidth: true});

    jQuery(window).scroll(function(){
        var vscroll = jQuery(this).scrollTop();
        jQuery('#logotext').css({
        "transform" : "translate(0px, "+vscroll/2+"px)"
        });
        
        var vscroll = jQuery(this).scrollTop();
        jQuery('#back-flower').css({
        "transform" : "translate("+vscroll/5+"px, -"+vscroll/12+"px)"
        });
        
        var vscroll = jQuery(this).scrollTop();
        jQuery('#fore-flower').css({
        "transform" : "translate(0px, -"+vscroll/2+"px)"
        });
    });
</script>