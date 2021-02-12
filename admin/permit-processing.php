<?php
session_start();
error_reporting(0);

require_once '../functions/db_connection.php';

//invoke db classes
require_once '../functions/databaseController.php';
require_once '../functions/Applications.php';


//new instance of db controller
$db_handle = new databaseController();

## get system settings
$sql = "select `dist_name`,`dist_town` from settings";
$qry = mysqli_query($connect_db, $sql);
$fetch = mysqli_fetch_assoc($qry);
$district = $fetch['dist_name'];
$town = $fetch['dist_town'];


if(!isset($_SESSION['loggedin'])){
    header('Location: ./index.php');
    exit;
}

$app_id = "";
if(isset($_GET['applicationid']))
    $app_id=$_GET['applicationid'];

//get checklist types
$getChecklists=mysqli_query($connect_db, "select * from check_list");
$result = mysqli_fetch_array($getChecklists);


//process form data
if(isset($_POST['process'])){
   
     $checkID = $_POST['checklist'];    //get checklist ID
		
	//save each checklist item
    foreach($checkID as $clid)
        {
        //save application processes, checklist items
        $save = mysqli_query($connect_db, "INSERT INTO `app_processes` (app_id, check_id, dateEncode) VALUES ('".$app_id."', '".$clid."', CURRENT_TIMESTAMP)");
        }
    
    //invoke process method in Applications class
    $objApplication = new Applications();
    $process = $objApplication->processApplication($app_id);
          
    if($save == true){
    echo "<script>alert('Application successfully processed!\\nIt will be evaluated by the Technical Sub-Committee, and Statutory Planning Committee for possible approval.')</script>";
    echo "<script>window.location.href='process-application.php'</script>";//     
                }
        else{
            echo "<script>alert('Request failed.. Could not execute process)</script>";
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
    <link rel="icon" href="../assets/images/logo.jpg"logo.jpg" type="image/jpg">  
      
    <!-- GLOBAL STYLES -->
    <link rel="stylesheet" href="../admin/assets/plugins/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="../admin/assets/css/main.css" />
    <link rel="stylesheet" href="../admin/assets/css/theme.css" />
    <link rel="stylesheet" href="../admin/assets/css/MoneAdmin.css" />
    <link rel="stylesheet" href="../assets/font-awesome/css/fontawesome-all.css" />
    <!--END GLOBAL STYLES -->

     
      <!--page level styles-->
    <link rel="stylesheet" href="../third-party/dist/css/bootstrapValidator.css">
    <!--
        <link rel="stylesheet" href="assets/css/jquery-ui.css">
        <link rel="stylesheet" href="../admin/assets/plugins/tagsinput/jquery.tagsinput.css">
        <link rel="stylesheet" href="../admin/assets/plugins/chosen/chosen.min.css">
    -->
     <link href="../admin/assets/css/bootstrap-fileupload.min.css" rel="stylesheet" />
     <link href="../admin/assets/plugins/switch/static/stylesheets/bootstrap-switch.css" rel="stylesheet" />
    
    <!--
        <link href="../admin/assets/plugins/jquery-steps-master/demo/css/normalize.css" rel="stylesheet" />
        <link href="../admin/assets/plugins/jquery-steps-master/demo/css/jquery.steps.css" rel="stylesheet" />
        <link href="../admin/assets/plugins/jquery-steps-master/demo/css/wizardMain.css" rel="stylesheet" />
    -->
    <link href="../admin/assets/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet" />

    <!--scripts-->
    <!--jquery 1.0 library-->
    <script type="text/javascript" src="../third-party/vendor/jquery/jquery-1.10.2.min.js"></script>
    
      <!--jquery3.3.1 library-->
    <!--    <script type="text/javascript" src="../assets/js/jquery-3.3.1.min.js"></script>-->
        <!--datatable js-->
    <!--    <script type="text/javascript" src="../assets/js/datatables.min.js"></script>-->
    <!--    -->
    <script type="text/javascript" src="../third-party/vendor/bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="../third-party/dist/js/bootstrapValidator.js"></script>
  
  
    <!--stylesheet-->
    <style type="text/css">
        legend{
            font-size: 15px;
            font-weight: bold;
            color: #5b6574;
        }
       
        .panel .my-sub-link:hover{
        /*   background-color: #33b35a;*/
        /*   color: white;*/
            background: #343a40;
            transition: transform .3s ease, -webkit-transform .3s ease, -moz-transform .3s ease, -o-transform .3s ease;
        }
        
    </style>
</head>    <!-- END HEAD -->

   
    <!-- BEGIN BODY -->
<body class="padTop53">
    
        <div class="alert alert-warning fadeInDown hidden" style="visibility: visible; animation-duration: 1500ms; animation-delay: 300ms; animation-name: fadeInDown;" role="alert" id="myAlert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> <span class="sr-only">Close</span></button>
            <strong>Important!!</strong> Before continuing to process this application, make sure all relevants documents, files and information are specified and/or attached.
        </div>
   
 
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
                            <li><a href=""><i class="fa fa-tags"></i> My Tasks </a>
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
                <li class="panel active">
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
                <li class="panel">
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
<!--                <li><a href="tasks.php"><i class="fa fa-tasks"></i> Users Tasks </a></li>-->
<!--                <li><a href="chat.php"><i class="fa fa-comments"></i> Chat Option </a></li>-->
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
                        <h5><span class="fa fa-home"></span> E-Permit <i class="fa fa-chevron-right"></i> Main Menu <i class="fa fa-chevron-right"></i> Applications <i class="fa fa-chevron-right"></i> Process Application</h5>
                    </div>     
                </div>
                
                  <hr />
                  
            <!--HOME SECTION -->
            <div class="row">
                <div class="col-lg-12">
                    <!--  go back link-->
                    <a href="process-application.php" class="btn btn-warning right btn-sm"><i class="fa fa-arrow-left"></i> Go Back</a>
                    <div class="box">
                        <header><div class="icons"><i class="fa fa-link"></i></div>
                        <h5>PROCESS APPLICATION</h5></header>

            <?php
            //get application_id
            $app_id = ($_GET["applicationid"]);
            $id=intval($_GET['applicationid']);
            $stmt = mysqli_query($connect_db, "SELECT * FROM applications WHERE applicationid='$app_id'");
            $record = mysqli_fetch_array($stmt);
    
            ?>
                 <!-- applicant personal info-->
            <div class="panel panel-default">
                 <div class="panel-body">                    
                    <div class="panel panel-default">
                        <div class="panel-heading"><i class="fa fa-building"></i>
                            Application Details with ID: <strong class="text-danger"> <?php echo $app_id;?></strong>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <!--<th>ID</th>-->
                                            <th>App. Number</th>
                                            <th>Applicant Name</th>
                                            <th>Mobile No.</th>
                                            <th>Project Name</th>
                                            <th>Site Location</th>
                                            <th>Category</th>
                                            <th>Landuse Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                        <!--<td><?php //echo $record['applicationid']; ?></td>-->
                                            <td class="text-success"><?php echo $record['application_no']; ?></td>
                                            <td class="text-success"><?php echo $record['name']; ?></td>
                                            <td class="text-success"><?php echo $record['phoneno']; ?></td>
                                            <td class="text-success"><?php echo $record['project_type']; ?></td>
                                            <td class="text-success"><?php 
                                            //get locality name by binding with id param
                                            $getSiteLocality=mysqli_query($connect_db, "select loc_name from locality where id='".$record['location']."'");
                                            $result = mysqli_fetch_array($getSiteLocality);
                                            //fetch corresponding data
                                            echo $result['loc_name']; ?></td>
                                            <td class="text-success"><?php
                                            //get application category name
                                            $getCategory=mysqli_query($connect_db, "select type_name from app_types where id='".$record['category_id']."'");
                                            $result1 = mysqli_fetch_array($getCategory);
                                            //fetch corresponding data
                                            echo $result1['type_name'];
                                             ?></td>
                                            <td class="text-success"><?php
                                            //get landuse type name
                                            $getLandUse=mysqli_query($connect_db, "select land_use from landuse where id='".$record['landuse_id']."'");
                                            $result2 = mysqli_fetch_array($getLandUse);
                                            //fetch corresponding data
                                            echo $result2['land_use'];
                                             ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>   <!--application details end here-->
             
               <!--checklist file attachment-->
                <div class="panel-body">                    
                    <div class="panel panel-default">
                        <div class="panel-heading">
                              <i class="fa fa-upload"></i> Checklists File Attachments</div>
                            <div class="panel-body">
                                <p>Please, you must check the corresponding checkbox for all <strong>required and submitted </strong> checklist items for this application. In case any <b>required checklist item</b>  is not yet presented, kindly go back and put the application on hold.</p>
                                <form action="" method="post">
                                <div class="table-responsive">
                                 <table id="table" class="table table-striped table-bordered table-hover">
                        <!--table head-->
                                <thead class="">
                                    <tr>
                                    <th>No.</th>
                                    <!-- <th data-field="id">ID</th>-->
                                    <th data-field="checklist">Checklist Name</th>
<!--                                    <th data-field="select">Select Files</th>-->
                                    <th data-field="checked">Is Attached?</th>
                            </tr>
                                </thead>
                                <tbody>
                    <?php
                        ## will add 'status' in sql later to filter results
                        $sql=mysqli_query($connect_db,"SELECT * from `check_list` ORDER BY `id` ASC");
                        $cnt=1;
                        while($last=mysqli_fetch_array($sql)){
                            $data[] = array(
                            "id"=>$last['id'], "check_name"=>$last['check_name']);
                    ?>
                            <tr>
                            <td><?php echo $cnt; ?></td>
<!--                        <td id="checkid"><?php //echo $last['id'] ?></td>-->
                            <td class="text-danger" id="checkname"><?php echo $last['check_name']; ?></td>
<!--                            <td><input type="file" id="filename" name="filename" class="isSelected"></td>-->
                            <td><input type="checkbox" name="checklist[]" accept="" value="<?php echo $last['id']; ?>"> Yes 
                            </td>
<!--
                            <td class="datatable-ct">
                               <a href="?<?php //echo $last['id']; ?>"><button class="btn btn-info btn-sm" name="listid"> List ID</button></a>
                                </td>
-->
                            </tr>
                <?php
                $cnt=$cnt+1;        
            }?>

                                </tbody>
                                </table>
            
                            </div> <!--end table-->
                               
                               <!--addd terms and privacy notes-->
                               <div class="panel panel-default">
                               <div class="panel panel-heading"> Terms & Conditions</div>
                               <div class="panel-body">
                            <div class="terms">  
                        <b style="font-style: italic"> Please read the terms and conditions of the assembly.</b>
                         <br/><br/>
                        An application received can be reviewed only if all documents, drawings and information provided are proven to be true and valid; and does not bare any falsehood.  
                        Please be informed that, any forgery whatsoever found will make your application rejected liable to possible prosecution. 
                        <br/><br/>
                        It is also recommended that all checklist items are validated to ensure that the applicant meet all required details and/or information needed for ease processing of the application. In case of unavailable document or paper, kindly put the application on hold and request for all needed files before processing an application for a client/applicant.
                        <br/>  <br/>                      
                        By clicking the submit or process button, you are indicating that the Planning Officer has read and interpreted this agreement and privacy policy to the client/applicant; and that the client accepts and agrees to the terms and conditions.
                    </div>
                            <div class="checkbox col-lg-4">
                            <input type="checkbox" id="chk" required/>I confirm
<!--                            <label for="chk">I confirm</label>-->
                            </div> 
                            
                            <br><br>
                            <!--add action buttons-->
                            <div class="form-actions no-margin-bottom" style="text-align:center;">
                         <!--process button-->
                             <button class="btn btn-success" type="submit" id="process_btn" name="process" style="font-weight: bold" onclick=""> <i class="fa fa-play" style="margin-right: 2px; "></i> Process </button>
                            <!--link to cancel-->
                            <a class="btn btn-danger" type="reset" href="dashboard.php" style="margin-left: 25px; font-weight: bold
                            "><i class="fa fa-times" style="margin-right: 3px; font-weight:bold"></i> Cancel</a>
                            </div>
                      
                                        </div>
                                    </div>
                                </form> <!--end form-->
                            </div> <!--end panel body-->
                    </div>
                    
                    
                     <!--terms and conditions -->
<!--                <div class="panel-body">-->
<!--                <div class="panel panel-default">-->
<!--
                        <div class="panel-heading">
                            <i class="fa fa-handshake"></i>
                            Terms & Conditions
                        </div>
-->
<!--                        <div class="panel-body">-->
<!--                            <div class="terms">  -->
<!--
                        <b style="font-style: italic"> Please read the terms and conditions of the assembly.</b>
                         <br/><br/>
                        An application received can be reviewed only if all documents, drawings and information provided are proven to be true and valid; and does not bare any falsehood.  
                        Please be informed that, any forgery whatsoever found will make your application rejected liable to possible prosecution. 
                        <br/><br/>
                        It is also recommended that all checklist items are validated to ensure that the applicant meet all required details and/or information needed for ease processing of the application. In case of unavailable document or paper, kindly put the application on hold and request for all needed files before processing an application for a client/applicant.
                        <br/>  <br/>                      
                        By clicking the submit or process button, you are indicating that the Planning Officer has read and interpreted this agreement and privacy policy to the client/applicant; and that the client accepts and agrees to the terms and conditions.
-->
<!--                    </div>-->
<!--                            <form role="form" id="form-newpermit" method="post">-->
<!--
                            <div class="checkbox col-lg-4">
                            <input type="checkbox" id="chk" required/>I confirm
                            <label for="chk">I confirm</label>
                            </div> 
-->
                            
<!--                            <br><br><br>-->
                            <!--add action buttons-->
<!--                            <div class="form-actions no-margin-bottom" style="text-align:center;">-->
                         <!--process button-->
<!--                                 <button class="btn btn-success" type="submit" id="process_btn" name="process" style="font-weight: bold"> <i class="fa fa-play" style="margin-right: 2px; "></i> Process </button>-->
                                <!--link to cancel-->
<!--                                <a class="btn btn-danger" type="reset" href="dashboard.php" style="margin-left: 25px; font-weight: bold"><i class="fa fa-times" style="margin-right: 3px; font-weight:bold"></i> Cancel</a>-->
<!--                            </div>-->
                      
<!--                            </form>                          -->
<!--                        </div>-->

<!--                </div>-->
<!--                </div>-->
                
                
                
                </div> <!--end checklist -->
                
               
                
            </div>
                       
            </div>
            
        
            <!-- add form wizard rrow -->
<!--
            <div class="row">
                <div class="col-lg-12">  
                     <div class="panel panel-default">
                            <div class="panel-heading">
                                   Complete Checklists File Attachments
                                </div>
                                <div class="panel-body">
                                    <div id="wizardV" >
                                    
                        <h2> </h2>
                        <section>
                            <form role="form">
                                <div class="form-group">
                                                    <label>First Name</label>
                                                    <input class="form-control" />
                                                    <p class="help-block">Example block-level help text here.</p>
                                                </div>         
                                <div class="form-group">
                                                    <label>Last Name</label>
                                                    <input class="form-control" />
                                                    <p class="help-block">Example block-level help text here.</p>
                                                </div>
                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input class="form-control" />
                                                    <p class="help-block">Example block-level help text here.</p>
                                                </div>
                                <div class="form-group">
                                                    <label>Retype Email</label>
                                                    <input class="form-control" />
                                                    <p class="help-block">Example block-level help text here.</p>
                                                </div>             </form>
                        </section>

                        <h2>  </h2>
                        <section>
                           <form role="form">
                                                <div class="form-group">
                                                    <label>Username</label>
                                                    <input class="form-control" />
                                                    <p class="help-block">Example block-level help text here.</p>
                                                </div>
                                                <div class="form-group">
                                                    <label>Password</label>
                                                    <input class="form-control" />
                                                    <p class="help-block">Example block-level help text here.</p>
                                                </div>
                                               <div class="form-group">
                                                    <label>Retype Password</label>
                                                    <input class="form-control" />
                                                    <p class="help-block">Example block-level help text here.</p>
                                                </div>
                                                <div class="form-group">
                                                    <label> Security Code </label>
                                                    <input class="form-control" />
                                                    <p class="help-block">Example block-level help text here.</p>
                                                </div>

                                            </form>
                        </section>

                        <h2></h2>
                        <section>
                              <form role="form">
                                                <div class="form-group">
                                                    <label> Occupation </label>
                                                    <input class="form-control" />
                                                    <p class="help-block">Example block-level help text here.</p>
                                                </div>
                                                <div class="form-group">
                                                    <label> Qualification </label>
                                                    <input class="form-control" />
                                                    <p class="help-block">Example block-level help text here.</p>
                                                </div>
                                               <div class="form-group">
                                                    <label> Age </label>
                                                    <input class="form-control" />
                                                    <p class="help-block">Example block-level help text here.</p>
                                                </div>
                                                <div class="form-group">
                                                    <label> Notes </label>
                                                    <input class="form-control" />
                                                    <p class="help-block">Example block-level help text here.</p>
                                                </div>

                                            </form>
                        </section>

                        <h2></h2>
                        <section>
                            <p style="text-align:justify;color:gray;">
                                <b> Agreement & Declaration</b> <br /><br />
                                Morbi ornare tellus at elit ultrices id dignissim lorem elementum. Sed eget nisl at justo condimentum dapibus. Fusce eros justo, 
                                pellentesque non euismod ac, rutrum sed quam. Ut non mi tortor. Vestibulum eleifend varius ullamcorper. Aliquam erat volutpat.
                                <br />  <br /> 
                                Donec diam massa, porta vel dictum sit amet, iaculis ac massa. Sed elementum dui commodo lectus sollicitudin in auctor mauris 
                                venenatis. Quisque at sem turpis, id sagittis diam. Suspendisse malesuada eros posuere mauris vehicula vulputate. Aliquam sed sem tortor. 
                                Quisque sed felis ut mauris feugiat iaculis nec ac lectus. Sed consequat vestibulum purus, imperdiet varius est pellentesque vitae. 
                                Suspendisse consequat cursus eros, vitae tempus enim euismod non. Nullam ut commodo tortor.
                                <br />


                            </p>
                        </section>    
                                </div>

                                </div>
                    </div> 
                </div>
            </div>          
-->
            <!-- end wizard row here -->
                                            
                <br> <!--break for new section-->
                
            </div>   
        </div>
    </div>
      
<!--  modal dialogs-->
      <div class="modal fade" id="notifyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" arial-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                              <div class="modal-header">
                               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                  <h4>Building Permit Application System</h4>
                              </div>
                                <div class="modal-body">
                                    <p class="text-warning">The selected application record cannnot be deleted. All applications are archived and reviewed for reference purposes.</p>
                                </div>  
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div> 
                            </div>
            </div>  
      </div>
        
        <br>
        </div> <!--end inner wrapper-->
        </div>


<!-- FOOTER -->
    <div id="footer">
        <p>&copy; E-Permit 2020. &nbsp;Developed by <a class="app-developer"  href="../jecmasghana/index.html" target="_blank">Jecmas </a>&nbsp;</p>
    </div>
    <!--END FOOTER -->
    
        
 <!-- PAGE LEVEL SCRIPTS -->
    <script src="../admin/assets/plugins/validationengine/css/validationEngine.jquery.css"></script>
    <!--END PAGE LEVEL SCRIPT-->
     <script src="../admin/assets/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="../admin/assets/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="../admin/assets/plugins/jasny/js/bootstrap-fileupload.js"></script>
    <script src="../admin/assets/js/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <script src="../admin/assets/js/WizardInit.js"></script>
    <script src="../admin/assets/plugins/jquery-steps-master/build/jquery.steps.min.js"></script>
    <script src="../admin/assets/plugins/switch/static/js/bootstrap-switch.min.js"></script>
<!--    ------------->
   

    <!-- data table JS
    ============================================ -->
    <script src="../assets/datatable/js/bootstrap-table.js"></script>
<!--    <script src="../assets/datatable/js/data-table/tableExport.js"></script>-->
    <script src="../assets/datatable/js/data-table/data-table-active.js"></script>
    <script src="../assets/datatable/js/data-table/bootstrap-table-editable.js"></script>
<!--    <script src="../assets/datatable/js/data-table/bootstrap-editable.js"></script>-->
<!--    <script src="../assets/datatable/js/data-table/bootstrap-table-resizable.js"></script>-->
<!--    <script src="../assets/datatable/js/data-table/colResizable-1.5.source.js"></script>-->
<!--    <script src="../assets/datatable/js/data-table/bootstrap-table-export.js"></script>-->
   <!-- validation scripts-->

    
   
<script type="text/javascript">
    $(document).ready(function() {
        
      //display effect on process button clicked
    $('#process_btn').click(function(){
        var mybutton = document.getElementById('process_btn');
        mybutton.innerHTML = "please wait";
        $('.spinning').show();
        setTimeout(function(){
            $('.spinning').hide();
            mybutton.innerHTML = "Process";
        }, 3500);
    });
        
    
     $('#form-newpermit').bootstrapValidator({
//        live: 'disabled',
        message: 'This value is not valid',
        feedbackIcons: {
//            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            
            location: {
                group: '.col-lg-4',
                validators: {
                    notEmpty: {
                            message: 'please confirm'
                        },
                        }
                   },    
        }
    });
    
    
    // Validate the form manually
    $('#validateBtn').click(function() {
        $('#defaultForm').bootstrapValidator('validate');
    });

    $('#resetBtn').click(function() {
        $('#defaultForm').data('bootstrapValidator').resetForm(true);
    });
});

</script>

   
   <script type="text/javascript">
		function showSpin(){
			$('.loading').show();
			setTimeout(function(){
				$('.loading').hide();
			}, 2500);
		}
	</script>
    </body>
</html>




