<?php
## start session
session_start();

## add database connection
require_once '../functions/db_connection.php';

## get loggedin user ID
$userID = "";
if(isset($_SESSION['id']))
	$userID = $_SESSION['id'];

## get last loggedin date-time
$last_login_date = "";
if(isset($_SESSION['login_date_time']))
	$last_login_date = $_SESSION['login_date_time'];

//	$sql = "UPDATE `userlogs` SET `logout`='CURRENT_TIMESTAMP' WHERE userId =$userID AND MAX(login)=$last_login_date";
//	$run = mysqli_query($connect_db, $sql);
//if($run == true)
//{
//	echo "<script>alert('Session logout')</script>";
//}
   
	
		$logout_sql = mysqli_query($connect_db, "UPDATE `userlogs` AS s LEFT JOIN( SELECT userid,login,logout FROM userlogs ORDER BY login DESC ) AS l ON l.id = s.id SET s.logout ='CURRENT_TIMESTAMP' WHERE s.userId='$userID' and s.login=$last_login_date");
		
	## unset and destroy session
	session_unset();
	//session_destroy();

## display session message
$_SESSION['msg']="You have logged out successfully..";

		
	





?>


<!DOCTYPE html>

 <html lang="en">   
    <head>
    <meta charset="utf-8">
     <!--  Application title -->
    <title>E-Permit System </title>
    
    <!--meta information-->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Permit application and registration system for citizens to apply for building permit from the district assembly">
    <meta name="author" content="Paul Eshun">
    
    <!-- browser image -->
    <link rel="icon" href="../assets/images/logo.jpg" type="image/jpg">    
     <!-- bootstrap csss -->
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <!-- page main css -->
    <link href="../assets/css/pas-styles.css" rel="stylesheet">
    <link href="../assets/font-awesome/css/fontawesome-all.css" rel="stylesheet">
    
     
    <script type="text/javascript">
        function pageRedirect() {
            window.location.replace("index.php");
        }      

        setTimeout("pageRedirect()", 2000);
    </script>
    
    <!--  styles-->
       <style type="text/css"> 
           body{
               background: #fefefe;
               color: #3a6248;;
           }
           .logout .loader{
               position: fixed;
               left: 0px;
               top: 40%;
               width: 100%;
               z-index: 2;
/*               background: url('../assets/images/6.gif') 50% 50% no-repeat rgb(249,249,249);*/
                background:#fff url('../assets/images/loader.gif') 50% 50% no-repeat;
/*               opacity: 0.8;*/
           }
           .hint{
               display: inline-block;
               margin-top: 60px;
           }
        </style>
    </head>

<body>

    <div class="logout text-center"> 
        <div class="loader"><span class="hint">loging out, please wait...</span></div>
<!--        <div class="text-hint">Loging out, please wait...</div>-->
    </div>

</body>

</html>
