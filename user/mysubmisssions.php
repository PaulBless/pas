<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);

//include db connection file
include '../functions/db_connection.php';

//invoke controller classes
require_once '../functions/databaseController.php';
require_once '../functions/Applications.php';
require_once '../functions/Users.php';

//instance of db controller class
$db_handle = new databaseController();



//query to fetch locations
$sql = "SELECT * from locality order by loc_name asc";
$rs =mysqli_query($connect_db, $sql);

//query to fetch application categories
$select = "SELECT * from app_types order by type_name asc";
$rs1 =mysqli_query($connect_db, $select);

//query to fetch landuse types
$get = "SELECT * from landuse order by land_use asc";
$rsLanduse =mysqli_query($connect_db, $get);


// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: ./index.php');
	exit;
}


## get applications list based on username
$search_value = "";
if(isset($_SESSION['name']))
	$search_value = $_SESSION['name'];

## search id param
$search_id = "";
if(isset($_SESSION['id']))
	$search_id = $_SESSION['id'];


## fetch applications submitted by this loggedin user
$myapplication = new Applications();
$dbresults = $myapplication->getApplicationByCreatedUser($search_value);
## --------------------------------------


?>

     
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> 
<html lang="en"> <!--<![endif]-->
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
    <link rel="icon" href="../admin/assets/logo.jpg" type="image/jpg">  
      
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
    
 <!-- dataTables export buttons scripts-->
