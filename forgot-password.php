
<?php 
session_start();
require_once './functions/db_connection.php';


if(isset($_POST['submit']))
{
    $uname = ($_POST['username']);
    $uemail = ($_POST['email']);
	
	//preparing the SQL statement will prevent SQL injection.
    if ($stmt = $connect_db->prepare('SELECT userid, fullname, `password` FROM `users_account` WHERE username = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), 
    //in our case the username is a string so we use "s"
	$stmt->bind_param('s', $uname);
	$stmt->execute();
	//store the result, and check if the account exists in the database.
	$stmt->store_result();

    //check if account exists in database
    if ($stmt->num_rows > 0) {
	$stmt->bind_result($userid, $fname, $userpwd);
	$stmt->fetch(); 	//Account exists, fetch results
		//new password
		$new_pass = "eps12345";
		$hash_pass = md5($new_pass);
		
		echo "<script>alert('Checking our records, click Ok to proceed ')</script>";
		//proceed to reset password
		$sql = "update `users_account` SET password='$hash_pass' WHERE username='$uname' OR userid='$userid'";
		$query = mysqli_query($connect_db, $sql);
		if(!empty($query)){
			echo "<script>alert('You have successfully reset your password!\\nYou can now login with: $new_pass'); window.location='index.php'</script>";
			}
	}else {
         //display invalid username message
        echo "<script>alert('Username or email does not exists in our records'); window.location.href='forgot-password.php'</script>";
        }
        
	$stmt->close();    //close the query statement
    
	}
    
    
}
								
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <!--  Application title -->
    <title>E-Permit System</title>
    
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
        <div class="logo"><img src="./assets/images/logo.jpg" width="100" height="100"/><span style="display: block"><h3 class="app-title font-weight-semibold">E-Permit System</h3></span><br/><span><h6>Enter your username and e-mail below and we will send you a new password..</h6></span>
              
        <!-- Display error message-->
           <div class="error" style="color: red"></div>
        </div><br>
       
        <div class="form-group">
         <input type="text" class="form-control rounded-pill form-control-lg" placeholder="Enter your username" name="username" value="" id="user_id" required autofocus>
        </div>
         <div class="form-group ">
            <input type="email" class="form-control rounded-pill form-control-lg " placeholder="Enter your email " name="email" value="" id="user_email" required>
        </div> 
         
        
        <div class="submit-link">
        <button class="btn btn-custom btn-block text-uppercase font-weight-bold rounded-pill btn-login" name="submit">submit</button>
        </div>
        <div class="bottom-text">
            <p class="lower-text">Developed by <a class="developer" href="">Jecmas Ghana</a></p>
<!--            <p class="lower-text">Developed by <a class="developer" href="">Jecmas Ghana</a></p>-->
        </div>
    </form>
    </div>
    
<!-- scripts-->
    <script src="./assets/js/jquery.min.js"></script>
    <script src="./assets/js/popper.min.js"></script>
    <script src=".assets/js/bootstrap.min.js"></script>
    
        
</body>
</html>
