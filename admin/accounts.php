
<?php
session_start();

include '../functions/db_connection.php';
//invoke controller classes
require_once '../functions/databaseController.php';
require_once '../functions/Applications.php';


//instance of db controller class
$db_handle = new databaseController();


// If the user is not logged in, redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: logout.php');
	exit;
}


//get user action type
$action = "";
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}


//get application reviewid
$reviewId = "";
if (isset($_GET['reviewId'])) {
    $reviewId = $_GET['reviewId'];
}


?>


 <?php //include('../includes/header.php'); ?>
    
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> 
<html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head class="">
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
    <script type="text/javascript">
		function pageLoading(){
			$('.spinning').show();
			setTimeout(function(){
				$('.spinning').hide();
			}, 1500);
		}
	</script>
      
       <Style>
           /* custom styling to sub-menus*/
        .panel .my-sub-link:hover{
    /*            background-color: #33b35a;*/
    /*            color: white;*/
                background: #343a40;
                transition: transform .3s ease, -webkit-transform .3s ease, -moz-transform .3s ease, -o-transform .3s ease;
            }
		   .spinning{
			opacity: 1.0;
			background: #fefefe url(../assets/images/LoaderIcon.gif) no-repeat center;
			position: fixed;
			width: 100%;
			height: 100%;
			top: 0px;
			left: 0px;
			z-index: 2000;
			display: none;
		}
    </Style>
    
	</head>
   
<!--   BEGIN THE PAGE BODY-->
    <body class="padTop53 " onload="pageLoading()" onreset="" >
    	<div class="spinning"></div>
    
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
                <li class="panel active">
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
                        <h5><span class="fa fa-home"></span> E-Permit <i class="fa fa-chevron-right"></i> Accounts <i class="fa fa-chevron-right"></i> System Users </h5>
                    </div>
                </div>
                  <hr />
                   
                 <div class="col-lg-12">
                   <a href="dashboard.php" class="btn btn-warning btn-sm" style="font-weight: bold"><i class="fa fa-arrow-left" style="margin-right: 3px;"></i> Go Back</a>
                <div class="box">
                    <header>
                        <div class="icons"><i class="fa fa-users"></i></div>
                        <h5>SYSTEM USERS ACCOUNTS</h5>

                        <div class="toolbar">
                            <ul class="nav pull-right">
                                <li>
                                    <a class="accordion-toggle minimize-box" data-toggle="collapse" href="#div-4">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </header>
                    
                    <!--get admin account details-->
                    <div class="panel panel-default">
                                               
                        <a href="" target="_self" data-toggle="modal" data-target="#regAdmin" class="btn btn-primary btn-rect" style="font-weight: bold; float: right; margin: 5px 5px 5px 5px;"><i class="fa fa-plus-circle"></i> Register New Admin</a>
