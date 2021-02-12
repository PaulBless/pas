<?php

session_start();
session_destroy();

## add database connection
require_once './functions/db_connection.php';

## get loggedin user ID
$userID = "";
if(isset($_SESSION['id']))
	$userID = $_SESSION['id'];

## proceed to update table
##capture logout date and time
$logout_sql = mysqli_query($connect_db, "UPDATE userlog AS s LEFT JOIN( SELECT * FROM userlog ) AS l ON l.id = s.id SET s.logout = NOW() WHERE s.userId='$userID'
");
?>


<!DOCTYPE html>
<<html>
    <head>
          <head>
    <meta charset="utf-8">
     <!--  Application title -->
    <title>E-Permit System | Logout</title>
    
    <!--meta information-->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Permit application and registration system for citizens to apply for building permit from the district assembly">
    <meta name="author" content="Paul Eshun">
    
    <!-- browser image -->
    <link rel="icon" href="./assets/images/logo.jpg" type="image/jpg">    
     <!-- bootstrap csss -->
    <link href="./assets/css/bootstrap.css" rel="stylesheet">
    <!-- page main css -->
    <link href="./assets/css/pas-styles.css" rel="stylesheet">
    <link href="./assets/font-awesome/css/fontawesome-all.css" rel="stylesheet">
    
     
    <script type="text/javascript">
        function pageRedirect() {
            window.location.replace("index.php");
        }      

        setTimeout("pageRedirect()", 3000);
    </script>
    
    <!--  styles-->
       <style type="text/css">  
           body{
               background: #fff;
           }
           .logout .loader{
               position: fixed;
               left: 0px;
               top: 40%;
               width: 100%;
               z-index: 2;
               background: url('./assets/images/loader.gif') 50% 50% no-repeat;
               opacity: 0.8;
           }
           .hint{
               display: inline-block;
               margin-top: 60px;
           }
        </style>
    </head>
    
    <body>
        <div class="logout text-center"> 
        <div class="loader"><span class="hint">Loging out soon...</span></div>
<!--        <div class="text-hint">Loging out, please wait...</div>-->
    </div>
    </body>
</html>

