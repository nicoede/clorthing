<?php
 //Connect to the database
    $host = "127.0.0.1";
    $user = "nicoede";                           //Your Cloud 9 username
    $pass = "";                                  //Remember, there is NO password by default!
    $db = "clothing";                                  //Your database name you want to connect to
    $port = 3306;                                //The port #. It is always 3306
    
    $connection = mysqli_connect($host, $user, $pass, $db, $port)or die(mysqli_error($connection));
    
    define('BASEURL', getcwd());
    
    $cart_id = '';
    if(isset($_COOKIE[CART_COOKIE])){
      $cart_id = $_COOKIE[CART_COOKIE];
    }
    
?>