<!--                        <a href="register.php" target="_self" data-toggle="" data-target="" class="btn btn-primary btn-rect" style="font-weight: bold; float: right; margin: 5px 5px 5px 5px;"><i class="fa fa-plus-circle"></i> Register New Admin</a>-->
						<br>
                       <div class="panel-body" style="margin-top: 10px;">
                        <div class="panel panel-default">

                            <div class="panel-heading" style="text-align: center; font-size: 16px; font-weight: bold; color:#007bff;"><i class="" style=""></i>  Admin Accounts</div>
                                <div class="panel-body" style="">
                                    <table id="table" data-toggle="table" data-pagination="" data-search="true" data-show-columns="" data-show-pagination-switch="" data-show-refresh="" data-key-events="" data-show-toggle="" data-resizable="" data-cookie="" data-cookie-id-table="saveId" data-show-export="" data-click-to-select="" data-toolbar="#toolbar" class="table table-bordered table-hover" width="100%">
            
                    			<thead class="text-warning" style="background: #000">
                        			<tr class="">
                        <th class="">No.</th>
                        <th data-field="userid" class="hidden">ID</th>
                        <th data-field="fullname">Full Name</th>
                        <th data-field="mobile">Mobile No</th>
                        <th data-field="email">Email</th>
                        <th data-field="username">Username</th>
                        <th data-field="password" class="hidden">Password</th>
                        <th data-field="status">Status</th>
                        <th data-field="regdate">Registered Date</th>
                        <th data-field="action">Action</th>
                        </tr>
                    			</thead>
                    <tbody>
        <?php
            $query1=mysqli_query($connect_db,"SELECT * from admin_account order by fullname ASC");
            $cnt=1;
            while($records=mysqli_fetch_array($query1)){

        ?>
                <tr>
                <td><?php echo $cnt; ?></td>
                 <td class="hidden"><?php echo $records['adminid'] ?></td>
                <td><?php echo $records['fullname']; ?></td>
                <td><?php echo $records['mobileno']; ?></td>
                <td><?php echo $records['email']; ?></td>
                <td><?php echo $records['username']; ?></td>
                <td class="hidden"><?php echo ($records['password']); ?></td>
                <td>
                <?php if($records['status'] == "Active"): ?>
                    <font class="text-success"><?php echo $records['status']; ?></font>
                    <?php else: ?>
                    <font class="text-danger"><?php echo $records['status']; ?></font>
                    <?php endif; ?>
                </td>
                <td><?php echo date('d M, Y', strtotime($records['regdate'])); ?></td>
                <td class="datatable-ct">
                
                <!--check application status, to enable edit button-->
                   <?php if($records['status'] != "Active"): ?>
                    <a title="Click to unlock user account" href="unlock-admin.php?adminid=<?php echo $records['adminid']; ?>" onclick="return confirm('This action will re-activate or unlock this admin account, Are you sure?')"  class="btn btn-info btn-sm "> <span class="fa fa-unlock"></span> Unlock</a>
                           <?php else: ?>
                    <a title="Click to lock" href="lock-admin.php?adminid=<?php echo $records['adminid']; ?>" onclick="return confirm('This admin account will be locked, meaning the admin cannot access the system again!')" class="btn btn-warning btn-sm"> <span class="fa fa-lock"></span> Lock</a>
                   <?php endif; ?> 
                  
                <!--delete link-->
                 <a title="Click to delete" class="btn btn-danger btn-sm" href="delete-admin.php?adminid=<?php echo htmlentities($records['adminid']);?>" onclick="return confirm('Do you really want to delete this admin account from the system?')"> <i class="fa fa-trash"></i> Delete </a>
                </td>
                </tr>
            <?php
            $cnt=$cnt+1;        
}?>
                    </tbody>
                </table>   
                                </div>

                        </div>
                          </div>                
                    
                        <!--get user accounts details-->
                        <div class="panel-body">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="text-align: center; font-size: 16px; font-weight: bold; color:#21a9f2;"><i class=""></i> User Accounts</div>
                            <div class="panel-body">
                              
                              <table id="table" data-toggle="table" data-pagination="" data-search="true" data-show-columns="" data-show-pagination-switch="" data-show-refresh="" data-key-events="" data-show-toggle="" data-resizable="" data-cookie="" data-cookie-id-table="saveId" data-show-export="" data-click-to-select="" data-toolbar="#toolbar" class="table table-bordered table-hover" width="100%">
            
                    			<thead class="text-warning" style="background: #000">
                        		<tr class="">
                        <th class="">No.</th>
                        <th data-field="userid" class="hidden">ID</th>
                        <th data-field="fullname">Full Name</th>
                        <th data-field="mobile">Mobile No</th>
                        <th data-field="email">Email</th>
                        <th data-field="username">Username</th>
                        <th data-field="password" class="hidden">Password</th>
                        <th data-field="role" class="">Role</th>
                        <th data-field="status">Status</th>
                        <th data-field="regdate">Date Added</th>
                        <th data-field="action">Action</th>
                        </tr>
                    			</thead>
                    			<tbody>
        <?php
            $query1=mysqli_query($connect_db,"SELECT * from users_account order by fullname ASC");
            $cnt=1;
            while($records=mysqli_fetch_array($query1)){

        ?>
                <tr>
                <td><?php echo $cnt; ?></td>
                 <td class="hidden"><?php echo $records['userid'] ?></td>
                <td><?php echo $records['fullname']; ?></td>
                <td><?php echo $records['mobileno']; ?></td>
                <td><?php echo $records['email']; ?></td>
                <td><?php echo $records['username']; ?></td>
                <td class="hidden"><?php echo ($records['password']); ?></td>
                <td class=""><?php echo ($records['role']); ?></td>
                <td>
                <?php if($records['status'] == "Active"): ?>
                    <font class="text-success"><?php echo $records['status']; ?></font>
                    <?php else: ?>
                    <font class="text-danger"><?php echo $records['status']; ?></font>
                    <?php endif; ?>
                </td>
                <td><?php echo date('d M, Y', strtotime($records['regdate'])); ?></td>
                <td class="datatable-ct">
                
                <!--check application status, to enable edit button-->
                   <?php if($records['status'] != "Active"): ?>
                    <a title="Click to unlock user account" href="unlock-user.php?userid=<?php echo $records['userid']; ?>" onclick="return confirm('Are you sure you want to re-activate or unlock this user account?')"  class="btn btn-info btn-sm "> <span class="fa fa-unlock"></span> Unlock</a>
                           <?php else: ?>
                    <a title="Click to lock user account" href="lock-user.php?userid=<?php echo $records['userid']; ?>" onclick="return confirm('This user account will be locked, meaning the user cannot access the system again!')" class="btn btn-warning btn-sm"> <span class="fa fa-lock"></span> Lock</a>
                   <?php endif; ?> 
                <!--delete link-->
                 <a title="Click to delete user" class="btn btn-danger btn-sm" href="delete-user.php?userid=<?php echo htmlentities($records['userid']);?>" onclick="return confirm('Do you really want to delete this user account?')"> <i class="fa fa-trash"></i> Delete </a>
                </td>
                </tr>
            <?php
            $cnt=$cnt+1;        
}?>
                    </tbody>
                			  </table>   
                                
                            </div>
                        </div>
                        </div>    
                    
                    </div>
      
                </div>
					</div>

			</div>

        </div><!--END PAGE CONTENT -->
        
    </div> <!--END MAIN WRAPPER -->


	<!-- REGISTER ADMIN MODAL FORM -->
	<div class="col-lg-12">
        <div class="modal fade in" id="regAdmin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="">
           <div class="modal-dialog">
                <div class="modal-content">
                      <div class="modal-header">
                       <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                           <h4 class="modal-title" id="H2">Admin Account Registration</h4>
                      </div>
                      <div class="modal-body">
                          <form id="defaultForm" method="post" class="form-horizontal px-4 py-3" action="register-admin.php">
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Firstname</label>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" name="firstName" placeholder="Enter firstname" id="first-name" value="" />
                            </div>
                        </div>
                        <!--lastname-->
                        <div class="form-group">
                             <label class="col-lg-3 control-label">Lastname</label>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" name="lastName" placeholder="Enter lastname" id="last-name" value="" />
                            </div>
                        </div>
                        <!--email-->
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Email address</label>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" name="email" placeholder="Enter email address" value="" />
                            </div>
                        </div>
                        <!--phone number-->
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Phone Number</label>
                            <div class="col-lg-6">
                                <input onblur="chk_phone" type="tel" class="form-control" name="phone" placeholder="Enter mobile number" pattern="[0][0-9]{9}" maxlength="10" id="phone-number" value=""/>
                            </div>
                        </div><!--end-->
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Username</label>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" name="username" placeholder="Enter Username" />
                            </div>
                        </div>
                        <!--password-->
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Password</label>
                            <div class="col-lg-6">
                                <input type="password" class="form-control" name="password" placeholder="Enter password" />
                            </div>
                        </div>
                        <!--confirm password-->
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Password Again</label>
                            <div class="col-lg-6">
                                <input type="password" class="form-control" name="confirmPassword" placeholder="Retype password again" />
                            </div>
                        </div>
                        <!--captcha-->
                        <div class="form-group">
                            <label class="col-lg-3 control-label" id="captchaOperation"></label>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" name="captcha" placeholder="Enter answer" style="text-align: center" />
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="col-lg-4 control-label hidden">Date</label>
                            <div class="col-lg-4">
                               <input type="text" class="form-control hidden" value="<?php echo date("d/m/Y h:i:sa") ?>" name="regdate" id="regdate">
                            </div>
                        </div> 
                        <!-- register button-->
                        <div class="form-group">
                            <div class="col-lg-4 col-lg-offset-3">
                                <button type="submit" class="btn btn-block btn-success btn-signup" name="btnRegister" id="btnreg" style="font-weight:bold"><i class="fa fa-paper-plane"></i> Register</button>
                            </div>
                            <div class="" >
                            	<button type="submit" class="btn btn-danger" data-dismiss="modal" style="font-weight:bold"><i class="fa fa-times"></i> Close</button>
                            </div>
                        </div>
						  </form>
                         </div>
                          
