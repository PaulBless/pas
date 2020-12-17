<?php

//session_start();

//include 'functions/db_connection.php';
//invoke controller classes
//require_once '../functions/databaseController.php';
//require_once '../functions/Applications.php';
//require_once '../functions/Users.php';
//require_once '../functions/Admin.php';

//instance of db controller class
//$db_handle = new databaseController();

$usertype = "Admin";

//preparing the SQL statement to prevent SQL injection.
    if ($stmt = $connect_db->prepare('SELECT * FROM users_account WHERE role = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), 
    //in our case the username is a string so we use "s"
	$stmt->bind_param('s', $usertype);
	$stmt->execute();
	//store the result, and check if the account exists in the database.
	$stmt->store_result();

    //check if account exists in database
    if ($stmt->num_rows > 0) {
    //Admin account exists, go to login
     header('Location: index.php');
        }
        else{
        header('Location: ./admin/register.php');
        }
    }
        
?>