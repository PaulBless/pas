<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);

//include db connection file
include '../functions/db_connection.php';
require_once '../functions/databaseController.php';
require_once '../functions/Applications.php';

//instance of db controller class
$db_handle = new databaseController();

// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: ./index.php');
	exit;
}


//get application id from previous session page
$id = "";
if(isset($_GET['applicationID']))
$id = ($_GET['applicationID']);

//get loggedin user id
$userid = "";
if(isset($_SESSION['id']))
$userid = ($_SESSION['id']);


//process form
if(isset($_POST['btngiveout']))
{
    //get form data
    $number=($_POST['mobile']);
    $name=($_POST['receiver']);
    $receiver_name=strtoupper($name);
    
    //sql statement
    $sql_check = "select * from `app_received` where app_id='$id'";
    //get application approval records: if exists
    $result = $connect_db->query($sql_check);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc())
            {
            $recDate = date('d M, Y', strtotime($row["dateReceived"]));       
            $recName = ($row["rec_name"]);       
            }
         echo "<div class='alert alert-warning fadeIn col-lg-6 col-md-offset-3' style='top: 10px; transition: all 0.3s ease-in-out 0s'>"
        . "<a href='#' class='close' data-dismiss='alert' aria-label='close'><i class='fa fa-times'></i></a>"
        . "<strong><span class='fa fa-bullhorn'></span> </strong>" 
        . "<strong>&nbsp;&nbsp;Error Message!</strong> <br>This application has been received or given out on: <strong>$recDate </strong> to: <b>$recName</b>. <br> Cannot continue process..."
        . "</div>";   
        }else{
        //no record found
        //insert receiving record
        $add = mysqli_query($connect_db, "INSERT INTO `app_received` (app_id, givenby, rec_name, rec_number, dateReceived) VALUES ('".$id."', '".$userid."', '".$receiver_name."', '".$number."', CURRENT_TIMESTAMP)");
    
        if($add == true){
        //show success message
        echo "<div class='alert alert-success fadeIn col-lg-6 col-md-offset-3' style='top: 10px; transition: all 0.3s ease-in-out 0s'>"
        . "<a href='#' class='close' data-dismiss='alert' aria-label='close'><i class='fa fa-times'></i></a>"
        . "<strong><span class='fa fa-gift'></span> </strong>" 
        . "<strong>&nbsp;&nbsp;Success!! <br>Application successfully handed over. Record saved.</strong>."
        . "</div>";   
        }
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
     <link href="../admin/assets/css/bootstrap-fileupload.min.css" rel="stylesheet" />
    
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
                        <li class="my-sub-link"><a href="permits.php"><i class="fa fa-arrow-right"></i> Building Permits </a></li>
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
                        <h5><span class="fa fa-home"></span> E-Permit <i class="fa fa-chevron-right"></i> Main Menu <i class="fa fa-chevron-right"></i> Transaction <i class="fa fa-chevron-right"></i> HandOver Permit Application</h5>
                    </div>     
                </div>
                
                  <hr />
                  
            <!--HOME SECTION -->
            <div class="row">
                <div class="col-lg-12">
                    <!--  go back link-->
                    <a href="manage-permits.php" class="btn btn-warning right btn-sm"><i class="fa fa-arrow-left"></i> Go Back</a>
                    <div class="box">
                        <header><div class="icons"><i class="fa fa-link"></i></div>
                        <h5>HANDOVER PERMIT APPLICATION</h5></header>

            <?php
            //get application_id
            $app_id = ($_GET["applicationID"]);
            $id=intval($_GET['applicationID']);
            $stmt = mysqli_query($connect_db, "SELECT * FROM applications WHERE applicationid='$app_id'");
            $record = mysqli_fetch_array($stmt);
    
            ?>
                 <!-- applicant personal info-->
            <div class="panel panel-default">
                 <div class="panel-body">                    
                    <div class="panel panel-default">
                        <div class="panel-heading"><i class="fa fa-building"></i>
                            Application Details with ID: <strong class="text-success"> <?php echo $app_id;?></strong>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <!--<th>ID</th>-->
                                            <th>App. Number</th>
                                            <th>Applicant Name</th>
                                            <th>Gender</th>
                                            <th>Mobile No.</th>
                                            <th>Project Name</th>
                                            <th>Site Location</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                        <!--<td><?php //echo $record['applicationid']; ?></td>-->
                                            <td class=""><?php echo $record['application_no']; ?></td>
                                            <td class=""><?php echo $record['name']; ?></td>
                                            <td class=""><?php echo $record['gender']; ?></td>
                                            <td class=""><?php echo $record['phoneno']; ?></td>
                                            <td class="s"><?php echo $record['project_type']; ?></td>
                                            <td class=""><?php 
                                            //get locality name by binding with id param
                                            $getSiteLocality=mysqli_query($connect_db, "select loc_name from locality where id='".$record['location']."'");
                                            $result = mysqli_fetch_array($getSiteLocality);
                                            //fetch corresponding data
                                            echo $result['loc_name']; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                
                 </div> <!--application details end here-->
                 
                 <!--permit info-->
                 <div class="panel-body">
                    <div class="panel panel-default">
                        <div class="panel-heading"><i class="fa fa-star"></i>
                        Building Permit Information</div>
                            <div class="panel-body">
                               <?php
            //get application_id
            $app_id = ($_GET["applicationID"]);
            $id=intval($_GET['applicationID']);
            $query = mysqli_query($connect_db, "SELECT * FROM permits WHERE application_id='$app_id'");
            $data = mysqli_fetch_array($query);
    
            ?>
                        <form role="form" id="form-newpermit" method="post" class="form-horizontal px-4 py-3" action="">

                                <div class="form-group hidden">
                                    <label class="control-label col-lg-4">Permit ID </label>
                                    <div class="col-lg-4">
                                        <input name="permitid" id="permitid" class="form-control" value="<?php echo $data['permitid']; ?>" />
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Building Permit Number</label>
                                    <div class="col-lg-4">
                                        <input name="permitno" id="permitno" class="form-control" value="<?php echo $data['permit_number']; ?>" readonly/>
                                    </div>
                                </div>
                                   <div class="form-group">
                                    <label class="control-label col-lg-4">Date Assigned</label>
                                    <div class="col-lg-4">
                                        <input name="permitno" id="permitno" class="form-control" value="<?php echo date('d M, Y', strtotime($data['dateAssigned'])); ?>" readonly/>
                                    </div>
                                </div>
                                                    
                                </form>
                            </div>
                        
                    </div>
                </div> <!-- end holding reason here-->    
                 
                   <!--add receiver info-->
                 <div class="panel-body">
                    <div class="panel panel-default">
                        <div class="panel-heading"><i class="fa fa-handshake"></i>
                        Receiver's Information</div>
                            <div class="panel-body">
                                <form role="form" id="form-newpermit" method="post" class="form-horizontal px-4 py-3" action="">

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Receiver's Name </label>
                                    <div class="col-lg-4">
                                        <input name="receiver" id="receiver" class="form-control" required/>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Receiver's Phone #</label>
                                    <div class="col-lg-4">
                                        <input name="mobile" id="mobile" type="tel" maxlength="10" class="form-control" required/>
                                    </div>
                                </div>
                                
                                <!-- button groups -->
                                <div class="form-actions no-margin-bottom" style="text-align:center;">
                                <!-- submit button-->
                               <button type="submit" name="btngiveout" value="" id="btnSave" class="btn btn-success" style="margin-right: 10px; font-weight: bold"><i class="fa fa-check"></i> HandOver</button>
                                <a class="btn btn-danger" type="reset" href="dashboard.php" style="margin-left: 25px; font-weight: bold"><i class="fa fa-times"></i> Cancel</a>
                                </div>                       
                                </form>
                                </div>
                        
                    </div>
                </div> <!-- end holding reason here-->    
                            
            </div>
                </div>   
            </div>   
        </div>
    </div>
      
        </div> <!--end inner wrapper-->
        </div>


<!-- FOOTER -->
    <div id="footer">
        <p>&copy; E-Permit 2020. &nbsp;Developed by <a class="app-developer" style="" href="">Jecmas </a>&nbsp;</p>
    </div>
    <!--END FOOTER -->
    
        
 <!-- PAGE LEVEL SCRIPTS -->
    <script src="../admin/assets/plugins/validationengine/css/validationEngine.jquery.css"></script>
    <!--END PAGE LEVEL SCRIPT-->
     <script src="../admin/assets/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="../admin/assets/plugins/dataTables/dataTables.bootstrap.js"></script>
<!--    ------------->
   

    <!-- data table JS
    ============================================ -->
    <script src="../assets/datatable/js/bootstrap-table.js"></script>
    <script src="../assets/datatable/js/data-table/tableExport.js"></script>
    <script src="../assets/datatable/js/data-table/data-table-active.js"></script>
    <script src="../assets/datatable/js/data-table/bootstrap-table-editable.js"></script>
    <script src="../assets/datatable/js/data-table/bootstrap-editable.js"></script>
    <script src="../assets/datatable/js/data-table/bootstrap-table-resizable.js"></script>
    <script src="../assets/datatable/js/data-table/colResizable-1.5.source.js"></script>
    <script src="../assets/datatable/js/data-table/bootstrap-table-export.js"></script>
   <!-- validation scripts-->

    
   
<script type="text/javascript">
    $(document).ready(function() {
         
     //bootstrap form-control fields validation
    $('#form-newpermit').bootstrapValidator({
//        live: 'disabled',
        message: 'This value is not valid',
        feedbackIcons: {
//            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            receiver: {
                group: '.col-lg-4',
                validators: {
                    notEmpty: {
                            message: 'Enter name of receiver '
                        },
                    regexp: {
                        regexp: /^[a-zA-Z -]+$/,
                        message: 'Enter only alphabets'
                    },
                        }
                    },
            mobile: {
                group: '.col-lg-4',
                validators: {
                    notEmpty: {
                            message: 'Enter mobile number of receiver '
                        },
                    stringLength: {
                        min: 1,
                        max: 10,
                        message: 'Incomplete mobile number'
                            },
                    digits:{
                        message: 'Only digits allowed'
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

    </body>
</html>
