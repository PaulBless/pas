<?php 

##session begin
session_start();
error_reporting(0);

##include db class
require_once('../functions/db_connection.php');

## variables for adding new landuse
$land_name =($_POST['landuse']);
$comment = ($_POST['comment']);

##variables for adding new record
$var =mysql_real_escape_string($_POST['']);
$varent = mysql_real_escape_string($_POST['']);

    //preparing the SQL statement will prevent SQL injection.
    if ($stmt = $connect_db->prepare('SELECT land_use FROM landuse WHERE land_use = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), 
    //in our case the username is a string so we use "s"
	$stmt->bind_param('s', $land_name);
	$stmt->execute();
	$stmt->store_result(); //get & store the result, to check if exists.
    if ($stmt->num_rows > 0) {
	$stmt->bind_result($locname);
	$stmt->fetch(); 
        
    //record exists, fetch results   
    echo "<div class='alert alert-danger bounceUp col-lg-6 col-md-offset-3' style='top: 10px; transition: transform .3s ease, -webkit-transform .3s ease, -moz-transform .3s ease, -o-transform .3s ease'>"
        . "<a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a>"
        . "<strong><span class='fa fa-info fa-2x'></span> </strong>" 
        . "<strong>&nbsp;&nbsp;The record '$land_use' is already added!</strong>."
        . "</div>";
        
    }else{
    //save new record 
   if ($stmt = $connect_db->prepare('INSERT INTO landuse (land_use, comment) VALUES (?, ?)')){
	$stmt->bind_param('ss', $land_use, $comment);
	$stmt->execute();
      
    echo "<div class='alert alert-success fadeIn col-lg-6 col-md-offset-3' style='top: 10px; transition: all 0.3s ease-in-out 0s'>"
        . "<a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a>"
        . "<strong><span class='fa fa-info fa-2x'></span> </strong>" 
        . "<strong>&nbsp;&nbsp;Record saved successfully!</strong>."
        . "</div>";
        header('location: landuse.php');
        } else {
	// Something is wrong with the sql statement, 
	echo 'Could not prepare statement!';
        }  
        }
    }


?>