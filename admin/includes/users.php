<?php
include "admin_header.php";
include "admin_navigation.php";
include "../../core/init.php";
include "../../includes/functions.php";
session_start();
?>

<?php 
if($_SESSION['user_role'] != 'Admin'){  
  header("Location: ../index.php");
}
?>

<?php
if(isset($_GET['edit'])){
  $user_id = $_GET['edit'];
  
  $query_role = "SELECT * FROM users WHERE user_id = {$user_id}";
  $query_role_result = mysqli_query($connection, $query_role);
  
  while($row = mysqli_fetch_assoc($query_role_result)){
    $user_role = $row['user_role'];
  }
  
  if($user_role == 'Admin'){
    $userRole = 'Subscriber';
    $query = "UPDATE users SET user_role = '{$userRole}' WHERE user_id = {$user_id} ";
    $query_result = mysqli_query($connection, $query);
  }
  
  if($user_role == 'Subscriber'){
    $userRole = 'Admin';
    $query = "UPDATE users SET user_role = '{$userRole}' WHERE user_id = {$user_id} ";
    $query_result = mysqli_query($connection, $query);
  }
  
}
?>

<h1 class="text-center" style="margin-bottom: 100px; margin-top: 12%">All Users</h1>

<form action="" method="post" >
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th class="text-center">Id</th>
        <th class="text-center">Username</th>
        <th class="text-center">First Name</th>
        <th class="text-center">Last Name</th>
        <th class="text-center">Email</th>
        <th class="text-center">Role</th>
        <th class="text-center">Image</th>
        <th class="text-center">Date</th>
      </tr>
    </thead>
    <tbody class="text-center">
      <?php 
        show_all_users();
      ?>
    </tbody>
  </table>
</form>