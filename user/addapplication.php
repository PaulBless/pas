<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);

//include db connection file
include '../functions/db_connection.php';
## get system settings
$sql = "select `dist_name`,`dist_town` from settings";
$qry = mysqli_query($connect_db, $sql);
$fetch = mysqli_fetch_assoc($qry);
$district = $fetch['dist_name'];
$town = $fetch['dist_town'];

//invoke controller classes
require_once '../functions/databaseController.php';
require_once '../functions/Applications.php';

//instance of db controller class
$db_handle = new databaseController();


//global variables
$last_id = "";                 
$application_id = "";         //application number
$currentyear = date("Y");     //current year
$uniqueApplicationNo = "";		//variable to generate unique application numbers 
$this_year = date('y');			//year format: YY

//query to fetch locations
$sql = "SELECT * from locality order by loc_name asc";
$rs =mysqli_query($connect_db, $sql);

//query to fetch application categories
$select = "SELECT * from app_types order by type_name asc";
$rs1 =mysqli_query($connect_db, $select);


//query to fetch landuse types
$get = "SELECT * from landuse order by land_use asc";
$rsLanduse =mysqli_query($connect_db, $get);


//query to fetch last application year
$res = "SELECT applicationid,datecreated,application_no from applications order by datecreated desc";
$rs2 =mysqli_query($connect_db, $res);
$myrows =mysqli_fetch_array($rs2);
if($myrows > 0){
	//no record found
	$check_date = date('Y', strtotime($myrows['datecreated'])); //last date 
	$check_app_id = ($myrows['applicationid']);		//last id
	$check_app_no = ($myrows['application_no']);		//last application no
	 // echo "<script>alert('Last application year is : $check_date')</script>";
	## - last application date/year same with current year
	if($check_date == $currentyear)
	{

			# get last application number,
			## and split to get first four digit,
			## remove the year part and increment by 1 as new application number
			$first_four = substr($check_app_no, 0, 4);
			$check_app_id = $first_four + 1;	## set last id to 1
			$application_id = sprintf("%04d", $check_app_id);
			$uniqueApplicationNo = $application_id ."/". $this_year;
			// echo $uniqueApplicationNo;
	}
	## - last application year less than current year, and no record of application no
	if($check_date < $currentyear)
	{
			// echo "<script>alert('current year is > than last year, and no record of application #')</script>";
			$check_app_id = 1;	## set last id to 1
			$application_id = sprintf("%04d", $check_app_id);
			$uniqueApplicationNo = $application_id ."/". $this_year;
			// echo $uniqueApplicationNo;

	}

	}else{ 
	// echo "<script>alert('No records in application table')</script>";
	  $check_app_id = 1;
	 $application_id = sprintf("%04d", $check_app_id);
	$uniqueApplicationNo = $application_id ."/". $this_year;
	 // echo $uniqueApplicationNo;
	}



// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: ../index.php');
	exit;
}


//function generate numbers
function getApplicationNos($start, $count, $digits){
    $result  = array();
    $now_date = date("Ym");
    
    for ($n = $start; $n < $start + $count; $n++){
        $result[] = str_pad($n, $digits, "0", STR_PAD_LEFT);
        
    }
    return $result;
}

