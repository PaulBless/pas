
<?php 
session_start();

//require_once('');




?>



<!DOCTYPE html>
<html lang="en">
<head>
    <!--  Application title -->
    <title>district assembly - Permit Application System</title>
    
    <!--meta information-->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="permit processing and registration, permit application system for citizens to apply for building permit from the district assembly">
    <meta name="author" content="Paul Eshun">
    
    <!-- browser image -->
    <link rel="icon" href="./assets/images/logo.jpg" type="image/jpg">    
     <!-- Custom CSS -->
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- login-page main css -->
    <link href="./assets/css/pas-styles.css" rel="stylesheet">
  
</head>
    
<body class="change-password-page"> 
       
    <!--change password container-->
    <div class="change-pwd-container d-flex align-items-center justify-content-center">
    <form class="change-pwd-form text-center" method="post" role="form" action="change-password.php">
        <div class="logo"><img src="./assets/images/logo.jpg" width="120" height="120"/><span style="display: block"><h3 class="app-title font-weight-semibold">Permit Application System</h3></span><br/><span><h6>Complete the form to change your password..</h6></span>
              
        <!-- Display error message-->
            <?php echo '' ?>
        </div><br>
       <!--username-->
        <div class="form-group">
            <div class="input-group">
                <input type="text" class="form-control rounded-pill form-control-lg" placeholder="Username" name="username" required>
            </div>
        </div>
        <!--old password-->
         <div class="form-group">
             <div class="input-group">
                <input type="password" class="form-control rounded-pill form-control-lg" placeholder="Old Password" name="oldpass" required>
             </div>
        </div>
        <!-- new password-->
        <div class="form-group">
             <div class="input-group">
                <input type="password" class="form-control rounded-pill form-control-lg" placeholder="New Password" name="newpass" required>
             </div>
        </div>
        <!-- confirm password-->
        <div class="form-group">
             <div class="input-group">
                <input type="password" class="form-control rounded-pill form-control-lg" placeholder="Confirm New Password" name="confirmpass" required>
             </div>
        </div>
        <div class="changepwd-link">
        <button class="btn btn-custom mt-3 btn-block text-uppercase font-weight-bold rounded-pill btn-login" name="submit">Change Password</button>
        </div>
        <div class="bottom-text">
            <p class="lower-text">Developed by <a class="developer" href="">Jecmas Ghana</a></p>
        </div>
    </form>
    </div>
    
<!-- scripts-->
    <script src="./assets/js/jquery.min.js"></script>
    <script src="./assets/js/popper.min.js"></script>
    <script src=".assets/js/bootstrap.min.js"></script>
    
 
</body>
</html>
