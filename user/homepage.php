
<?php
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: ../index.php');
	exit;
}


## set/get user credentials
$loguser="";
$logrole="";
## get login username
if(isset($_SESSION['name'])){
    $loguser = $_SESSION['name'];
    }else{$loguser = ""; header('location: ../index.php');}
## get login user role
if(isset($_SESSION['role'])){
    $logrole = $_SESSION['role'];
    }else{$logrole = ""; header('location: ../index.php');}
?>


 
 <!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> 
<html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="UTF-8" />
    <title>E-Permit System </title>
     <meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
     <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <![endif]-->
    <!--browser icon-->
    <link rel="icon" href="../assets/images/logo.jpg"logo.jpg" type="image/jpg">  
      
    <!-- GLOBAL STYLES -->
    <link rel="stylesheet" href="../admin/assets/plugins/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="../admin/assets/css/main.css" />
    <link rel="stylesheet" href="../admin/assets/css/theme.css" />
    <link rel="stylesheet" href="../admin/assets/css/MoneAdmin.css" />
    <link rel="stylesheet" href="../assets/font-awesome/css/fontawesome-all.css" />
    <!--END GLOBAL STYLES -->
	
	<!--   page level styles -->
    <link href="../admin/assets/css/layout2.css" rel="stylesheet" />
    <link href="../admin/assets/plugins/flot/examples/examples.css" rel="stylesheet" />
    <link rel="stylesheet" href="../admin/assets/plugins/timeline/timeline.css" />

     
    <!--scripts-->
    <script type="text/javascript" src="../third-party/vendor/jquery/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="../third-party/vendor/bootstrap/js/bootstrap.js"></script>

    <!-- function to show loader on pageloading-->
	<script type="text/javascript">
		function pageLoading(){
			$('.loading').show();
			setTimeout(function(){
				$('.loading').hide();
			}, 2500);
		}
	</script>
   
    <!--stylesheet-->
    <style type="text/css">
        legend{
            font-size: 15px;
            font-weight: bold;
            color: #5b6574;
			}
		 .loading{
            opacity:1.0;
            background:#c1c1c1 url(../assets/images/spin.gif) no-repeat center;
            position:fixed;
            width:100%;
            height:100%;
            top:0px;
            left:0px;
            z-index:2000;
            display: none;
        }
		
    </style>
</head>    <!-- END HEAD -->

   
    <!-- BEGIN BODY -->
<body class="padTop53" onload="pageLoading()" >
	<div class="loading"></div>
 <!-- MAIN WRAPPER -->
    <div id="wrap" >
        
        <!-- HEADER SECTION -->
        <div id="top">
            <nav class="navbar navbar-inverse navbar-fixed-top " style="padding-top: 10px;">
                <a data-original-title="Show/Hide Menu" data-placement="bottom" data-tooltip="tooltip" class="accordion-toggle btn btn-primary btn-sm visible-xs" data-toggle="collapse" href="#menu" id="menu-toggle">
                    <i class="fa fa-bars"></i>
                </a>
                <!-- LOGO SECTION -->
                <header class="navbar-header">
                <!--app name/title-->