<!--
                         <div class="modal-footer">
                             <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                          </div>
-->

					</div>
                                </div>
                
        </div>
    </div>
    <!--END -->
    
<!-- FOOTER -->
    <div id="footer" class="">
        <p>&copy; E-Permit 2020. &nbsp;Developed by <a class="app-developer" style="" href="">Jecmas </a>&nbsp;</p>
    </div>
    <!--END FOOTER -->
    
    <?php //include ('../includes/footer.php'); ?>

<!-- validation scripts-->
<script type="text/javascript">
	$(document).ready(function() {
    
		//button click event
		
		// Generate a simple captcha
    function randomNumber(min, max) {
        return Math.floor(Math.random() * (max - min + 1) + min);
    };
    $('#captchaOperation').html([randomNumber(1, 100), '+', randomNumber(1, 200), '='].join(' '));
    
    //bootstrap form-control fields validation
    $('#defaultForm').bootstrapValidator({
//        live: 'disabled',
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            firstName: {
                group: '.col-lg-6',
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
            lastName: {
                group: '.col-lg-6',
                validators: {
                    notEmpty: {
                        message: 'Lastname cannot be empty, required!'
                    },
                     regexp: {
                        regexp: /^[a-zA-Z -]+$/,
                        message: 'The lastname can only consist of alphabet'
                    },
                }
            },
            username: {
                message: 'The username is not valid',
                validators: {
                    notEmpty: {
                        message: 'Username cannot be empty, required!'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_\.]+$/,
                        message: 'The username can only consist of alphabetical, number, dot and underscore'
                    },
//                    remote: {
//                        type: 'POST',
//                        url: '../functions/checkUsernameAvailabiility.php',
//                        message: 'The username is not available'
//                    },
                    different: {
                        field: 'password,confirmPassword',
                        message: 'The username and password cannot be the same as each other'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'Email address is required'
                    },
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'Password cannot be empty, required!'
                    },
                    stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The password must be more than 6 and less than 30 characters long'
                    },
                    identical: {
                        field: 'confirmPassword',
                        message: 'The password and its confirm are not the same'
                    },
                    different: {
                        field: 'username',
                        message: 'The password cannot be the same as username'
                    }
                }
            },
            confirmPassword: {
                validators: {
                    notEmpty: {
                        message: 'Retype your password to confirm!'
                    },
                    stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The password must be more than 6 and less than 30 characters long'
                    },
                    identical: {
                        field: 'password',
                        message: 'The passwords you entered do not match'
                    },
                    different: {
                        field: 'username',
                        message: 'Password cannot be the same as your Username'
                    }
                }
            },
            phone: {
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
            
            captcha: {
                validators: {
                    callback: {
                        message: 'Wrong answer',
                        callback: function(value, validator) {
                            var items = $('#captchaOperation').html().split(' '), sum = parseInt(items[0]) + parseInt(items[2]);
                            return value == sum;
                        }
                    }
                }
            }
        }
    });
    
    // keypress event
    //phone-number validation
    jQuery("#phone-number").keypress(function(ev){
    var x = $(this).val();
    if (ev.keyCode < 48 || ev.keyCode > 57) {
      ev.preventDefault();
        }
    });
    
    jQuery("#phone-number").onblur(function(ev){
        var x = $(this).val();
        var num = this.substring(0, 3);
        if (num != '054' && num != '024'){
            alert('Phone number is invalid.');
        }
    });
    
    //first-name validation
    jQuery("#first-name").keypress(function(ev){
        var x = $(this).val();
        if ((ev.keyCode < 65 || ev.keyCode > 90) && (ev.keyCode < 97 || ev.keyCode > 122 )){
            ev.preventDefault();
        }
    });
    
    //last-name validation
    jQuery("#last-name").keypress(function(ev){
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








