<?php
  define('CART_COOKIE', 'Ed3aCZORez3qoaP');
  define('CART_COOKIE_EXPIRE', time() + (86400*30));
?>

<?php 
if(isset($_SESSION['success_flash'])){
	echo "<script type='text/javascript'>alert('".$_SESSION['success_flash'].");</script>";
	unset($_SESSION['success_flash']);
}

if(isset($_SESSION['error_flash'])){
	echo "<div class='bg-danger'><p class='text-danger text-center'>".$_SESSION['error_flash']."</p></div>";
	unset($_SESSION['error_flash']);
}
?>

