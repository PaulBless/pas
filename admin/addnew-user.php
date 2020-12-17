
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
    
//    $uname = ($_POST['firstname']);
    $upass = 'eps12345';
    
    ## set default password
    if(!isset($_POST['password'])){
        $_POST['password'] = 'eps12345';
    }
    
    ## set registration date
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
    $passcode = $_POST['password'];
    $password = md5($_POST['password']); //ecnrypt password using MD5
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
    #create instance object of users class
    $new_user = new Users();
    #hash entered password
    $pwd_hash = password_hash($passcode, PASSWORD_DEFAULT); 
    //insert the record in db
    $insertid = $new_user->addUser($name, $mobile, $email, $department, $username, $password, $usertype, $status, $regdate);
	//insert record using hash password
//    $insertid = $new_user->addUser($name, $mobile, $email, $department, $username, $pwd_hash, $usertype, $status, $regdate);
    if(empty($insertid)){
    echo "<script>alert('Error!\\n \\nCould not complete the request.. Try again later!')</script>";
    }else{
    $message = "User successfully registered.\\n \\nUsername: ".$username. "\\nPassword: ".$upass. "\\n\\nPlease keep your username and password always safe.";
    echo "<script>alert('".$message."')</script>";
    
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
    <title>E-Permit System  </title>
     <meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
     <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <![endif]-->
    <!--browser icon-->
    <link rel="icon" href="../assets/images/uwada-logo.jpg" type="image/jpg">    
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
    
    <script type="text/javascript">
		function pageLoading(){
			$('.loading').show();
			setTimeout(function(){
				$('.loading').hide();
			}, 1500);
		}
	</script>
   
    <!--stylesheet-->
    <style type="text/css">
        legend{
            font-size: 15px;
            font-weight: bold;
            color: #5b6574;
        }
        .panel .my-sub-link:hover{
/*            background-color: #33b35a;*/
/*            color: white;*/
            background: #343a40;
            transition: transform .3s ease, -webkit-transform .3s ease, -moz-transform .3s ease, -o-transform .3s ease;
        }
      
       .loading{
            opacity:1.0;
            background:#fefefe url(../assets/images/LoaderIcon.gif) no-repeat center;
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
<body class="padTop53" onload="pageLoading()">
	<div class="loading" id=""></div>

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
                             <li class="my-sub-link"><a href="adminaccounts.php"><i class="fa fa-arrow-right"></i> Admin Accounts</a></li>
               </ul>
                </li>
                 <!--panel item-->
                <li class="panel active" >
                    <a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle collapsed" data-target="#form-nav">
                        <i class="fa fa-users"></i>  System Users
                        <span class="pull-right">
                        <i class="fa fa-angle-down"></i>
                        </span>
                    </a>
                    <ul class="collapse" id="form-nav">
                        <li class="my-sub-link"><a href="addnew-user.php"><i class="fa fa-arrow-right"></i> Add New User </a></li>
                        <li class="my-sub-link"><a href="manage-users.php"><i class="fa fa-arrow-right"></i> Manage Users </a></li>
                        <li class="my-sub-link"><a href="user-logs.php"><i class="fa fa-arrow-right"></i> User Logs</a></li>
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
                        <li class="my-sub-link"><a href="grantpermit.php"><i class="fa fa-arrow-right"></i> Grant A Permit </a></li>
                        <li class="my-sub-link"><a href="reviewlists.php"><i class="fa fa-arrow-right"></i> Review Applications </a></li>
                        <li class="my-sub-link"><a href="permits.php"><i class="fa fa-arrow-right"></i> Building Permits </a></li>
                    </ul>
                </li>
                <!--panel menu item-->
                <li><a href="committee-decisions.php"><i class="fa fa-bookmark"></i> Committee Decisions </a></li>
                <li><a href="site-inspections.php"><i class="fa fa-eye"></i> Site Inspections </a></li>
                <!--menu item-->
                <li><a href="tasks.php"><i class="fa fa-tasks"></i> Users Tasks </a></li>
                <!--menu item-->
                <li><a href="chat.php"><i class="fa fa-comments"></i> Chat Option </a></li>
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
                        <h5><span class="fa fa-home"></span> E-Permit <i class="fa fa-chevron-right"></i> Main Menu <i class="fa fa-chevron-right"></i> System Users <i class="fa fa-chevron-right"></i> Add New User </h5>
                    </div>
                </div>
                <hr />
                
            <div class="row">
                <div class="col-lg-12">
                    <div class="box">
                        <header>
                        <div class="icons"><i class="fa fa-user-plus"></i>
                        </div>
                        <h5>REGISTER NEW USER</h5>
                        <div class="toolbar">
                        <ul class="nav">
                        <li>
                        <div class="btn-group">
                        <a class="accordion-toggle btn btn-xs minimize-box" data-toggle="collapse"
                        href="#collapseForm">
<!--                        <i class="fa fa-chevron-up"></i>-->
                        </a>
                        </div>
                        </li>
                        </ul>
                        </div>
                        </header>
                        <!--form inputs fields-->
                    <div id="collapseForm" class="accordion-body collapse in body ">                           
                    <legend id="fst">Personal Information</legend>
                        <form id="form-adduser" method="post" class="form-horizontal px-4 py-3" action="">
                       <!--input field-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Firstname</label>
                            <div class="col-lg-4">
                                <input type="text" id="fname" name="firstname" class="form-control" />
                            </div>
                            <span class="lbl-error col-lg-4" id="fname-error"></span>
                        </div>
                        <!--input field-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Lastname</label>
                            <div class="col-lg-4">
                                <input type="text" id="lname" name="lastname" class="form-control" />
                            </div>
                            <span class="lbl-error col-lg-4" id="lname-error"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4">E-mail</label>
                            <div class="col-lg-4">
                                <input type="email" id="email" name="email" class="form-control" />
                            </div>
                            <span class="lbl-error col-lg-4" id="email-error"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4">Phone number</label>
                            <div class="col-lg-4">
                                <input type="tel" class="form-control" name="mobile" placeholder="" id="mobile" pattern="[0][0-9]{9}" onblur="" maxlength="10"/>
                            </div>
                            <span class="lbl-error col-lg-4" id="mobile-error"></span>   
                        </div>
                        <!--department-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Department Name:</label>
                            <div class="col-lg-4">
                                <select class="form-control" name="department" data-by-notempty="" data-by-notempty-message="Department is required" data-by-field="department">
                                <option value="">--Select--</option>
                                <option value="Physical Planning">Physical Planning</option>
                                <option class="hidden" value="Works">Works</option>
                                <option class="hidden" value="Account">Account</option>
                                </select>
                            </div>
                            <span class="lbl-error col-lg-4" id="dept-error"></span>
                        </div>
                        <!--end-->
<!--                        <br>-->
<!--                        <hr>-->
                        <!--account info-->
                        <legend> Account Information</legend>
                        <!--select user type-->
                        <div class="form-group">
                        <label class="control-label col-lg-4">User Type:</label>
                        <div class="col-lg-4">
                                <select class="form-control" name="usertype" id="usertype" onselect="" onclick="" onchange="">
                                <option value="">--Select--</option>
                                <option class="hidden" value="Admin">Admin</option>
                                <option value="Officer">Planning Officer</option>
                                <option value="User">User</option>
                                </select>
                            </div>
                        <span class="lbl-error col-lg-4" id="usertype-error"></span>
                        </div>
                        <!--username-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Username</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="username" value="" placeholder="Value Will Be Generated" disabled />
                            </div>
                        </div>
                        <!--password-->
                        <div class="form-group">
                            <label class="col-lg-4 control-label">Password</label>
                            <div class="col-lg-4">
                                <input type="password" class="form-control" name="password" placeholder="Value Will Be Generated" disabled />
                            </div>
                        </div>
                        <!--date value hidden-->
                        <div class="form-group">
                            <label class="col-lg-4 control-label hidden">Date</label>
                            <div class="col-lg-4">
                               <input type="text" class="form-control hidden" value="<?php echo date("d/m/Y h:i:sa") ?>" name="regdate" id="regdate">
                            </div>
                        </div>
                        <!--buttons group-->
                        <div class="form-actions no-margin-bottom" style="text-align:center;">
<!--                        <input type="submit" name="btnRegister" value="Register" class="btn btn-success" style="margin-right: 25px">-->
                        <!-- submit button-->
                       <button type="submit" name="btnRegister" value="Register" id="btnSave" class="btn btn-success" style="font-weight: bold"><i class="fa fa-save"></i> Register</button>
                        <a class="btn btn-danger" type="reset" href="dashboard.php" style="margin-left: 25px; font-weight: bold"><i class="fa fa-times"></i> Cancel</a>
                        </div>
                        </form>
                    </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!--END PAGE CONTENT -->
        
</div>    <!--END MAIN WRAPPER -->

<!-- FOOTER -->
    <div id="footer">
        <p>&copy; E-Permit 2020. &nbsp;Developed by <a class="app-developer" style="" href="">Jecmas </a>&nbsp;</p>
    </div>
    <!--END FOOTER -->
    
        
    <!--END PAGE LEVEL SCRIPT-->
   <!-- validation scripts-->
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
            firstname: {
                group: '.col-lg-4',
                validators: {
                    notEmpty: {
                        message: 'Firstname cannot be empty, required!'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z]+$/,
                        message: 'The firstname can only consist of alphabet'
                    },
                }
            },
            lastname: {
                group: '.col-lg-4',
                validators: {
                    notEmpty: {
                        message: 'Lastname cannot be empty, required!'
                    },
                     regexp: {
                        regexp: /^[a-zA-Z ]+$/,
                        message: 'The lastname can only consist of alphabet'
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
    
    //usertype on selected value changes
    $('#usertype').change(function(){
        var x = $(this).val();
        var get_username = $("#firstname").substring(0, 5);
        var get_password = "eps12345";
        if (x !== ''){
            $("#username").val() = get_username;
            $("#password").val() = get_password;
            alert("usernam is "+get_username);
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

     
	$('#btnSave').click(function(){
        var addBtn = document.querySelector('.btn-success');
        
        addBtn.addEventListener("click", function(){
            addBtn.innerHTML = "Saving..";
            addBtn.classList.add('saving');
            $('.spinning').show();
            setTimeout(function(){
				$('.spinning').hide();
                addBtn.classList.remove('saving');
                addBtn.innerHTML = "Save";
            }, 4000);
        }, false);
        
    });
</script>

<!--preloading-->
 <script>
        var preloader = document.getElementById('loader');
        function displayLoader(){
            preloader.style.display = 'none';
        }
        setTimeout(function(){
            $('.loading').fadeToggle();
        }, 1500);
    </script>
   
    </body>
</html>
