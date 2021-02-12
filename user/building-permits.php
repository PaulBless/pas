<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);

//include db connection file
include '../functions/db_connection.php';
## get system settings
$sql = "select `dist_name`,`dist_town` from settings";
$qry = mysqli_query($connect_db, $sql);
$fetch = mysqli_fetch_assoc($qry);
$district = $fetch['dist_name'];
$town = $fetch['dist_town'];

//invoke controller classes
require_once '../functions/databaseController.php';
require_once '../functions/Applications.php';

//instance of db controller class
$db_handle = new databaseController();


//global variables
$last_id = "";                 
$application_id = "";         //application number
$currentyear = date("Y");     //current year

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
	header('Location: ../index.php');
	exit;
}


//run code below to get last application id from db
//after fetch application number, and increment to generate new
//$sql = "SELECT application_no FROM Applications ORDER BY application_no DESC LIMIT 1";
$sql = "select applicationid from applications order by applicationid desc limit 1";
$result = $connect_db->query($sql);
if ($result->num_rows > 0) {
    // output data from row
    while($row = $result->fetch_assoc()) {
        $last_id = $row["applicationid"];   //get last application_no
        $last_id += 1; //increment the number by 1
        $def = "/";
        $application_id = sprintf($currentyear ."/". "%04d", $last_id);
//            echo $application_id;
    }
}else{
    //no record of application id found in db
    //therefore assign new application id first
    $last_id = 1;
    $application_id = $currentyear ."/". "%04d" .$last_id;
//    echo $application_id;
}


//function generate numbers
function getApplicationNos($start, $count, $digits){
    $result  = array();
    $now_date = date("Ym");
    
    for ($n = $start; $n < $start + $count; $n++){
        $result[] = str_pad($n, $digits, "0", STR_PAD_LEFT);
        
    }
    return $result;
}

//try get numbers
for($i=$number;$i<=100;$i++){
//    echo sprintf($date_now ."%05d", $i) . "<br>";
}


