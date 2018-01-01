<?php 
include "includes/header.php";
include "includes/navigation.php"; 
include "includes/functions.php";
include "modals/m_login_suc.php";
include "modals/m_login_fail.php";
?>

        
<section id="home">
    <div id="headerWrapper">
      <div id="back-flower"></div>
      <div class="container" style="margin-top: 100px;">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1 class="text-center" style="color: white; margin-bottom: 30px;">Login</h1>
                    <form role="form" action="" method="post" id="login-form" autocomplete="off">
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Username:">
                        </div>
                        <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password:">
                            <?php echo "<p class='text-danger'>$errPassword</p>";?>
                        </div>
                        <a style="color: white;" href="mailto:">Forgot your password?</a>
                        <input type="submit" name="login" id="btn-login" class="btn btn-custom btn-lg btn-block logIn" style="margin-top: 10px; background-color: black; color:white;" value="Login">
                    </form>
                     <?php $return = login(); ?>
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
        <div id="fore-flower"></div>
    </div>
</section>

<?php include "includes/footer.php"; ?>

<script>
    var check = '<?php echo $return ?>';
    
    if(check == 1){
        $('#login_suc_modal_id').modal('show');
    }
    
    if(check == 2){
        $('#wrong_pass_modal_id').modal('show');
    }
</script>