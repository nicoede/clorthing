<?php
include '../../core/init.php';
session_start();

$product_id = mysqli_real_escape_string($connection, $_POST['product_id']);
$size = mysqli_real_escape_string($connection, $_POST['size']);
$available = mysqli_real_escape_string($connection, $_POST['available']);
$quantity = mysqli_real_escape_string($connection, $_POST['quantity']);
$item = array();
$item[] = array(
	'id'       => $product_id,
	'size'     => $size,
	'quantity' => $quantity,
);
 
$domain = ($_SERVER['HTTP_HOST'] != 'localhost')?'.'.$_SERVER['HTTP_HOST']:false;
$query = "SELECT * FROM products WHERE products_id = $product_id";
$query_result = mysqli_query($connection, $query);
$product = mysqli_fetch_assoc($query_result);
$_SESSION['success_flash'] = $product['products_title']. 'was added to your cart';

//check to see if the cart cookie exists

if($cart_id == ''){
    $query = "SELECT * FROM cart WHERE cart_id = $cart_id";
    $query_result = mysqli_query($connection, $query);
    $cart = mysqli_fetch_assoc($query_result);
    $previous_items = json_decode($cart['cart_items'], true);
    $item_match = 0;
    $new_items = array();
    foreach($previous_items as $p_item){
        if($item[0]['id'] == $p_item['id'] && $item[0]['size'] == $p_item['size']){
            $p_item['quantity'] = $p_item['quantity'] + $item[0]['quantity'];
            if($p_item['quantity'] > $available){
                $p_item['quantity'] = $available;
            }
            $item_match = 1;
        }
        $new_items[] = $p_item;
    }
    
    if($item_match != 1){
        $new_items = array_merge($item, $previous_items);
    }
    
    $items_json = json_encode($new_items);
    $cart_expire = date("Y-m-d H:i:s", strtotime("+30 days"));
    $query_1 = "UPDATE cart SET cart_items = '{$items_json}', cart_expire_date = '{$cart_expire}' WHERE cart_id = $cart_id";
    $query_1_result = mysqli_query($connection, $query_1);
    setcookie(CART_COOKIE, '', 1, "/", $domain, false);
    setcookie(CART_COOKIE, $cart_id, CART_COOKIE_EXPIRE, '/', $domain, false);
}else{ //add the cart to the database and set cookie
	$items_json = json_encode($item);
	$cart_expire = date("Y-m-d H:i:s", strtotime("+30 days"));
	$query = "INSERT INTO cart (cart_items, cart_expire_date) VALUES ('{$items_json}', '{$cart_expire}')";
	$query_result = mysqli_query($connection, $query);
	$cart_id = $connection->insert_id;
	setcookie(CART_COOKIE, $cart_id, CART_COOKIE_EXPIRE, '/', $domain, false);
}

?>