<?php

if(isset($_POST['register']))
{
    //get for data
    $fullname=$_POST['txtfullname'];
    $username=$_POST['txtusername'];
    $password=$_POST['txtpassword'];
    $mobile=$_POST['txtmobileno'];
    $email=$_POST['txtemail'];
    $cpassword=$_POST['txtconfirmpwd'];
  
  echo "<script>alert('fullname is : ".$_POST['txtfullname']."')";
       
    
}

?>




<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>E-Permit System</title>
		    <link rel="icon" href="../assets/images/logo.jpg" type="image/jpg">    
        <!--Login css-->
		<link rel="stylesheet" href="../assets/css/mystyles.css">
		<link rel="stylesheet" href="../assets/font-awesome/css/fontawesome-all.css">
        <link rel="stylesheet" href="../assets/font-awesome/css/fontawesome.css">
        
    <!-- validate inputs-->
    <script type="text/javascript">
        $('.phone').datepicker();
        $(".phone").keydown(function (e) {
    // Allow: backspace, delete, tab, escape, enter and .
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
        // Allow: Ctrl+A, Command+A
        (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
         // Allow: home, end, left, right, down, up
        (e.keyCode >= 35 && e.keyCode <= 40)) {
        // let it happen, don't do anything
        return;
    }
    // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
    </script>
	</head>
	
	
	<body>
		<div class="container register">
            <div class="top">
                <img class="logoimg" src="../assets/images/logo.jpg">
                <h1>E-Permit System</h1><span class="sub-title">Admin Account Registration!</span>
            </div>
			<form action="" method="post" id="registration">
				
				<label for="fullname:">
					Full name:
				</label>
				<input type="text" class="form-field name" name="txtfullname" placeholder="Enter fullname" id="fullname" required>
				
				<label for="mobileno">
					Mobile No:
				</label>
				<input type="text" class="form-field phone" name="txtmobileno" placeholder="Enter mobile number" id="mobileno" min="10" required>
				
				<label for="email">
					Email ID:
				</label>
				<input type="text" class="form-field email" name="txtemail" placeholder="Enter email address" id="emailid" required>
				
				<label for="username">
					Username:
				</label>
				<input type="text" class="form-field uname" name="txtusername" placeholder="Enter username" id="username" required>
				
           <label for="password">
					Password:
				</label>
				<input type="password" class="form-field upassword" name="txtpassword" placeholder="Enter account password" id="password" required>
           <label for="confirm-pwd">
					Confirm Password:
				</label>
				<input type="password" class="form-field upassword-confirm" name="txtconfirmpwd" placeholder="Retype account password" id="confirm-password" required>
          
           <!--action buttons-->
            <div class="button-action">
            <input type="submit" value="Register" name="register" class="">
            <a href="login.php"> <input type="button" value="Cancel" name="cancel" class="">
</a>
            </div>
			</form>
			<div class="text-lower">Already have an account? <a href="login.php">Login</a></div>
		</div>
	</body>
</html>