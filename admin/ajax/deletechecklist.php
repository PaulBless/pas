<?php
session_start();
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);

require_once('../../functions/db_connection.php');

## ---------------------------------------- ##
## get checklist based on uniqueid
## from previous page/session by binbing
$checkId = "";
if(isset($_GET['checkId']))
    $checkId= $_GET['checkId'];

## this code session trigger to delete a specific landuse record from db
## prepare sql statement to transact operation
if ($stmt = $connect_db->prepare('DELETE FROM `check_list` WHERE id= ?')){
    ##bind parameter to query statement
    $stmt->bind_param('i', $checkId);
    ## execute the query
    $stmt->execute();
    
## display success message
    ?>
                <script type="text/javascript">
                alert("This checklist record has been deleted..");
                window.location = "../check-lists.php";
                </script>
                <?php
    }
else{
    //show any errors
    echo "<script>alert('Error!!\\n Could not proceess..')</script>";
}
## +++++++++++++++++++++++++++++++++++++++++ ##

?>