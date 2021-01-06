
 
<?php
session_start();

include '../functions/db_connection.php';
//invoke controller classes
require_once '../functions/databaseController.php';
require_once '../functions/Applications.php';

//instance of db controller class
$db_handle = new databaseController();


// If the user is not logged in, redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: logout.php');
	exit;
}



//get specific application ID
$appID="";
if(isset($_GET['applicationid']))
    $appID=($_GET['applicationid']);

//get current login userid
$user="";
if(isset($_SESSION['id']))
    $user=($_SESSION['id']);


//process form
if(isset($_POST['btnSubmit']))
{
    
    //1st: check if site inspection has been done on this application
    //query from the inspections table ot see existence of applicationID
    $ret= mysqli_query($connect_db,"SELECT * FROM `inspections` WHERE applicationID='$appID'");
    $num=mysqli_fetch_array($ret);
    if($num>0)
    {
        $inspectDate = date('d M, Y', strtotime($num['inspDate']));

        //show waiting response alert
        echo "<script>alert('Please wait... Checking if site inspection has been carried on this application.') </script>";
        
        //show site inspection success alert
        echo "<script>alert('Response...\\n \\nSite inspection of this application has been successfully carried out on: ".$inspectDate." \\nCannot add duplicate records..')</script>";
        
    }
    else{
            //1: check existence
            //show waiting response message
            echo "<script>alert('Please wait... Checking if site inspection has been carried on this application.') </script>";

            //2: if no record found
            //get form data
            $remarks = $_POST['remarks'];
            $date = $_POST['insdate'];
        
            //insert new record
            $query =  "INSERT INTO `inspections` (applicationID, inspID, remarks, inspDate) VALUES ('".$appID."', '".$user."', '".$remarks."', '".$date."')";
            $ins_query=mysqli_query($connect_db, $query);
            //show success message
            echo "<div class='alert alert-success fadeIn col-lg-6 col-md-offset-3' style='top: 10px; transition: all 0.3s ease-in-out 0s'>"
            . "<a href='#' class='close' data-dismiss='alert' aria-label='close'><i class='fa fa-times'></i></a>"
            . "<strong><span class='fa fa-gift'></span> </strong>" 
            . "<strong>&nbsp;&nbsp;Success!</strong> <br>Site inspection details successfully specified to this application.."
            . "</div>"; 
//        echo"<script>window.location.href='carryinspection.php'</script>";
        
        }   
}


?>


<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> 
<html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
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
   <link rel="stylesheet" href="../third-party/dist/css/bootstrapValidator.css">
    <!--scripts-->
   <script type="text/javascript" src="../third-party/vendor/jquery/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="../third-party/vendor/bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="../third-party/dist/js/bootstrapValidator.js"></script>
 

    <style type="text/css">
        .panel .my-sub-link:hover{
    /*            background-color: #33b35a;*/
    /*            color: white;*/
                background: #343a40;
                transition: transform .3s ease, -webkit-transform .3s ease, -moz-transform .3s ease, -o-transform .3s ease;
            }
		.spinning{
			opacity: 0.7;
			background: #ccc url(../assets/images/spin.gif) no-repeat center;
			position: fixed;
			width: 100%;
			height: 100%;
			top: 0px;
			left: 0px;
			z-index: 2000;
			display: none;
				
		}
    </style>
    
	</head><!-- END HEAD -->
	
	
