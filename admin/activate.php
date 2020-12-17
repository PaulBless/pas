<?php
require_once '../functions/databaseController.php';
require_once '../functions/Applications.php';
$db_handle = new databaseController();  //new instance of db controller class



## get specific userid
$appId = "";
if(isset($_GET['applicationId']));
$appId = $_GET['applicationId'];

## new object of users class
$application = new Applications();
$activate = $application->activateApplication($appId);
if(!empty($application)){
echo "<script>alert('Success!\\n \\nApplication has been re-activated successfully! This application can now be processed.')</script>";
echo"<script>window.location.href='pendinglists.php'</script>";
}

?>