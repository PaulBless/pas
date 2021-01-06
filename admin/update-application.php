<?php

/* SYSTEM INFO
Author: Paul Eshun
Role: Web Software Developer
Company: Jecmas Solutions, Ghana
App: Building Permit Application System
*/

session_start();
error_reporting(E_ALL ^ E_NOTICE);

//include db connection file
include '../functions/db_connection.php';

//invoke controller classes
require_once '../functions/databaseController.php';
require_once '../functions/Applications.php';

//instance of db controller class
$db_handle = new databaseController();


// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: ./index.php');
	exit;
}

//get locationid from previous session page
$target_id = "";
if(isset($_GET['target_id']))
$target_id = ($_GET['target_id']);


//process data on form submission
if(isset($_POST['btnSubmit'])){
 
    //get form data
    //variables
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $mobile = $_POST['mobile'];
    $residence = $_POST['residence'];
    $occupation = $_POST['occupation'];
    $contactname = $_POST['contactname'];
    $contactnumber = $_POST['contactnumber'];
    $location = $_POST['location'];     //location - dropdown
    $locality = $_POST['locality'];     //locality - textbox
    $project = ($_POST['project']);     //project name
    $setState = ($_POST['status']);     //application status
    $setLocation = ($_POST['locationID']);  //location ID: save this into db
    
    /*create instance of application class
    object instantiation of application model
    */
    // $application = new Applications();
    //  //edit the record
    //  $application->editApplication($name, $gender, $mobile, $residence, $occupation, $contactname, $contactnumber, $locality, $project, $target_id);

    //sql prepare update statement
    if ($stmt = $connect_db->prepare('UPDATE `applications` SET `name`= ?, `gender`= ?, `phoneno`=?, `town`=?, `occupation`=?, `contactname`=?, `contactnumber`=?, `project_type`=? WHERE `applicationid`= ?')){
        $stmt->bind_param('ssssssssi', strtoupper($name), $gender, $mobile, ucwords($residence), ucwords($occupation), strtoupper($contactname), $contactnumber, strtoupper($project), $target_id);
        $stmt->execute();
        
      echo "<div class='alert alert-info fade in col-lg-6 col-md-offset-3' style='top: 10px; transition: all 0.3s ease-in-out 0s'>"
        . "<a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a>"
        . "<strong><span class='fa fa-bell'></span> </strong>" 
        . "<strong>&nbsp;&nbsp;The changes have been applied successfully!</strong>."
        . "</div>";"<script>window.location.href='applications.php'</script>";
            } //end if
    else{echo "MySQL Error";}
     
    
}


