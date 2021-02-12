


<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);

//include db connection file
include '../functions/db_connection.php';

//invoke controller classes
require_once '../functions/databaseController.php';
//require_once '../functions/Applications.php';

//instance of db controller class
$db_handle = new databaseController();



// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: ../index.php');
	exit;
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
    $date = date("d/m/Y h:i:sa"); 
    
       
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





     
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <!--meta descriptions-->
    <meta charset="UTF-8" />
    <title>E-Permit System | Search Applications </title>
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
    <link href="../admin/assets/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <!-- end page level styles-->
    
    <!--page level scripts-->
    <script type="text/javascript" src="../third-party/vendor/jquery/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="../third-party/vendor/bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="../third-party/dist/js/bootstrapValidator.js"></script>
    
    <!-- datatable -->
         <script src="../admin/assets/plugins/dataTables/dataTables.bootstrap.js"></script>
      <script src="../admin/assets/plugins/dataTables/jquery.dataTables.js"></script>
    
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
                        <i id="icon" class="fa fa-user "></i>&nbsp;Welcome, <?=$_SESSION['name']?>
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
                <li><a href="addapplication.php"><i class="fa fa-plus"></i> Add New Application </a></li>
                <!--menu item-->
                <li><a href="application-lists.php"><i class="fa fa-th"></i> Application Lists </a></li>
                <!--menu item-->
                <li><a href="mysubmisssions.php"><i class="fa fa-folder"></i> My Submitted Forms </a></li>
                <!--menu item-->
                <li><a href="building-permits.php"><i class="fa fa-bookmark"></i> Permits Granted </a></li>
                <!--menu item exit-->
                <li><a href="../logout.php"><i class="fa fa-power-off"></i> Logout </a></li>

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
                        <i class="fa fa-chevron-right"></i> Chat </h5>
                    </div>
                </div>
        <hr />
                
            <div class="row">
                <div class="col-lg-12">
                    <div class="box">
                        <header>
                        <div class="icons"><i class="fa fa-briefcase"></i>
                        </div>
                        <h5>CHAT</h5></header>
                        
                        <div class="panel panel-default">
                                                      
                            
                            <div class="panel-body">
                              
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
        <p>&copy; E-Permit 2020. &nbsp;Developed by <a class="app-developer"  href="../jecmasghana/index.html" target="_blank">Jecmas </a>&nbsp;</p>
    </div>
    <!--END FOOTER -->
    
      <!-- GLOBAL SCRIPTS -->
<!--    <script src="../admin/assets/js/jquery-2.0.3.min.js"></script>-->
<!--     <script src="../admin/assets/plugins/bootstrap/js/bootstrap.min.js"></script>-->
<!--    <script src="../admin/assets/js/modernizr-2.6.2-respond-1.1.0.min.js"></script>-->
    <!-- END GLOBAL SCRIPTS -->
    <!-- PAGE LEVEL SCRIPTS -->
    <script src="../admin/assets/plugins/validationengine/css/validationEngine.jquery.css"></script>
    <script src="../admin/assets/plugins/jasny/js/bootstrap-fileupload.js"></script>   
<!--
    <script src="../admin/assets/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="../admin/assets/plugins/dataTables/dataTables.bootstrap.js"></script>
-->
   
         <!--END PAGE LEVEL SCRIPTS -->     

      <!-- bootstrap validation scripts-->
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
                group: '.col-lg-4',
                validators: {
                    notEmpty: {
                            message: 'Specify the propose development name'
                        },
                    regexp: {
                        regexp: /^[a-zA-Z ]+$/,
                        message: 'Occupation can only consist of alphabets'
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
    
    //contact number
      jQuery("#contactnumber").keypress(function(ev){
    var x = $(this).val();
    if (ev.keyCode < 48 || ev.keyCode > 57) {
      ev.preventDefault();
        }
    });
    
    //validate number format
    jQuery("#mobile").onblur(function(ev){
        var x = $(this).val();
        var num = this.substring(0, 3);
        if (num !== '054' && num !== '024'){
            alert('Phone number is invalid.');
        }
    });
    
    //first-name validation
    jQuery("#name").keypress(function(ev){
        var x = $(this).val();
        if ((ev.keyCode < 65 || ev.keyCode > 90) && (ev.keyCode < 97 || ev.keyCode > 122 )){
            ev.preventDefault();
        }
    });
    
    //last-name validation
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





                            