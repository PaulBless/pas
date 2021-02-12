<?php

	//database configuration variables
	$host = "localhost";	//server host
	$user = "root";			//database user
	$password = "";			//password for db/server
	$database = "";
	
	//create server connection
	$database_connection = mysqli_connect($host,$user,$password);
		
	//check if sever connection exists
	if(!$database_connection)
	{
		//failed to connect server
		echo "<script>alert('Error! Connection failed..')</script>";
	}else{
		//passed server connection
		
	//query to create database
	$createDB_sql = "CREATE DATABASE `testDB`";
	//proceed to create database
	if(mysqli_query($database_connection, $createDB_sql)){
		echo "<div class='alert alert-success'>Database successfully created!</div>";
	//create tables for database
	
	/*table for admin account*/
	$sql_admin_tbl = "CREATE TABLE `admin_account` (
  `adminid` int(11) NOT NULL AUTO_INCREMENT, `fullname` varchar(350) NOT NULL,
  `mobileno` varchar(10) NOT NULL, `email` varchar(350) NULL, `username` varchar(50) NOT NULL,`password` varchar(255) NOT NULL,`activity` varchar(50) NOT NULL,`status` varchar(50) NOT NULL,`regdate` timestamp NOT NULL default current_timestamp PRIMARY KEY (`adminid`) ) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1";

	/*table for users account*/
	$sql_users_tbl = "CREATE TABLE `users_account` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,`fullname` varchar(500) NOT NULL, `mobileno` varchar(50) NOT NULL,`email` varchar(350) NULL, `department_name` VARCHAR(50) NOT NULL,`username` varchar(50) NOT NULL,`password` varchar(50) NOT NULL, `role` varchar(50) NOT NULL,`activity` varchar(50) NOT NULL,`status` varchar(50) NOT NULL,`regdate` date NOT NULL, PRIMARY KEY (`userid`)) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1";
	
		
	$table_install = mysqli_query($database_connection, $sql_admin_tbl);
	$table_install = mysqli_query($database_connection, $sql_users_tbl);

	if($table_install == true){
	echo "<div class='alert alert-success'>Tables install success</div>";
	}

}else{
		echo "<label class='text-danger'>Failed to create database..</label>" . mysqli_error($database_connection);
		}
		
	
	
	}
	
//close connection
mysqli_close($database_connection);
?>