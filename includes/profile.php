<?php 
include "admin_header.php";
include "admin_navigation.php";
include "../../core/init.php";
include "../../includes/functions.php";
session_start();
?>

<?php
  $userName = $_SESSION['username'];
  $query = "SELECT * FROM users WHERE username = '{$userName}' ";
  $query_result = mysqli_query($connection, $query);
  
  while($row = mysqli_fetch_assoc($query_result)){
    $user_id = $row['user_id'];
    $user_image = $row['user_image'];
    $user_firstname = $row['user_firstname'];
    $user_lastname = $row['user_lastname'];
    $user_email = $row['user_email'];
  }
?>

<div class="col-xs-6 col-xs-offset-3">
  <h1 class="page-header" style="margin-top: 150px;">
           Your Profile
           <span style="float: right; margin-top: -20px;"> <?php echo "<img class='thumbnail img-responsive' width='64' src='https://s3-ap-southeast-1.amazonaws.com/nicoedeimages/clothing/{$user_image}' alt='image'>"; ?>  </span>
        </h1>
    <div class="form-wrap" style="margin-bottom: 100px;">
    </h1>
        <form role="form" action="profile.php" method="post" autocomplete="off" enctype="multipart/form-data">
            <div class="form-group">
                <label for="username">Username: </label>
                <input type="text" name="username" id="username" class="form-control" value="<?php echo $userName; ?>">
            </div>
             <div class="form-group">
                <label for="email">Email: </label>
                <input type="email" name="email" id="email" class="form-control" value="<?php echo $user_email; ?>">
            </div>
            <div class="form-group">
              <label for="user_firstname">First Name: </label>
              <input value="<?php echo $user_firstname?>" type="text" class="form-control" name="user_firstname"/>
            </div>
            
            <div class="form-group">
              <label for="user_lastname">Last Name: </label>
              <input value="<?php echo $user_lastname?>" type="text" class="form-control" name="user_lastname"/>
            </div>
            <div class="form-group">
                <label for="password">Password: </label>
                <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                 <?php echo "<p class='text-danger'>Please retype your password!</p>";?>
            </div>
            <div class="form-group">
              <label for="image">Profile Picture: </label>
              <input type="file" name="image"/>
            </div>
            
            <input type="submit" name="update_profile" id="btn-login" class="btn btn-custom btn-lg btn-block updateUser" style="background-color: black; color:white;" value="Update">
        </form>
       <?php $return = update_user($user_id); ?>
    </div>
</div> <!-- /.col-xs-12 -->
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

<?php include "admin_footer.php"; ?>

<script>
    var check = <?php echo $return; ?>;
    
    if(check == 1){
      $('#register_user_modal_id').modal('show');
    }
    
    if(check == 2){
      $('#m_registration_error').modal('show');
    }
    
    if(check == 3){  
      $('#user_exists').modal('show');
    }
</script>