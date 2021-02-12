<?php 
session_start();
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

require_once('../../functions/db_connection.php');

## ------------------------------- ##
## get application based on uniqueid
## from previous page/session by binding
$applicationId = "";
if(isset($_GET['applicationId']))
    $applicationId= $_GET['applicationId'];

## this code session trigger to delete a specific landuse record from db
## prepare sql statement to transact operation
if ($stmt = $connect_db->prepare('DELETE FROM `applications` WHERE applicationid= ?')){
    ##bind parameter to query staement
    $stmt->bind_param('i', $applicationId);
    ## execute the query
    $stmt->execute();
    
## display success message
//    echo "<script>alert('Record Deleted!\\n\\Application record successfully deleted!');window.history.back();</script>";
	?>
            <script type="text/javascript">
             alert("This application record has been deleted..");
              window.location = "../applications.php";
           </script>
   <?php
	}
else{
    //show any errors
    echo "<script>alert('Error!!\\n Could not proceess..')</script>";
}
## +++++++++++++++++++++++++++++++++++++++++ ##


?>