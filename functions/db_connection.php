<?php

//database configuration variables
//    $host = "localhost";
//	$user = "root";
//    $password = "";
//	$database = "pas";
//    $database_connection = mysqli_connect($host,$user,$password,$database);

//===========================

    //define database entities
	define('DB_SERVER','localhost');
    define('DB_USER','root');
    define('DB_PASS' ,'');
    define('DB_NAME', 'pas');
	$connect_db = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
    // Check connection
    if (mysqli_connect_errno())
    {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }



?>