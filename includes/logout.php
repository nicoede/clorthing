<?php 
session_start(); 

$_SESSION['username'] = null;
$_SESSION['firstname'] = null; 
$_SESSION['lastname'] = null; 
$_SESSION['user_role'] = null;

echo "<script type='text/javascript'>window.top.location='../index.php';</script>"; exit;

?>