//process data on form submission
if(isset($_POST['btnSubmit'])){
    
    //get form data
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $mobile = $_POST['mobile'];
    $residence = $_POST['residence'];
    $occupation = $_POST['occupation'];
    $contactname = $_POST['contactname'];
    $contactnumber = $_POST['contactnumber'];
    $location = $_POST['location'];
    $project = ($_POST['project']);
    $sub_date = ($_POST['date2']);
    $date = date("d/m/Y h:i:sa"); 
    $status = 'New';
    $landuseID = ($_POST['landuse']);
    $categoryID = ($_POST['category']);
   
    //proceed to save new application for later processing
    //preparing the SQL statement will prevent SQL injection.
    if ($stmt = $connect_db->prepare('SELECT name, application_no FROM applications WHERE name = ? AND phoneno = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), 
    //in our case the username is a string so we use "s"
	$stmt->bind_param('ss', $name, $mobile);
	$stmt->execute();
	$stmt->store_result(); 	//store the result, and check it availability.
    //check if record exists in database
    if ($stmt->num_rows > 0) {
	$stmt->bind_result($fullname, $app_number);
	$stmt->fetch(); 	//record exists, fetch results 
    //        $error = "Record Exists..\\n \\nThe record with applicant Name: ".$fullname. " and Application ID: ".$app_number. " is already added or registered.. \\nCannot save duplicate records!";
    //        echo "<script>alert('".$error."')</script>";

        //show error msg via hmtl-element
        echo "<div class='alert alert-danger fade in col-lg-8 col-md-offset-2' style='top: 8px; transition: all 0.3s ease-in-out'>"
        . "<a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a>"
        . "<strong><span class='fa fa-bell'></span> </strong>" 
        . "<strong>&nbsp;&nbsp;Record Exist!! </br> The record with Applicant Name: '$fullname' and Application No: '$app_number' is already created or added! </br>Cannot proceed to save duplicate records.. </strong>."
        . "</div>";
    }else{
    
        //create instance of application class
    $new_application = new Applications();
    //insert the record
    $insertid = $new_application->addApplication($name, $gender, $mobile, $residence, $occupation, $contactname, $contactnumber, $location, $project, $sub_date, $application_id, $_SESSION['name'], $status, $landuseID, $categoryID);
    
    if(empty($insertid)){
        //show error message in case of qrong sql query
        echo "<div class='alert alert-warning fade in'>"
        . "<a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a>"
        . "<strong><span class='fa fa-gift'></span> </strong> .<strong>&nbsp;&nbsp;Could not process the request! There could be problem with SQL statement..</strong>"
        . "</div>";

    }else{
        // $message = "Application successfully saved.\\n \\nApplication No: ".$application_id;
        //  echo "<script>alert('".$message."')</script>";
  
    //show error msg via hmtl-element
    echo "<div class='alert alert-success fade in col-lg-8 col-md-offset-2' style='top: 8px; transition: all 0.3s ease-in-out'>"
    . "<a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a>"
    . "<span class='fa fa-bell'></span>" 
    . "&nbsp;&nbsp;Application successfully saved! </br> <strong>Application No: '$application_id' </strong>."
    . "</div>";
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
    <title>E-Permit System </title>
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
            
            <ul id="menu" class="collapse">
                <li class="panel ">
                    <a href="homepage.php"><i class="fa fa-home"></i> Main Menu
                    </a>                                   
                </li>

                <!--menu item -->
                <li class="panel "><a href="addapplication.php"><i class="fa fa-plus"></i> Add New Application </a></li>
                <!--menu item-->
                <li class="panel"><a href="application-lists.php"><i class="fa fa-th"></i> Application Lists </a></li>
                <!--menu item-->
                <li class="panel"><a href="mysubmisssions.php"><i class="fa fa-folder"></i> My Submitted Forms  </a></li>
                <li class="panel active"><a href="building-permits.php"><i class="fa fa-star"></i> Permits Granted </a></li>
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
                        <h5><span class="fa fa-home"></span> E-Permit <i class="fa fa-chevron-right"></i> User Dashboard <i class="fa fa-chevron-right"></i> Building Development Permits</h5>
                    </div>
                </div>
                  <hr />
                  
                 <!--HOME SECTION -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="box">
                        <header>
                        <div class="icons"><i class="fa fa-star"></i>
                        </div>
                        <h5>BUILDING DEVELOPMENT PERMITS</h5></header>
                        
           				<div class="panel-body">
                		<div class="data-table-area mg-tb-15">
                    		<div class="sparkline13-graph">
                        		<div class="datatable-dashv1-list custom-datatable-overright table-responsive">
                            
					   			<table id="table" class="table table-bordered table-hover" style="width: 100">
						   		<caption style="padding-bottom: 5px; "><span class="label label-warning" style="font-weight: bold; text-transform: uppercase; font-size: 14px">Lists Of Permits Granted</span></caption>

							<thead class="text-warning" style="background: #000">
							<tr>
							<th>No.</th>
							<!-- <th data-field="id">ID</th>-->
							<th data-field="appno">App. Number</th>
							<th data-field="fullname" width="">Applicant Name</th>
							<th data-field="phoneno">Phone No.</th>
							<th data-field="project" width="">Project Development Name</th>
							<th data-field="permitno" width="">Permit Number</th>
							<th data-field="dateApply"  width="">Date Applied</th>
							<th data-field="date"  width="">Date Granted</th>
							</tr>
						</thead>
							<tbody>
			<?php
				 $cnt=1;    //COUNTER
				$sql_get = "SELECT applicationid,name, phoneno, application_no, project_type, datecreated, permit_number, dateAssigned from applications INNER JOIN permits ON applications.applicationid=permits.application_id ORDER BY name ASC";
				$result1 = $connect_db->query($sql_get);
				if($result1->num_rows > 0){
					while($row = $result1->fetch_assoc())
					{
					?>

					<tr>
						<td><?php echo $cnt; ?></td>
						<td><?php echo ($row['application_no']); ?></td>
						<td><?php echo $row['name']; ?></td>
						<td><?php echo $row['phoneno']; ?></td>
						<td ><?php echo $row['project_type']; ?></td>
						<td class="text-danger"><?php echo ($row['permit_number']); ?></td>
						<td><?php echo (date('d M, Y', strtotime($row['datecreated']))); ?></td>
						<td><?php echo (date('d M, Y', strtotime($row['dateAssigned']))); ?></td>
	<!--
						<td class="datatable-ct">
						 <a href="giveout.php?applicationID=<?php //echo $row['applicationid'];?>" ><button class="handOverBtn btn btn-info btn-sm btn-rect" id="appId" style="font-weight: bold">Give </button></a>
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
    
    
    //bootstrap form-control fields validation
    $('#form-newpermit').bootstrapValidator({
//        live: 'disabled',
        message: 'This value is not valid',
        feedbackIcons: {
//            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            name: {
                group: '.col-lg-4',
                validators: {
                    notEmpty: {
                        message: 'Applicant name cannot be empty, required!'
                    },
                     regexp: {
                        regexp: /^[a-zA-Z ]+$/,
                        message: 'The name can only consist of alphabets'
                    },
                }
            },
            gender: {
                group: '.col-lg-5',
                validators: {
                    notEmpty: {
                        message: 'Please select gender'
                    },
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
            contactnumber: {
                group: '.col-lg-4',
                validators: {
                    digits: {
                        message: 'Contact number should be digits only'
                    },
                    notEmpty: {
                            message: 'Contact number is required'
                        },
                    stringLength: {
                        min: 1,
                        max: 10,
                        message: 'Contact number is not complete'
                            },
                        }
                    },
            residence: {
                group: '.col-lg-4',
                validators: {
                    notEmpty: {
                            message: 'Place or town of residence cannot be empty'
                        },
                    regexp: {
                        regexp: /^[a-zA-Z ]+$/,
                        message: 'The residence can only consist of alphabets'
                    },
                        }
                    },
            occupation: {
                group: '.col-lg-4',
                validators: {
                    notEmpty: {
                            message: 'Provide occupation of applicant'
                        },
                    regexp: {
                        regexp: /^[a-zA-Z ]+$/,
                        message: 'Occupation can only consist of alphabets'
                    },
                        }
                    },
            contactname: {
                group: '.col-lg-4',
                validators: {
                    notEmpty: {
                            message: 'Emergency contact name is required'
                        },
                    regexp: {
                        regexp: /^[a-zA-Z ]+$/,
                        message: 'Contact name can only consist of alphabets'
                    },
                        }
                    },
            location: {
                group: '.col-lg-4',
                validators: {
                    notEmpty: {
                            message: 'Location of site is required'
                        },
                        }
                    },
            project: {
                group: '.col-lg-6',
                validators: {
                    notEmpty: {
                            message: 'Specify the proposed development name'
                        },
                    regexp: {
                        regexp: /^[a-zA-Z ]+$/,
                        message: 'Proposed development name can only consist of alphabets'
                    },
                        }
                    },
            date2: {
                group: '.col-lg-4',
                validators: {
                    notEmpty: {
                            message: 'Select valid date'
                        },
                    date: {
                        message: 'Specify application date',
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
