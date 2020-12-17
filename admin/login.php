




<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>E-Permit System - Admin Login</title>
		    <link rel="icon" href="../assets/images/uwada-logo.jpg" type="image/jpg">    
        <!--Login css-->
<!--        <link rel="stylesheet" href="../assets/css/bootstrap.css">-->
		<link rel="stylesheet" href="../assets/css/mystyles.css">
		<link rel="stylesheet" href="../assets/font-awesome/css/fontawesome-all.css">
	</head>
	
	<body>
		<div class="container login">
            <div class="top">
                <img class="logoimg" src="../assets/images/uwada-logo.jpg">
                <h1>E-Permit System</h1><span class="sub-title">Admin Dashboard - Please Login!</span>
            </div>
			<form action="" method="post" name="frmLogin" id="frmLogin" class="frm-login">
				<label for="username">
					<i class="fa fa-user"></i>
				</label>
				<input type="text" name="username" placeholder="Username" id="username" class="text-input" required>
				<label for="password">
					<i class="fa fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Password" id="password" class="text-input" required>
				<!--add links-->
            <div class="forgot-link">
            <a class="forgot-pwd" href="forgot-password.php">Forgot Password?</a>
            </div>
            <!--login button-->
				<input type="submit" value="LOGIN" name="Login">
            </form>
		</div>
<!--		 <div class="bottom-text">Developed by <a href="" class="developer">Jecmas Ghana</a></div>-->
	</body>
</html>