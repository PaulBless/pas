<!--new scripts-->
<?php
session_start();
include 'functions/db_connection.php';

if(isset($_POST['btnLogin']))
{
    $entered_username = mysqli_real_escape_string($_POST['username']);
    $entered_pwd =mysqli_real_escape_string($_POST['password']);
    
      // Prepare our SQL, preparing the SQL statement will prevent SQL injection.
//    if ($stmt = $connect_db->prepare('SELECT id, password FROM employee_user WHERE username = ?')) {
//	// Bind parameters (s = string, i = int, b = blob, etc), 
//    //in our case the username is a string so we use "s"
//	$stmt->bind_param('s', $_POST['username']);
//	$stmt->execute();
//	// Store the result so we can check if the account exists in the database.
//	$stmt->store_result();
//
//    //check if account exists in database
//    if ($stmt->num_rows > 0) {
//	$stmt->bind_result($id, $password);
//	$stmt->fetch();
//	// Account exists, now we verify the password.
//	// Note: remember to use password_hash in your registration file to store the hashed passwords.
//	if (password_verify($_POST['password'], $password)) {
//        // Verification success! User has loggedin!
//		// Create sessions so we know the user is logged in, they basically act like cookies but remember the data on the server.
//		session_regenerate_id();
//		$_SESSION['loggedin'] = TRUE;
//		$_SESSION['name'] = $_POST['username'];
//		$_SESSION['id'] = $id;
//		echo 'Welcome ' . $_SESSION['name'] . '!';
//        //redirect loggedin user to application homepage
//        header('location: /permits/home.php');
//	       } 
//        else {
//        //display invalid password alert message
//         echo "<script>alert('Enter valid username')</script>";
//		echo 'Incorrect password!';
//	       }
//        } 
//        else {
//         //display invalid username alert message
//        echo "<script>alert('Enter valid username')</script>";
//	   echo 'Incorrect username!';
//        }
//        
//	$stmt->close();    //close the query statement
//    }
}

?>