<!--                <img src="../assets/images/logo.jpg" width="25" height="25">-->
               <a class="app-name"> E-Permit System</a>
                <!-- add search button-->
                </header>
                <!-- END LOGO SECTION -->
                <ul class="nav navbar-top-links navbar-right">

                    <!-- MESSAGES SECTION -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="tooltip" title="View Messages" href="#"><!--link to notifications-->
                         <i id="icon" class="fa fa-bell"></i>&nbsp; 
                        </a>
                    </li>
                    <!--END MESSAGES SECTION -->

                    <!--USER SETTINGS SECTIONS -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i id="icon" class="fa fa-user "></i>&nbsp;Welcome, <?=$_SESSION['name']?>
                            <i id="icon" class="fa fa-chevron-down"></i>
                        </a>

                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="user-profile.php"><i class="fa fa-user-circle"></i> My Profile </a>
                            </li>
                            <li><a href=""><i class="fa fa-tags"></i> My Tasks </a>
                            </li>
                            <li><a href="update-password.php"><i class="fa fa-lock"></i> Change Password </a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="../logout.php"><i class="fa fa-sign-out-alt"></i> Logout </a>
                            </li>
                        </ul>

                    </li>
                    <!--END ADMIN SETTINGS -->
                    
                </ul>

            </nav>

        </div>
        <!-- END HEADER SECTION -->


        <!-- MENU SECTION -->
       <div id="left" >
            <div class="media user-media well-small">
                <div class="media-body">
                    <h5 class="media-heading"><i class="fa fa-user"></i> Login As: <?=$_SESSION['role'];?></h5>
                    <ul class="list-unstyled user-info">
                        <li><a class="btn btn-success btn-xs btn-circle" style="width: 10px;height: 12px;"></a> Online  
                        </li>
                    </ul>
                </div>
                <br />
            </div>
            
            <!--list items-->
            <ul id="menu" class="collapse">
                <li class="panel active">
                    <a href="homepage.php" >
                        <i class="fa fa-home"></i> Main Menu
                    </a>                                   
                </li>

                <!--menu item -->
                <li><a href="addapplication.php"><i class="fa fa-plus"></i> Add New Application </a></li>
                <!--menu item-->
                <li class="panel"><a href="search-applications.php"><i class="fa fa-search"></i> Search Applications </a></li>
                <!--menu item-->
                <li class="panel"><a href="mysubmisssions.php"><i class="fa fa-folder"></i> My Submitted Forms </a></li>
                <li class="panel"><a href="building-permits.php"><i class="fa fa-star"></i> Building Permits </a></li>
                <!--menu item-->
<!--                <li class="panel"><a href="chat.php"><i class="fa fa-comments"></i> Chat Option </a></li>-->
               
                <!--menu item exit-->
                <li class="panel"><a href="../logout.php" onclick=""><i class="fa fa-power-off"></i> Logout</a></li>

            </ul>

        </div>
        <!--END MENU SECTION -->

        <!--PAGE CONTENT -->
        <div id="content">
                     
            <div class="inner" style="min-height: 700px;">
                <div class="row">
                    <div class="col-lg-12">
                       <!--page title/section-->
                        <h5><span class="fa fa-home"></span> E-Permit <i class="fa fa-chevron-right"></i> User Dashboard </h5>
                    </div>
                </div>
                  <hr />
                  
                 <!--HOME SECTION -->
                 <div class="row">
                     <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Electronic Permit System
                            </div>                   
                            <div class="app-details" style="padding: 20px">
                            <p>This is an electronic web based system or application designed and developed for internal use in managing and processing building applications permits. 
                            
                            </p> 
                            <p>
                            The application is designed with user functionalities that enable easy and efficient application, processing, tracking, monitoring and generating of building application permits.
                            </p>
                            <p>
                            This is a complete web based information management system build for smart use in district assemblies for a complete end-to-end processing and reporting of permits.
                            </p>
                            <p>
                            It comes with features such as registering new applications, searching through application records, filtering individual applications, generating and granting unique building permits  numbers, etc.
                            </p>
                            <p>
                             
                            </p>
                            </div>
                        </div>
                    </div>
                </div>
                 
                 
                   <!-- CHART & CHAT  SECTION -->
                 <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Real Time Traffic
                            </div>                   
                            <div class="demo-container">
                                <div id="placeholderRT" class="demo-placeholder"></div>
                            </div>
                        </div>
                    </div>

                </div>
                 <!--END CHAT & CHAT SECTION -->
                 
                
            </div>

        </div>
        <!--END PAGE CONTENT -->

    </div>

    <!--END MAIN WRAPPER -->
    
    <!-- FOOTER -->
    <div id="footer">
        <p>&copy; E-Permit 2020. &nbsp;Developed by <a class="app-developer" style="" href="">Jecmas </a>&nbsp;</p>
    </div>
    <!--END FOOTER -->

<!-- PAGE LEVEL SCRIPTS -->
    <script src="../admin/assets/plugins/flot/jquery.flot.js"></script>
    <script src="../admin/assets/plugins/flot/jquery.flot.resize.js"></script>
    <script src="../admin/assets/plugins/flot/jquery.flot.time.js"></script>
     <script  src="../admin/assets/plugins/flot/jquery.flot.stack.js"></script>
    <script src="../admin/assets/js/for_index.js"></script>

	</body>
</html>