//try get numbers
for($i=$number;$i<=100;$i++){
//    echo sprintf($date_now ."%05d", $i) . "<br>";
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
    $status = 'New';
    $landuseID = ($_POST['landuse']);
    $categoryID = ($_POST['category']);
   
    //proceed to save new application for later processing
    //preparing the SQL statement will prevent SQL injection.
    if ($stmt = $connect_db->prepare('SELECT name, application_no FROM applications WHERE name = ? AND phoneno = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), 
    //in our case the username is a string so we use "s"
	$stmt->bind_param('ss', $name, $mobile);
	$stmt->execute();
	$stmt->store_result(); 	//store the result, and check it availability.
    //check if record exists in database
    if ($stmt->num_rows > 0) {
	$stmt->bind_result($fullname, $app_number);
	$stmt->fetch(); 	//record exists, fetch results 
    //        $error = "Record Exists..\\n \\nThe record with applicant Name: ".$fullname. " and Application ID: ".$app_number. " is already added or registered.. \\nCannot save duplicate records!";
    //        echo "<script>alert('".$error."')</script>";

        //show error msg via hmtl-element
        echo "<div class='alert alert-danger fade in col-lg-8 col-md-offset-2' style='top: 8px; transition: all 0.3s ease-in-out'>"
        . "<a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a>"
        . "<strong><span class='fa fa-bell'></span> </strong>" 
        . "<strong>&nbsp;&nbsp;Record Exist!! </br> The record with Applicant Name: '$fullname' and Application No: '$app_number' is already created or added! </br>Cannot proceed to save duplicate records.. </strong>."
        . "</div>";
    }else{
    
        //create instance of application class
    $new_application = new Applications();
    //insert the record
    $insertid = $new_application->addApplication($name, $gender, $mobile, $residence, $occupation, $contactname, $contactnumber, $location, $project, $sub_date, $uniqueApplicationNo, $_SESSION['name'], $status, $landuseID, $categoryID);
    
    if(empty($insertid)){
        //show error message in case of qrong sql query
        echo "<div class='alert alert-warning fade in'>"
        . "<a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a>"
        . "<strong><span class='fa fa-gift'></span> </strong> .<strong>&nbsp;&nbsp;Could not process the request! There could be problem with SQL statement..</strong>"
        . "</div>";

    }else{
        // $message = "Application successfully saved.\\n \\nApplication No: ".$application_id;
        //  echo "<script>alert('".$message."')</script>";
  
    //show error msg via hmtl-element
    echo "<div class='alert alert-success fade in col-lg-8 col-md-offset-2' style='top: 8px; transition: all 0.3s ease-in-out'>"
    . "<a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a>"
    . "<span class='fa fa-bell'></span>" 
    . "&nbsp;&nbsp;Application successfully saved! </br> <strong>Application No: '$uniqueApplicationNo' </strong>."
    . "</div>";
        }
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

     
      <!--page level scripts-->
    <link rel="stylesheet" href="../third-party/dist/css/bootstrapValidator.css">
     <link rel="stylesheet" href="../third-party/dist/css/bootstrapValidator.css">
     <link href="../admin/assets/css/bootstrap-fileupload.min.css" rel="stylesheet" />
     
    <!--scripts-->
    <script type="text/javascript" src="../third-party/vendor/jquery/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="../third-party/vendor/bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="../third-party/dist/js/bootstrapValidator.js"></script>
    <!-- function to show loader on pageloading-->
	<script type="text/javascript">
		function pageLoading(){
			$('.loading').show();
			setTimeout(function(){
				$('.loading').hide();
			}, 1000);
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
            opacity:0.7;
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

                    <!--USER SETTINGS SECTIONS -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i id="icon" class="fa fa-user "></i>&nbsp;Welcome, <?=$_SESSION['name']?>
                            <i id="icon" class="fa fa-chevron-down"></i>
                        </a>

                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="my-profile.php"><i class="fa fa-user-circle"></i> My Profile </a>
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
            
            <ul id="menu" class="collapse">
                <li class="panel ">
                    <a href="homepage.php"><i class="fa fa-home"></i> Main Menu
                    </a>                                   
                </li>

                <!--menu item -->
                <li class="panel active"><a href="addapplication.php"><i class="fa fa-plus"></i> Add New Application </a></li>
                <!--menu item-->
                <li class="panel"><a href="application-lists.php"><i class="fa fa-th"></i> Application Lists </a></li>
                <!--menu item-->
                <li class="panel"><a href="mysubmisssions.php"><i class="fa fa-folder"></i> My Submitted Forms </a></li>
                <li class="panel"><a href="building-permits.php"><i class="fa fa-star"></i> Permits Granted </a></li>
                <!--menu item-->
<!--                <li><a href="chat.php"><i class="fa fa-comments"></i> Chat Option </a></li>-->
                
                <!--menu item exit-->
                <li><a href="../logout.php"><i class="fa fa-power-off"></i> Logout  </a></li>

            </ul>

        </div>
        <!--END MENU SECTION -->

        <!--PAGE CONTENT -->
        <div id="content">         
            <div class="inner" style="min-height: 700px;">
                <div class="row">
                    <div class="col-lg-12">
                       <!--page title/section-->
                        <h5><span class="fa fa-home"></span> E-Permit <i class="fa fa-chevron-right"></i> User Dashboard <i class="fa fa-chevron-right"></i> Add Application</h5>
                    </div>
                </div>
                  <hr />


                 <!--HOME SECTION -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="box">
                        <header>
                        <div class="icons"><i class="fa fa-file"></i>
                        </div>
                        <h5>ADD NEW APPLICATION</h5></header>
                        
                    <div class="panel panel-default">
                       	
                       	<div class="text-warning" style="text-align: center;"><b>Please Note:</b> <span style="font-style: italic">All fields marked with * are required </span></div>

                        <div class="panel-body">
                               
                        <form role="form" id="form-newpermit" method="post" class="form-horizontal px-4 py-3" action="">
						
						<div class="panel panel-default">
						<div class="panel-heading">Applicant Info</div>
                       <br>
                       <!--name field-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Applicant Full Name <span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <input type="text" id="name" name="name" placeholder="Full Name" class="form-control"/>
                            </div>
                        </div>
                       <!--gender-->                        
                        <div class="form-group">
                          <label for="gender" class="control-label col-lg-4">Gender <span class="text-danger">*</span></label>
                          <div class="col-lg-5">
                          <label class="radio-inline"><input type="radio" name="gender" value="Male" required>Male</label>
                          <label class="radio-inline"><input type="radio" name="gender" value="Female" required>Female</label>
                          </div>
                        </div>
                        <!--phone-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Phone Number <span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <input type="tel" class="form-control" name="mobile" placeholder="Phone number" id="mobile" pattern="[0][0-9]{9}" maxlength="10"/>
                            </div>
                        </div>              
                        <!--residence/address-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Town of Residence <span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                            <input type="text" name="residence" id="residence" class="form-control" placeholder="Place of residence"> </div>
                        </div>
                        <!--occupation-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Occupation <span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <input type="text" id="occupation" name="occupation" placeholder="Occupation of applicant" class="form-control" />
                            </div>
                        </div>
                        <!--contact person name-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Name of Contact Person <span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <input type="text" id="contactname" name="contactname" placeholder="Emergency contact name" class="form-control" />
                            </div>
                        </div>
                        <!--contact person mobile number-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Contact Mobile Number <span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <input type="tel" id="contactnumber" name="contactnumber" placeholder="Emergency contact number" pattern="[0][0-9]{9}" maxlength="10" class="form-control" />
                            </div>
                        </div>
                        <br>
                        <!--end personal details section-->
                            
                   <div class="panel-heading"> Building or Structure Details </div>
                        <br>
                        <!--site location-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Site Location <span class="text-danger">*</span> </label>
<!--
                            <div class="col-lg-4">
                                <input name="location" id="location" class="form-control" placeholder="Location of site or building (eg. Adeiso)" />
                            </div>
-->
                        <div class="col-lg-4">
                            <!--get location lists from db-->
                            <!-- to display location lists-->
                                <select class="form-control" name="location" id="location" data-by-notempty="" data-by-notempty-message="Site location is required" data-by-field="location" data-bv-field="location">
                                <option value="">--Select--</option>
                                 <?php
                                while($rows = mysqli_fetch_array($rs))
                                {
                                 echo '<option value="'. $rows['id'].'">' .$rows['loc_name'].'</option>';      
                                }
                                ?>
                                </select>
                            </div>

                        </div>
                        <!--development-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Project Development Name <span class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <textarea  class="form-control" id="project" name="project" cols="6" rows="2"></textarea>
                            </div>
                        </div>
<!--                        <br>-->
                        
                        <div class="panel-heading">Legend Details</div>
                        <br>
                        <!--land use type-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Landuse Type <span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                            <!--get landuse lists from db-->
                            <!-- to display landuse lists-->
                                <select class="form-control" name="landuse" id="landuse" data-by-notempty="" data-by-notempty-message="Landuse type is required" data-by-field="landuse" data-bv-field="landuse">
                                <option value="">--Select--</option>
                                 <?php
                                while($rows = mysqli_fetch_array($rsLanduse))
                                {
                                 echo '<option value="'. $rows['id'].'">' .$rows['land_use'].'</option>';      
                                }
                                ?>
                                </select>
                            </div>
                        </div>
                          <!--land category-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Application Category <span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                            <!--get location lists from db-->
                            <!-- to display location lists-->
                                <select class="form-control" name="category" id="category" data-by-notempty="" data-by-notempty-message="Application category is required" data-by-field="category" data-bv-field="category">
                                <option value="">--Select--</option>
                                 <?php
                                while($data = mysqli_fetch_array($rs1))
                                {
                                 echo '<option value="'. $data['id'].'">' .$data['type_name'].'</option>';      
                                }
                                ?>
                                </select>
                            </div>
                        </div>
                        <!--date-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Encoded Date <span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                            <input id="date2" class="form-control" type="date" name="date2">
                            </div>
                        </div>
                        
<!--                        <br>-->
                        <div class="form-actions no-margin-bottom" style="text-align:center;">
                        <!--submit buttin-->
                        <button type="submit" name="btnSubmit" class="btn btn-success" style="margin-right: 25px; font-weight: bold"><i class="fa fa-save" style="margin-right:3px;"></i>Save Application</button>
                         <!--cancel button-->
                        <a class="btn btn-danger" type="reset" href="homepage.php" style="margin-left: 25px; font-weight: bold;"><i class="fa fa-times" style="margin-right: 4px;"></i>Cancel</a>
                        </div> 
                        <br>
							</div> <!--panel default X -->
                        </form>
                        
                    </div>	<!--panel body end-->
                </div> <!--panel default end-->
            </div>
        </div>   
    </div>
       
       
            </div>
        </div>
    </div>

	<!-- FOOTER -->
    <div id="footer">
        <p>&copy; E-Permit 2020. &nbsp;Developed by <a class="app-developer"  href="../jecmasghana/index.html" target="_blank">Jecmas </a>&nbsp;</p>
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
        mybutton.innerHTML = "Saving data..";
        mybutton.classList.add('spinning'); //add class list
        //show loader
        $('spinner').show();
        
        setTimeout(function(){
            mybutton.classList.remove('spinning');  //remove class list
            $('spinner').hide();
            mybutton.innerHTML = "Submit";
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
