
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


// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}


?>


 <?php //include('../includes/header.php'); ?>

     
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
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
    <link rel="icon" href="../assets/images/uwada-logo.jpg" type="image/jpg">    
    <!-- GLOBAL STYLES -->
    <link rel="stylesheet" href="../admin/assets/plugins/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="../admin/assets/css/main.css" />
    <link rel="stylesheet" href="../admin/assets/css/theme.css" />
    <link rel="stylesheet" href="../admin/assets/css/MoneAdmin.css" />
    <link rel="stylesheet" href="../assets/font-awesome/css/fontawesome-all.css" />
    <link rel="stylesheet" href="../assets/font-awesome/css/fontawesome.css" />
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
      /* preloader styling*/
        .loading{
            position: fixed;
            width: 100%;
            height: 100vh;
            background: #efefef url('../assets/images/ajax-loader-small.gif')
                no-repeat center;
            z-index: 99999;      
        }
        
        legend{
            font-size: 15px;
            font-weight: bold;
            color: #5b6574;
        }
        
    /*  table styling*/
        .table {
    width: 100%;
    border-spacing: 0px;
    color: #6d6c6c;
}

        .table td {
            padding: 10px;
            border-bottom: 1px solid #d9d9d9;
        }

        .table th {
            padding: 10px;
            border-bottom: 1px solid #d9d9d9;
            background: #d9d9d9;
            text-align: left;
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
<body class="padTop53" onload="" >
    
<!--    preloader-->
<div class="loading" id="loader"></div>


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
                <li class="panel active">
                    <a href="dashboard.php" >
                        <i class="fa fa-home"></i> Main Menu
                    </a>                                   
                </li>
                <!-- menu panel items-->
                <li class="panel ">
                    <a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" data-target="#settings-nav">
                        <i class="fa fa-cog"> </i> Settings     
                        <span class="pull-right">
                          <i class="fa fa-angle-right"></i>
                        </span>
                    </a>
                    <ul class="collapse" id="settings-nav">
                        <li class="my-sub-link"><a href=""><i class="fa fa-map-marker-alt"></i> Locations </a></li>
                        <li class="my-sub-link"><a href=""><i class="fa fa-donate"></i> Payments </a></li>
                        <li class="my-sub-link"><a href=""><i class="fa fa-boxes"></i> Application Category </a></li>
                        <li class="my-sub-link"><a href=""><i class="fa fa-people-carry"></i> Designation</a></li>
                    </ul>
                </li>
                <!-- menu panel items-->
                <li class="panel ">
                    <a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" data-target="#options-nav">
                        <i class="fa fa-ribbon"> </i> Option Menu     
                        <span class="pull-right">
                          <i class="fa fa-angle-right"></i>
                        </span>
                    </a>
                    <ul class="collapse" id="options-nav">
                        <li class="my-sub-link"><a href=""><i class="fa fa-check"></i> Check Lists </a></li>
                        <li class="my-sub-link"><a href=""><i class="fa fa-map"></i> Land Use </a></li>
                        <li class="my-sub-link"><a href=""><i class="fa fa-briefcase"></i> Application Category </a></li>
                    </ul>
                </li>
                <!--panel item-->
                <li class="panel ">
                    <a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle collapsed" data-target="#form-nav">
                        <i class="fa fa-users"></i>  System Users
                        <span class="pull-right">
                        <i class="fa fa-angle-right"></i>
                        </span>
                    </a>
                    <ul class="collapse" id="form-nav">
                        <li class="my-sub-link"><a href="addnew-user.php"><i class="fa fa-user-plus"></i> Add New User </a></li>
                        <li class="my-sub-link"><a href="manage_users.php"><i class="fa fa-user-secret"></i> Manage Users </a></li>
                        <li class="my-sub0-link"><a href="user-logs.php"><i class="fa fa-cog"></i> User Logs</a></li>
                    </ul>
                </li>

                <li class="panel">
                    <a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" data-target="#pagesr-nav">
                        <i class="fa fa-suitcase"></i> Applications
                        <span class="pull-right">
                        <i class="fa fa-angle-right"></i>
                        </span>
                    </a>
                    <ul class="collapse" id="pagesr-nav">
                        <li class="my-sub-link"><a href="new-application.php"><i class="fa fa-folder-open"></i> Add New Application </a></li>
                        <li class="my-sub-link"><a href="manage-applications.php"><i class="fa fa-shopping-cart"></i> Manage Applications </a></li>
                        <li class="my-sub-link"><a href=""><i class="fa fa-shopping-bag"></i> Review Applications </a></li>
                    </ul>
                </li>
                <li class="panel">
                    <a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" data-target="#chart-nav">
                        <i class="fa fa-briefcase"></i> Building Permits
                        <span class="pull-right">
                        <i class="fa fa-angle-right"></i>
                        </span>
                    </a>
                    <ul class="collapse" id="chart-nav">
                        <li><a href=""><i class="fa fa-thumbs-up"></i> Grant A Permit </a></li>
                        <li><a href=""><i class="fa fa-link"></i> Building Permits </a></li>
                    </ul>
                </li>
                <!--panel menu item-->
                <li class="panel">
                    <a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" data-target="#DDL-nav">
                        <i class="fa fa-sitemap"></i> Actions
                        <span class="pull-right">
                            <i class="fa fa-angle-right"></i>
                        </span>
                    </a>
                    <ul class="collapse" id="DDL-nav">
                        <li><a href="#"><i class="fa fa-angle-right"></i> Action Link 1 </a></li>
                        <li><a href="#"><i class="fa fa-angle-right"></i> Action Link 2 </a></li>
                        <li><a href="#"><i class="fa fa-angle-right"></i> Action Link 3 </a></li>
                        <li><a href="#"><i class="fa fa-angle-right"></i> Action Link 4 </a></li>
                    </ul>
                </li>
            
                <!--menu item -->
                <li><a href=""><i class="fa fa-bullseye"></i> Site Inspections </a></li>
                <!--menu item-->
                <li><a href=""><i class="fa fa-tasks"></i> Users Tasks </a></li>
                <!--menu item-->
                <li><a href=""><i class="fa fa-map-marker"></i> Maps </a></li>
                <!--menu item-->
                <li><a href=""><i class="fa fa-comments"></i> Chat Option </a></li>
                <!--menu item exit-->
                <li><a href=""><i class="fa fa-power-off"></i> Logout </a></li>

            </ul>

        </div>
        <!--END MENU SECTION -->

        <!--PAGE CONTENT -->
        <div id="content">
                     
            <div class="inner" style="min-height: 700px;">
                <div class="row">
                    <div class="col-lg-12">
                       <!--page title/section-->
                        <h5><span class="fa fa-home"></span> E-Permit <i class="fa fa-chevron-right"></i> Main Menu <i class="fa fa-chevron-right"></i> System Users <i class="fa fa-chevron-right"></i> Manage Users </h5>
                    </div>
                </div>
                  <hr />
                
            <div class="row">
                <div class="col-lg-12">
                    <div class="box">
                        <header>
                        <div class="icons"><i class="fa fa-th-large"></i>
                        </div>
                        <h5>LIST OF USERS</h5>
                        <div class="toolbar">
                        <ul class="nav">
                        <li>
                        <div class="btn-group">
                        <a class="accordion-toggle btn btn-xs minimize-box" data-toggle="collapse"
                        href="#collapseForm"></a>
                        </div>
                        </li>
                        </ul>
                        </div>
                        </header>
                        
                        <br>
    
<!--   begin table to display records-->
    <table class="table table-hover table-responsive" id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true" data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
    <tr>
       <th align="center">No.</th>
<!--       <th align="center">UserID</th>-->
        <th align="center">Full Name</th>
        <th align="center">Mobile No<br></th>
        <th align="center">Email ID<br></th>
        <th align="center">Department</th>
        <th align="center">Username</th>
        <th align="center">Password</th>
        <th align="center">User Type</th>
        <th align="center">Status</th>
<!--        <th align="center">Registration Date</th>-->
        <th align="center">Action</th>
    </tr>
        
    <?php 
    //get total logs activity
//$sql_logs = "SELECT users_account.userid, users_account.fullname, users_account.username, users_account.department_name, userlog.login, userlog.logout FROM users_account INNER JOIN userlog ON users_account.userid=userlog.userId ORDER BY userlog.login";
$sql_logs = "SELECT userid,fullname, mobileno, email, department_name, username, password, role, status, regdate from users_account ORDER BY fullname ASC";
$result1 = $connect_db->query($sql_logs);
$num=1;
if($result1->num_rows > 0){
    while($row = $result1->fetch_assoc())
    {
        $user_id = $row['userid'];
        $user_fname = $row['fullname'];
        $user_mobile = $row['mobileno'];
        $user_email = $row['email'];
        $user_dept = $row['department_name'];
        $user_uname = $row['username'];
        $user_pass = $row['password'];
        $user_role = $row['role'];
        $user_status = $row['status'];
        ?>
        <tr class="tdid <?php echo $user_id; ?>">
            <td class="tdno"><?php echo $num;?></td>
<!--            <td class="id"><?php //echo $user_id;?></td>-->
            <td class="tdname"><?php echo $user_fname;?></td>
            <td class="tdmobile"><?php echo $user_mobile;?></td>
            <td class="tdemail"><?php echo $user_email;?></td>
            <td class="tddept"><?php echo $user_dept;?></td>
            <td class="tdusername"><?php echo $user_uname;?></td>
            <td class="tdpassword"><?php echo $user_pass;?></td>
            <td class="tdrole"><?php echo $user_role;?></td>
            <td class="tdstatus"><?php echo $user_status;?></td>
<!--            <td class="regdate"><?php //echo $row['regdate'];?></td>-->
            <td>
            
            <!--   edit button-->
             <a id="editUser" class="tdEdit btn btn-info btn-xs btn-line" href='' data-toggle='modal' data-id="<?=$user_id; ?>" data-name="<?=$user_fname; ?>" data-mobile="<?=$user_mobile; ?>'" data-email="<?=$user_email; ?>" data-dept="'.$user_dept.'" data-username="'$.user_uname.'" data-pass="'.$user_pass.'" data-role="'.$user_role.'" data-status="'.user_status.'" data-target="#viewUser" data-href=''>Edit</a>
            <a id="DeleteUser" class="tdDelete btn btn-danger btn-xs btn-line" data-href="delete-user.php?id=<?php echo $row['userid'];?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>
            <!--trigger delete user button-->
            <button id="confirm" class="btn btn-danger btn-xs btn-line" type="button" data-toggle="modal" data-target="#confirm-delete" data-href="process.php?id=<?php echo $row['userid']; ?>"> Delete</button>

            </td>
        </tr>
        <?php $num=$num+1;
    }} ?>
        </table> <!-- end table-->
                    </div>
                </div>
            </div>

      <div class="row">
                <div class="col-lg-12">
                    <div class="box">
                        <header>
                        <div class="icons"><i class="fa fa-th-large"></i>
                        </div>
                        <h5>LIST OF SYSTEM ADMINS</h5>
                        <div class="toolbar">
                        <ul class="nav">
                        <li>
                        <div class="btn-group">
                        <a class="accordion-toggle btn btn-xs minimize-box" data-toggle="collapse"
                        href="#collapseForm"></a>
                        </div>
                        </li>
                        </ul>
                        </div>
                        </header>
                        
                    <br>
    
<!--   begin table to display records-->
    <table class="table table-hover table-responsive" id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true" data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
    <tr>
       <th align="center">No.</th>
<!--       <th align="center">ID</th>-->
        <th align="center">Full Name</th>
        <th align="center">Mobile No<br></th>
        <th align="center">Email ID<br></th>
        <th align="center">Username</th>
<!--        <th align="center">Password</th>-->
        <th align="center">Status</th>
        <th align="center">Registration Date</th>
        <th align="center">Action</th>
    </tr>
        
    <?php 
    //get admin user list
$sql_logs = "SELECT adminid,fullname, mobileno, email, username, password, status, regdate from admin_account ORDER BY fullname ASC";
$result1 = $connect_db->query($sql_logs);
$num=1;
if($result1->num_rows > 0){
    while($row = $result1->fetch_assoc())
    {
        $id = $row['adminid'];
        $fname = $row['fullname'];
        $mobile = $row['mobileno'];
        $email = $row['email'];
        $uname = $row['username'];
        $pass = $row['password'];
        $status = $row['status'];
        $regdate = $row['regdate'];
        ?>
        <tr class="tdid <?php echo $user_id; ?>">
            <td class="tdno"><?php echo $num;?></td>
<!--            <td class="id"><?php //echo $id;?></td>-->
            <td class="tdname"><?php echo $fname;?></td>
            <td class="tdmobile"><?php echo $mobile;?></td>
            <td class="tdemail"><?php echo $email;?></td>
            <td class="tdusername"><?php echo $uname;?></td>
<!--            <td class="tdpassword"><?php //echo $pass;?></td>-->
            <td class="tdstatus"><?php echo $status;?></td>
            <td class="regdate"><?php echo $regdate;?></td>
            <td>
            
            <!--   edit button-->
            <a id="lockUser" class="tdDelete btn btn-info btn-xs btn-line" data-href="delete-user.php?id=<?php echo $row['userid'];?>" data-toggle="modal" data-target="#confirm-delete">Lock</a>
            <!--trigger delete user button-->
            <button id="confirm" class="btn btn-danger btn-xs btn-line" type="button" data-toggle="modal" data-target="#confirm-delete" data-href="process.php?id=<?php echo $row['userid']; ?>"> Delete</button>

            </td>
        </tr>
        <?php $num=$num+1;
    }} ?>
        </table> <!-- end table-->
                    </div>
                </div>
            </div>

    <div class="form-actions no-margin-bottom" style="text-align:center;">
            <a class="btn btn-warning" type="reset" href="dashboard.php" style="margin-right: 25px; margin-bottom:25px">Main Menu</a>
            </div>
            
            
<!--
            <script>
                //detect table row button clicked
                $('#editUser').click(function(){
                var $trow = $(this).closest('tr');
                var rowID = $trow.attr('class');
                //   var rowID = $trow.attr('class').split('_')[1];

                //find values of fields
                var name = $trow.find('tdname').val();
                var mobile = $trow.find('tdmobile').val();
                var email = $trow.find('tdemail').val();
                var dept = $trow.find('tddept').val();
                var username = $trow.find('tdusername').val();
                var pwd = $trow.find('tdpassword').val();
                var status = $trow.find('tdstatus').val();

                //pass values to modal
                $('#fullname').val(name);
                $('#mobile').text(mobile);
                $('#email').text(email);
                $('#dept').text(dept);
                $('#uname').text(username);
                $('#upass').text(pwd);
                $('#status').text(status);
                $('#viewUser').modal('show');
        
    });    
            </script>
-->
<!-- preview user record modal-->
    <div class="col-lg-12">
        <div class="modal fade" id="viewUser" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="H1">Update User </h4>
                                        </div>
                                        <div class="modal-body">
                                            <form role="form">
                                        <div class="form-group">
                                            <label>Fullname</label>
                                            <input class="form-control" name="name" id="fullname" />
                                        </div>
                                        <div class="form-group">
                                            <label>Mobile No.</label>
                                            <input id="mobile" name="mobile" class="form-control mobile" />
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input name="email" id="email" class="form-control email"/>
                                        </div>
                                        <div class="form-group">
                                            <label>Department</label>
                                            <input name="dept" id="dept" class="form-control dept" />
                                        </div>
                                        <div class="form-group">
                                            <label>Username</label>
                                            <input name="uname" id="uname" class="form-control username" readonly=""/>
                                        </div>
                                       <div class="form-group">
                                            <label>Password</label>
                                            <input name="upass" id="upass" class="form-control pass" readonly=""/>
                                        </div>
<!--
                                        <div class="form-group">
                                            <label>Retype Password</label>
                                            <input class="form-control" />
                                            <p class="help-block">Example block-level help text here.</p>
                                        </div>
-->
                                         <button type="button" class="btn btn-primary">Save changes</button>

                                    </form>
                                        </div>
                                        
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                </div>
    </div>
             
<!--  delete-modal       -->
    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" arial-hidden="true">
                      <div class="modal-dialog">
                          <div class="modal-content">
                              <div class="modal-header">
                               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                  <h4>Delete User</h4>
                              </div>
                                <div class="modal-body">
                                    <p>The selected user with name: <?php echo $row['fullname']; ?> will be deleted?</p>
                                </div>  
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <a href="" class="btn btn-danger btn-ok">Delete</a>
                                </div> 
                            </div>
                      </div>  
                       
                </div>
                    
</div><!--END PAGE CONTENT -->
        
    </div>
</div>    <!--END MAIN WRAPPER -->

<!-- FOOTER -->
    <div id="footer">
        <p>&copy; E-Permit 2020. &nbsp;Developed by <a class="app-developer" style="" href="">Jecmas </a>&nbsp;</p>
    </div>
    <!--END FOOTER -->
    
<!--  PAGE LEVEL SCRIPT-->
    <script>
        var preloder = document.getElementById('loader');
        function displayLoader(){
            preloader.style.display = 'none';
        }
        setTimeout(function(){
            $('.loading').fadeToggle();
        }, 1500);
    </script>
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
    
    //show user record in modal
    $('#viewUser').on('show.bs.modal', function(event){
        var user = $(event.relatedTarget);
        var id = user.data('id');
        var fullname = user.data('name');
        var mobile = user.data('mobile');
        var email = user.data('email');
        var dept = user.data('dept');
        var username = user.data('username');
        var password = user.data('pass');
        var role = user.data('role');
        var status = user.data('status');
        
        var modal =$(this);
//        modal.find('#fullname').val(fullname);
        modal.find('#fullname').text(fullname);
        modal.find('#mobile').val(mobile);
        modal.find('#email').val(email);
        modal.find('#dept').val(dept);
        modal.find('#uname').val(username);
        modal.find('#upass').val(password);
        modal.find('#role').val(role);
        modal.find('#status').val(status);
//        modal.find('#editUser').attr('src', 'update-user.php?id='+userid);
    })
    
//    script to delete user
    $('#confirm-delete').on('show.bs.modal', function(e)){
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href')); 
            }
});
</script>

    </body>
</html>
