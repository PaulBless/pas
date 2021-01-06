<?php
require_once '../functions/databaseController.php';
require_once '../functions/Admin.php';
$db_handle = new databaseController();  //new instance of db controller class


## get specific userid
$adminId = "";
if(isset($_GET['adminid']))
	$adminId = $_GET['adminid'];

## new object of users class
$admin = new Admin();
$admin->deleteAdmin($adminId);
if(!empty($admin)){
echo "<script>alert('Success!\\nThis admin account has been permanently deleted!')</script>";
echo"<script>window.location.href='accounts.php'</script>";
//echo"<script>window.location.href='adminaccounts.php'</script>";
}

?>