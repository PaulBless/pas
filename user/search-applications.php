


<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);

//include db connection file
include '../functions/db_connection.php';


 //If the user is not logged in, redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: ../index.php');
	exit;
}

if(isset($_POST['']))
{
	if(empty($_POST['']))
	{
		//show error message for no input value
		echo "<script>alert('Enter the name of the applicant you want to search..')</script>";
		
	}else{
		//fetch records using parameter value specified
		$key = $_POST['searchtxt'];
		$sql_query = "select * from applications where name='$key'";
		$get_results = mysqli_query($connect_db, $sql_query);
		if($get_results == true){
			$output .= '
				<table class="table table-bordered table-striped table-hover">
					<thead style="background: #123; color: #fff">
					<tr>
						<td>Applicant Name</td>
						<td>Mobile No.</td>
						<td>Application #</td>
						<td>Project Development Name</td>
						<td>Date Added</td>
					</tr>
					</thead>
			';
		
			while($data = mysqli_fetch_array($get_results)){
				$output .='
				<tbody>
				<tr>
					<td>'. $data['name'] .'</td>
					<td>'. $data['phoneno'] .'</td>
					<td>'. $data['application_no'] .'</td>
					<td>'. $data['project_type'] .'</td>
					<td>'. $data['datecreated'] .'</td>
				</tr>
				</tbody>
				';
				}
			$output .='</table>';
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
    <!--meta descriptions-->
    <meta charset="UTF-8" />
    <title>E-Permit System </title>
     <meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="Electronic permit application and processing system designed for use in the district assembly" name="description" />
	<meta content="Paul Eshun" name="author" />
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
    
    <!-- datatable -->
         <script src="../admin/assets/plugins/dataTables/dataTables.bootstrap.js"></script>
      <script src="../admin/assets/plugins/dataTables/jquery.dataTables.js"></script>
    <!-- function to show loader on pageloading-->
	<script type="text/javascript">
		function pageLoading(){
			$('.loading').show();
			setTimeout(function(){
				$('.loading').hide();
			}, 600);
		}
	</script>
   
    
    <style type="text/css">
        legend{
            font-size: 15px;
            font-weight: bold;
            color: #5b6574;
        }
  		
		 .loading{
					opacity:0.7;
					background:#c1c1c1 url(../assets/images/spin.gif) no-repeat center;
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
<body class="padTop53" onload="pageLoading()" >
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
                        <i id="icon" class="fa fa-user "></i>&nbsp;Welcome, <?=$_SESSION['name']?>
                        <i id="icon" class="fa fa-chevron-down"></i>
                        </a>

                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="user-profile.php"><i class="fa fa-user-circle"></i> My Profile </a>
                            </li>
                            <li><a href="#"><i class="fa fa-tags"></i> My Tasks </a>
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
                    <h5 class="media-heading"><i class="fa fa-user"></i> Login As: <?=$_SESSION['role']?>!</h5>
                    <ul class="list-unstyled user-info">
                        <li><a class="btn btn-success btn-xs btn-circle" style="width: 10px;height: 12px;"></a> Online  
                        </li>
                    </ul>
                </div>
                <br />
            </div>
            
            <!--list items-->
            <ul id="menu" class="collapse">
                <li class="panel ">
                    <a href="homepage.php" >
                        <i class="fa fa-home"></i> Main Menu
                    </a>                                   
                </li>
                <!--menu item -->
                <li class="panel"><a href="addapplication.php"><i class="fa fa-plus"></i> Add New Application </a></li>
                <!--menu item-->
                <li class="panel active"><a href="search-applications.php"><i class="fa fa-search"></i> Search Applications </a></li>
                <!--menu item-->
                <li class="panel"><a href="mysubmisssions.php"><i class="fa fa-folder"></i> My Submitted Forms </a></li>
                <li><a href="building-permits.php"><i class="fa fa-star"></i> Building Permits </a></li>
                <!--menu item-->
<!--                <li class="panel"><a href="chat.php"><i class="fa fa-comments"></i> Chat Option </a></li>-->
                
                <!--menu item exit-->
                <li class="panel"><a href="../logout.php"><i class="fa fa-power-off"></i> Logout </a></li>

            </ul>
        </div>
        <!--END MENU SECTION -->

        <!--PAGE CONTENT -->
		<div id="content">
                     
			<div class="inner" style="min-height: 700px;">
				<div class="row">
							<div class="col-lg-12">
							   <!--page title/section-->
								<h5><span class="fa fa-home"></span> E-Permit 
								<i class="fa fa-chevron-right"></i> User Dashboard 
								<i class="fa fa-chevron-right"></i> Search Applications </h5>
							</div>
						</div>
				<hr />

					<div class="row">
					<div class="col-lg-12">
						<div class="box">
							<header>
							<div class="icons"><i class="fa fa-briefcase"></i>
							</div>
							<h5>SEARCH APPLICATIONS</h5></header>

                        <div class="panel panel-default">
                                                      
                            <form role="form" data-toggle="validator" method="post" class="form-horizontal" novalidate="true">
                                <div class="form-group" style="padding-top: 1.3em;">
                                    <div class="col-md-9 col-md-offset-1 col-xs-9 col-sm-10" >
                                    <input type="text" class="form-control" name="searchtxt" placeholder="Enter applicant name to search" autocomplete="off"></div>
								<!--  <input type="submit" name="btnSearch" value="Search" class="btn btn-info" style="pointer-events: all; cursor: pointer;">-->
                                    <button class="btn btn-primary " type="submit" id="btn_search" name="btn_search" style="pointer-events: all; cursor: pointer; font-weight: bold">Search</button>
                                 </div>
                            </form>
                            
                           
                           <div class="panel-body">
                			<div class="data-table-area mg-tb-15">
                    			<div class="sparkline13-graph">
                        			<div class="datatable-dashv1-list custom-datatable-overright table-responsive">
                             
                              <table id="table" class="table table-bordered table-striped hidden" data-responsive="table">
                              	<thead class="text-warning" style="background: #000; font-weight: bold">
                              	<tr>
                              	<td>No.</td>
                              	<td>Applicant Name</td>
                              	<td>Mobile #</td>
                              	<td>Application #</td>
                              	<td>Project Development Name</td>
                              	<td>Site Location</td>
                              	<td>Date Added</td>
                              	</tr>
                              	</thead> <!--head end-->
                              		
                              	<tbody>
                              	<?php 
								if(isset($_POST['btn_search']))
								{
									if(empty($_POST['searchtxt'])){
										echo "<script>alert('Please enter the applicant name')</script>";
									}
									
							$count = 1; //counter for table rows
							$search_parameter = $_POST['searchtxt'];
							// Prepare the SQL statement to prevent SQL injection.
							if ($stmt = $connect_db->prepare('SELECT `name`, `phoneno`, `application_no`, `project_type` ,`location`, `datecreated` FROM `applications` WHERE `name` = ?')) {
							// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
							$stmt->bind_param('s', $search_parameter);
							$stmt->execute();
							// Store the result so we can check if the account exists in the database.
							$stmt->store_result();
							
							if ($stmt->num_rows > 0) {
							$stmt->bind_result($fullname, $phoneno, $app_number, $project_name, $locID, $add_date);
							$stmt->fetch();
							// record exists, fetch data, display in table
							?>
								<tr>
							<td><?php echo $count; ?></td>
							<td><?php echo $fullname; ?></td>
							<td><?php echo $phoneno; ?></td>
							<td><?php echo $app_number; ?></td>
							<td ><?php echo $project_name; ?></td>
							<td><?php 
							//get locality name by binding with id param
						$getSiteLocality=mysqli_query($connect_db, "select loc_name from locality where id='".$locID."'");
						$result = mysqli_fetch_array($getSiteLocality);
						//fetch corresponding data
						 if(empty($result['loc_name'])) echo "Invalid Location"; else
                    	echo $result['loc_name']; ?></td>
							<td><?php echo (date('d M, Y', strtotime($add_date))); ?></td>
						</tr>
						<?php
						$count=$count+1;        
						}	//end of record found
						else{
							echo "<script>alert('The name you entered does not match any record in the system')</script>";
							}
											
								$stmt->close();	//close the sql statement
							
								}	//end of sql prepare
									
							}	//end of button search
							?>
                              
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
    </div>

</div><!--END PAGE CONTENT -->
        
</div>    <!--END MAIN WRAPPER -->

<!-- FOOTER -->
    <div id="footer">
        <p>&copy; E-Permit 2020. &nbsp;Developed by <a class="app-developer" style="" href="">Jecmas </a>&nbsp;</p>
    </div>
    <!--END FOOTER -->
    
    <!-- PAGE LEVEL SCRIPTS -->
    <script src="../admin/assets/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="../admin/assets/plugins/dataTables/dataTables.bootstrap.js"></script>
  <!-- end script --> 
   
     <script>
         $(document).ready(function () {
            $('#myTable').dataTable({
                autoWidth: false,
                columnDef:[{
                    targets: ['_all'],
                    className: 'mdc-data-table_cell'
                }]
            });
             
             
//             var table = $('#myTable').removeAttr('width').DataTable({
//                scrollY: "300px",
//                 scrollX: true,
//                 scrollCollapse: true,
//                 paging: false,
//                 columnDefs: [{width: 200, targets: 0}],
//                fixedColumns: true                                         
//             });
             
//             $('#myTable').DataTable({
//                scrollY: true,
//                 scroller: {
//                     rowHeight: 30,
//                     rowWidth: 150
//                 }
//             });
         });
    </script>
         <!--END PAGE LEVEL SCRIPTS -->     

      <!-- bootstrap validation scripts-->
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

</script>

    </body>
</html>





                            