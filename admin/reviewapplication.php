
<?php
session_start();

include '../functions/db_connection.php';
//invoke controller classes
require_once '../functions/databaseController.php';
require_once '../functions/Applications.php';


//instance of db controller class
$db_handle = new databaseController();

## get system settings
$sql = "select `dist_name`,`dist_town` from settings";
$qry = mysqli_query($connect_db, $sql);
$fetch = mysqli_fetch_assoc($qry);
$district = $fetch['dist_name'];
$town = $fetch['dist_town'];


// If the user is not logged in, redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}


//get user action type
$action = "";
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}


//get application reviewid
$reviewId = "";
if (isset($_GET['reviewId'])) {
    $reviewId = $_GET['reviewId'];
}



//proceed to process data
if(isset($_POST['btnSubmit'])){
    
    echo "<script>alert('Processing your request, please wait...')</script>";
    
    //variables
    $reviewDate = date('Y-M-d');
    $appNo = "";
    if (isset($_POST['appnumber']))
        $appNo = ($_POST['appnumber']);
    
        //2nd: query `defer` table to review application
        $select = mysqli_query($connect_db, "SELECT * FROM `defer` WHERE appID='".$reviewId."' AND `state`='1'");
        $num=mysqli_fetch_array($select);
        if($num>0){
        //get review date
        $selDate = date('d M, Y', strtotime($num['dateReview']));

        //show site inspection success alert
        echo "<script>alert('Response...\\nSorry, this application record had been already reviewed on: ".$selDate." \\nCannot add duplicate records..')</script>";
        
        }else{
    
        //1st: reset application status, 
		//set it to Reviewed/New for future processing
        //by binding primary key
        $application = new Applications();
        $application->reviewApplication($reviewId);
    
        //2nd: query `defer` table to review application
        $update = mysqli_query($connect_db, "UPDATE `defer` SET `state`='1', `dateReview`='".$reviewDate."' WHERE appID='".$reviewId."'");
                          
        //	echo "<script>alert('The status of this application record with Application #: ".$appNo." has been successfully reviewed; it is now ready/available for further processing.')</script>";
        //		echo "<script>window.location.href='reviewlists.php'</script>";
        //show success message
        echo "<div class='alert alert-info fade in col-lg-6 col-md-offset-3' style='top: 10px; transition: all 0.3s ease-in-out 0s'>"
        . "<a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a>"
        . "<strong><span class='fa fa-bell'></span> </strong>" 
        . "<strong>&nbsp;&nbsp;The status of this application record with Application Number: ".$appNo." has been successfully reviewed; it is now ready for further processing!</strong>."
        . "</div>";"<script>window.location.href='reviewlists.php'</script>";
        }
}

?>


 <?php //include('../includes/header.php'); ?>
    
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> 
<html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head class="">

    <meta charset="UTF-8" />
    <title>E-Permit System  </title>
     <meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
     <!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <![endif]-->
    <!--browser icon-->
    <link rel="icon" href="../assets/images/logo.jpg" type="image/jpg">    
    <!-- GLOBAL STYLES -->
    <link rel="stylesheet" href="../admin/assets/plugins/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="../admin/assets/css/main.css" />
    <link rel="stylesheet" href="../admin/assets/css/theme.css" />
    <link rel="stylesheet" href="../admin/assets/css/MoneAdmin.css" />
    <link rel="stylesheet" href="../assets/font-awesome/css/fontawesome-all.css" />
    <!--END GLOBAL STYLES -->

    <!--page level scripts-->
    <!--   <link rel="stylesheet" href="../third-party/vendor/bootstrap/css/bootstrap.css">-->
    <link rel="stylesheet" href="../third-party/dist/css/bootstrapValidator.css">
    <!--scripts-->
    <script type="text/javascript" src="../third-party/vendor/jquery/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="../third-party/vendor/bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="../third-party/dist/js/bootstrapValidator.js"></script>
    
      
    <style>
           /* custom styling to sub-menus*/
        .panel .my-sub-link:hover{
            /*  background-color: #33b35a;*/
            /*  color: white;*/
                background: #343a40;
                transition: transform .3s ease, -webkit-transform .3s ease, -moz-transform .3s ease, -o-transform .3s ease;
            }
    </style>
    
