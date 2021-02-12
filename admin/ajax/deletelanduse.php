<?php 

session_start();
error_reporting(E_NOTICE ^ E_ALL ^ E_WARNING);

require_once('../../functions/db_connection.php');

## ------------------------------------------##
## get landuse based on uniqueid
## from previous page/session by binding
$landuseId = "";
if(isset($_GET['landuseId']))
    $landuseId= $_GET['landuseId'];

## this code session trigger to delete a specific landuse record from db
## prepare sql statement to transact operation
if ($stmt = $connect_db->prepare('DELETE FROM `landuse` WHERE id= ?')){
    ##bind parameter to query staement
    $stmt->bind_param('i', $landuseId);
    ## execute the query
    $stmt->execute();
    
# display success message
   ?>
               <script type="text/javascript">
                alert("This landuse record has been deleted..");
                window.location = "../landuse.php";
                </script>
                <?php
	}
    else{
    //show any errors
    echo "<script>alert('Error!!\\n Could not proceess..')</script>";
}
## +++++++++++++++++++++++++++++++++++++++++ ##


?>