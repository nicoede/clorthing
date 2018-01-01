<?php
 //Connect to the database
    // $host = "127.0.0.1";
    // $user = "nicoede";                           //Your Cloud 9 username
    // $pass = "";                                  //Remember, there is NO password by default!
    // $db = "clothing";                                  //Your database name you want to connect to
    // $port = 3306;                                //The port #. It is always 3306
    
    // $connection = mysqli_connect($host, $user, $pass, $db, $port)or die(mysqli_error($connection));
    
    $url = parse_url(getenv("mysql://b6aa9facbbabf0:d7bced72@us-cdbr-iron-east-05.cleardb.net/heroku_e7658ca9d7d0bd1?reconnect=true"));

    $server = "us-cdbr-iron-east-05.cleardb.net";
    $username_db = "b6aa9facbbabf0";
    $password_db = "d7bced72";
    $db_db = "heroku_e7658ca9d7d0bd1";
    
    $connection = mysqli_connect($server, $username_db, $password_db, $db_db);
    
    define('BASEURL', getcwd());
    
    $cart_id = '';
    if(isset($_COOKIE[CART_COOKIE])){
      $cart_id = $_COOKIE[CART_COOKIE];
    }
    
?>