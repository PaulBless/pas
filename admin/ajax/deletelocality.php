<?php 

session_start();
error_reporting(E_WARNING ^ E_ALL ^ E_NOTICE);

require('../../functions/db_connection.php');
   
## ----------------------------------------- ##
## get specific location based on uniqueid
## from previous page
$locId = "";
if(isset($_GET['locId']))
//    $locId= $_GET['locId'];
    $locId= $_REQUEST['locId'];

## this code session trigger to delete a specific location record from db
## prepare sql statement to transact operation
if ($stmt = $connect_db->prepare('DELETE FROM `locality` WHERE id= ?')){
    ##bind parameter to query staement
    $stmt->bind_param('i', $locId);
    ## execute the query
    $stmt->execute();
    
	?>
                <script type="text/javascript">
                alert("This location record has been deleted..");
                window.location = "../locations.php";
                </script>
                <?php
	}
else{
    //show any errors
    echo "<script>alert('Error!!\\n Could not proceess..')</script>";
}
## ++++++++++++++++++++++++++++++++++++++++ ##

?>