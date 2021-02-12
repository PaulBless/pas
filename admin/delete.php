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

## ----------------------------------------- ##
//get unique id from previous session/page


?>
