<?php
//session_start();
error_reporting(1);
require_once '../functions/databaseController.php';
require_once '../functions/Admin.php';
$db_handle = new databaseController();  //new instance of db controller class



## get specific userid
$adminId = $_GET['adminid'];
$curstate = "Inactive";

## new object of users class
$admin = new Admin();
$admin->changeAccountState($curstate, $adminId);
if(!empty($admin)){
echo "<script>alert('Success!\\nThis admin account has been de-activated successfully! The admin cannot accessed the system again..')</script>";
echo"<script>window.location.href='accounts.php'</script>";
//echo"<script>window.location.href='adminaccounts.php'</script>";
}

?>