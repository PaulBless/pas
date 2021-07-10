
<?php 

session_start();
error_reporting(0);

//ensure db is added before processing script
require_once('functions/db_connection.php');


// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if (isset($_POST['btnLogin'])) {   
    //pass form username and password
    $user_name = $_POST['username'];
    //$user_pass = $_POST['password'];
    $user_pass =md5($_POST['password']); //encrypt password using Message Digest MD5

    // preparing the SQL statement to prevent SQL injection.
    if ($stmt = $connect_db->prepare('SELECT   `userid`, `password`, `role`, `status` FROM `users_account` WHERE username = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
	$stmt->bind_param('s', $user_name);
	$stmt->execute();  //execute the query
	$stmt->store_result(); // Store the result to check if the account exists

        if ($stmt->num_rows > 0) {
        $stmt->bind_result($userid, $stored_password, $user_type, $user_status);
        $stmt->fetch();
        
        //check user status
        if($user_status === "Locked") {
            echo "<script>alert('Access Denied!\\n\\nYour account is currently locked, you cannot login into the system... Please contact your system admin')</script>";
            echo "<script>window.location.href='index.php'</script>";
        } 
		
        
        // Account exists, now we verify the password.
        //verify password by hashing algorithm
        if ($user_pass === $stored_password){
        //	if (password_verify($user_pass, $stored_password)) {
            // query for insert userlog in to data base
        
            // Verification success! User has loggedin!
            //Create sessions so we know the user is logged in, 
            //they basically act like cookies but is saved on the server.
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $user_name;   //log-username
            $_SESSION['id'] = $userid;    //log-userid
            $_SESSION['role'] = $user_type; //log-usertype
            $checkRole = $user_type;
            
            mysqli_query($connect_db,"insert into userlog(userId,login,logout) values('".$_SESSION['id']."', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)");
            
            //query for insert user activity
            mysqli_query($connect_db, "insert into user_activities(activity,date_created) values('".$user_name.", successfully login into the system.', '$logdate')");
            
            //get login date and save as sesssion
            $sql_logindate = mysqli_query($connect_db, "SELECT MAX(`login`) FROM `userlog` WHERE userId='".$userid."'");
            $get_login = mysqli_fetch_assoc($sql_logindate);
            $data = $get_login['login'];
            
            $_SESSION['login_date_time'] = $data;
                
            if($checkRole == 'User'){
                header('Location: ./user/homepage.php');
            }
            elseif($checkRole == 'Officer'){
                header('Location: ./user/homepage.php');
            }
           
        }
    else {
        ## display alert popup
        echo "<script>alert('Login Error\\nWrong password, please check..')</script>"; }
    } else {
		## display alert popup
    echo "<script>alert('Login Error\\nInvalid username!')</script>";
    }

	$stmt->close();    //close sql
    }
    
}
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!--  Application title -->
    <title>E-Permit System | Users LogIn</title>
    
    <!--meta information-->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Permit application and registration system for citizens to apply for building permit from the district assembly">
    <meta name="author" content="Paul Eshun">
    
    <!-- browser image -->
    <link rel="icon" href="./assets/images/logo.jpg" type="image/jpg">    
     <!-- bootstrap csss -->
    <link href="./assets/css/bootstrap.css" rel="stylesheet">
    <!-- page main css -->
    <link href="./assets/css/pas-styles.css" rel="stylesheet">
    <link href="./assets/font-awesome/css/fontawesome-all.css" rel="stylesheet">

  <script src="./assets/js/jquery.min.js"></script>
    <script src="./assets/js/popper.min.js"></script>
    <script src=".assets/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(function(){
          $("#user_id").focus(); 
       });    
    </script>
</head>
       
<body class="page-login"> 
   <!--login container-->
   <div class="login-container d-flex align-items-center justify-content-center">
       <form class="login-form text-center" action="" method="post" role="form">
        <div class="logo"><img src="./assets/images/logo.jpg" width="110" height="110"/><span style="display: block"><h4 class="app-title">E-Permit System</h4></span>
        <span class="hint"><h6>Users Login Portal</h6></span>   
         </div> 
        <div class="form-group">
         <input type="text" class="form-control rounded-pill form-control-lg" placeholder="Username" name="username" id="user_id" required>
        </div>
         <div class="form-group">
            <input type="password" class="form-control rounded-pill form-control-lg" placeholder="Password" name="password" id="user_pass" required>
        </div>
        <div class="forgot-link d-flex align-items-center justify-content-between">
            <div class="form-check">
                <input type="checkbox" id="remember" class="form-check-input">
                <label for="remember">Remember me</label>
            </div>
            <a class="forgot-pwd font-weight-semibold f-pwd" href="forgot-password.php">Forgot Password?</a>
        </div>
        <div class="login-link">
        <button class="btn btn-custom mt-1 btn-block font-weight-bold rounded-pill btn-login" name="btnLogin"> <i class="fa fa-login-alt"></i> Login</button>
        </div>

        <div class="bottom-text text-center">
            <p class="lower-text">Powered by <a class="developer" href="#">Jecmas </a></p>
        </div>
    
       </form>
    
   </div>
    
<!-- scripts-->
<!--
    <script src="./assets/js/jquery.min.js"></script>
    <script src="./assets/js/popper.min.js"></script>
    <script src=".assets/js/bootstrap.min.js"></script>
-->
</body>
</html>
