
<?php 
session_start();
$msg = "";

if(isset($_POST['submit']))
{
    $uname = ($_POST['username']);
    $res = "";
    
    
}
								
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
    <meta name="description" content="Permit processing and registration system for citizens to apply for building permit from the district assembly">
    <meta name="author" content="Paul Eshun">
    
    <!-- browser image -->
    <link rel="icon" href="./assets/images/logo.jpg" type="image/jpg">    
     <!-- Custom CSS -->
    <link href="./assets/css/bootstrap.css" rel="stylesheet">
    <!-- login-page main css -->
    <link href="./assets/css/pas-styles.css" rel="stylesheet">
    <!--  Font-awesome icons -->

    </head>
    
<body class="page-forgot-pwd"> 
   
    <!--login container-->
    <div class="forgot-password-container d-flex align-items-center justify-content-center">
    <form class="forgot-form text-center" method="post" role="form" action="">
        <div class="logo"><img src="./assets/images/logo.jpg" width="120" height="120"/><span style="display: block"><h3 class="app-title font-weight-semibold">Permit Application System</h3></span><br/><span><h6>Enter your username and e-mail below and we will send you a new password..</h6></span>
              
        <!-- Display error message-->
           <div class="error" style="color: red"><?php if($msg != "") echo $msg . "<br>"; ?></div>
        </div><br>
       
        <div class="form-group">
            <div class="input-group">
                <input type="text" class="form-control rounded-pill form-control-lg" placeholder="Username" name="username" required>
            </div>
        </div>
         <div class="form-group">
             <div class="input-group">
                <input type="email" class="form-control rounded-pill form-control-lg" placeholder="Email" name="email" required>
             </div>
        </div>
        <div class="submit-link">
        <button class="btn btn-custom mt-3 btn-block text-uppercase font-weight-bold rounded-pill btn-login" name="submit">recover password</button>
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