</head>
   

<!--   BEGIN THE PAGE BODY-->
<body class="padTop53 " onload="" onreset="" >
    <div class="spinning"></div>
    
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
               <a class="app-name"> <?php echo $district . ", ". $town ?></a>
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

                    <!--ADMIN SETTINGS SECTIONS -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i id="icon" class="fa fa-user "></i>&nbsp;Howdy, <?=$_SESSION['uname']?>
                            <i id="icon" class="fa fa-chevron-down"></i>
                        </a>

                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="my-profile.php"><i class="fa fa-user-circle"></i> My Profile </a>
                            </li>
                            <li><a href="#"><i class="fa fa-tags"></i> My Tasks </a>
                            </li>
                            <li><a href="change-password.php"><i class="fa fa-lock"></i> Change Password </a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="logout.php"><i class="fa fa-sign-out-alt"></i> Logout </a>
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
                    <h5 class="media-heading"><i class="fa fa-user"></i> Login As: Admin!</h5>
                    <ul class="list-unstyled user-info">
                        <li><a class="btn btn-success btn-xs btn-circle" style="width: 10px;height: 12px;"></a> Online  
                        </li>
                    </ul>
                </div>
                <br />
            </div>
            
            <ul id="menu" class="collapse">
                <li class="panel ">
                    <a href="dashboard.php" >
                        <i class="fa fa-home"></i> Main Menu
                    </a>                                   
                </li>
                <!-- menu panel items-->
                <li class="panel ">
                    <a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" data-target="#settings-nav">
                        <i class="fa fa-cogs"> </i> Settings     
                        <span class="pull-right">
                          <i class="fa fa-angle-down"></i>
                        </span>
                    </a>
                    <ul class="collapse" id="settings-nav">
                        <li class="my-sub-link"><a href="general.php"><i class="fa fa-arrow-right"></i> General </a></li>
                        <li class="my-sub-link"><a href="locations.php"><i class="fa fa-arrow-right"></i> Locations </a></li>
                        <li class="my-sub-link"><a href="application-types.php"><i class="fa fa-arrow-right"></i> Application Category </a></li>
                        <li class="my-sub-link"><a href="landuse.php"><i class="fa fa-arrow-right"></i> Land Use</a></li>
                        <li class="my-sub-link"><a href="check-lists.php"><i class="fa fa-arrow-right"></i> Check Lists</a></li>
                        <li class="my-sub-link hidden"><a href="adminaccounts.php"><i class="fa fa-arrow-right"></i> Admin Accounts</a></li>

                    </ul>
                </li>
                 <!--panel item-->
                <li class="panel">
                    <a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle collapsed" data-target="#form-nav">
                        <i class="fa fa-users"></i>  System Users
                        <span class="pull-right">
                        <i class="fa fa-angle-down"></i>
                        </span>
                    </a>
                    <ul class="collapse" id="form-nav">
                        <li class="my-sub-link"><a href="addnew-user.php"><i class="fa fa-arrow-right"></i> Add New User </a></li>
                        <li class="my-sub-link"><a href="accounts.php"><i class="fa fa-arrow-right"></i> Accounts </a></li>
                        <li class="my-sub-link"><a href="loglist.php"><i class="fa fa-arrow-right"></i> Logs List</a></li>
                    </ul>
                </li>
                <li class="panel ">
                    <a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" data-target="#pagesr-nav">
                        <i class="fa fa-folder-open"></i> Permit Applications
                        <span class="pull-right">
                        <i class="fa fa-angle-down"></i>
                        </span>
                    </a>
                    <ul class="collapse" id="pagesr-nav">
                        <li class="my-sub-link" id="getObject"><a href="new-application.php"><i class="fa fa-arrow-right"></i> Add New Application </a></li>
                        <li class="my-sub-link" id="getObject"><a href="process-application.php"><i class="fa fa-arrow-right"></i> Process Application </a></li>
                        <li class="my-sub-link"><a href="applications.php"><i class="fa fa-arrow-right"></i> Application Lists </a></li>
                        <li class="my-sub-link"><a href="pendinglists.php"><i class="fa fa-arrow-right"></i> Pending Lists </a></li>
                    </ul>
                </li>
                <li class="panel active">
                    <a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" data-target="#chart-nav">
                        <i class="fa fa-chart-area"></i> Transactions
                        <span class="pull-right">
                        <i class="fa fa-angle-down"></i>
                        </span>
                    </a>
                    <ul class="collapse" id="chart-nav">
                        <li class="my-sub-link"><a href="grantpermit.php"><i class="fa fa-arrow-right"></i> Grant New Permit </a></li>
                        <li class="my-sub-link"><a href="reviewlists.php"><i class="fa fa-arrow-right"></i> Review Applications </a></li>
                        <li class="my-sub-link"><a href="permits.php"><i class="fa fa-arrow-right"></i> Permits Granted </a></li>
                    </ul>
                </li>
                <!--panel menu item-->
                <li><a href="committee-decisions.php"><i class="fa fa-bookmark"></i> Committee Decisions </a></li>
                <li><a href="site-inspections.php"><i class="fa fa-eye"></i> Site Inspections </a></li>
                <!--menu item-->
                    <!--
                                    <li><a href="tasks.php"><i class="fa fa-tasks"></i> Users Tasks </a></li>
                                    <li><a href="chat.php"><i class="fa fa-comments"></i> Chat Option </a></li>
                    -->
                <!-- Report menu item-->
                <li class="panel hidden">
                    <a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" data-target="#report-nav">
                        <i class="fa fa-signal"></i> Reports Menu
                        <span class="pull-right">
                        <i class="fa fa-angle-down"></i>
                        </span>
                    </a>
                    <ul class="collapse" id="report-nav">
                        <li class="my-sub-link"><a href=""><i class="fa fa-arrow-right"></i> Report Menu 1 </a></li>
                        <li class="my-sub-link"><a href=""><i class="fa fa-arrow-right"></i> Report Menu 2 </a></li>
                        <li class="my-sub-link"><a href=""><i class="fa fa-arrow-right"></i> Report Menu 3 </a></li>
                    </ul>
                </li>
                <!--menu item exit-->
                <li><a href="logout.php"><i class="fa fa-power-off"></i> Logout </a></li>

            </ul>

        </div>
        <!--END MENU SECTION -->

       
        <!--PAGE CONTENT -->
        <div id="content">
            <div class="inner" style="min-height: 700px;">
                <div class="row">
                    <div class="col-lg-12">
                       <!--page title/section-->
                        <h5><span class="fa fa-home"></span> E-Permit <i class="fa fa-chevron-right"></i> Transactions <i class="fa fa-chevron-right"></i> Review Application </h5>
                    </div>
                </div>
                  <hr />
                   
                 <div class="col-lg-12">
                   <a href="reviewlists.php" class="btn btn-warning btn-sm" style="font-weight: bold"><i class="fa fa-arrow-left" style="margin-right: 3px;"></i> Go Back</a>
                <div class="box">
                    <header>
                        <div class="icons"><i class="fa fa-share"></i></div>
                        <h5>REVIEW APPLICATION</h5>

                        <div class="toolbar">
                            <ul class="nav pull-right">
                                <li>
                                    <a class="accordion-toggle minimize-box" data-toggle="collapse" href="#div-4">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </header>
                    
                    <!--get application details-->
                    <div class="panel panel-default">
                       <div class="panel-body">
                        <div class="panel panel-default">
                            <div class="panel-heading"><i class="fa fa-building" ></i>  Application Details</div>
                                <div class="panel-body">
                                    <form class="form-horizontal" method="post">
                           <!--get record from db-->
                           <?php 
                            //instance of applications class
                            $objApplication = new Applications();
                            //fetch corresponding record
                            $results = $objApplication->getApplicationByID($reviewId);
                            
                            ?>
                            <!--application number-->
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Application Number</label>
                                    <div class="col-lg-4">
                                        <input name="appnumber" id="appnumber" class="form-control" disabled value="<?php echo $results[0]["application_no"]; ?>"/>
                                    </div>
                                </div>
                                <!--application status-->
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Application Status </label>
                                    <div class="col-lg-4">
                                        <input name="appstatus" id="appstatus" class="form-control red-bg" style="color: #efefef" disabled value="<?php echo $results[0]["status"]; ?>"/>
                                    </div>
                                </div>
                                <!--applicant fullname-->
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Applicant Name </label>
                                    <div class="col-lg-4">
                                        <input name="applicantname" id="applicantname" class="form-control" value="<?php echo $results[0]['name']; ?>" readonly/>
                                    </div>
                                </div> 
                                  <!--project title or name-->
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Project Development Name </label>
                                    <div class="col-lg-6">
                                       <textarea class="form-control" name="projectname" id="projectname" cols="6" rows="2" readonly><?php echo $results[0]['project_type']; ?></textarea>
                                    </div>
                                </div>   
                                <!--project location-->
                                <div class="form-group">
                                   <?php 
                                    //get location name by binding id
                                    $getstmt =mysqli_query($connect_db, "select loc_name from locality where id='".$results[0]['location']."'");
                                    $locName=mysqli_fetch_array($getstmt);
                                    
                                    ?>
                                    <label class="control-label col-lg-4">Project Location</label>
                                    <div class="col-lg-4">
                                        <input name="projectlocation" id="projectlocation" class="form-control" readonly value="<?php echo $locName['loc_name']; ?>" />
                                    </div>
                                </div>
                                   </form>
                                </div>

                        </div>
                          </div>                
                    
                        <!--get defer details-->
                        <div class="panel-body">
                        <div class="panel panel-default">
                            <div class="panel-heading"><i class="fa fa-bell"></i> Application Defer Details</div>
                            <div class="panel-body">
                               <?php $get=mysqli_query($connect_db, "select * from `defer` where appID='".$results[0]["applicationid"]."'"); $rsData=mysqli_fetch_array($get); ?>
                                <form class="form-horizontal" name="view_defer" id="viewDefer" method="post">
                                <!--deferred reason-->
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Deferred Reason</label>
                                    <div class="col-lg-6">
                                        <input name="defreason" id="defreason" value="<?php echo $rsData['reason']; ?>" class="form-control" readonly/>
                                    </div>
                                </div> 
                                <!--deferred date-->
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Deferred Date</label>
                                    <div class="col-lg-4">
                                        <input name="defdate" id="defdate" value="<?php echo (date('d M, Y', strtotime($rsData['dateDefer']))); ?>" class="form-control" readonly/>
                                    </div>
                                </div> 
                                <!--                               <input type="checkbox" name="review" required/> I confirm the review of this application for further processing, and development approval.-->
                                <div class="form-actions no-margin-bottom" style="text-align:center; padding-bottom: 20px;">
                            <button class="btn btn-success " type="submit" name="btnSubmit" style="font-weight: bold; margin-right: 15px"><i class="fa fa-check"></i> Confirm Review</button>
                            <a href="dashboard.php" class="btn btn-danger" style="font-weight: bold" type="reset"><i class="fa fa-times"></i>  Cancel</a>
                        </div>
                                </form>
                            </div>
                        </div>
                        </div>    
                    
                    </div>
                    
                    
                </div>
            </div>
            </div>

        </div><!--END PAGE CONTENT -->
        
    </div> <!--END MAIN WRAPPER -->

<!-- FOOTER -->
    <div id="footer" class="">
        <p>&copy; E-Permit 2020. &nbsp;Developed by <a class="app-developer"  href="../jecmasghana/index.html" target="_blank">Jecmas </a>&nbsp;</p>
    </div>
    <!--END FOOTER -->
    
    <?php //include ('../includes/footer.php'); ?>

	</body>
</html>








