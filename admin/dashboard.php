
 
<?php
session_start();

include '../functions/db_connection.php';
//invoke controller classes
require_once '../functions/databaseController.php';
require_once '../functions/Applications.php';
require_once '../functions/Users.php';
require_once '../functions/Admin.php';

//instance of db controller class
$db_handle = new databaseController();

## get system settings
$sql = "select `dist_name`,`dist_town` from settings";
$qry = mysqli_query($connect_db, $sql);
$fetch = mysqli_fetch_assoc($qry);
$district = $fetch['dist_name'];
$town = $fetch['dist_town'];


// If the user is not logged in, redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}

if(isset($_SESSION['ufullname'])){
	
}
//get user action type
$action = "";
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}


//global variables
$total_admin = "";
$total_users = "";                 
$total_applications = "";        
$total_permit = "";
$total_members = "";
$total_defer = "";
$total_pending = "";
$total_approved = "";

//run code below to get last total users, total applications,
//and total permits from db
//$sql_admin = "select count(*) as totadmin from admin_account where status='Active'";
$sql_admin = "select count(*) as totadmin from admin_account";
//$sql_users = "select count(*) as totusers from users_account where status='Active'";
$sql_users = "select count(*) as totusers from users_account";
$sql_total_applications = "select count(*) as totapplications from applications";
$sql_total_permits = "select count(*) as totpermits from permits";
$sql_total_defer = "select count(*) as totdefer from applications where status='Deferred'";
$sql_total_pending = "select count(*) as totpending from applications where status='Pending'";
$sql_total_approved = "select count(*) as totapproved from applications where status='Approved'";


//get total Admins
$result = $connect_db->query($sql_admin);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $total_admin = $row["totadmin"];  
//        echo $total_admin;
    }
}else{
    //no record found in db
    $total_admin = "0";
}
//get total Users
$result1 = $connect_db->query($sql_users);
if($result1->num_rows > 0){
    while($row = $result1->fetch_assoc()){
        $total_users = $row["totusers"];
//        echo $total_users;
    }
}else{
    $total_users = "0";
}

//get total applications
$result_application = $connect_db->query($sql_total_applications);
if($result_application->num_rows > 0){
    while($row = $result_application->fetch_assoc()){
        $total_applications = $row["totapplications"];
    }
}else{
    $total_applications = "0";
}

//get total permits granted
$result_permit = $connect_db->query($sql_total_permits);
if($result_permit->num_rows > 0){
    while($row = $result_permit->fetch_assoc()){
        $total_permit = $row["totpermits"];
    }
}else{
    $total_permit = "0";
}

//get total deferred applications
$result_defer = $connect_db->query($sql_total_defer);
if($result_defer->num_rows > 0){
    while($row = $result_defer->fetch_assoc()){
        $total_defer = $row["totdefer"];
    }
}else{
    $total_defer = "0";
}

//get total review list
$result_pending = $connect_db->query($sql_total_pending);
if($result_pending->num_rows > 0){
    while($row = $result_pending->fetch_assoc()){
        $total_pending = $row["totpending"];
    }
}else{
    $total_pending = "0";
}

//get total approved list
$result_approved = $connect_db->query($sql_total_approved);
if($result_approved->num_rows > 0){
    while($row = $result_approved->fetch_assoc()){
        $total_approved = $row["totapproved"];
    }
}else{
    $total_approved = "0";
}


?>


 <?php include('../includes/header.php'); ?>
    
<!--    <link href="../assets/datatable/css/bootstrap-table.css" rel="stylesheet" />-->

<style>
    /* custom styling to sub-menus*/
    .panel .my-sub-link:hover{
    /*   background-color: #33b35a;*/
    /*   color: white;*/
        background: #343a40;
        transition: transform .3s ease, -webkit-transform .3s ease, -moz-transform .3s ease, -o-transform .3s ease;
    }
