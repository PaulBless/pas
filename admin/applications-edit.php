<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);

//include db connection file
include '../functions/db_connection.php';

//invoke controller classes
require_once '../functions/databaseController.php';
require_once '../functions/Applications.php';

//instance of db controller class
$db_handle = new databaseController();


//global variables
$last_id = "";                 
$application_id = "";         //application number
$currentyear = date("Y");     //current year



// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: ./index.php');
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
        $error = "Record Exists..\\n \\nThe record with applicant Name: ".$fullname. " and Application ID: ".$app_number. " is already added or registered.. \\nCannot save duplicate records!";
        echo "<script>alert('".$error."')</script>";
    }else{
    //create instance of application class
    $new_application = new Applications();
    //insert the record
    $insertid = $new_application->addApplication($name, $gender, $mobile, $residence, $occupation, $contactname, $contactnumber, $location, $project, $sub_date, $application_id, $_SESSION['uname']);
    if(empty($insertid)){
    echo "<script>alert('Error!\\n \\nCould not complete the request.. Try again later!')</script>";
    }else{
    $message = "Application successfully saved.\\n Application ID: ".$application_id;
    echo "<script>alert('".$message."')</script>";
    
        }
        }
    }
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
                        <h5><span class="fa fa-home"></span> E-Permit <i class="fa fa-chevron-right"></i> Main Menu <i class="fa fa-chevron-right"></i> Applications <i class="fa fa-chevron-right"></i> Manage Applications</h5>
                    </div>
                </div>
                  <hr />
                  
                 <!--HOME SECTION -->
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
            <header><div class="icons"><i class="fa fa-file"></i></div>
            <h5>MANAGE APPLICATIONS</h5></header>
                        
            <div class="panel panel-default">
             <div class="panel-heading">
            List of Applications Received</div>
            <div class="panel-body">
        <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true" data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
            <thead>
                <tr>
                <th data-field="id">ID</th>
                <th data-field="fullname">Full Name</th>
                <th data-field="dob"></th>
                <th data-field="gender">Department</th>
                <th data-field="age">Registration Date</th>
                <th data-field="nationality">Email</th>
                <th data-field="phone">Phone</th>
                <th data-field="action">Action</th>
                </tr>
            </thead>
            <tbody>
        <?php
            $sql=mysqli_query($connect_db,"SELECT * from applications");
             $more=1;
            while($last=mysqli_fetch_array($sql)){

        ?>

        <tr>
        <td><? echo $more; ?></td>
        <td><?php echo $last['name'] ?></td>
        <td><?php echo $last['gender'] ?></td>
        <td><?php echo $last['phoneno'] ?></td>
        <td><?php echo $last['datecreated'] ?></td>
        <td><?php echo $last['email'] ?></td>
        <td><?php echo $last['phone'] ?></td>
        <td class="datatable-ct">
        <a href="#?id=<?php echo $last['id']?>" ><button class="btn btn-info">Send for Review</button></a>
        <!--delete link-->
        <a href="delev.php?id=<?php echo htmlentities($last['id']);?>" onclick="return confirm('Do you really want to delete this user ?')"> Delete</a>
        </td>
        </tr>
    <?php
        $more=$more+1;
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
    </div>/

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
       $(document).ready(function(){
            //process record fetch into datatable
            $('#myTable').DataTable({
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post';
                'ajax': {
                'url': 'process.php'
                },
                'columns':[
                {data: 'name'},
                {data: 'phoneno'},
                {data: 'location'},
                {data: 'project_type'},
                {data: 'application_no'},
                ]                               
            });    
       });
    </script>
   
<script type="text/javascript">
$(document).ready(function() {
      
    
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
                    regexp: {
                        regexp: /^[a-zA-Z ]+$/,
                        message: 'Site location can only consist of alphabets'
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
