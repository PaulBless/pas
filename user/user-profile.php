<?php
//start session.
session_start();

// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: ../index.php');
	exit;
}

//include database connection
include '../functions/db_connection.php';

require_once '../functions/db_connection.php';
## get system settings
$sql = "select `dist_name`,`dist_town` from settings";
$qry = mysqli_query($connect_db, $sql);
$fetch = mysqli_fetch_assoc($qry);
$district = $fetch['dist_name'];
$town = $fetch['dist_town'];


// We don't have the password or email info stored in sessions so instead we can get the results from the database.
  $stmt = $connect_db->prepare('SELECT fullname, mobileno, email, department_name, password, email, role, status, regdate FROM users_account WHERE userid = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($fullname,$mobile,$email,$department,$password, $email,$usertype,$status,$regdate);
$stmt->fetch();
$stmt->close();  
?>

<?php include('../includes/header.php'); ?>
 <!-- MAIN WRAPPER -->
    <div id="wrap" >
        
        <!--preloader element-->
       <div class="preloader"></div>
       
        <!-- HEADER SECTION -->
        <div id="top">
            <nav class="navbar navbar-inverse navbar-fixed-top " style="padding-top: 10px;">
                <a data-original-title="Show/Hide Menu" data-placement="bottom" data-tooltip="tooltip" class="accordion-toggle btn btn-primary btn-sm visible-xs" data-toggle="collapse" href="#menu" id="menu-toggle">
                    <i class="fa fa-bars"></i>
                </a>
                <!-- LOGO SECTION -->
                <header class="navbar-header">
                <!--app name/title-->
<!--                <img src="../assets/images/logo.jpg" width="25" height="25">-->
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
                            <i id="icon" class="fa fa-user "></i>&nbsp;Welcome, 
                            <?=$_SESSION['name']?>
                            <i id="icon" class="fa fa-chevron-down"></i>
                        </a>

                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="user-profile.php"><i class="fa fa-user-circle"></i> My Profile </a>
                            </li>
                            <li><a href=""><i class="fa fa-tags"></i> My Tasks </a>
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
                    <h5 class="media-heading"><i class="fa fa-user"></i> Login As: <?=$_SESSION['role']?></h5>
                    <ul class="list-unstyled user-info">
                        <li><a class="btn btn-success btn-xs btn-circle" style="width: 10px;height: 12px;"></a> Online  
                        </li>
                    </ul>
                </div>
                <br />
            </div>
            
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
                <li><a href="building-permits.php"><i class="fa fa-star"></i> Permits Granted </a></li>
               
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
                        <h5><span class="fa fa-home"></span> E-Permit <i class="fa fa-chevron-right"></i> User Dashboard <i class="fa fa-chevron-right"></i> My Profile <i class="fa fa-chevron-right"></i> Profile Information </h5>
                    </div>
                </div>
                  <hr />
                  
                 <!--HOME SECTION -->
                 <div class="row">
                     <div class="col-lg-12">
                        <div class="box">
                            <header>
                                <div class="icons"><i class="fa fa-th-large"></i>
                                </div>
                                <h5>MY PROFILE</h5>
                                <div class="toolbar">
                                <ul class="nav">
                                <li>
                                </li>
                                </ul>
                                </div>
                            </header>                 
                        <!--  personal info-->
                        <div class="panel panel-default">
                        <div class="panel-heading">
                            Personal Information
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Heading or Title</th>
                                            <th>Value Data</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <!--item data fullname-->
                                       <tr>
                                            <td>Fullname: </td>
                                            <td><?=$fullname?></td>
                                        </tr>
                                         <!--item data mobileno-->
                                       <tr>
                                            <td>Mobile Number: </td>
                                            <td><?=$mobile?></td>
                                        </tr>
                                         <!--item data email-->
                                       <tr>
                                            <td>Email ID: </td>
                                            <td><?=$email?></td>
                                        </tr>
                                         <!--item data department-->
                                       <tr>
                                            <td>Department: </td>
                                            <td><?=$department?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>     
                        <!--account table-->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                            Account Information
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Heading or Title</th>
                                            <th>Value Data</th>
                                        </tr>
                                    </thead>
                                   <tbody>
                                       <tr>
                                            <td>Username: </td>
                                            <td><?=$_SESSION['name']?></td>
                                        </tr>
                                        <tr>
                                            <td>Password:</td>
                                            <td><?=$password ?></td>
                                        </tr>
                                         <!--item data usertype-->
                                       <tr>
                                            <td>Account Type: </td>
                                            <td><?=$usertype?></td>
                                        </tr>
                                        <tr>
                                            <td>Status:</td>
                                            <td><?=$status?></td>
                                        </tr>
                                         <!--item data registration date-->
                                       <tr>
                                            <td>Registration Date: </td>
                                            <td><?=$regdate?></td>
                                        </tr>
                                   </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                         </div>
                    </div>
                </div>   
                
            </div>

        </div>
        <!--END PAGE CONTENT -->


        </div>
         <!-- END RIGHT STRIP  SECTION -->

    <!--END MAIN WRAPPER -->

<?php include('../includes/footer.php'); ?>


