<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);

//include db connection file
include '../functions/db_connection.php';



// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: ./index.php');
	exit;
}


//process data on form submission
if(isset($_POST['btnSubmit'])){
    
    //get form data
    $typename = ucfirst($_POST['typename']);
       
    //preparing the SQL statement will prevent SQL injection.
    if ($stmt = $connect_db->prepare('SELECT type_name FROM app_types WHERE type_name = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), 
    //in our case the username is a string so we use "s"
	$stmt->bind_param('s', $typename);
	$stmt->execute();
	$stmt->store_result(); 	//store the result, and check it availability.
    //check if record exists in database
    if ($stmt->num_rows > 0) {
	$stmt->bind_result($tname);
	$stmt->fetch(); 	//record exists, fetch results 
       
    echo "<div class='alert alert-danger bounceUp col-lg-6 col-md-offset-3' style='top: 10px; transition: transform .3s ease, -webkit-transform .3s ease, -moz-transform .3s ease, -o-transform .3s ease'>"
        . "<a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a>"
        . "<strong><span class='fa fa-info fa-2x'></span> </strong>" 
        . "<strong>&nbsp;&nbsp;Record Exists!!  '$tname' is already added!</strong>."
        . "</div>";
        
    }else{
    //save new record 
   if ($stmt = $connect_db->prepare('INSERT INTO app_types (type_name) VALUES (?)')){
	$stmt->bind_param('s', $typename);
	$stmt->execute();
      
    echo "<div class='alert alert-success fadeIn col-lg-6 col-md-offset-3' style='top: 10px; transition: all 0.3s ease-in-out 0s'>"
        . "<a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a>"
        . "<strong><span class='fa fa-info fa-2x'></span> </strong>" 
        . "<strong>&nbsp;&nbsp;Record saved successfully!</strong>."
        . "</div>";
    
        } else {
	// Something is wrong with the sql statement, 
    //check to make sure accounts table exists with field data.
	echo 'Could not prepare sql statement!';
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
    <link rel="icon" href="../admin/assets/logo.jpg" type="image/jpg">  
      
    <!-- GLOBAL STYLES -->
    <link rel="stylesheet" href="../admin/assets/plugins/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="../admin/assets/css/main.css" />
    <link rel="stylesheet" href="../admin/assets/css/theme.css" />
    <link rel="stylesheet" href="../admin/assets/css/MoneAdmin.css" />
    <link rel="stylesheet" href="../assets/font-awesome/css/fontawesome-all.css" />
    <!--END GLOBAL STYLES -->

     
      <!--page level scripts-->
    <link rel="stylesheet" href="../third-party/dist/css/bootstrapValidator.css">
     <link rel="stylesheet" href="../third-party/dist/css/bootstrapValidator.css">
     <link href="../admin/assets/css/bootstrap-fileupload.min.css" rel="stylesheet" />
     
    <!--scripts-->
    <script type="text/javascript" src="../third-party/vendor/jquery/jquery-1.10.2.min.js"></script>
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
/*            background-color: #33b35a;*/
/*            color: white;*/
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
                       <li class="my-sub-link"><a href="adminaccounts.php"><i class="fa fa-arrow-right"></i> Admin Accounts</a></li>
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
                        <li class="my-sub-link"><a href="manage-users.php"><i class="fa fa-arrow-right"></i> Manage Users </a></li>
                        <li class="my-sub-link"><a href="user-logs.php"><i class="fa fa-arrow-right"></i> User Logs</a></li>
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
                        <li class="my-sub-link"><a href="grantpermit.php"><i class="fa fa-arrow-right"></i> Grant A Permit </a></li>
                        <li class="my-sub-link"><a href="reviewlists.php"><i class="fa fa-arrow-right"></i> Review Applications </a></li>
                        <li class="my-sub-link"><a href="permits.php"><i class="fa fa-arrow-right"></i> Building Permits </a></li>
                    </ul>
                </li>
                <!--panel menu item-->
                <li><a href="committee-decisions.php"><i class="fa fa-bookmark"></i> Committee Decisions </a></li>
                <li><a href="site-inspections.php"><i class="fa fa-eye"></i> Site Inspections </a></li>
                <!--menu item-->
                <li><a href="tasks.php"><i class="fa fa-tasks"></i> Users Tasks </a></li>
                <!--menu item-->
                <li><a href="chat.php"><i class="fa fa-comments"></i> Chat Option </a></li>
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
                        <h5><span class="fa fa-home"></span> E-Permit <i class="fa fa-chevron-right"></i> Main Menu <i class="fa fa-chevron-right"></i> Application Category <i class="fa fa-chevron-right"></i> Add New </h5>
                    </div>
                </div>
                  <hr />
                  
                 <!--HOME SECTION -->
            <div class="row">
                <div class="col-lg-12">
                   <a href="application-types.php" class="btn btn-warning text-center"> <i class="fa fa-arrow-left" style="margin-right: 3px;"></i> Go Back</a>
                    <div class="box">
                        <header>
                        <div class="icons"><i class="fa fa-th-large"></i>
                        </div>
                        <h5>Add Application Category</h5></header>
                        
                        <div class="panel panel-default">
                            <div class="panel-body">
                               
                        <form role="form" id="form-newpermit" method="post" class="form-horizontal px-4 py-3" action="">
                                    
                        <!--site location-->
                        <div class="form-group">
                            <label class="control-label col-lg-4">Application Category Name</label>
                            <div class="col-lg-4">
                                <input name="typename" id="typename" class="form-control" placeholder="" />
                                <p class="help-block">Provide name of application type(eg. individual)</p>
                            </div>
                            <div class="col-lg-4">
                            <!--save button-->
                            <button class="btn btn-success" type="submit" name="btnSubmit"><i class="fa fa-save"></i> Save</button>
                            </div>
                        </div>
                     
                        
                        <br>
                       
                        </form>
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
        <p>&copy; E-Permit 2020. &nbsp;Developed by <a class="app-developer" style="" href="">Jecmas </a>&nbsp;</p>
    </div>
    <!--END FOOTER -->
    
        
 <!-- PAGE LEVEL SCRIPTS -->
    <script src="../../admin/assets/plugins/validationengine/css/validationEngine.jquery.css"></script>
    <script src="../../admin/assets/plugins/jasny/js/bootstrap-fileupload.js"></script> 
    <!--END PAGE LEVEL SCRIPT-->
   
   <!-- validation scripts-->
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
            
            location: {
                group: '.col-lg-4',
                validators: {
                    notEmpty: {
                            message: 'Enter site location  '
                        },
                    regexp: {
                        regexp: /^[a-zA-Z ]+$/,
                        message: 'Enter only alphabets'
                    },
                        }
                    },
            
        }
    });
    
    
    
    //first-name validation
    jQuery("#firstname").keypress(function(ev){
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