<!--    BEGIN PAGE BODY-->
<body class="padTop53" onload="">
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
                <li class="panel ">
                    <a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" data-target="#chart-nav">
                        <i class="fa fa-chart-area"></i> Transactions
                        <span class="pull-right">
                        <i class="fa fa-angle-down"></i>
                        </span>
                    </a>
                    <ul class="collapse" id="chart-nav">
                        <li class="my-sub-link"><a href="grantpermit.php"><i class="fa fa-arrow-right"></i> Grant New Permit </a></li>
                        <li class="my-sub-link"><a href="reviewlists.php"><i class="fa fa-arrow-right"></i> Review Applications </a></li>
                        <li class="my-sub-link"><a href="permits.php"><i class="fa fa-arrow-right"></i> Building Permits </a></li>
                    </ul>
                </li>
                <!--panel menu item-->
                <li><a href="committee-decisions.php"><i class="fa fa-bookmark"></i> Committee Decisions </a></li>
                <li class="panel active"><a href="site-inspections.php"><i class="fa fa-eye"></i> Site Inspections </a></li>
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
                        <h5><span class="fa fa-home"></span> E-Permit <i class="fa fa-chevron-right"></i> Site Inspections <i class="fa fa-chevron-right"></i> Add Inspection</h5>
                    </div>
                </div>
                  <hr />
                   
                 
                 <div class="col-lg-12">
                   <a href="carryinspection.php" class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" style="margin-right: 3px;"></i> Go Back</a>
                <div class="box">
                    <header>
                        <div class="icons"><i class="fa fa-anchor"></i></div>
                        <h5>ADD SITE INSPECTION</h5>
                        <div class="toolbar">
                            <ul class="nav pull-right">
                                <li>
                                    <a class="accordion-toggle minimize-box" data-toggle="collapse" href="#div-4"><i class="fa fa-smile"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </header>
                    
                <div class="panel-body">
                    <div class="panel panel-default">
                        <div class="panel-heading"><i class="fa fa-building"></i>
                            Application Details</div>
                            <div class="panel-body">
                               <!--get application details: bind with ID-->
                               <?php
                                $app_id = ($_GET["applicationid"]); //application ID
                                $id=intval($_GET['applicationid']);
                                $stmt = mysqli_query($connect_db, "SELECT * FROM applications WHERE applicationid='$app_id'");
                                $record = mysqli_fetch_array($stmt);

                                ?>
                                <form role="form" id="form-newpermit" method="post" class="form-horizontal px-4 py-3" action="">
                                <!--complete application details-->
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Application Number: </label>
                                    <div class="col-lg-4">
                                        <input name="appnumber" id="appnumber"  value="<?php echo $record['application_no']; ?>"class="form-control" disabled/>
                                    </div>
                                </div>  
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Applicant Name: </label>
                                    <div class="col-lg-4">
                                        <input name="name" id="name"  value="<?php echo $record['name']; ?>"class="form-control" disabled />
                                    </div>
                                </div>  
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Mobile Number: </label>
                                    <div class="col-lg-4">
                                        <input name="mobile" id="mobile" value="<?php echo $record['phoneno']; ?>" class="form-control" disabled />
                                    </div>
                                </div>  
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Project Name: </label>
                                    <div class="col-lg-7">
                                        <input name="project" id="project" value="<?php echo $record['project_type']; ?>" class="form-control" disabled/>
                                    </div>
                                </div> 
                                <div class="form-group">
                                   <!--get site location name-->
                                   <?php $get = mysqli_query($connect_db, "SELECT loc_name FROM locality WHERE id='".$record['location']."'"); $data=mysqli_fetch_array($get); ?>
                                    <label class="control-label col-lg-4">Site Location: </label>
                                    <div class="col-lg-4">
                                        <input name="location" id="location" value="<?php echo $data['loc_name']; ?>" class="form-control" disabled />
                                    </div>
                                </div>                       
                                </form>
                                
                            </div>
                    </div>
                </div> <!--end application details here-->    
                            
                <div class="panel-body">
                    <div class="panel panel-default">
                            <div class="panel-heading"><i class="fa fa-th"></i> Site Inspection Details</div>
                            <div class="panel-body">
                                <form class="form-horizontal" name="addPermit" id="addPermit" method="post" role="form">
                                <!--district name-->
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Inspection Remarks</label>
                                    <div class="col-lg-7">
                                        <input name="remarks" id="remarks" class="form-control " placeholder="Enter remarks or recommendation" required/>
                                    </div>
                                </div>
                                <!--town sheet-->
                                <div class="form-group ">
                                    <label class="control-label col-lg-4">Inspection Date </label>
                                    <div class="col-lg-4">
                                        <input name="insdate" id="insdate" class="form-control" type="date" required/>
                                    </div>
                                </div>
                              
                                <div class="form-actions no-margin-bottom" style="text-align:center; padding-top: 20px; paddig-left: 250px;">
<!--                                    <button class="btn btn-primary " type="submit" name="test" style="font-weight: bold"> test</button>-->
                                    <button class="submitBtn btn btn-success " type="submit" name="btnSubmit" style="font-weight: bold; margin-right: 15px"><i class="fa fa-save"></i> Save Record</button>
                                    <a href="dashboard.php" class="btn btn-danger " type="reset" style="font-weight: bold"><i class="fa fa-times"></i>  Cancel</a>
                                </div>
                                </form>
                    
                            </div>
                        </div>
                </div>
    
                </div>
            </div>
                </div>

            </div>
        <!--END PAGE CONTENT -->
        
    </div> <!--END MAIN WRAPPER -->

<!--PAGE FOOTER-->
	<div id="footer">
		<p class="">&copy; E-Permit 2020. &nbsp;Developed by <a href="" class="app-developer">Jecmas</a></p>
	</div>

<!--javascripts-->
<script type="text/javascript">
    $(document).ready(function(){
		
        //bootstrap form-control fields validation
    	$('#addPermit').bootstrapValidator({
//        live: 'disabled',
        message: 'This value is not valid',
        feedbackIcons: {
//            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        remarks: {
            group: '.col-lg-4',
                validators: {
                    notEmpty: {
                        message: 'Remarks cannot be empty, required!'
                    },
                     regexp: {
                        regexp: /^[a-zA-Z ]+$/,
                        message: 'The recommendation must be alphabets only'
                    },
                }
            },
        inspdate: {
            group: '.col-lg-4',
                validators: {
                    notEmpty: {
                        message: 'Inspection date cannot be empty, enter valid date!'
                    },
                     regexp: {
//                        regexp: /^[a-zA-Z0-9 -/]+$/,
//                        message: 'The permit number dont match format'
                    },
                }
            },
          
        });
	});
        
		//keypress event for datetime
    jQuery("#inspdate").keypress(function(ev){
    var x = $(this).val();
    if (ev.keyCode < 48 || ev.keyCode > 57) {
      ev.preventDefault();
        }
    });
    
		//form submit function validation
        $('#form2').on('submit', function(){
            var permitno = document.getElementById('remarks').value;
            if(permitno == null || permitno ==""){
                alert "Enter site inspection remarks";
            }else{//do nothing
            }            
        });
        		
</script>

<script type="text/javascript">    	
	//page loading script
	function pageLoading(){
		$('.spinning').show();
		setTimeout(function(){
			$('.spinning').hide();
		}, 500);
	}
	</script>
</body>
</html>
	