</style>
    
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
                        <li class="my-sub-link"><a href="permits.php"><i class="fa fa-arrow-right"></i> Permits Granted </a></li>
                    </ul>
                </li>
                <!--panel menu item-->
                <li><a href="committee-decisions.php"><i class="fa fa-bookmark"></i> Committee Decisions </a></li>
                <li><a href="site-inspections.php"><i class="fa fa-eye"></i> Site Inspections </a></li>
                <!--Task & Chat Menu items - Hide-->
<!--
                <li><a href="tasks.php"><i class="fa fa-tasks"></i> Users Tasks </a></li>
                <li><a href="chat.php"><i class="fa fa-comments"></i> Chat Option </a></li>
-->
				<!-- end this item-->
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
                <li><a href="logout.php" id="logout"><i class="fa fa-power-off"></i> Logout </a></li>

            </ul>

        </div>
        <!--END MENU SECTION -->

       
        <!--PAGE CONTENT -->
        <div id="content">
            <div class="inner" style="min-height: 700px;">
                <div class="row">
                    <div class="col-lg-12">
                       <!--page title/section-->
                        <h5 class=""><span class="fa fa-home"></span> E-Permit <i class="fa fa-chevron-right"></i> Admin Dashboard </h5>
                    </div>
                </div>
                  <hr />
                  <?php 
				 ## get loggedin date-time
                $last_login_date = "";
                if(isset($_SESSION['login_date_time']))
                $last_login_date = $_SESSION['login_date_time'];
                echo $last_login_date;
				?>
                  
                 <!--BLOCK SECTION -->
                 <div class="row">
                    <div class="col-lg-12">


                   <!--system users-->
                    <div class="col-lg-4 col-sm-6 col-xs-12 main-widget">
                        <div class="main-box infographic-box">
                            <i class="fa fa-users red-bg"></i>
                            <span class="headline"><strong>System Users</strong></span>
                            <span class="value"><?php echo $total_users + $total_admin; ?></span>
                             <span class="subtitle">(total system users)</span>
                        </div>
                    </div>
                    <!--total applications received-->
                    <div class="col-lg-4 col-sm-6 col-xs-12 main-widget">
                        <div class="main-box infographic-box">
                            <i class="fa fa-briefcase emerald-bg"></i>
                            <span class="headline"><strong>Total Applications</strong></span>
                            <span class="value"><?php echo $total_applications ?></span>
                             <span class="subtitle">(total applications lists)</span>
                        </div>
                    </div>
                    <!--permits granted -->
                    <div class="col-lg-4 col-sm-6 col-xs-12 main-widget">
                        <div class="main-box infographic-box">
                            <i class="fa fa-handshake green-bg"></i>
                            <span class="headline"><strong>Permits Granted</strong></span>
                            <span class="value"><?php echo $total_permit ?></span>
                             <span class="subtitle">(total granted permits)</span>
                        </div>
                    </div>
                    <!-- approved list -->
                    <div class="col-lg-4 col-sm-6 col-xs-12 main-widget">
                        <div class="main-box infographic-box">
                            <i class="fa fa-check green-bg"></i>
                            <span class="headline"><strong>Approved Lists</strong></span>
                            <span class="value"><?php echo $total_approved ?></span>
                             <span class="subtitle">(applications approved by committee)</span>
                        </div>
                    </div>
                    <!--total deferred applications-->
                    <div class="col-lg-4 col-sm-6 col-xs-12 main-widget">
                        <div class="main-box infographic-box">
                            <i class="fa fa-times red-bg"></i>
                            <span class="headline"><strong>Deferred Lists</strong></span>
                            <span class="value"><?php echo $total_defer ?></span>
                             <span class="subtitle">(applications rejected by committee)</span>
                        </div>
                    </div>
                    <!--total pending applications-->
                     <div class="col-lg-4 col-sm-6 col-xs-12 main-widget">
                        <div class="main-box infographic-box">
                            <i class="fa fa-bolt dark-bg"></i>
                            <span class="headline"><strong>Pending Lists </strong></span>
                            <span class="value"><?php echo $total_pending ?></span>
                            <span class="subtitle">(applications waiting validation)</span>
                        </div>
                    </div>
                    </div>
                </div>
                 <!--end row top items-->          
                 
                  <!--END BLOCK SECTION -->
                <hr />
                   <!-- CHART TRAFFIC SECTION -->
                 <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Real Time Traffic
                            </div>                   
                            <div class="demo-container">
                                <div id="placeholderRT" class="demo-placeholder"></div>
                            </div>
                        </div>
                    </div>

                </div>
                 <!--END CHAT & CHAT SECTION -->
                 
                

            </div>

        </div>
        <!--END PAGE CONTENT -->

         <!-- RIGHT STRIP  SECTION -->
        <div id="right">
            <div class="well well-small">
                <ul class="list-unstyled">
                    <li class="text-primary">System Users: <span class="text-warning" style="font-weight:bold"><?php echo $total_members = $total_admin + $total_users ?></span></li>
                    <li class="text-primary">Applications: <span class="text-warning" style="font-weight:bold"><?php echo $total_applications ?></span></li>
                    <li class="text-primary">Permits Granted: <span class="text-warning" style="font-weight:bold"><?php print $total_permit ?></span></li>
                </ul>
            </div>
            <!--well column-->
                <!--
                            <div class="well well-small">
                                <button class="btn btn-block"> Help Content: How To </button>
                                <button class="btn btn-primary btn-block" > Tickets</button>
                                <button class="btn btn-info btn-block"> New </button>
                                <button class="btn btn-success btn-block"> Users </button>
                                <button class="btn btn-danger btn-block"> Profit </button>
                                <button class="btn btn-warning btn-block"> Sales </button>
                                <button class="btn btn-inverse btn-block"> Stock </button>
                            </div>
                -->
           
            <!--column colapsable:facts-->
            <div class="panel panel-primary">
                 <div class="panel-heading ">
                             E-Permit: What To Know 
                            </div>
                   	<div class="panel-body">
                        <div class="panel-group" id="accordion">
                             <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">#1: Check Lists</a>
                                            </h4>
                                        </div>
                                        <div id="collapseOne" class="panel-collapse collapse in">
                                            <div class="panel-body">
                                                This is where you can add different check list items to the application (eg Block Plan, Indenture) as a requisite for applicants when submitting building permit application.
                                            </div>
                                        </div>
                                    </div>
                             <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">#2: System Users</a>
                                            </h4>
                                        </div>
                                        <div id="collapseTwo" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                This section is where you create members or users of the E-Permit application. After you create a user, the user can access the system with his/her login credentials.
                                            </div>
                                        </div>
                                    </div>
                             <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">#3: Locations</a>
                                            </h4>
                                        </div>
                                        <div id="collapseThree" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                This section is where you specify and add the various communities or towns within the district, (as site locations).
                                            </div>
                                        </div>
                                    </div>
                              <!--accordion item-->
                             <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">#4: Chat Option</a>
                                            </h4>
                                        </div>
                                        <div id="collapseFour" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                This section or option is included for members or system users to chat or share information (instant messaging).
                                            </div>
                                        </div>
                                    </div>
                              <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseFive">#5: Grant Permit</a>
                                            </h4>
                                        </div>
                                        <div id="collapseFive" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                This option is for you to grant building development permits for applications after processed and validated.
                                            </div>
                                        </div>
                                    </div>
                        </div>
                    </div>
            </div>
        </div>
         <!-- END RIGHT STRIP  SECTION -->
    </div>

    <!--END MAIN WRAPPER -->

<?php include('../includes/footer.php'); ?>


 <!-- data table JS
    ============================================ -->
<!--
    <script src="../assets/datatable/js/bootstrap-table.js"></script>
    <script src="../assets/datatablejs/data-table/tableExport.js"></script>
    <script src="../assets/datatablejs/data-table/data-table-active.js"></script>
    <script src="../assets/datatablejs/data-table/bootstrap-table-editable.js"></script>
    <script src="../assets/datatablejs/data-table/bootstrap-editable.js"></script>
    <script src="../assets/datatablejs/data-table/bootstrap-table-resizable.js"></script>
    <script src="../assets/datatablejs/data-table/colResizable-1.5.source.js"></script>
    <script src="../assets/datatablejs/data-table/bootstrap-table-export.js"></script>
-->
