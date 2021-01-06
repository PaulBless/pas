<?php

##start session
session_start();
error_reporting(0);

##include db connection
require_once '../functions/db_connection.php';

//function triggers to save user login credentials
function saveLoginDetails($logid){
	$sql = mysqli_query($connect_db, "insert into userlogs(userId, login, logout) values ($logid, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)");
	if($sql == true){
		
	}
}

## proceed to execute on clicking login button
if(isset($_POST['btnRecover'])){

//post variables
$log_username = $_POST['username'];
$log_usermail = $_POST['email'];

	//preparing the SQL statement will prevent SQL injection.
    if ($stmt = $connect_db->prepare('SELECT adminid, fullname, password FROM admin_account WHERE username = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), 
    //in our case the username is a string so we use "s"
	$stmt->bind_param('s', $log_username);
	$stmt->execute();
	//store the result, and check if the account exists in the database.
	$stmt->store_result();

    //check if account exists in database
    if ($stmt->num_rows > 0) {
	$stmt->bind_result($userid, $fname, $userpwd);
	$stmt->fetch(); 	//Account exists, fetch results
		//new password
		$new_pass = "eps12345";
		$hash_pass = password_hash($new_pass, PASSWORD_DEFAULT);
		
		echo "<script>alert('Checking our records, click Ok to proceed ')</script>";
		//proceed to reset password
		$sql = "update admin_account SET password='$hash_pass' WHERE username='$log_username' OR adminid='$userid'";
		$query = mysqli_query($connect_db, $sql);
		if(!empty($query)){
			echo "<script>alert('You have successfully reset your password!\\nYou can now login with: $new_pass'); window.location='index.php'</script>";
			}
	}else {
         //display invalid username message
        $_SESSION['msg']="Username or email does not exists";
        }
        
	$stmt->close();    //close the query statement
    
	}
	
	
}

?> 
<!--end php script-->



<!DOCTYPE html>
<html lang="en">
<head>
    <!--  Application title -->
    <title>E-Permit System </title>
    
    <!--meta information-->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Permit application and registration system for citizens to apply for building permit from the district assembly">
    <meta name="author" content="Paul Eshun">
    
    <!-- browser image -->
    <link rel="icon" href="../assets/images/logo.jpg" type="image/jpg">    
     <!-- bootstrap csss -->
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <!-- page main css -->
    <link href="../assets/css/pas-styles.css" rel="stylesheet">
    <link href="../assets/font-awesome/css/fontawesome-all.css" rel="stylesheet">
    
    <style lang="" type="text/css">
        .loading{
            opacity: 0.5;
            background:#fefefe url(../assets/images/loader.gif) no-repeat center;
            position:fixed;
            width:100%;
            height:100%;
            top:0px;
            left:0px;
            z-index:2000;
            display: none;
        }
    </style>
    

   <script type="text/javascript"> 
//        jQuery(function(){ jQuery("input[name=username]").focus();}); 
//       $(function(){
//          $("user_id").focus(); 
//       });
    </script>
   
   </head>
    
    
<body class="page-forgot-pwd" onload=""> 
        <!-- loader icon-->
       <div class="loading"></div>
       <!--login container-->
    <div class="forgot-password-container d-flex align-items-center justify-content-center">
       <!-- begin login form--> 
        <form class="forgot-form text-center" action="" method="post" role="form">
        <div class="logo"><img src="../assets/images/logo.jpg" width="100" height="100"/><span style="display: block"><h4 class="app-title" style="font-size: 16px">E-Permit System</h4></span>
        <span class="hint"><h6>Reset your password</h6></span>  
        <!-- display error message -->
        <p class="text-danger text-bold"><?php echo $_SESSION['msg'];?>
        <?php echo $_SESSION['msg']="";?><?php echo $_SESSION['msg']="";?></p>
         </div> 
        <div class="form-group">
         <input type="text" class="form-control rounded-pill form-control-lg" placeholder="Enter your username" name="username" value="" id="user_id" required autofocus>
        </div>
         <div class="form-group ">
            <input type="email" class="form-control rounded-pill form-control-lg " placeholder="Enter your email " name="email" value="" id="user_email" required>
        </div> 
         
       
        <div class="login-link">
        <button id="submit-btn" class="btn btn-custom mt-3 btn-block font-weight-bold rounded-pill btn-login" name="btnRecover" onclick="">Submit</button>
        </div>
         <!--register link-->
            <div class="login-link font-weight-normal " style="margin-top: 10px;">Already have an account? <a class="new-register font-weight-semibold f-reg" href="index.php" style="color: #3a6248">Login</a></div>
<!--            <div class="register-link font-weight-normal ">Don't have an account? <a class="new-register font-weight-semibold f-reg" href="register.php">Register</a></div>-->
<!--
        <div class="bottom-textt ">
            <p class="lower-text">Powered by <a class="developer" href="">Jecmas Ghana</a></p>
        </div>
-->
        </form>
    </div>
    
  
<!-- scripts-->
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="..assets/js/bootstrap.min.js"></script>
    
    <script type="text/javascript">
        $(document).ready(function(){
           
			$('#submit-btn').click(function(){
				alert 'button clicked';
			});
        });
      
    </script>
    
    <script type="text/javascript" lang="javascript">
		function process(){
			$('.loading').show();
			$.ajax({
			url:'./checkAdminUser.php',
			method:'GET',
//			data:{id:$id},
			success:function(){
					setTimeout(function(){
						$('.loading').fadeToggle();		
					},1500)
				}
			})
		}
	</script>
</body>
</html>

