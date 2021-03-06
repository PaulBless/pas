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


//check user loggedin
if(!isset($_SESSION['loggedin'])){
    header('Location: ./index.php');
    exit;
}

//add new record
if(isset($_POST['btnAdd'])){
    $landuse = trim(htmlspecialchars($_POST['landuse']));
    $comment = trim(htmlspecialchars($_POST['comment']));

    //preparing the SQL statement will prevent SQL injection.
    if ($stmt = $connect_db->prepare('SELECT land_use FROM landuse WHERE land_use = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), 
    //in our case the username is a string so we use "s"
	$stmt->bind_param('s', $land_name);
	$stmt->execute();
	$stmt->store_result(); //get & store the result, to check if exists.
    if ($stmt->num_rows > 0) {
	$stmt->bind_result($locname);
	$stmt->fetch(); 
    //record exists, display error   
    echo "<div class='alert alert-danger bounceUp col-lg-6 col-md-offset-3' style='top: 10px; transition: transform .3s ease, -webkit-transform .3s ease, -moz-transform .3s ease, -o-transform .3s ease'>"
        . "<a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a>"
        . "<strong><span class='fa fa-info fa-2x'></span> </strong>" 
        . "<strong>&nbsp;&nbsp;The record '$landuse' is already added!</strong>."
        . "</div>";
        
    }else{
    //save new record 
   if ($stmt = $connect_db->prepare('INSERT INTO landuse (land_use, comment) VALUES (?, ?)')){
	$stmt->bind_param('ss', $landuse, $comment);
	$stmt->execute();
      
    echo "<div class='alert alert-success fadeIn col-lg-6 col-md-offset-3' style='top: 10px; transition: all 0.3s ease-in-out 0s'>"
        . "<a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a>"
        . "<strong><span class='fa fa-info fa-2x'></span> </strong>" 
        . "<strong>&nbsp;&nbsp;Record saved successfully!</strong>."
        . "</div>";
        header('location: landuse.php');
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
    <link rel="icon" href="../assets/images/logo.jpg"logo.jpg" type="image/jpg">  
      
    <!-- GLOBAL STYLES -->
    <link rel="stylesheet" href="../admin/assets/plugins/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="../admin/assets/css/main.css" />
    <link rel="stylesheet" href="../admin/assets/css/theme.css" />
    <link rel="stylesheet" href="../admin/assets/css/MoneAdmin.css" />
    <link rel="stylesheet" href="../assets/font-awesome/css/fontawesome-all.css" />
    <link rel="stylesheet" href="../admin/assets/plugins/Font-Awesome/css/font-awesome.css" />
    <!--END GLOBAL STYLES -->

     
    <!--  page level styles-->
    <link href="../admin/assets/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet" />

    <script type="text/javascript" src="../third-party/vendor/jquery/jquery-1.10.2.min.js"></script>
    <!-- bootstrap js plugin -->
    <script type="text/javascript" src="../third-party/vendor/bootstrap/js/bootstrap.js"></script>
        
    <!--jquery -->
    <script type="text/javascript" src="../assets/js/jquery-3.3.1.min.js"></script>
    <!-- jquery datatable scripts -->
    <!--<link rel="stylesheet" href="../assets/export/jquery.dataTables.min.css">-->
    <script type="text/javascript" src="../assets/export/jquery.dataTables.min.js"></script>
    <!-- end -->
        
    <!-- dataTables export buttons scripts-->
    <link rel="stylesheet"  href="../assets/export/buttons.dataTables.min.css">    
    <script src="../assets/export/dataTables.buttons.min.js" type="text/javascript"></script> 
    <script src="../assets/export/jszip.min.js" type="text/javascript"></script> 
    <script src="../assets/export/pdfmake.min.js" type="text/javascript"></script> 
    <script src="../assets/export/vfs_fonts.js" type="text/javascript"></script> 
    <script src="../assets/export/buttons.html5.min.js" type="text/javascript"></script> 
    
    <!-- function to show loader on pageloading-->
	<script type="text/javascript">
		function pageLoading(){
			$('.loading').show();
			setTimeout(function(){
				$('.loading').hide();
			}, 1500);
		}
	</script>
    
    <!--end function here-->
    <script>
        $(document).ready(function () {
            var table = $('#table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                     'excel', 'pdf'
                ]
            });

        });
    </script>

    <!--  end  -->
  
  
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
		.spinner{
			opacity: 1.0;
			background: #ccc url(../assets/images/spin.gif) no-repeat center;
			position: fixed;
			width: 100%;
			height: 100%;
			top: 0px;
			left: 0px;
			z-index: 2000;
			display: none;
		}
    </style>
</head>    <!-- END HEAD -->

   
    <!-- BEGIN BODY -->
<body class="padTop53 " onload="pageLoading()" >
	<div class="loading"></div>
	<div class="spinner"></div>

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
                <li class="panel active">
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
                        <h5><span class="fa fa-home"></span> E-Permit <i class="fa fa-chevron-right"></i> Main Menu <i class="fa fa-chevron-right"></i> Transactions <i class="fa fa-chevron-right"></i> Permits</h5>
                    </div>
                </div>
                  <hr />
                  
                 <!--HOME SECTION -->
            <div class="row">
            <div class="col-lg-12">                       
            <a href="manage-permits.php" class="manage_permit btn btn-primary btn-lg btn-rect right" style="font-weight: bold"><i class="fa fa-anchor" style="margin-right: 3px;"> </i>Manage Permits </a>

            <div class="box">
            <header><div class="icons"><i class="fa fa-star"></i></div>
            <h5>BUILDING DEVELOPMENT PERMITS</h5></header>
                        
            <div class="panel panel-default">
            <!--             <div class="panel-heading">List of Applications Granted Permits</div>-->
            
            <div class="panel-body">
                <div class="data-table-area mg-tb-15">
                    <div class="sparkline13-graph">
                        <div class="datatable-dashv1-list custom-datatable-overright">
                            
                   <table id="table" class="table table-bordered table-hover">
					   <caption class="" style="padding-bottom: 5px"><span class="label label-warning" style="font-weight: bold; text-transform: uppercase; font-size: 14px">Lists Of Permits Granted </span></caption>

                    <thead class="text-warning" style="background: #000;">
                        <tr>
                        <th>No.</th>
                        <!-- <th data-field="id">ID</th>-->
                        <th data-field="appno">App. Number</th>
                        <th data-field="fullname">Applicant Name</th>
                        <th data-field="phoneno">Phone No.</th>
                        <th data-field="project">Project Development Name</th>
                        <th data-field="permitno">Development Permit Number</th>
                        <th data-field="date">Date Applied</th>
                        <th data-field="date2">Date Granted</th>
                        <!-- <th data-field="action"></th>-->
                        </tr>
                    </thead>
                    <tbody>
        <?php
             $cnt=1;    //COUNTER
            $sql_get = "SELECT `applicationid`,`name`, `phoneno`, `application_no`, `project_type`, `datecreated`, `permit_number`, `dateAssigned` FROM `applications` INNER JOIN `permits` ON `applications`.`applicationid`=`permits`.`application_id` ORDER BY `dateAssigned`,`name` ASC";
            $result1 = $connect_db->query($sql_get);
            if($result1->num_rows > 0){
                while($row = $result1->fetch_assoc())
                {
                ?>
                
                <tr>
                    <td><?php echo $cnt; ?></td>
                    <td class=""><?php echo ($row['application_no']); ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['phoneno']; ?></td>
                    <td><?php echo $row['project_type']; ?></td>
                    <td class="text-success"><?php echo ($row['permit_number']); ?></td>
                    <td class="text-info"><?php echo (date('d M, Y', strtotime($row['datecreated']))); ?></td>
                    <td class="text-danger"><?php echo (date('d M, Y', strtotime($row['dateAssigned']))); ?></td>
                    <!--                     
                    <td class="datatable-ct">
                     <a href="giveout.php?applicationID=<?php echo $row['applicationid'];?>" ><button class="handOverBtn btn btn-info btn-sm btn-rect" id="appId" style="font-weight: bold">Give </button></a>
                     <button class="btn btn-danger btn-sm btn-rect" data-toggle="modal" data-target="#showModal"><i class="fa fa-trash"></i> </button>
                        
                    </td>  
                    -->
                </tr>
            <?php
            $cnt=$cnt+1;        
        }}?>
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
       
<!--modals form-->
    <div class="col-lg-12">
        <div class="modal fade in" id="showModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title" id="H2">E-Permit System</h4>
                    </div>
                    <div class="modal-body">
                        <!--land use name-->
                            <div class="text-danger">
                            Please, this record cannot be deleted. All applications and permits are archived for future references and purposes. Permission denied!
                            </div>                             
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
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
    <script src="../admin/assets/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="../admin/assets/plugins/dataTables/dataTables.bootstrap.js"></script>
  <!-- end script -->  
    
    <!-- data table JS
    ============================================ -->
    <script src="../assets/datatable/js/bootstrap-table.js"></script>
<!--    <script src="../assets/datatable/js/data-table/tableExport.js"></script>-->
    <script src="../assets/datatable/js/data-table/data-table-active.js"></script>
    <script src="../assets/datatable/js/data-table/bootstrap-table-editable.js"></script>
    <script src="../assets/datatable/js/data-table/bootstrap-editable.js"></script>
<!--    <script src="../assets/datatable/js/data-table/bootstrap-table-resizable.js"></script>-->
<!--    <script src="../assets/datatable/js/data-table/colResizable-1.5.source.js"></script>-->
<!--    <script src="../assets/datatable/js/data-table/bootstrap-table-export.js"></script>-->
   <!-- validation scripts-->

    
   
<script type="text/javascript">
$(document).ready(function() {
    
	$('.manage_permit').click(function(e){
		$('.spinner').show().fadeIn('slow');
		setTimeout(function(){
			$('.spinner').hide().fadeOut(100);
		}, 2500);
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




