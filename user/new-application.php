
<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);

//include db connection file
include '../functions/db_connection.php';

//invoke controller classes
require_once '../functions/databaseController.php';
require_once '../functions/Applications.php';

//instance of db controller class
$db_handle = new databaseController();


 //If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: ./index.php');
	exit;
}


//declare variables to hold application numbers
$date_now = date("Ym");     //current date/month
$application_number = "";   //application number
    
    
//check db if application_number exists
if($select = $connect_db->prepare('SELECT application_no FROM applications ORDER BY application_no DESC')){
        $select->execute();
        $select->store_result();
        if ($select->num_rows > 0)
        {
            //if exists, fetch
            $select->bind_result($last_app_number);
            $select->fetch();
            $application_number = $date_now .$last_app_number. + 1; 
            echo $application_number;
        }else{
            //record dont exists, 
            //generate new application number
            $application_number = $date_now ."001";
            echo $application_number;
        }
    }

//process data on form submission
if(isset($_POST['btnSubmit'])){
    
    //get form data
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $mobile = $_POST['mobile'];
    $residence = $_POST['residence'];
    $occupation = $_POST['occupation'];
    $contactname = $_POST['contactname'];
    $contactnumber = $_POST['contactnumber'];
    $location = $_POST['location'];
    $project = ($_POST['project']);
    $sub_date = ($_POST['date2']);
    $date = date("d/m/Y h:i:sa"); 
    
    
   
    //proceed to save new application for later processing
    //preparing the SQL statement will prevent SQL injection.
    if ($stmt = $connect_db->prepare('SELECT name, application_no FROM applications WHERE name = ? AND application_no = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), 
    //in our case the username is a string so we use "s"
	$stmt->bind_param('ss', $name, $app_number);
	$stmt->execute();
	$stmt->store_result(); 	//store the result, and check it availability.
    //check if record exists in database
    if ($stmt->num_rows > 0) {
	$stmt->bind_result($fullname, $user_name);
	$stmt->fetch(); 	//record exists, fetch results 
        $error = "Record Exists..\\n \\nThe record with applicant Name: ".$fullname. " with Application Number: ".$app_number. " is already added or taken.. \\nCannot save duplicate records!";
        echo "<script>alert('".$error."')</script>";
    }else{
    //create instance of application class
    $new_application = new Applications();
    //insert the record
    $insertid = $new_application->addApplication($name, $gender, $mobile, $residence, $occupation, $contactname, $contactnumber, $location, $project, $sub_date, $application_number, $_SESSION['name']);
    if(empty($insertid)){
    echo "<script>alert('Error!\\n \\nCould not complete the request.. Try again later!')</script>";
    }else{
    $message = "Application successfully added.\\n \\nApplication ID: ".$application_number;
    echo "<script>alert('".$message."')</script>";
    
        }
        }
    }
    
    
}


?>


 <?php //include('../includes/header.php'); ?>

     
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <!--meta descriptions-->
    <meta charset="UTF-8" />
    <title>E-Permit System </title>
     <meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="Electronic permit application and processing system designed for use in the district assembly" name="description" />
	<meta content="Paul Eshun" name="author" />
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

      <!--page level styles-->
    <link rel="stylesheet" href="../third-party/dist/css/bootstrapValidator.css">
     <link href="../admin/assets/css/bootstrap-fileupload.min.css" rel="stylesheet" />
<!--    <link href="../admin/assets/plugins/jquery-steps-master/demo/css/wizardMain.css" rel="stylesheet" />-->
    <!-- end page level styles-->
    
    <!--page level scripts-->
    <script type="text/javascript" src="../third-party/vendor/jquery/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="../third-party/vendor/bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="../third-party/dist/js/bootstrapValidator.js"></script>
    
    <style type="text/css">
        legend{
            font-size: 15px;
            font-weight: bold;
            color: #5b6574;
        }
    </style>
</head>    <!-- END HEAD -->

   
    <!-- BEGIN BODY -->
<body class="padTop53 " >


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
                        <i id="icon" class="fa fa-user "></i>&nbsp;Howdy, <?=$_SESSION['name']?>
                        <i id="icon" class="fa fa-chevron-down"></i>
                        </a>

                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="user-profile.php"><i class="fa fa-user-circle"></i> My Profile </a>
                            </li>
                            <li><a href="#"><i class="fa fa-tags"></i> My Tasks </a>
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
                    <h5 class="media-heading"><i class="fa fa-user"></i> Login As: <?=$_SESSION['role']?>!</h5>
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
                <li><a href="new-application.php"><i class="fa fa-plus"></i> Add New Application </a></li>
                <!--menu item-->
                <li><a href="search-applications.php"><i class="fa fa-search"></i> Search Applications </a></li>
                <!--menu item-->
                <li><a href="view-applications.php"><i class="fa fa-info"></i> Submitted Applications </a></li>
                <!--menu item-->
                <li><a href=""><i class="fa fa-comments"></i> Chat Option </a></li>
                <!--menu item exit-->
                <li><a href="../logout.php"><i class="fa fa-power-off"></i> Exit Application </a></li>

            </ul>
        </div>
        <!--END MENU SECTION -->

        <!--PAGE CONTENT -->
		<div id="content">
                     
    <div class="inner" style="min-height: 700px;">
        <div class="row">
                    <div class="col-lg-12">
                       <!--page title/section-->
                        <h5><span class="fa fa-home"></span> E-Permit 
                        <i class="fa fa-chevron-right"></i> User Dashboard 
                        <i class="fa fa-chevron-right"></i> New Application </h5>
                    </div>
                </div>
                  <hr />
                
            <div class="row">
                <div class="col-lg-12">
                    <div class="box">
                        <header>
                        <div class="icons"><i class="fa fa-file"></i>
                        </div>
                        <h5>NEW APPLICATION</h5></header>
                        
                        <div class="panel panel-default">
                            <div class="panel-body">
                               
                        <form role="form" id="form-newpermit" method="post" class="form-horizontal px-4 py-3" action="">
                        
                        <legend>Applicant Details</legend>
                       <!--name field-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Applicant Full Name </label>
                            <div class="col-lg-4">
                                <input type="text" id="name" name="name" placeholder="Full Name" class="form-control"/>
                            </div>
                        </div>
                       <!--gender-->                        
                        <div class="form-group">
                          <label for="gender" class="control-label col-lg-4">Gender</label>
                          <div class="col-lg-5">
                          <label class="radio-inline"><input type="radio" name="gender" value="Male" required>Male</label>
                          <label class="radio-inline"><input type="radio" name="gender" value="Female" required>Female</label>
                          </div>
                        </div>
                        <!--phone-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Phone number</label>
                            <div class="col-lg-4">
                                <input type="tel" class="form-control" name="mobile" placeholder="Phone number" id="mobile" pattern="[0][0-9]{9}" maxlength="10"/>
                            </div>
                        </div>              
                        <!--residence/address-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Town of Residence</label>
                            <div class="col-lg-4">
                            <input type="text" name="residence" id="residence" class="form-control" placeholder="Place of residence"> </div>
                        </div>
                        <!--occupation-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Occupation</label>
                            <div class="col-lg-4">
                                <input type="text" id="occupation" name="occupation" placeholder="Occupation of applicant" class="form-control" />
                            </div>
                        </div>
                        <!--contact person name-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Name of Contact Person</label>
                            <div class="col-lg-4">
                                <input type="text" id="contactname" name="contactname" placeholder="Emergency contact name" class="form-control" />
                            </div>
                        </div>
                        <!--contact person mobile number-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Contact Mobile Number</label>
                            <div class="col-lg-4">
                                <input type="tel" id="contactnumber" name="contactnumber" placeholder="Emergency contact number" pattern="[0][0-9]{9}" maxlength="10" class="form-control" />
                            </div>
                        </div>
                        <br>
                        <!--end personal details section-->
                
                                    
                   <legend> Building or Structure Details </legend>
                        <!--site location-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Site Location </label>
                            <div class="col-lg-4">
                                <input name="location" id="location" class="form-control" placeholder="Location of site or building (eg. Adeiso)" />
                            </div>
                        </div>
                        <!--development-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Proposed Development</label>
                            <div class="col-lg-6">
                                <textarea style="" class="form-control" id="project" name="project" cols="6" rows="6"></textarea>
                            </div>
                        </div>
                        <!--date-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Submission Date</label>
                            <div class="col-lg-4">
                            <input id="date2" class="form-control" type="date" name="date2">
                            </div>
                        </div>
<!--                       <br>-->
          
                              
<!--                <legend>Attach Documents </legend>-->
                        <!--checklist-->
<!--
                    <div class="form-group">
                        <label class="control-label col-lg-4">Document Type 1</label>
                        <div class="col-lg-2">
                                <select class="form-control" name="document1" data-by-notempty="" data-by-notempty-message="This document type is required" data-by-field="document1" disabled>
                                <option value="Site Plan">Site plan</option>
                                </select>
                            </div>
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <input type="hidden" >
                            <div class="input-group">
                            <span class="btn btn-file btn-info">
                            <span class="fileupload-new">Select file</span>
                            <span class="fileupload-exists">Change</span>
                            <input class="col0lg-4" type="file">
                            </span> 
                            <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a> 
                           
                            <div class="col-lg-6">
                            <i class="fa fa-file fileupload-exists "></i>
                            <span class="fileupload-preview "></span>
                            </div>
                            </div>
                        </div>
                    </div>
-->
                        <!--checklist-->
<!--
                    <div class="form-group">
                        <label class="control-label col-lg-4">Document Type 2</label>
                        <div class="col-lg-2">
                            <select class="form-control" name="document2" data-by-notempty="" data-by-notempty-message="Document type is required" data-by-field="document2" disabled>
                            <option value="Building Plan">Building plan</option>
                            </select>
                        </div>
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                        <input type="hidden" >
                        <div class="input-group">
                        <span class="btn btn-file btn-info">
                        <span class="fileupload-new">Select file</span>
                        <span class="fileupload-exists">Change</span>
                        <input class="col0lg-4" type="file">
                        </span> 
                        <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a> 
                           
                        <div class="col-lg-6">
                        <i class="fa fa-file fileupload-exists "></i>
                        <span class="fileupload-preview "></span>
                        </div>
                        </div>
                        </div>
                        </div>
-->
                       
<!--
                    <div class="form-group">
                            <label class="control-label col-lg-4">Document Type 3</label>
                            <div class="col-lg-2">
                                <select class="form-control" name="document3" data-by-notempty="" data-by-notempty-message="Document type is required" data-by-field="document3" disabled>
                                <option value="Site Plan">Site plan</option>
                                </select>
                            </div>
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                            <input type="hidden" >
                            <div class="input-group">
                            <span class="btn btn-file btn-info">
                            <span class="fileupload-new">Select file</span>
                            <span class="fileupload-exists">Change</span>
                            <input class="col0lg-4" type="file">
                            </span> 
                            <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a> 
                           
                            <div class="col-lg-6">
                            <i class="fa fa-file fileupload-exists "></i>
                            <span class="fileupload-preview "></span>
                            </div>
                            </div>
                        </div>
                        </div>
-->
                         <!--checklist-->
<!--
                    <div class="form-group">
                        <label class="control-label col-lg-4">Document Type 4</label>
                        <div class="col-lg-2">
                            <select class="form-control" name="document4" data-by-notempty="" data-by-notempty-message="Document type is required" data-by-field="document4" disabled>
                            <option value="Indenture">Indenture</option>
                            </select>
                        </div>
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                        <input type="hidden" >
                        <div class="input-group">
                        <span class="btn btn-file btn-info">
                        <span class="fileupload-new">Select file</span>
                        <span class="fileupload-exists">Change</span>
                        <input class="col0lg-4" type="file">
                        </span> 
                        <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a> 
                           
                        <div class="col-lg-6">
                        <i class="fa fa-file fileupload-exists "></i>
                        <span class="fileupload-preview "></span>
                        </div>
                        </div>
                        </div>
                        </div>
-->
<!--                        <br>-->
                  
             
<!--
               <legend>Agreement & Declaration</legend>
                    <div class="terms">  
                       <p style="text-align:justify;">
                        <b> You must read the terms and conditions carefully to understand and accept before submitting application.</b>
                         <br/><br/>
                        An application received can be reviewed only if all documents, drawings and information provided are proven to be true and valid; and does not bare any falsehood.
                        <br/>  
                        Please be informed that, any forgery whatsoever found will make your application rejected, and liable to possible prosecution. 
                        <br/>
                        It is also recommendedd that all check list items and documents uploaded meet required specifications. Make sure to attach all necessary files to ease the processing of the application.
                        <br/>    
                    </p>
                    </div>
-->
<!--
                    <div class="checkbox">
                        <label>
                        <input type="checkbox" value="">
                        I confirm that all the information provided above are valid and true.</label>
                    </div>    
-->
                    
                        <br/>
                         
                          <!--buttons group-->
                        <div class="form-actions no-margin-bottom" style="text-align:center;">

                        <input type="submit" name="btnSubmit" value="Save Application" class="btn btn-success" style="margin-right: 25px">
                     
                        <a class="btn btn-danger" type="reset" href="homepage.php" style="margin-left: 25px">Cancel</a>
                        </div> 
                          
                          <br/>
                           </form>    
                            </div>
                        </div>
                            
                   
                    </div>
                </div>
            </div>
    </div>

</div><!--END PAGE CONTENT -->
        
</div>    <!--END MAIN WRAPPER -->

		<!-- FOOTER -->
    	<div id="footer">
        <p>&copy; E-Permit 2020. &nbsp;Developed by <a class="app-developer" style="" href="">Jecmas </a>&nbsp;</p>
    </div>
    	<!--END FOOTER -->
    
      
    <!-- PAGE LEVEL SCRIPTS -->
    <script src="../admin/assets/plugins/validationengine/css/validationEngine.jquery.css"></script>
    <script src="../admin/assets/plugins/jasny/js/bootstrap-fileupload.js"></script>   
         <!--END PAGE LEVEL SCRIPTS -->     

      <!-- bootstrap validation scripts-->
<script type="text/javascript" >
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
            name: {
                group: '.col-lg-4',
                validators: {
                    notEmpty: {
                        message: 'Applicant name cannot be empty, required!'
                    },
                     regexp: {
                        regexp: /^[a-zA-Z ]+$/,
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
                    regexp: {
                        regexp: /^[a-zA-Z ]+$/,
                        message: 'Site location can only consist of alphabets'
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
                group: '.col-lg-4',
                validators: {
                    notEmpty: {
                            message: 'Select valid date'
                        },
                    date: {
                        message: 'Specify application date',
                    },
                     }
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
    
    //contact number
      jQuery("#contactnumber").keypress(function(ev){
    var x = $(this).val();
    if (ev.keyCode < 48 || ev.keyCode > 57) {
      ev.preventDefault();
        }
    });
    
      //name validation
    jQuery("#name").keypress(function(ev){
        var x = $(this).val();
        if ((ev.keyCode < 65 || ev.keyCode > 90) && (ev.keyCode < 97 || ev.keyCode > 122 )){
            ev.preventDefault();
        }
    });
    
    //contact-name validation
    jQuery("#contactname").keypress(function(ev){
        var x = $(this).val();
        if ((ev.keyCode < 65 || ev.keyCode > 90) && (ev.keyCode < 97 || ev.keyCode > 122 ) && (ev.keyCode == 32)){
            ev.preventDefault();
        }
    });
    
    //residence
      jQuery("#residence").keypress(function(ev){
        var x = $(this).val();
        if ((ev.keyCode < 65 || ev.keyCode > 90) && (ev.keyCode < 97 || ev.keyCode > 122 ) && (ev.keyCode == 32)){
            ev.preventDefault();
        }
    });
    
    //location
      jQuery("#location").keypress(function(ev){
        var x = $(this).val();
        if ((ev.keyCode < 65 || ev.keyCode > 90) && (ev.keyCode < 97 || ev.keyCode > 122 ) && (ev.keyCode == 32)){
            ev.preventDefault();
        }
    });
    
    //project name
      jQuery("#project").keypress(function(ev){
        var x = $(this).val();
        if ((ev.keyCode < 65 || ev.keyCode > 90) && (ev.keyCode < 97 || ev.keyCode > 122 ) && (ev.keyCode == 32)){
            ev.preventDefault();
        }
    });

    //occupation
      jQuery("#occupation").keypress(function(ev){
        var x = $(this).val();
        if ((ev.keyCode < 65 || ev.keyCode > 90) && (ev.keyCode < 97 || ev.keyCode > 122 ) && (ev.keyCode == 32)){
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
