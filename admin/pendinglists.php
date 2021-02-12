<?php
session_start();
error_reporting(0);

require_once '../functions/db_connection.php';

## get system settings
$sql = "select `dist_name`,`dist_town` from settings";
$qry = mysqli_query($connect_db, $sql);
$fetch = mysqli_fetch_assoc($qry);
$district = $fetch['dist_name'];
$town = $fetch['dist_town'];



if(!isset($_SESSION['loggedin'])){
    header('Location: ./index.php');
    exit;
}


?>


     
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
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
    <link rel="icon" href="../assets/images/logo.jpg"logo.jpg" type="image/jpg">  
      
    <!-- GLOBAL STYLES -->
    <link rel="stylesheet" href="../admin/assets/plugins/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="../admin/assets/css/main.css" />
    <link rel="stylesheet" href="../admin/assets/css/theme.css" />
    <link rel="stylesheet" href="../admin/assets/css/MoneAdmin.css" />
    <link rel="stylesheet" href="../assets/font-awesome/css/fontawesome-all.css" />
        <link rel="stylesheet" href="../admin/assets/plugins/Font-Awesome/css/font-awesome.css" />
    <!--END GLOBAL STYLES -->

     
      <!--page level styles-->
    <link rel="stylesheet" href="../third-party/dist/css/bootstrapValidator.css">
     <link rel="stylesheet" href="../third-party/dist/css/bootstrapValidator.css">
     <link href="../admin/assets/css/bootstrap-fileupload.min.css" rel="stylesheet" />
    <!-- custom datatable style-->
    <!--    <link rel="stylesheet" href="../assets/css/datatables.min.css">-->
    
    <link href="../admin/assets/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet" />

    <!--scripts-->
    <!--jquery 1.0 library-->
    <script type="text/javascript" src="../third-party/vendor/jquery/jquery-1.10.2.min.js"></script>
    
      <!--jquery3.3.1 library-->
    <!--    <script type="text/javascript" src="../assets/js/jquery-3.3.1.min.js"></script>-->
        <!--datatable js-->
    <!--    <script type="text/javascript" src="../assets/js/datatables.min.js"></script>-->
    <!--    -->
    <script type="text/javascript" src="../third-party/vendor/bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="../third-party/dist/js/bootstrapValidator.js"></script>
  <script type="text/javascript">
		function pageLoading(){
			$('.loading').show();
			setTimeout(function(){
				$('.loading').hide();
			}, 500);
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
        /*   background-color: #33b35a;*/
        /*   color: white;*/
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
		.spinning{
            opacity:0.5;
            background:#ccc url(../assets/images/spin.gif) no-repeat center;
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
<body class="padTop53 " onload="pageLoading()" >
<div class="spinning"></div>
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
                <li class="panel active">
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
                        <li class="my-sub-link"><a href="permits.php"><i class="fa fa-arrow-right"></i> Permits Granted </a></li>
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
                        <h5><span class="fa fa-home"></span> E-Permit <i class="fa fa-chevron-right"></i> Main Menu <i class="fa fa-chevron-right"></i> Pending Applications</h5>
                    </div>
                </div>
                  <hr />
                  
                 <!--HOME SECTION -->
        <div class="row">
        <div class="col-lg-12">
            <div class="box">
            <header><div class="icons"><i class="fa fa-briefcase"></i></div>
            <h5>LIST OF PENDING APPLICATIONS</h5></header>
                        
            <div class="panel panel-default">
<!--             <div class="panel-heading"></div>-->
            
            <div class="panel-body">
                <div class="data-table-area mg-tb-15">
                    <div class="sparkline13-graph">
                        <div class="datatable-dashv1-list custom-datatable-overright">
                            <div id="toolbar" style="margin-right: 15px;">
<!--
                                <select class="form-control">
                                    <option value="">Export Basic</option>
                                    <option value="all">Export All</option>
                                    <option value="selected">Export Selected</option>
                                </select>
-->
                            <br><br>
                            </div>
                    <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="" data-show-pagination-switch="" data-show-refresh="" data-key-events="" data-show-toggle="" data-resizable="" data-cookie="true" data-cookie-id-table="saveId" data-show-export="" data-click-to-select="" data-toolbar="#toolbar" class="table table-striped table-bordered table-hover">
                    <!--table head-->
                        <thead class="text-warning" style="background: #000">
                            <tr>
                            <th>No.</th>
                            <!-- <th data-field="id">ID</th>-->
                            <th data-field="appid">App. Number</th>
                            <th data-field="fullname">Applicant Name</th>
<!--                            <th data-field="mobile">Mobile No</th>-->
                            <th data-field="project">Project Development Name</th>
                            <th data-field="status">Status</th>
                            <th data-field="reason">Pending Reason</th>
                            <th data-field="action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
            <?php
                ## will add 'status' in sql later to filter results
                ## query by status=
                // $sql=mysqli_query($connect_db,"SELECT * from `applications` ORDER BY `status` ASC, `name` ASC");
                $query =mysqli_query($connect_db, "SELECT applicationid,name,phoneno,project_type,application_no,status,reason FROM `applications` INNER JOIN `holding` ON `applications`.`applicationid`=`holding`.`appID` WHERE `status`='Pending'");
                $cnt=1;
                while($last=mysqli_fetch_array($query)){

            ?>
                    <tr>
                    <td><?php echo $cnt; ?></td>
                    <!-- <td><?php //echo $last['applicationid'] ?></td>-->
                    <td><?php echo $last['application_no']; ?></td>
                    <td><?php echo $last['name']; ?></td>
<!--                    <td><?php //echo $last['phoneno']; ?></td>-->
                    <td><?php echo $last['project_type']; ?></td>
                    <td><?php echo ($last['status']); ?></td>
                    <td><?php echo ($last['reason']); ?></td>
                    <td class="datatable-ct">
                    <!--reactivate button link-->
                    <a class="btn btn-info btn-sm " style="font-weight: bold" href="activate.php?applicationId=<?php echo htmlentities($last['applicationid']);?>" onclick="return confirm('Are you sure you want to re-activate the selected application with Application No: <?php  echo htmlentities($last['application_no']); ?> ? Press OK to continue')"> <span class="fa fa-retweet"></span> Validate</a>
                   <?php //include('modals.php'); ?>
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
            </div>
 
        
        </div> <!--end inner wrapper-->
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
     <script src="../admin/assets/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="../admin/assets/plugins/dataTables/dataTables.bootstrap.js"></script>
    
    <!-- data table JS
    ============================================ -->
    <script src="../assets/datatable/js/bootstrap-table.js"></script>
    <script src="../assets/datatable/js/data-table/tableExport.js"></script>
    <script src="../assets/datatable/js/data-table/data-table-active.js"></script>
    <script src="../assets/datatable/js/data-table/bootstrap-table-editable.js"></script>
    <script src="../assets/datatable/js/data-table/bootstrap-editable.js"></script>
    <script src="../assets/datatable/js/data-table/bootstrap-table-resizable.js"></script>
    <script src="../assets/datatable/js/data-table/colResizable-1.5.source.js"></script>
    <script src="../assets/datatable/js/data-table/bootstrap-table-export.js"></script>
   <!-- validation scripts-->

    
   
    <script type="text/javascript">
    $(document).ready(function() {
   
        // Validate the form manually
        $('#validateBtn').click(function() {
            $('#defaultForm').bootstrapValidator('validate');
        });

        $('#resetBtn').click(function() {
            $('#defaultForm').data('bootstrapValidator').resetForm(true);
        });
    });

        //make spining on button click
        $('.processBtn').click(function(){
            var spinme = document.getElementsByClassName('spinning');
           function showSpin(){            
            spinme.style.display = 'none';
           }
            setTimeout(function(){
                $('.spinning').fadeToggle();
            }, 500);
        });
        
    </script>

  
   <script>
      $('.processBtn').on('click',function(){
          $('.spinning').show();
          
          setTimeout(function(){
              $('spinning').hide();
          }, 500);
      });
             
       
       $(function(){
           
       });
    </script>
   
   
 
    </body>
</html>




