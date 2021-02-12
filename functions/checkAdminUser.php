<?php

session_start();

include 'functions/db_connection.php';
//invoke controller classes
require_once '../functions/databaseController.php';
require_once '../functions/Admin.php';

//instance of db controller class
$db_handle = new databaseController();


//preparing the SQL statement to prevent SQL injection.
    if ($stmt = $connect_db->prepare('SELECT * FROM system_users')) {
	$stmt->execute();

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