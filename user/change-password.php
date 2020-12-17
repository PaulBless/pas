<?php

?>


<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="UTF-8" />
    <title>E-Permit System | Add new user </title>
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
    <script type="text/javascript" src="../third-party/dist/js/bootstrapValidator.js"></script>
    <script type="text/javascript" src="../third-party/dist/js/bootstrapValidator.js"></script>
    
    <!--stylesheet-->
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
                    <a href="" >
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
                        <li class=""><a href=""><i class="fa fa-map-marker-alt"></i> Locations </a></li>
                        <li class=""><a href=""><i class="fa fa-donate"></i> Payments </a></li>
                        <li class=""><a href=""><i class="fa fa-boxes"></i> Application Category </a></li>
                        <li class=""><a href=""><i class="fa fa-people-carry"></i> Designation</a></li>
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
                        <li class=""><a href=""><i class="fa fa-check"></i> Check Lists </a></li>
                        <li class=""><a href=""><i class="fa fa-map"></i> Land Use </a></li>
                        <li class=""><a href=""><i class="fa fa-briefcase"></i> Application Category </a></li>
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
                        <li class=""><a href=""><i class="fa fa-user-plus"></i> Add New User </a></li>
                        <li class=""><a href=""><i class="fa fa-user-secret"></i> Manage Users </a></li>
                        <li class=""><a href=""><i class="fa fa-cog"></i> User Logs</a></li>
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
                        <li><a href=""><i class="fa fa-folder-open"></i> Submit New Application </a></li>
                        <li><a href=""><i class="fa fa-shopping-cart"></i> Manage Applications </a></li>
                        <li><a href=""><i class="fa fa-shopping-bag"></i> Review Applications </a></li>
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
                <li><a href="#"><i class="fa fa-power-off"></i> Exit Application </a></li>

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
                        <div class="icons"><i class="fa fa-th-large"></i>
                        </div>
                        <h5>ADD NEW USER</h5>
                        <div class="toolbar">
                        <ul class="nav">
                        <li>
                        <div class="btn-group">
                        <a class="accordion-toggle btn btn-xs minimize-box" data-toggle="collapse"
                        href="#collapseForm"><i class="fa fa-chevron-up"></i></a>
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
                                <option value="">-Select-</option>
                                <option value="Physical Planning">Physical Planning</option>
                                <option value="Works">Works</option>
                                <option value="Account">Account</option>
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
                                <option value="">-Select-</option>
                                <option value="Engineer">Engineer</option>
                                <option value="Inspector">Inspector</option>
                                <option value="Officer">Officer</option>
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
                        <input type="submit" name="btnRegister" value="Register" class="btn btn-success" style="margin-right: 25px">
                        <a class="btn btn-danger" type="reset" href="dashboard.php" style="margin-left: 25px">Cancel</a>
                        </div>
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
    