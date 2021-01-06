<!--begin php script-->
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
if(isset($_POST['btnLogin'])){

//post variables
$log_username = $_POST['username'];
$log_userpass = $_POST['password'];

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
   
    //now verify the password.
	if (password_verify($log_userpass, $userpwd)) {

		// Verification success! User has loggedin!
		// Create sessions so we know the user is logged in, they basically act like cookies but remember the data on the server.
		session_regenerate_id();
		$_SESSION['loggedin'] = TRUE;
		$_SESSION['uname'] = $fname;
		$_SESSION['id'] = $userid;
		date_default_timezone_set("Africa/Accra");
		$_SESSION['login_date_time'] = date('Y-m-d H:i:sa');
		
		// if remember me clicked . store values in $_COOKIE  array
		if(!empty($_POST["rememberme"])) {
		//COOKIES for username
		setcookie ("user_login",$_POST["username"],time()+ (10 * 365 * 24 * 60 * 60));
		//COOKIES for password
		setcookie ("userpassword",$_POST["password"],time()+ (10 * 365 * 24 * 60 * 60));
		} else {
		if(isset($_COOKIE["user_login"])) {
		setcookie ("user_login","");
		if(isset($_COOKIE["userpassword"])) {
		setcookie ("userpassword","");
			}
		}
	}
		//save login details
		$sql = mysqli_query($connect_db, "insert into userlogs(userId, login, logout) values ('".$_SESSION['id']."', CURRENT_TIMESTAMP, '')");
		
		//save user activity
		$sql_act = mysqli_query($connect_db, "insert into user_activities(activity, date_created) values ('".$_SESSION['uname'].", successfully logged into the  system.','".date('d/M/Y')."')");
		
        //redirect loggedin user to application homepage
		//after all parameters are checked and satisfied
        header('location: dashboard.php');
	       }
		else {
        //display invalid password message
            $_SESSION['msg']="Incorrect password";
	       }
       
		} else {
         //display invalid username message
        $_SESSION['msg']="Invalid username";
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
    
    
<body class="page-login" onload=""> 
        <!-- loader icon-->
       <div class="loading"></div>
       <!--login container-->
    <div class="login-container d-flex align-items-center justify-content-center">
       <!-- begin login form--> 
        <form class="login-form text-center" action="" method="post" role="form">
        <div class="logo"><img src="../assets/images/logo.jpg" width="100" height="100"/><span style="display: block"><h4 class="app-title">E-Permit System</h4></span>
        <span class="hint"><h6>Admin Login Portal</h6></span>  
        <!-- display error message -->
        <p class="text-danger text-bold"><?php echo $_SESSION['msg'];?>
        <?php echo $_SESSION['msg']="";?><?php echo $_SESSION['msg']="";?></p>
         </div> 
        <div class="form-group">
         <input type="text" class="form-control rounded-pill form-control-lg" placeholder="Username" name="username" value="<?php if(isset($_COOKIE["user_login"])) { echo $_COOKIE["user_login"]; } ?>" id="user_id" required autofocus>
        </div>
         <div class="form-group">
            <input type="password" class="form-control rounded-pill form-control-lg" placeholder="Password" name="password" value="<?php if(isset($_COOKIE["userpassword"])) { echo $_COOKIE["userpassword"]; } ?>"id="user_pass" required>
        </div>
        <div class="forgot-link d-flex align-items-center justify-content-between">
            <div class="form-check">
                <input type="checkbox" name="rememberme" id="remember" <?php if(isset($_COOKIE["user_login"])) { ?> checked <?php } ?> class="form-check-input">
                <label for="remember">Remember me</label>
            </div>
           <!--forgot password link-->
            <a class="forgot-pwd font-weight-semibold f-pwd" href="forgot-password.php" >Forgot Password?</a>    
        </div>
        <div class="login-link">
        <button id="submit-btn" class="btn btn-custom mt-3 btn-block font-weight-bold rounded-pill btn-login" name="btnLogin" onclick="">Login</button>
        </div>
         <!--register link-->
            <div class="register-link font-weight-normal ">Powered by <a class="new-register font-weight-semibold f-reg" href="../jecmasgh/index.html" target="blank">Jecmas Ghana</a></div>
<!--            <div class="register-link font-weight-normal ">Don't have an account? <a class="new-register font-weight-semibold f-reg" href="register.php">Register</a></div>-->
<!--
        <div class="bottom-textt ">
            <p class="lower-text">Powered by <a class="developer" href="">Jecmas Ghana</a></p>
        </div>
-->
        </form>
    </div>
    
  
<!-- scripts-->
    <script src="./assets/js/jquery.min.js"></script>
    <script src="./assets/js/popper.min.js"></script>
    <script src=".assets/js/bootstrap.min.js"></script>
    
    <script type="text/javascript">
        $(document).ready(function(){
           
			
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
