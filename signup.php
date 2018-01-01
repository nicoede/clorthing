<?php 
include "includes/header.php";
include "includes/navigation.php"; 
include "includes/functions.php";
include "modals/m_registration_error.php";
include "modals/m_registration_suc.php";
include "modals/m_registration_usernot.php";
?>
        
<section id="home">
    <div id="headerWrapper">
        <div id="back-flower"></div>
        <div class="container" style="margin-top: 40px;">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1 class="text-center" style="color: white; margin-bottom: 30px;">Register</h1>
                </h1>
                    <form role="form" action="signup.php" method="post" id="login-form" autocomplete="off">
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username">
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                        </div>
                        <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                            <?php echo "<p class='text-danger'>$errPassword</p>";?>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password" class="sr-only">Confirm Password</label>
                            <input type="password" name="confirm_password" id="key" class="form-control" placeholder="Confirm Password">
                            <?php echo "<p class='text-danger'>$errPassword</p>";?>
                        </div>
                        <?php $return = register_user(); ?>
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block registerUser" style="background-color: black; color:white;" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
        <div id="fore-flower"></div>
    </div>
</section>

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