<link rel="stylesheet"  href="../assets/export/buttons.dataTables.min.css">    
<script src="../assets/export/dataTables.buttons.min.js" type="text/javascript"></script> 
<script src="../assets/export/jszip.min.js" type="text/javascript"></script> 
<script src="../assets/export/pdfmake.min.js" type="text/javascript"></script> 
<script src="../assets/export/vfs_fonts.js" type="text/javascript"></script> 
<script src="../assets/export/buttons.html5.min.js" type="text/javascript"></script> 
   
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
    
    <!-- function to show loader on pageloading-->
	<script type="text/javascript">
		function pageLoading(){
			$('.loading').show();
			setTimeout(function(){
				$('.loading').hide();
			}, 1000);
		}
	</script>
   
    <!--stylesheet-->
    <style type="text/css">
        legend{
            font-size: 15px;
            font-weight: bold;
            color: #5b6574;
		     }
		 .loading{
            opacity:1.0;
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

                    <!--USER SETTINGS SECTIONS -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i id="icon" class="fa fa-user "></i>&nbsp;Howdy, <?=$_SESSION['name']?>
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
            
            <ul id="menu" class="collapse">
                <li class="panel ">
                    <a href="homepage.php"><i class="fa fa-home"></i> Main Menu
                    </a>                                   
                </li>

                <!--menu item -->
                <li class="panel "><a href="addapplication.php"><i class="fa fa-plus"></i> Add New Application </a></li>
                <!--menu item-->
                <li class="panel"><a href="search-applications.php"><i class="fa fa-search"></i> Search Applications </a></li>
                <!--menu item-->
                <li class="panel active"><a href="mysubmisssions.php"><i class="fa fa-folder"></i> My Submissions  </a></li>
                <li class="panel"><a href="building-permits.php"><i class="fa fa-star"></i> Building Permits </a></li>
                <!--menu item-->
                <li class="panel"><a href="chat.php"><i class="fa fa-comments"></i> Chat Option </a></li>
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
                        <h5><span class="fa fa-home"></span> E-Permit <i class="fa fa-chevron-right"></i> User Dashboard <i class="fa fa-chevron-right"></i> My Submitted Applications</h5>
                    </div>
                </div>
                  <hr />
                  
                 <!--HOME SECTION -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="box">
                        <header>
                        <div class="icons"><i class="fa fa-folder"></i>
                        </div>
                        <h5>MY SUBMISSIONS</h5></header>
                        
           				<div class="panel-body">
                			<div class="data-table-area mg-tb-15">
                    			<div class="sparkline13-graph">
                        			<div class="datatable-dashv1-list custom-datatable-overright">
                            <div class="table-responsive">
					   			<table id="table" class="table table-bordered table-striped table-hover">
           	<caption class="" style="padding-bottom: 5px"><span class="label label-warning" style="font-weight: bold; text-transform: uppercase; font-size: 14px">Lists Of Applications Submitted by: <?php echo $_SESSION['name'];?></span></caption>
           		<thead class="text-warning" style="background: #000">
                <tr>
                    <th><strong>S/No</strong></th>
			<!--     <th><strong>ID</strong></th>-->
                    <th><strong>Applicant Name</strong></th>
			<!--     <th><strong>Phone Number</strong></th>-->
                    <th><strong>Project Development Name</strong></th>
                    <th><strong>Site Location</strong></th>
                    <th><strong>App. Number</strong></th>
                    <th><strong>Encoded Date </strong></th>

                </tr>
           		<tbody>
                  <?php
					$no=1;
                    if (! empty($dbresults)) {
                        foreach ($dbresults as $k => $v) {
                            ?>
          		<tr>
                    <td><?php echo $no; ?></td>
<!--                    <td><?php //echo $dbresults[$k]["applicationid"]; ?></td>-->
                    <td><?php echo $dbresults[$k]["name"]; ?></td>
<!--                    <td><?php //echo $dbresults[$k]["phoneno"]; ?></td>-->
                    <td><?php echo $dbresults[$k]["project_type"]; ?></td>
                    <td><?php 
					//get locality name by binding with id param
                    $getSiteLocality=mysqli_query($connect_db, "select loc_name from locality where id='".$dbresults[$k]["location"]."'");
                    $result = mysqli_fetch_array($getSiteLocality);
                    //fetch corresponding data
					 if(empty($result['loc_name'])) echo "Invalid Location"; else
                    echo $result['loc_name']; ?></td>
                    <td><?php echo $dbresults[$k]["application_no"]; ?></td>
                    <td><?php echo date('d M, Y', strtotime($dbresults[$k]["datecreated"])); ?></td>
                    
                </tr>
                    <?php
						$no += 1;
                        }
                    }
                    ?>
           		</tbody>
								</table> </div>
          
                        			</div>
                    			</div>       
                         	</div>
                     </div>
                     
                     <!--testing oop concept-->
           <div class="panel-body hidden">
           	<table id="table" class="table table-bordered table-striped table-hover">
           	<caption class="" style="padding-bottom: 5px"><span class="label label-warning" style="font-weight: bold; text-transform: uppercase; font-size: 14px">Lists Of Applications Submitted by: <?php echo $_SESSION['name'];?></span></caption>
           		<thead class="text-warning" style="background: #000">
                <tr>
                    <th><strong>S/No</strong></th>
			<!--     <th><strong>ID</strong></th>-->
                    <th><strong>Applicant Name</strong></th>
                    <th><strong>Phone Number</strong></th>
                    <th><strong>Project Development Name</strong></th>
                    <th><strong>Site Location</strong></th>
                    <th><strong>App. Number</strong></th>
                    <th><strong>Encoded Date </strong></th>

                </tr>
           		<tbody>
                  <?php
					$no=1;
                    if (! empty($dbresults)) {
                        foreach ($dbresults as $k => $v) {
                            ?>
          		<tr>
                    <td><?php echo $no; ?></td>
<!--                    <td><?php //echo $dbresults[$k]["applicationid"]; ?></td>-->
                    <td><?php echo $dbresults[$k]["name"]; ?></td>
                    <td><?php echo $dbresults[$k]["phoneno"]; ?></td>
                    <td><?php echo $dbresults[$k]["project_type"]; ?></td>
                    <td><?php echo $dbresults[$k]["application_no"]; ?></td>
                    <td><?php 
					//get locality name by binding with id param
                    $getSiteLocality=mysqli_query($connect_db, "select loc_name from locality where id='".$dbresults[$k]["location"]."'");
                    $result = mysqli_fetch_array($getSiteLocality);
                    //fetch corresponding data
					 if(empty($result['loc_name'])) echo "Invalid Location"; else
                    echo $result['loc_name']; ?></td>
                    <td><?php echo date('d M, Y', strtotime($dbresults[$k]["datecreated"])); ?></td>
                    
                </tr>
                    <?php
						$no += 1;
                        }
                    }
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

	<!-- FOOTER -->
    <div id="footer">
        <p>&copy; E-Permit 2020. &nbsp;Developed by <a class="app-developer" style="" href="">Jecmas </a>&nbsp;</p>
    </div>
    <!--END FOOTER -->
    
        
        
 <!-- PAGE LEVEL SCRIPTS -->
    <script src="../admin/assets/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="../admin/assets/plugins/dataTables/dataTables.bootstrap.js"></script>
  <!-- end script --> 
   
   <!-- validation scripts-->
<script type="text/javascript">
	$(document).ready(function() {
     
    //display effect on submit button clicked
    $('#btnSubmit').click(function(){
        var mybutton = document.getElementById('btnSubmit');
        mybutton.innerHTML = "Saving data..";
        mybutton.classList.add('spinning'); //add class list
        //show loader
        $('spinner').show();
        
        setTimeout(function(){
            mybutton.classList.remove('spinning');  //remove class list
            $('spinner').hide();
            mybutton.innerHTML = "Submit";
        }, 6000);
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
