
<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);

//include db connection file
include '../functions/db_connection.php';

//invoke controller classes
require_once '../functions/databaseController.php';
require_once '../functions/Admin.php';

//instance of db controller class
$db_handle = new databaseController();



// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}

//get and set loggedin username
if (isset($_SESSION['uname'])){
   $uname = ($_SESSION['uname']);
}
//get and set loggedin username
if (isset($_SESSION['ufname'])){
   $ufname = ($_SESSION['ufname']);
}

//get and set loggedin userid
if (isset($_SESSION['id'])){
   $uid = ($_SESSION['id']);
}

//fetch user data
$admin = new Admin();
$fetch = $admin->getAdminById($uid);
//get stored passcode from db
$user_password = $fetch[0]['password'];

//testing code
if(isset($_POST['test']))
{

	
}


//process form date to execute request 
if(isset($_POST['btnchange'])){
	$username = $_POST['username'];
    $oldpwd = $_POST['oldpassword'];
    $newpwd = $_POST['newpassword'];
    $confirmpwd = $_POST['confirmnewpass'];
        
	$password_length = strlen($_POST['newpassword']);
	$newpass_encrypt = password_hash($_POST['newpassword'], PASSWORD_DEFAULT);
	$oldpass_encrypt = password_hash($user_password, PASSWORD_DEFAULT);
	
	## validations
	if(password_verify($_POST['oldpassword'], $user_password)) #valid old password: proceed
	{
			if($_POST['newpassword'] == $_POST['confirmnewpass']) #passwords identical
			{
				if($password_length >= 6 ) ## check password length
				{
					echo "<script>alert('processing.. please wait')</script>";
					## process request
					$myadmin = new Admin();
					$update_passcode = $myadmin->changePassword($newpass_encrypt, $uid);
					## show success msg
    				$message = "Password changed successfully\\nYour new password is: $newpwd\\n\\nYou will be required to login again";
    				echo "<script>alert('".$message."');window.location='restart_session.php';</script>";
				}else { 
					echo "<script>alert('Password strength very weak, it must be atleast 6 characters long')</script>";
					  }
			}else{
				echo "<script>alert('The new password and confirm password must match (be the same values)')</script>";
				 }
	}else{	
		echo "<script>alert('The old password is incorrect')</script>";
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
<!--   <link rel="stylesheet" href="../third-party/vendor/bootstrap/css/bootstrap.css">-->
    <link rel="stylesheet" href="../third-party/dist/css/bootstrapValidator.css">
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
		
        .panel .my-sub-link:hover{
/*            background-color: #33b35a;*/
/*            color: white;*/
            background: #343a40;
            transition: transform .3s ease, -webkit-transform .3s ease, -moz-transform .3s ease, -o-transform .3s ease;
        }
     
        .loading{
            position: fixed;
            width: 100%;
            height: 100%;
            opacity:  0.9;
            background:#efefef url(../assets/images/spin.gif) center no-repeat;
            z-index: 99999;
			display: none;
			top: 0px;
			left: 0px;
        } 
		
		.spinning{
            position: fixed;
            width: 100%;
            height: 100%;
            opacity:  0.9;
            background:#f1f1f1 url(../assets/images/91.gif) center no-repeat;
            z-index: 99999;
			display: none;
			top: 0px;
			left: 0px;
        }
    </style>
   </head>    <!-- END HEAD -->

   
    <!-- BEGIN BODY -->
<body class="padTop53" onload="displayLoader()" >
<div class="loading" id="loader"></div>
<div class="spinning" id="spinner"></div>

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
                <li class="panel " >
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
                        <h5><span class="fa fa-home"></span> E-Permit <i class="fa fa-chevron-right"></i> Main Menu <i class="fa fa-chevron-right"></i> User Settings <i class="fa fa-chevron-right"></i> Change Password </h5>
                    </div>
                </div>
                <hr />
                
            <div class="row">
                <div class="col-lg-12">
                    <div class="box">
                        <header>
                        <div class="icons"><i class="fa fa-th"></i>
                        </div>
                        <h5>CHANGE PASSWORD </h5>
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
						<form id="form-change" method="post" class="form-horizontal px-4 py-3" action="">
                    		<div class="panel panel-default">                                 <!--account info-->
								<div class="panel-heading">
									Account Info
								</div>
						<br>
                        <!--username-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Username</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="username" value="<?php echo $fetch[0]['username']; ?>" readonly/>
                            </div>
                        </div>
                        <!--old password-->
                        <div class="form-group">
                            <label class="col-lg-4 control-label">Old Password</label>
                            <div class="col-lg-4">
                                <input type="password" value="" class="form-control" name="oldpassword" id="oldpwd" placeholder="Enter your old password" required/>
                            </div>
                          <span class="lbl-error col-lg-4" id="oldpwd-error"></span>
                        </div>
                        <!--new password 1-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">New Password</label>
                            <div class="col-lg-4">
                                <input type="password" id="newpassword" name="newpassword" value="" placeholder="Enter your new password" class="form-control" minlength="6" maxlength="30" required/>
                            </div>
                            <span class="lbl-error col-lg-4" id="newpwd-error"></span>
                        </div>
                        <!--- new password 2 -->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Confirm New Password</label>
                            <div class="col-lg-4">
                                <input type="password" id="cfmnewpwd" name="confirmnewpass" value="" placeholder="Confirm your new password" class="form-control" minlength="6" maxlength="30" required/>
                            </div>
                            <span class="lbl-error col-lg-4" id="email-error"></span>
                        </div>
                        
                        <!--buttons group-->
                        <div class="form-actions no-margin-bottom" style="text-align:center;">

						<!-- submit button-->
<!--                       <button type="submit" name="test" value="" id="test" class="btn_change btn btn-info" style="font-weight: bold"> Submit</button>-->
                       
                       <button type="submit" name="btnchange" value="" id="btnchange" class="btn_change btn btn-primary" style="font-weight: bold"> Change Password</button>
                        <a class="btn btn-danger" type="reset" href="dashboard.php" style="margin-left: 25px; font-weight: bold"><i class="fa fa-times"></i> Cancel</a>
                        </div>
                        <br>
							</div><!-- panel default-->
                       
							
                        </form>
                        
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
            oldpassword: {
                group: '.col-lg-4',
                validators: {
                    notEmpty: {
                        message: 'Old password cannot be empty, required!'
                    },
                 stringLength:{
					min: 6,
					max: 30,
					message: 'Password not complete, must be atlease 6 characters long'
					},
                }
            }, 
			newpassword: {
                group: '.col-lg-4',
                validators: {
                    notEmpty: {
                        message: 'New password is required!'
                    },
             		stringLength:{
						min: 6,
						max: 30,
						message: 'Password not complete, must be atleast 6 characters long'
					},
					identical: {
                        field: 'confirmnewpass',
                        message: 'The password and its confirm are not the same'
                    },
                    different: {
                        field: 'oldpassword',
                        message: 'The password cannot be the same as username'
                    },
                }
            },
            confirmnewpass: {
                group: '.col-lg-4',
                validators: {
                    notEmpty: {
                            message: 'Retype the new password again'
                        },
                    stringLength: {
                        min: 6,
                        max: 30,
                        message: 'Password should be at 6 characters long'
                            },
					identical: {
                        field: 'newpassword',
                        message: 'The password and its confirm are not the same'
                    },
                    different: {
                        field: 'oldpassword',
                        message: 'The password cannot be the same as username'
                    },
				}
              },
                    
    });
    
    
    // keypress event
    //phone-number validation
    jQuery("#mobile").keypress(function(ev){
    var x = $(this).val();
    if (ev.keyCode < 48 || ev.keyCode > 57) {
      ev.preventDefault();
        }
    });
    
    //last-name validation
    jQuery("#fullname").keypress(function(ev){
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
	
	$('#btnchange').click(function(){
		changePassword();
	});
     
	$('#btnSave').click(function(){
        var addBtn = document.querySelector('.btn-success');
        
        addBtn.addEventListener("click", function(){
            addBtn.innerHTML = "Saving..";
            addBtn.classList.add('saving');
            
            setTimeout(function(){
                addBtn.classList.remove('saving');
                addBtn.innerHTML = "Save";
            }, 4000);
        }, false);
        
    });
</script>

	<script type="text/javascript">
		function changePassword(){
			$('.spinning').show();
			setTimeout(function(){
				var btn= document.querySelector('btnchange');
				btn.innerHTML="Processing..";
				$('.spinning').fadeOut();
			}, 5000);
		}
	</script>

<!--preloading-->
 	<script type="text/javascript">
        function displayLoader(){
        $('.loading').show();
        setTimeout(function(){
            $('.loading').fadeOut();
        }, 1500);
		}
    </script>
   
    </body>
</html>
