<?php
session_start();
error_reporting(0);

require_once '../functions/db_connection.php';


if(!isset($_SESSION['loggedin'])){
    header('Location: ./index.php');
    exit;
}

if(isset($_POST['btnDelete']))
{	
	//get button value
	$locId = $_POST['btnDelete'];
	$get_location_id = $_GET['btnDelete'];
//	echo "<script>alert('location id is: .')</script>";
//	echo "location id is: ." .$locId;
	echo "location id is: " .$_POST['btnDelete'];
	
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
<!--end here-->
  
  <script type="text/javascript">
		function pageLoading(){
			$('.loading').show();
			setTimeout(function(){
				$('.loading').fadeOut();
			}, 1500);
		}
	</script>
  
<!--  loader for the button click-->
   <script type="text/javascript">
	   var myVar;

	   function showSpinner() {
    	myVar = setTimeout(Loader, 3000);
	   }

	   function Loader() {
  		document.getElementById("loader").style.display = "none";
//  		document.getElementById("myDiv").style.display = "block";
	   }
	   
	</script>
   <!-- datatable export buttons -->
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
    <!-- end -->
    
    <!-- custom stylesheet-->
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
		/*bootstrap loader*/
		.loader {
			position: fixed;
			display: none;
			background: #fefefe;
			left: 50%;
			top: 50%;
			z-index: 1;
			width: 150px;
			height: 150px;
			margin: -75px 0 0 -75px;
			border: 16px solid #111;
			border-radius: 50%;
			border-top: 16px solid red;
			width: 120px;
			height: 120px;
			-webkit-animation: spin 2s linear infinite;
			animation: spin 2s linear infinite;
			}
			@keyframes spin {
				0% { transform: rotate(0deg); }
				100% { transform: rotate(360deg); }
			}
			@-webkit-keyframes spin {
			  0% { -webkit-transform: rotate(0deg); }
			  100% { -webkit-transform: rotate(360deg); }
			}
		/*	end*/

		/*styling to the loadericon */
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
/*			-webkit-animation: spin 2s linear infinite;*/
/*			animation: spin 2s linear infinite;*/
        }	
		@keyframes spin {
				0% { transform: rotate(0deg); }
				100% { transform: rotate(360deg); }
			}
			@-webkit-keyframes spin {
			  0% { -webkit-transform: rotate(0deg); }
			  100% { -webkit-transform: rotate(360deg); }
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
	<!--    end-->
</head>    <!-- END HEAD -->

   
    <!-- BEGIN BODY -->
<body class="padTop53 " onload="pageLoading()" id="page" >
	<div class="loading"></div>
	<div class="spinning"></div>
	<div class="loader" id="loader"></div>


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
                <li class="panel active">
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
                <li class=""><a href="logout.php"><i class="logout fa fa-power-off" id="logout"></i> Logout </a></li>

            </ul>

        </div>
        <!--END MENU SECTION -->

       
        <!--PAGE CONTENT -->
        <div id="content">
                     
            <div class="inner" style="min-height: 700px;">
                <div class="row">
                    <div class="col-lg-12">
                       <!--page title/section-->
                        <h5><span class="fa fa-home"></span> E-Permit <i class="fa fa-chevron-right"></i> Main Menu <i class="fa fa-chevron-right"></i> Settings <i class="fa fa-chevron-right"></i> Locations</h5>
                    </div>
                </div>
        <hr />
                  
        <!--HOME SECTION -->
        <div class="row">
        <div class="col-lg-12">                       
            <a href="location-addnew.php" data-toggle="" data-target="" onclick="showLoader()" class="add_new btn btn-primary right" style="font-weight: bold" id="addnew"><i class="fa fa-plus"></i> Add New Location</a>
            
          
            <div class="box">
            <header><div class="icons"><i class="fa fa-map"></i></div>
            <h5>LIST OF LOCATIONS/COMMUNITIES</h5></header>
                        
                <div class="panel panel-default"> 
                        <div class="panel-body">
                        <div class="data-table-area mg-tb-15">
                            <div class="sparkline13-graph">
                                <div class="datatable-dashv1-list custom-datatable-overright">

						<table id="table" class="table table-striped table-bordered table-hover">

                            <thead class="text-warning" style="background: #000">
                                <tr>
                                <th>No.</th>
                                <!-- <th data-field="id">ID</th>-->
                                <th data-field="locname">Location Name</th>
                                <th data-field="action">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                <?php
                    $sql=mysqli_query($connect_db,"SELECT * from locality order by loc_name ASC");
                    $cnt=1;
                    while($last=mysqli_fetch_array($sql)){

                ?>
                        <tr>
                        <td><?php echo $cnt; ?></td>
                        <!-- <td><?php //echo $last['id'] ?></td>-->
                        <td><?php echo $last['loc_name'] ?></td>
                        <td class="datatable-ct">
                        <!--edit button-->
                        <!--process application link-->
                        <a href="edit-location.php?loc_id=<?php echo $last['id'];?>"  ><button class="btn btn-info btn-sm" id="locId" name=""><i class="fa fa-pencil-alt"></i> Edit</button></a>
                        <!--delete link-->
                        <a class="btn_delete btn btn-danger btn-sm" href="delete.php?locId=<?php echo htmlentities($last['id']);?>" onclick="return confirm('Do you really want to delete this site location?')" data-loc-id="<?php echo htmlentities($last['id']);?>"> <i class="fa fa-trash" style="margin-right: 3px"></i>Delete</a>
                        
                        <!-- delete button testing -->
<!--                        <input type="submit" class="mybtn_delete btn btn-success" name="btnDelete" data-loc-id="<?php //echo ($last['id']); ?>" value="<?php //echo ($last['id']); ?>">-->
                        
<!--                        <button type="submit" class="mybtn_delete btn btn-success" name="btnDelete" data-loc-id="<?php //echo ($last['id']); ?>" value="<?php //echo ($last['id']); ?>">Delete</button>-->
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
       
       
<!--modals-->
       <div class="col-lg-12">
            <div class="modal fade in" id="add_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title" id="H2">Add New Location</h4>
                        </div>
                        <div class="modal-body">
                            <form role="form" id="insert_new" name="" action="">
                            <div class="form-group">
                            <label>Location name</label>
                            <input class="form-control" name="location" id="location">
                            <p class="help-block">Example (Adeiso)</p>
                            </div>                            
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                            <button type="button" class="btn btn-primary"><i class="fa fa-save"></i> Save </button>
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
        <p>&copy; E-Permit 2020. &nbsp;Developed by <a class="app-developer" style="" href="">Jecmas </a>&nbsp;</p>
    </div>
    <!--END FOOTER -->
    
<!-- PAGE LEVEL SCRIPTS -->
    <script src="../admin/assets/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="../admin/assets/plugins/dataTables/dataTables.bootstrap.js"></script>
  <!--END PAGE LEVEL SCRIPT-->

    
    <!-- data table JS
    ============================================ -->
    <script src="../assets/datatable/js/bootstrap-table.js"></script>
    <script src="../assets/datatable/js/data-table/tableExport.js"></script>
    <script src="../assets/datatable/js/data-table/data-table-active.js"></script>
    <script src="../assets/datatable/js/data-table/bootstrap-table-editable.js"></script>
    <script src="../assets/datatable/js/data-table/bootstrap-editable.js"></script>
    <script src="../assets/datatable/js/data-table/bootstrap-table-resizable.js"></script>
    <script src="../assets/datatable/js/data-table/colResizable-1.5.source.js"></script>
<!--    <script src="../assets/datatable/js/data-table/bootstrap-table-export.js"></script>-->
   <!-- validation scripts-->

    
   
<script type="text/javascript">
	$(document).ready(function() {
	//confirm logout on button click
        $('.logout').click(function(){
			alert ("Logout button clicked");
//            if(confirm("Are you sure you want to logout?"))
//                window.location.href = "http://127.0.0.1/pas/admin/index.php";
//
//            return false;
        });


		//delete record function 
		$('.mybtn_delete').click(function(){
	//		e.preventDefault();   
	   var locId = $(this).attr('data-loc-id');
	   var parent = $(this).parent("td").parent("tr");
//		$('.spinning').show();	//show loadericon
		//begin ajax request
//		$.ajax({        
//			type: 'POST',	//type of request
//			url: 'delete.php',	//url to process
//			data: 'locId='+locId,	//data to bind
//			
//			before:function(data){
//				$('.spinning').show();
//			}
//			success:function(){
//				$('.spinning').hide();
//			}
//		});
		
		if(locid != ''){
	  	alert ("Location ID: " +locId);
		}else{
			alert ("no id for selection");
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

   	
<!-- begin function to show loader when button click-->
	<script type="text/javascript">
		function showLoader(){
			$('.spinning').show();
			setTimeout(function(){
				$('.spinning').hide();
			}, 200);
		}
	</script>
<!--end function here-->
   
   <!-- begin test function to show processing message when button click-->
	<script type="text/javascript">
		function showFunction(){
			$('#myDiv').style.display = "block";
			setTimeout(function(){
				$('#myDiv').fadeOut();
			}, 500);
		}
	</script>
<!--end function here-->
   
    </body>
</html>




