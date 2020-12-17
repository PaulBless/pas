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
echo "<script>alert('Success!\\n \\nThis User acount has been successfully unlocked! The user can now accessed the system again..')</script>";
echo"<script>window.location.href='manage-users.php'</script>";
}

?>