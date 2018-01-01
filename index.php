<?php include "includes/header.php" ;?>
<?php include "includes/navigation.php"; ?>
<?php include "core/init.php"; 
include "includes/cfg.php";
?>
    

<section id="home">
    <div id="headerWrapper">
        <div id="back-flower"></div>
        <div id="logotext"></div>
        <div id="fore-flower"></div>
    </div>
</section>
    
<section id="featured" style="background-color: white; ">
    <div class="center">
        <div class="container-fluid">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="row">
                    
                    <h2 class="text-center" style="margin-bottom: 40px;"><b> Featured Products </b></h2>
                    <span id="modal_erros" class="bg-danger"></span>
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
                        <button type="button" class="btn btn-md btn-success" style="background-color: black; border: black;" onclick='detailsmodal(<?php echo $products_id; ?>)'>Details</button>
                    </div>
                    
                    <?php } ?>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</section>

<br><br><br><br><br>
<?php include "includes/footer.php"; ?>