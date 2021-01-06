<?php
require_once '../functions/databaseController.php';
require_once '../functions/Users.php';
$db_handle = new databaseController();  //new instance of db controller class



## get specific userid
$userId = $_GET['userid'];

## new object of users class
$user = new Users();
$user->unlockAccount($userId);
if(!empty($user)){
echo "<script>alert('Success!\\nThis User account has been successfully unlocked! The user can now accessed the system again..')</script>";
echo"<script>window.location.href='accounts.php'</script>";
//echo"<script>window.location.href='accounts.php'</script>";
}

?>