<?php
require_once '../functions/databaseController.php';
require_once '../functions/Admin.php';
$db_handle = new databaseController();  //new instance of db controller class


## get specific userid
$adminId = $_GET['adminid'];

## new object of users class
$admin = new Admin();
$admin->deleteAdmin($adminId);
if(!empty($admin)){
echo "<script>alert('Success!\\n \\nThis admin account has been permanently deleted!')</script>";
echo"<script>window.location.href='adminaccounts.php'</script>";
}

?>