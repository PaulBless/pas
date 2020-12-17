<?php
session_start();
include './functions/db_connection.php';

// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if ( !isset($_POST['username'], $_POST['password']) ) {
	// Could not get the data that should have been sent.
    echo "<script>alert('Enter valid username and password')</script>";
    } 
    
    //pass form username and password
    $user_name = $_POST['username'];
    $user_pass = $_POST['password'];

  // Prepare our SQL, preparing the SQL statement will prevent SQL injection.
    if ($stmt = $connect_db->prepare('SELECT id, password, role FROM users_account WHERE username = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
	$stmt->bind_param('s', $user_name);
	$stmt->execute();
	// Store the result so we can check if the account exists in the database.
	$stmt->store_result();

    if ($stmt->num_rows > 0) {
	$stmt->bind_result($userid, $password, $user_type);
	$stmt->fetch();
	// Account exists, now we verify the password.
	// Note: remember to use password_hash in your registration file to store the hashed passwords.
	if (password_verify($user_pass, $password)) {
        // Verification success! User has loggedin!
		//Create sessions so we know the user is logged in, 
        //they basically act like cookies but is saved on the server.
		session_regenerate_id();
		$_SESSION['loggedin'] = TRUE;
		$_SESSION['name'] = $user_name;
		$_SESSION['id'] = $userid;
        $checkRole = $user_type;
        
        if($checkRole== 'Admin'){
        //redirect user to admin dashboard
        header('Location: ../admin/dashboard.php');   
        }
        elseif($checkRole=='User'){
            header('Location: ../user/home.php');
        }
        elseif($checkRole=='Officer'){
            header('Location: ../permits/home.php');
        }
	}
    else {
        //echo 'Incorrect password, please check.';
        echo "<script>alert('Incorrect password, please check..')</script>";

	}
    } else {
	//echo 'Incorrect username!';
    echo "<script>alert('Invalid username!')</script>";
    }

	$stmt->close();    //close sql
    }
    
    
?>