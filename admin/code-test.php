
<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);

//include db connection file
include '../functions/db_connection.php';

//invoke controller classes
require_once '../functions/databaseController.php';
require_once '../functions/Users.php';

//instance of db controller class
$db_handle = new databaseController();

// //function to generate random username
//function random_username($uname){
//    $new_name = $uname.mt_rand(0,10000);   
//    }


//mt_srand();
//$id = mt_rand(10000000, 99999999);
//echo $id;

// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}

//get and set username and password on usertype value changed
if (isset($_GET['usertype'])){
   $uname = (substr($_GET['firstname'], 0, 4));
    $upass = 'eps12345';
}

//process data on form submission
if(isset($_POST['btnRegister'])){
    
    $uname = ($_POST['firstname']);
//    $upass = 'eps12345';
//    $mypass = $_POST[$upass];
    if(!isset($_POST['password'])){
        $_POST['password'] = 'eps12345';
    }
    if(isset($_GET['regdate'])){
        $regdate = $_GET['regdate'];
    }
    //get form data
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $department = $_POST['department'];
    $usertype = $_POST['usertype'];
    $password = $_POST['password'];
    $username = ($_POST['firstname']);
    $status = 'Active';
    $activity = '';
    $name = "{$firstname} {$lastname}"; //join first and last names
    // $regdate = date("d-m-Y h:i:sa"); 
//    $regdate = ($_GET['regdate']);
    
       
    //preparing the SQL statement will prevent SQL injection.
    if ($stmt = $connect_db->prepare('SELECT fullname, username FROM users_account WHERE fullname = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), 
    //in our case the username is a string so we use "s"
	$stmt->bind_param('s', $name);
	$stmt->execute();
	$stmt->store_result(); 	//store the result, and check it availability.
    //check if record exists in database
    if ($stmt->num_rows > 0) {
	$stmt->bind_result($fullname, $user_name);
	$stmt->fetch(); 	//record exists, fetch results 
        $error = "Record Exists..\\n \\nThe Name: ".$fullname. " with Username: ".$user_name. " is already taken or registered.. \\nCannot save duplicate records!";
        echo "<script>alert('".$error."')</script>";
//        echo 'The Name: ' .$fullname. ' with Username: '.$user_name. ' is already taken or registered.. \\nCannot save duplicate records!';
    }else{
    //create instance of users class
    $new_user = new Users();
    $pwd_hash = password_hash($password, PASSWORD_DEFAULT); //hash the password
    //insert the record
    $insertid = $new_user->addUser($name, $mobile, $email, $department, $username, $password, $usertype, $status, $regdate);
    if(empty($insertid)){
    echo "<script>alert('Error!\\n \\nCould not complete the request.. Try again later!')</script>";
    }else{
    $message = "New user successfully registered.\\n \\nUsername: ".$username. "\\nPassword: ".$password. "\\n\\nPlease keep your username and password always safe.";
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
    <title>E-Permit System | code test </title>
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
<!--     <link href="../admin/assets/plugins/jquery-steps-master/demo/css/normalize.css" rel="stylesheet" />-->
<!--    <link href="../admin/assets/plugins/jquery-steps-master/demo/css/wizardMain.css" rel="stylesheet" />-->
<!--    <link href="../admin/assets/plugins/jquery-steps-master/demo/css/jquery.steps.css" rel="stylesheet" />  -->
    <!-- end page level styles-->
    
    <!--page level scripts-->
    <script type="text/javascript" src="../third-party/vendor/jquery/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="../third-party/vendor/bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="../third-party/dist/js/bootstrapValidator.js"></script>
    
    <style type="text/css">
        legend{
            font-size: 15px;
            font-weight: bold;
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
                        <i id="icon" class="fa fa-user "></i>&nbsp;Howdy, <?=$_SESSION['uname']?>
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
                            <li><a href="#" id="logout"><i class="fa fa-sign-out-alt"></i> Logout </a>
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
                <li><a href="new-application.php"><i class="fa fa-folder-open"></i> Submit New Application </a></li>
                <!--menu item-->
                <li><a href=""><i class="fa fa-search"></i> Search Applications </a></li>
                <!--menu item-->
                <li><a href=""><i class="fa fa-map-marker"></i> View Applications </a></li>
                <!--menu item-->
                <li><a href=""><i class="fa fa-comments"></i> Chat Option </a></li>
                <!--menu item exit-->
                <li><a href="#" id="logout"><i class="fa fa-power-off"></i> Exit Application </a></li>

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
                          <label class="radio-inline"><input type="radio" name="gender" value="female" required>Female</label>
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
                                <select class="form-control" name="locality" data-by-notempty="" data-by-notempty-message="Location is required" data-by-field="locality">
                                <option value="">-Select-</option>
                                <option value="Adeiso">Adeiso</option>
                                <option value="Ahwerease">Ahwerease</option>
                                <option value="Asuaba">Asuaba</option>
                                <option value="Asuotwene">Asuotwene</option>
                                <option value="Asuokaw">Asuokaw</option>
                                <option value="Danso">Danso</option>
                                <option value="Darmang">Darmang</option>
                                <option value="Okurase">Okurase</option>
                                <option value="Kumikrom">Kumikrom</option>
                                <option value="Kwesi Nyarko">Kwesi Nyarko</option>
                                <option value="Kraboa">Kraboa</option>
                                <option value="Maame Dede">Maame Dede</option>
                                <option value="Mepom">Mepom</option>       <option value="Nyanoa">Nyanoa</option>
                                </select>
                            </div>
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
                                <input type="tel" id="contactnumber" name="contactnumber" placeholder="Emergency contact number" pattern="" class="form-control" />
                            </div>
                        </div>
                        <!--end personal details section-->
                   <br>
                                    
                   <legend> Building or Structure Details </legend>
                             <!--locality-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Site Location </label>
                            <div class="col-lg-4">
                                <input name="location" id="location" class="form-control" placeholder="Location of site or building (eg. Adeiso)" />
                            </div>
                        </div>
                        <!--area-name field-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Area Name</label>
                            <div class="col-lg-4">
                                <input type="text" id="areaname" name="areaname" placeholder="Area name of site eg.Armakrom" class="form-control" />
                            </div>
                        </div>
                         <!--land size-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Size of land</label>
                            <div class="col-lg-4">
                                <input type="text" id="landsize" name="landsize" placeholder="" class="form-control" />
                            </div>
                        </div>
                        <!--occupation-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Proposed Development</label>
                            <div class="col-lg-6">
                                <textarea style="" class="form-control" id="project" name="project" cols="6" rows="8"></textarea>
                            </div>
                        </div>
                       <br>

               
               
              <legend>Zoning</legend>
                        <!--select user type-->
                        <div class="form-group">
                        <label class="control-label col-lg-4">Land Use</label>
                        <div class="col-lg-4">
                                <select class="form-control" name="usertype" id="usertype" onselect="" onclick="" onchange="">
                                <option value="">Select</option>
                                <option value="Commercial">Commercial</option>
                                <option value="Reidential">Residential</option>
                                </select>
                            </div>
                        </div>
                        <!--username-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Density</label>
                            <div class="col-lg-4">
                                <input type="number" class="form-control" name="username" value="" placeholder="" />
                            </div>
                        </div>
                        <!--password-->
                        <div class="form-group">
                            <label class="col-lg-4 control-label">Height</label>
                            <div class="col-lg-4">
                                <input type="number" class="form-control" name="password" placeholder="" />
                            </div>
                        </div>
                        <!--date value hidden-->
                        <div class="form-group">
                            <label class="col-lg-4 control-label hidden">Date</label>
                            <div class="col-lg-4">
                               <input type="text" class="form-control hidden" value="<?php echo date("d/m/Y h:i:sa") ?>" name="regdate" id="regdate">
                            </div>
                        </div>
          
                              
                <legend>Attach Documents </legend>
                             <!--locality-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Locality/Town (*)</label>
                            <div class="col-lg-4">
                                <select class="form-control" name="locality" data-by-notempty="" data-by-notempty-message="Location is required" data-by-field="locality">
                                <option value="">-Select-</option>
                                <option value="Adeiso">Adeiso</option>
                                <option value="Ahwerease">Ahwerease</option>
                                <option value="Asuaba">Asuaba</option>
                                <option value="Asuotwene">Asuotwene</option>
                                <option value="Asuokaw">Asuokaw</option>
                                <option value="Danso">Danso</option>
                                <option value="Darmang">Darmang</option>
                                <option value="Okurase">Okurase</option>
                                <option value="Kumikrom">Kumikrom</option>
                                <option value="Kwesi Nyarko">Kwesi Nyarko</option>
                                <option value="Kraboa">Kraboa</option>
                                <option value="Maame Dede">Maame Dede</option>
                                <option value="Mepom">Mepom</option>       <option value="Nyanoa">Nyanoa</option>
                                </select>
                            </div>
                        </div>
                        <!--area-name field-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Area Name</label>
                            <div class="col-lg-4">
                                <input type="text" id="areaname" name="areaname" class="form-control" />
                            </div>
                        </div>
                        <!--street name-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Street Name</label>
                            <div class="col-lg-4">
                                <input type="text" id="street" name="street" class="form-control" />
                            </div>
                        </div>
                        <!--occupation-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Occupation</label>
                            <div class="col-lg-4">
                                <input type="text" id="occupation" name="occupation" class="form-control" />
                            </div>
                        </div>     
             
             
             <!--area-name field-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Area Name</label>
                            <div class="col-lg-4">
                                <input type="text" id="areaname" name="areaname" class="form-control" />
                            </div>
                        </div>
                        
             
               <legend>Agreement & Declaration</legend>
                    <div class="terms">  
                       <p style="text-align:justify;">
                        <b> You must read the terms and conditions carefully to understand and accept before submitting application.</b>
                         <br/><br/>
                        An application received can be reviewed only if all documents, drawings and information provided are proven to be true and valid; and does not bare any falsehood.
                        <br/>  
                        Please be informed that, any forgery whatsoever found will make your application rejected liable to possible prosecution. 
                        <br/>
                        It is also recommendedd that all check list items are validated to ensure that the applicant meet all required details and/or information needed for ease processing of the application. In case of unavailable document or paper, kindly put the application on hold and request for all needed files before processing an application for a client/applicant.
                        <br />    
                    </p>
                    
                      
                    </div>
                    <div class="checkbox">
                        <label>
                        <input type="checkbox" value="">
                        I declare that all the information provided above are valid and true.</label>
                    </div>
                        
                        <br/>
                         
                           <div class="col-lg-6">
                <div class="panel panel-default">
                 <div class="panel-heading ">Applicant Info & Application Details</div>
                <!--body of panel, content will be here-->
                <div class="panel-body">
                   <!--begin form -->    
                    <form role="form" id="form" method="post" class="form-horizontal px-4 py-3" action="">
                       <!--name field-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Applicant Full Name </label>
                            <div class="col-lg-4">
                                <input type="text" id="name" name="name" class="form-control" value="<?php echo $record['name']; ?>" readonly=""/>
                            </div>
                        </div>
                       <!--gender-->                        
                        <div class="form-group">
                          <label for="gender" class="control-label col-lg-4">Gender</label>
                          <div class="col-lg-5">
                          <label class="radio-inline"><input type="radio" name="gender" value="Male" <?php if($record['gender']=="Male") echo "checked";?> >Male</label>
                          <label class="radio-inline"><input type="radio" name="gender" value="Female" <?php if($record['gender']=="Female") echo "checked";?>>Female</label>
                          </div>
                        </div>
                        <!--phone-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Phone number</label>
                            <div class="col-lg-4">
                                <input type="tel" class="form-control" name="mobile" id="mobile" pattern="[0][0-9]{9}" maxlength="10" value="<?php echo $record['phoneno']; ?>" readonly=""/>
                            </div>
                        </div>              
                        <!--site location-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Site Location </label>
                            <div class="col-lg-4">
                                <input name="location" id="location" class="form-control" value="<?php echo $record['location']; ?>"readonly="" />
                            </div>
                        </div>
                        <!--development-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Proposed Development</label>
                            <div class="col-lg-6">
                                <textarea style="" class="form-control" id="project" name="project" value="<?php echo $record['project_type']; ?>" readonly cols="6" rows="6"></textarea>
                            </div>
                        </div> <!--end applicant details preview section-->
                    </form>
                </div>
                </div>
            </div> 
                         
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
    
      <!-- GLOBAL SCRIPTS -->
    <script src="../admin/assets/js/jquery-2.0.3.min.js"></script>
     <script src="../admin/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="../admin/assets/js/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <!-- END GLOBAL SCRIPTS -->
    <!-- PAGE LEVEL SCRIPTS -->
<!--    <script src="../admin/assets/plugins/jquery-steps-master/lib/jquery.cookie-1.3.1.js"></script>-->
<!--    <script src="../admin/assets/plugins/jquery-steps-master/build/jquery.steps.js"></script>   -->
<!--    <script src="../admin/assets/js/WizardInit.js"></script>-->
         <!--END PAGE LEVEL SCRIPTS -->     

      <!-- bootstrap validation scripts-->
<script type="text/javascript">
$(document).ready(function() {
     
    //bootstrap form-control fields validation
    $('#form-adduser').bootstrapValidator({
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
            email: {
                group: '.col-lg-4',
                validators: {
                    notEmpty: {
                        message: 'Email address is required'
                    },
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    }
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
             department: {
                group: '.col-lg-4',
                validators: {
                    notEmpty: {
                            message: 'Select department'
                        },
                        }
                    },
            usertype: {
                group: '.col-lg-4',
                validators: {
                    notEmpty: {
                            message: 'Select user type'
                        },
                        }
                    },
        }
    });
    
    //this function triggers when form data is submitted
//    $("#form-adduser").submit(function(){
//        var num_val = $("#mobile").substring(0, 3);
//        if (num_val !== '024') && (num_val !== '054') && (num_val !== '055') && (num_val !== '059') && (num_val !== '027') && (num_val !== '057') && (num_val !== '056') && (num_val !== '026') && (num_val !== '020') && (num_val !== '050') && (num_val !== '023'){
//            alert('Phone number is invalid.');
//        }
//    });
    
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