?>

     
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
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

     
      <!--page level scripts-->
    <link rel="stylesheet" href="../third-party/dist/css/bootstrapValidator.css">
     <link rel="stylesheet" href="../third-party/dist/css/bootstrapValidator.css">
     <link href="../admin/assets/css/bootstrap-fileupload.min.css" rel="stylesheet" />
     
    <!--scripts-->
    <script type="text/javascript" src="../third-party/vendor/jquery/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="../third-party/vendor/bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="../third-party/dist/js/bootstrapValidator.js"></script>
    
    <!--stylesheet-->
    <style type="text/css">
        legend{
            font-size: 15px;
            font-weight: bold;
            color: #5b6574;
        }
        
        /*sub-menulink hover effects*/
        .panel .my-sub-link:hover{
/*            background-color: #33b35a;*/
/*            color: white;*/
            background: #343a40;
            transition: transform .3s ease, -webkit-transform .3s ease, -moz-transform .3s ease, -o-transform .3s ease;
        }
        
        /* spinning styles*/
        .spinner{
            opacity:0.5;
            background:#ccc url(../assets/images/spin.gif) no-repeat center;
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
<body class="padTop53 " >
    <div class="spinner"></div>

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
                        <h5><span class="fa fa-home"></span> E-Permit <i class="fa fa-chevron-right"></i> Main Menu <i class="fa fa-chevron-right"></i> Applications <i class="fa fa-chevron-right"></i> Update </h5>
                    </div>
                </div>
                  <hr />
                  
                 <!--HOME SECTION -->
            <div class="row">
                <div class="col-lg-12">
                   <a href="applications.php" class="btn btn-warning text-center"> <i class="fa fa-arrow-left" style="margin-right: 3px;"></i> Go Back</a>
                    <div class="box">
                        <header>
                        <div class="icons"><i class="fa fa-film"></i>
                        </div>
                        <h5>UPDATE APPLICATION</h5></header>
                        
                        <div class="panel panel-default">
                            <div class="panel-body">
                               
                    <form role="form" id="form-newpermit" method="post" class="form-horizontal px-4 py-3" action="">
                         <!-- fetch records from db-->
                            <?php
                            $stmt = mysqli_query($connect_db, "SELECT * FROM `applications` WHERE `applicationid`='$target_id'");
                            #bind result set
                            $record = mysqli_fetch_array($stmt); 
                            //app status
                            $appStatus = $record['status'];
                            ?>
                            
                        <legend>Applicant Details</legend>
                       <!--name field-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Applicant Full Name </label>
                            <div class="col-lg-4">
                                <input type="text" id="name" name="name" value="<?php echo $record['name']; ?>" class="form-control"/>
                            </div>
                        </div>
                       <!--gender-->                        
                        <div class="form-group">
                          <label for="gender" class="control-label col-lg-4">Gender</label>
                          <div class="col-lg-5">
                          <label class="radio-inline"><input type="radio" name="gender" value="Male" <?php if($record['gender']=="Male") echo "checked"; ?> required>Male</label>
                          <label class="radio-inline"><input type="radio" name="gender" value="Female" <?php if($record['gender']=="Female") echo "checked"; ?> required>Female</label>
                          </div>
                        </div>
                        <!--phone-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Phone number</label>
                            <div class="col-lg-4">
                                <input type="tel" class="form-control" name="mobile"  value="<?php echo $record['phoneno']; ?>" id="mobile" pattern="[0][0-9]{9}" maxlength="10"/>
                            </div>
                        </div>              
                        <!--residence/address-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Town of Residence</label>
                            <div class="col-lg-4">
                            <input type="text" name="residence" id="residence" class="form-control" value="<?php echo $record['town']; ?>"> </div>
                        </div>
                        <!--occupation-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Occupation</label>
                            <div class="col-lg-4">
                                <input type="text" id="occupation" name="occupation" value="<?php echo $record['occupation']; ?>" class="form-control" />
                            </div>
                        </div>
                        <!--contact person name-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Name of Contact Person</label>
                            <div class="col-lg-4">
                                <input type="text" id="contactname" name="contactname" value="<?php echo $record['contactname']; ?>" class="form-control" />
                            </div>
                        </div>
                        <!--contact person mobile number-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Contact Mobile Number</label>
                            <div class="col-lg-4">
                                <input type="tel" id="contactnumber" name="contactnumber" value="<?php echo $record['contactnumber']; ?>" pattern="[0][0-9]{9}" maxlength="10" class="form-control" />
                            </div>
                        </div>
                        <br>
                        <!--end personal details section-->
                
                                    
                   <legend> Building or Structure Details </legend>
                      <!--development-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Project Development Name</label>
                            <div class="col-lg-6">
                                <textarea class="form-control" id="project" name="project" cols="6" rows="2"><?php echo $record['project_type']; ?></textarea>
                            </div>
                        </div>
                          <!--site location-->
                        <div class="form-group ">
                           <?php 
                            //get locality name by binding with id param
                            $getLocality=mysqli_query($connect_db, "select loc_name from locality where id='".$record['location']."'");
                            $result = mysqli_fetch_array($getLocality);
                            ?>
                            <label class="control-label col-lg-4">Site Location </label>
                            <!-- display location_name-->
                            <div class="col-lg-4">
                             <input name="locality" id="locality" class="form-control" value="<?php if($result['loc_name'] == "") 
									 echo "Invalid Location"; echo $result['loc_name']; ?>" readonly/>
                            </div>
                            <!-- display location_id-->
                            <div class="col-lg-2 hidden">
                             <input name="locationID" id="locationID" class="form-control" value="<?php echo $record['location']; ?>" readonly/>
                            </div>
                            <div class="col-lg-4 hidden">
                            <!--get location lists from db-->
                            <!-- to display location lists-->
                               <?php 
                                //query to fetch locations
                                $sql = "SELECT * from locality order by loc_name asc";
                                $rs_location =mysqli_query($connect_db, $sql);
                                 ?>
                                <select class="form-control" name="location" id="location" data-by-notempty="" data-by-notempty-message="Site location is required" data-by-field="location" data-bv-field="location" disabled>
                                <option value="<?php echo $rs['id']; ?>"><?php echo $result['loc_name']; ?></option>
                                 <?php
                                while($rows = mysqli_fetch_array($rs))
                                {
                                 echo '<option value="'. $rows['id'].'">' .$rows['loc_name'].'</option>';      
                                }
                                ?>
                                </select>
                            </div>
                        </div>
                        
                        <!--application number-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Application No:</label>
                            <div class="col-lg-4">
                            <input id="appNo" class="form-control" type="text" name="appNo" disabled value="<?php echo $record['application_no']; ?>">
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="control-label col-lg-4">Status:</label>
                            <div class="col-lg-4">
                            <input id="status" class="form-control" type="text" name="status" disabled value="<?php echo $record['status']; ?>">
                            </div>
                        </div>
                        <!-- application type or landuse type -->
                        <div class="form-group">
                           <?php 
                            //get application type by binding with id param
                            $getTypes=mysqli_query($connect_db, "select land_use from landuse where id='".$record['landuse_id']."'");
                            $rsTypeName = mysqli_fetch_array($getTypes);
                            ?>
                            <label class="control-label col-lg-4">Landuse Type:</label>
                            <div class="col-lg-4">
                            <input id="landuse" class="form-control" type="text" name="landuse" disabled value="<?php if($rsTypeName['land_use'] == "") echo "Landuse Not Found"; else echo $rsTypeName['land_use']; ?>">
                            </div>
                        </div>
                        <!-- application type or landuse type -->
                        <div class="form-group">
                           <?php 
                            //get application type by binding with id param
                            $getCategory=mysqli_query($connect_db, "select type_name from app_types where id='".$record['category_id']."'");
                            $result1 = mysqli_fetch_array($getCategory);
                            ?>
                            <label class="control-label col-lg-4">Application Category:</label>
                            <div class="col-lg-4">
                            <input id="category" class="form-control" type="text" name="category" disabled value="<?php if($result1['type_name'] == "") echo "Category Not Found"; else echo $result1['type_name']; ?>">
                            </div>
                        </div>
                          <!--date -->
<!--
                        <div class="form-group">
                            <label class="control-label col-lg-4">Submission Date</label>
                            <div class="col-lg-4">
                            <input id="date2" class="form-control" type="date" name="date2">
                            </div>
                        </div>
-->
                        
                        <br>
                        <div class="form-actions no-margin-bottom" style="text-align:center;">                    
                        <!--save button-->
                        <button id="btnSubmit" class="btn_submit btn btn-success" type="submit" name="btnSubmit" style="font-weight: bold"><i class="fa fa-save"></i> Save Changes</button>
                     
                        <a class="btn btn-danger" type="reset" href="dashboard.php" style="margin-left: 25px; font-weight: bold"><i class="fa fa-times" style="margin-right: 3px;"></i>Cancel</a>
                        </div> 
                        </form>
                    </div>
                </div>
            </div>
        </div>   
    </div>
       
       
            </div>
     </div>
    <!-- END CONTENT-->
    
    </div> <!--END WRAPPER-->
        

<!-- FOOTER -->
    <div id="footer">
        <p>&copy; E-Permit 2020. &nbsp;Developed by <a class="app-developer" style="" href="">Jecmas </a>&nbsp;</p>
    </div>
    <!--END FOOTER -->
    
        
 <!-- PAGE LEVEL SCRIPTS -->
    <script src="../../admin/assets/plugins/validationengine/css/validationEngine.jquery.css"></script>
    <script src="../../admin/assets/plugins/jasny/js/bootstrap-fileupload.js"></script> 
    <!--END PAGE LEVEL SCRIPT-->
   
   <!-- validation scripts-->
<script type="text/javascript">
    $(document).ready(function() {
     
        //display effect on submit button clicked
        $('#btnSubmit').click(function(){
                    
            var mybutton = document.getElementById('btnSubmit');
            mybutton.innerHTML = "Updating wait..";
            mybutton.classList.add('spinning'); //add class list
            //show loader
            $('spinner').show();

            setTimeout(function(){
                mybutton.classList.remove('spinning');  //remove class list
                $('spinner').hide();
                mybutton.innerHTML = "Save Changes";
            }, 6000);
        });


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
                name: {
                    group: '.col-lg-4',
                    validators: {
                        notEmpty: {
                            message: 'Applicant name cannot be empty, required!'
                        },
                         regexp: {
                            regexp: /^[a-zA-Z -]+$/,
                            message: 'The name can only consist of alphabets'
                        },
                    }
                },
                gender: {
                    group: '.col-lg-5',
                    validators: {
                        notEmpty: {
                            message: 'Please select gender'
                        },
                    }
                },
                mobile: {
                    group: '.col-lg-4',
                    validators: {
                        digits: {
                            message: 'Phone number should be digits only'
                        },
                        notEmpty: {
                                message: 'Phone number is required'
                            },
                        stringLength: {
                            min: 1,
                            max: 10,
                            message: 'Phone number is not complete'
                                },
                            }
                        },
                contactnumber: {
                    group: '.col-lg-4',
                    validators: {
                        digits: {
                            message: 'Contact number should be digits only'
                        },
                        notEmpty: {
                                message: 'Contact number is required'
                            },
                        stringLength: {
                            min: 1,
                            max: 10,
                            message: 'Contact number is not complete'
                                },
                            }
                        },
                residence: {
                    group: '.col-lg-4',
                    validators: {
                        notEmpty: {
                                message: 'Place or town of residence cannot be empty'
                            },
                        regexp: {
                            regexp: /^[a-zA-Z ]+$/,
                            message: 'The residence can only consist of alphabets'
                        },
                            }
                        },
                occupation: {
                    group: '.col-lg-4',
                    validators: {
                        notEmpty: {
                                message: 'Provide occupation of applicant'
                            },
                        regexp: {
                            regexp: /^[a-zA-Z ]+$/,
                            message: 'Occupation can only consist of alphabets'
                        },
                            }
                        },
                contactname: {
                    group: '.col-lg-4',
                    validators: {
                        notEmpty: {
                                message: 'Emergency contact name is required'
                            },
                        regexp: {
                            regexp: /^[a-zA-Z ]+$/,
                            message: 'Contact name can only consist of alphabets'
                        },
                            }
                        },
                location: {
                    group: '.col-lg-4',
                    validators: {
                        notEmpty: {
                                message: 'Location of site is required'
                            },
                            }
                        },
                project: {
                    group: '.col-lg-6',
                    validators: {
                        notEmpty: {
                                message: 'Specify the proposed development name'
                            },
                        regexp: {
                            regexp: /^[a-zA-Z ]+$/,
                            message: 'Proposed development name can only consist of alphabets'
                        },
                            }
                        },
                date2: {
    //                group: '.col-lg-4',
    //                validators: {
    //                    notEmpty: {
    //                            message: 'Select valid date'
    //                        },
    //                    date: {
    //                        message: 'Specify application date',
    //                    },
    //                     }
                    },
            }
        });

    
    // keypress event
    //phone-number validation
    jQuery("#mobile").keypress(function(ev){
    var x = $(this).val();
    if (ev.keyCode < 48 || ev.keyCode > 57) {
      ev.preventDefault();
        }
    });
    //contact-number validation
     jQuery("#contactnumber").keypress(function(ev){
    var x = $(this).val();
    if (ev.keyCode < 48 || ev.keyCode > 57) {
      ev.preventDefault();
        }
    });
    
    jQuery("#mobile").onblur(function(ev){
        var x = $(this).val();
        var num = this.substring(0, 3);
        if (num !== '054' && num !== '024'){
            alert('Phone number is invalid.');
        }
    });
    
    //first-name validation
    jQuery("#firstname").keypress(function(ev){
        var x = $(this).val();
        if ((ev.keyCode < 65 || ev.keyCode > 90) && (ev.keyCode < 97 || ev.keyCode > 122 )){
            ev.preventDefault();
        }
    });
    
    //last-name validation
    jQuery("#lastname").keypress(function(ev){
        var x = $(this).val();
        if ((ev.keyCode < 65 || ev.keyCode > 90) && (ev.keyCode < 97 || ev.keyCode > 122 )){
            ev.preventDefault();
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
