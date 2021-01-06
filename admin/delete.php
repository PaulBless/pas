<?php
##start session
session_start();
error_reporting(E_ALL ^ E_NOTICE);

##include db connection
require_once ('../functions/db_connection.php');

## fetch locations lists
$locationID = $_GET['loc_id'];
    $sql = "select * from locality order by loc_name asc";
        $rest =mysqli_query($connect_db, $sql);
            $numRows = mysqli_num_rows($rest);
            if($numRows == 0){

            }else{
                echo '<select name="location" id="location">';
                while($locations = mysqli_fetch_assoc($rest))
                {
                    echo '<option value="'.$locations['id'].'">' .$locations['loc_name'].'<option>';
                }
                echo '</select>';
    }


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
                window.location = "applications.php";
                </script>
                <?php
	}
else{
    //show any errors
    echo "<script>alert('Error!!\\n Could not proceess..')</script>";
}
## +++++++++++++++++++++++++++++++++++++++++ ##

    
    

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
                window.location = "locations.php";
                </script>
                <?php
	}
else{
    //show any errors
    echo "<script>alert('Error!!\\n Could not proceess..')</script>";
}
## ++++++++++++++++++++++++++++++++++++++++ ##


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
                window.location = "landuse.php";
                </script>
                <?php
	}
else{
    //show any errors
    echo "<script>alert('Error!!\\n Could not proceess..')</script>";
}
## +++++++++++++++++++++++++++++++++++++++++ ##



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
                window.location = "check-lists.php";
                </script>
                <?php
    }
else{
    //show any errors
    echo "<script>alert('Error!!\\n Could not proceess..')</script>";
}
## +++++++++++++++++++++++++++++++++++++++++ ##



## ----------------------------------------- ##
//get unique id from previous session/page


?>
