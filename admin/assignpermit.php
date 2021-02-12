
 
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



//get specific application ID
$appID="";
if(isset($_GET['assignId']))
    $appID=($_GET['assignId']);

//get current login userid
$user="";
if(isset($_SESSION['id']))
    $user=($_SESSION['id']);


//process form
if(isset($_POST['btnSubmit']))
{
    //check if permit number exists
    $permit_number = trim(htmlspecialchars($_POST['permitno']));
    $q = mysqli_query($connect_db, "SELECT `permit_number` FROM `permits` WHERE `permit_number`='$permit_number'");
    $data = mysqli_fetch_assoc($q);
    if(!empty($data['permit_number']))
    {
        echo "<script>alert('Error! Building development permit number exists..\\nPlease check and enter unique permit numbers');window.history.back()</script>"; 
        exit();
    }

    //show waiting response alert
    echo "<script>alert('Please wait... Checking if site inspection has been carried on this application.') </script>";
          
    //1st: check if site inspection has been done on this application
    //query from the inspections table ot see existence of applicationID
    $ret= mysqli_query($connect_db, "SELECT * FROM `inspections` WHERE applicationID='$appID'");
    $num=mysqli_fetch_array($ret);
    if($num>0)
    {
        $inspectDate = $num['inspDate'];    //get inspection date

        //show site inspection success alert
        echo "<script>alert('Response...\\nSite inspection has been successfully carried out for this application on: ".$inspectDate." \\nClick OK to proceed assign permit.')</script>";
        
        
        //2: check permit existence
        //query from permits granted table
        $sql_pe= mysqli_query($connect_db, "SELECT * FROM `permits` WHERE application_id='$appID'");
        $numRows=mysqli_fetch_array($sql_pe);
        if($numRows>0){
            ## get permit assigned details
            $ass_date = date('d M, Y', strtotime($numRows['dateAssigned']));
            $ass_number = $numRows['permit_number'];
            //error alert: permit number exists
            echo "<script>alert('Ooops...\\n This application has been already granted and assigned building development permit on: ".$ass_date." with permit number: ".$ass_number."\\nCannot assign duplicate permits.')</script>";
            }else{
                //3: save permit details
            //get form data
            $permitno = trim(htmlspecialchars($_POST['permitno']));
            $townsheet = trim(htmlspecialchars($_POST['townsheet']));
            $zoning = trim(htmlspecialchars($_POST['zoning']));
        
            //insert new permit record
            $query =  "INSERT INTO `permits` (application_id, permit_number, dateAssigned, assignedBy, townsheet, zoning) VALUES ('".$appID."', '".$permitno."', CURRENT_TIMESTAMP, '".$user."', '".$townsheet."', '".$zoning."')";
            $ins_query=mysqli_query($connect_db, $query);
			
			//change application status to Permit Granted
			$application = new Applications();
			$grantpermit = $application->grantPermit($appID);
            //show success message
            echo "<div class='alert alert-success fadeIn col-lg-6 col-md-offset-3' style='top: 10px; transition: all 0.3s ease-in-out 0s'>"
            . "<a href='#' class='close' data-dismiss='alert' aria-label='close'><i class='fa fa-times'></i></a>"
            . "<strong><span class='fa fa-gift'></span> </strong>" 
            . "<strong>&nbsp;&nbsp;Success!</strong> <br>Building development permit number has been successfully assigned to this application.."
            . "</div>"; 

            }
        
    }
    else{
        //1: check existence
        //show waiting response message
        echo "<script>alert('Please wait... Checking if site inspection has been carried on this application.') </script>";
        
        //2: if no record found
        //show error message; indicating no valid site inspection
        echo "<script>alert('Response...\\n There is no record of site inpection for this application. Site Inpection is required before proceeding to assign development permit.') </script>";
        echo"<script>window.location.href='grantpermit.php'</script>";
        
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
       
    <!--       bootstrap validator style-->
    <!-- <link rel="stylesheet" href="../third-party/dist/css/bootstrapValidator.css"> -->
    <!--        bootstrap validator script-->
    <!-- <script type="text/javascript" src="../third-party/dist/js/bootstrapValidator.js"></script> -->

       <style>
           /* custom styling to sub-menus*/
        .panel .my-sub-link:hover{
            /*            background-color: #33b35a;*/
            /*            color: white;*/
                background: #343a40;
                transition: transform .3s ease, -webkit-transform .3s ease, -moz-transform .3s ease, -o-transform .3s ease;
            }
    </style>
    
</head>
<!--   end page head here-->
    
    
<!--    begin page body-->
    <body class="padTop53" onload="">
    	
    
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
                        <h5><span class="fa fa-home"></span> E-Permit <i class="fa fa-chevron-right"></i> Transactions <i class="fa fa-chevron-right"></i> Assign Building Development Permit </h5>
                    </div>
                </div>
                  <hr />
                   
                 
                 <div class="col-lg-12">
                   <a href="grantpermit.php" class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" style="margin-right: 3px;"></i> Go Back</a>
                    <div class="box">
                    <header>
                        <div class="icons"><i class="fa fa-puzzle-piece"></i></div>
                        <h5>BUILDING DEVELOPMENT PERMIT APPROVAL</h5>
                        <div class="toolbar">
                            <ul class="nav pull-right">
                                <li>
                                    <a class="accordion-toggle minimize-box" data-toggle="collapse" href="#div-4"><i class="fa fa-smile"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </header>
                    
                <div class="panel-body col-lg-6">
                    <div class="panel panel-default ">
                        <div class="panel-heading"><i class="fa fa-th"></i>
                            Application Details</div>
                            <div class="panel-body row">
                               <!--get application details: bind with ID-->
                               <?php
                                $app_id = ($_GET["assignId"]); //application ID
                                $id=intval($_GET['assignId']);
                                $stmt = mysqli_query($connect_db, "SELECT * FROM applications WHERE applicationid='$app_id'");
                                $record = mysqli_fetch_array($stmt);

                                ?>
                                <form role="form" id="form-newpermit" method="post" class="form-horizontal col-lg-12 px-4 py-3" action="">
                                <!--complete application details-->
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Application Number: </label>
                                    <div class="col-lg-5">
                                        <input name="appnumber" id="appnumber"  value="<?php echo $record['application_no']; ?>"class="form-control" disabled/>
                                    </div>
                                </div>  
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Applicant Name: </label>
                                    <div class="col-lg-8">
                                        <input name="name" id="name"  value="<?php echo $record['name']; ?>"class="form-control" disabled />
                                    </div>
                                </div>  
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Mobile Number: </label>
                                    <div class="col-lg-5">
                                        <input name="mobile" id="mobile" value="<?php echo $record['phoneno']; ?>" class="form-control" disabled />
                                    </div>
                                </div>  
                                <div class="form-group hidden">
                                    <label class="control-label col-lg-4">Project Name: </label>
                                    <div class="col-lg-8">
                                        <input name="project" id="project" value="<?php echo $record['project_type']; ?>" class="form-control" disabled/>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Project Name: </label>
                                    <div class="col-lg-8">
                                        <textarea name="project" id="project" value="<?php echo $record['project_type']; ?>" class="form-control" disabled><?php echo $record['project_type']; ?></textarea>
                                    </div>
                                </div> 
                                <div class="form-group">
                                   <!--get site location name-->
                                   <?php $get = mysqli_query($connect_db, "SELECT loc_name FROM locality WHERE id='".$record['location']."'"); $data=mysqli_fetch_array($get); ?>
                                    <label class="control-label col-lg-4">Site Location: </label>
                                    <div class="col-lg-5">
                                        <input name="location" id="location" value="<?php echo $data['loc_name']; ?>" class="form-control" disabled />
                                    </div>
                                </div>                       
                                </form>
                                
                            </div>
                    </div>
                </div> <!-- end application details here-->    
                            
                <div class="panel-body col-lg-6">
                    <div class="panel panel-default ">
                            <div class="panel-heading"><i class="fa fa-building"></i> Building Development Approval Details</div>
                            <div class="panel-body row">
                                <form class="form-horizontal col-lg-12" name="addPermit" id="addPermit" method="post">
                                <!--district name-->
                                <div class="form-group">
                                    <label class="control-label col-lg-5">Permit Development No. <span class="text-danger">*</span></label>
                                    <div class="col-lg-7">
                                        <input name="permitno" id="permitno" onblur="" onkeyup="" class="form-control" required/>
                                    </div>
                                </div>
                                <!--town sheet-->
                                <div class="form-group">
                                    <label class="control-label col-lg-5">Town Sheet No. </label>
                                    <div class="col-lg-7">
                                        <input name="townsheet" id="townsheet" class="form-control" />
                                    </div>
                                </div> 
                                <!--zoning-->
                                <div class="form-group">
                                    <label class="control-label col-lg-5">Zoning </label>
                                    <div class="col-lg-7">
                                        <input name="zoning" id="zoning" class="form-control" />
                                    </div>
                                </div>
                                
                                <div class="form-actions no-margin-bottom" style="text-align:center; padding-top: 20px;">
								<!--  <button class="btn btn-primary " type="submit" name="test" style="font-weight: bold"> test</button>-->
                                    <button class="btn btn-success" type="submit" name="btnSubmit" style="font-weight: bold; margin-right: 10px"><i class="fa fa-handshake"></i> Grant Permit</button>
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
      
     </div>  <!--END MAIN WRAPPER -->

<?php include('../includes/footer.php'); ?>

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
        permitno: {
            group: '.col-lg-4',
                validators: {
                    notEmpty: {
                        message: 'Permit number cannot be empty, required!'
                    },
                     regexp: {
                        //                        regexp: /^[a-zA-Z0-9 -/]+$/,
                        //                        message: 'The permit number dont match format'
                    },
                }
            },
          
    });
    
        $('#form2').on('submit', function(){
            var permitno = document.getElementById('permitno').value;
            if(permitno == null || permitno ==""){
                alert ("Enter development permit number");
            }else{//do nothing
            }            
        });
        
        function validatedesc()
        {
        var des = document.forms[0]["permitno"].value; // get the value of filed
       
        if (des == null || des == "") // check if value is null or blank
        { //if yes = show an error message
            alert ("Development application number can not be blank");
        }
        else
        { //if no = do nothing
        
        }
        }   
    });

</script>

	</body>
</html>






