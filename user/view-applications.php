
<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);



//invoke controller classes
require_once '../functions/databaseController.php';
//require_once '../functions/Applications.php';

//instance of db controller class
$db_handle = new databaseController();



// If the user is not logged in redirect to the login page...
//if (!isset($_SESSION['loggedin'])) {
//	header('Location: index.php');
//	exit;
//}

//get records
//if (! (isset($_GET['pageNumber']))) {
//    $pageNumber = 1;
//} else {
//    $pageNumber = $_GET['pageNumber'];
//}

//$perPageCount = 5;

//$sql = "SELECT * FROM applications  WHERE 1";

//if ($result = mysqli_query($connect_db, $sql)) {
//    $rowCount = mysqli_num_rows($result);
//    mysqli_free_result($result);
//}

//$pagesCount = ceil($rowCount / $perPageCount);

//$lowerLimit = ($pageNumber - 1) * $perPageCount;

//$sqlQuery = " SELECT * FROM applications WHERE 1 limit " . ($lowerLimit) . " ,  " . ($perPageCount) . " ";
//$results = mysqli_query($connect_db, $sqlQuery);

?>

<!--<table class="table table-hover table-responsive">-->
<!--    <tr>-->
<!--        <th align="center">Name</th>-->
<!--        <th align="center">Experience<br>(in years)-->
<!--        </th>-->
<!--        <th align="center">Subject</th>-->
<!--    </tr>-->
    <?php //foreach ($results as $data) { ?>
<!--    <tr>-->
<!--        <td align="left"><?php //echo $data['name'] ?></td>-->
<!--        <td align="left"><?php //echo $data['experience'] ?></td>-->
<!--        <td align="left"><?php //echo $data['major'] ?></td>-->
<!--    </tr>-->
    <?php
    //}
    ?>
<!--</table>-->

<!--<div style="height: 30px;"></div>-->
<!--<table width="50%" align="center">-->
<!--    <tr>-->
<!--        <td valign="top" align="left"></td>-->

<!--        <td valign="top" align="center">-->
 
	<?php
//	for ($i = 1; $i <= $pagesCount; $i ++) {
//    if ($i == $pageNumber) {
        ?>
<!--	      <a href="javascript:void(0);" class="current"><?php //echo $i ?></a>-->
<?php
//    } else {
        ?>
<!--	      <a href="javascript:void(0);" class="pages"-->
<!--            onclick="showRecords('<?php //echo $perPageCount;  ?>', '<?php //echo $i; ?>');"><?php //echo $i ?></a>-->
<?php
   // } // endIf
//} // endFor

?>
<!--</td>-->
<!--        <td align="right" valign="top">-->
<!--	     Page <?php //echo $pageNumber; ?> of <?php //echo $pagesCount; ?>-->
<!--	</td>-->
<!--    </tr>-->
<!--</table>-->



<!-- begin html page-->
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> 
<html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <!--meta descriptions-->
    <meta charset="UTF-8" />
    <title>E-Permit System  </title>
     <meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="Electronic permit application and processing system designed for use in the district assembly" name="description" />
	<meta content="Paul Eshun" name="author" />
     <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <![endif]-->
    
    <!--browser icon-->
    <link rel="icon" href="../assets/images/uwada-logo.jpg" type="image/jpg">    
    
    <!-- GLOBAL STYLES -->
    <link rel="stylesheet" href="../admin/assets/plugins/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="../admin/assets/css/main.css" />
    <link rel="stylesheet" href="../admin/assets/css/theme.css" />
    <link rel="stylesheet" href="../admin/assets/css/MoneAdmin.css" />
    <link rel="stylesheet" href="../assets/font-awesome/css/fontawesome-all.css" />
    <!--END GLOBAL STYLES -->

      <!--page level styles-->
    <link rel="stylesheet" href="../third-party/dist/css/bootstrapValidator.css">
     <link href="../admin/assets/css/bootstrap-fileupload.min.css" rel="stylesheet" />
    <link href="../admin/assets/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <link rel="stylesheet" href="../user/style.css" type="text/css" />
       <!-- end page level styles-->
    
    <!--page level scripts-->
    <script type="text/javascript" src="../third-party/vendor/jquery/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="../third-party/vendor/bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="../third-party/dist/js/bootstrapValidator.js"></script>
    
<!--    custom styles-->
    <style type="text/css">
        legend{
            font-size: 15px;
            font-weight: bold;
            color: #5b6574;
        }
        

        #inner-container {
            width: 1134px;
            max-width: 100%;
            padding: 20px 0 70px 0;
            height: 100%;
        }

        #container {
            min-height: 100%;
            padding: 20px;
            border-radius: 2px;
        }

        .pages {
            padding: 10px 14px;
            color: #000000;
            border-radius: 50%;
            background: #CCC;
            text-decoration: none;
            margin: 0px 6px;
            font-size: 0.9em;
        }

        .pages:hover {
            color: #ffffff;
            background: #666;
        }

        .current {
            padding: 10px 14px;
            color: #ffffff;
            background: #73AD21;
            text-decoration: none;
            border-radius: 50%;
            margin: 0px 6px;
        }

        .table {
            width: 100%;
            border-spacing: 0px;
            color: #6d6c6c;
        }

        .table td {
            padding: 10px;
            border-bottom: 1px solid #d9d9d9;
        }

        .table th {
            padding: 10px;
            border-bottom: 1px solid #d9d9d9;
            background: #d9d9d9;
            text-align: left;
        }
    </style>
</head>    <!-- END HEAD -->

   
    <!-- BEGIN BODY -->
<body class="padTop53 " onload="">


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
                <li class="panel active">
                    <a href="homepage.php" >
                        <i class="fa fa-home"></i> Main Menu
                    </a>                                   
                </li>

                <!--menu item -->
                <li><a href="addapplication.php"><i class="fa fa-plus"></i> Add New Application </a></li>
                <!--menu item-->
                <li><a href="search-applications.php"><i class="fa fa-search"></i> Search Applications </a></li>
                <!--menu item-->
                <li><a href="view-applications.php"><i class="fa fa-info"></i> Submitted Applications </a></li>
                <!--menu item-->
                <li><a href="chat.php"><i class="fa fa-comments"></i> Chat Option </a></li>
                <!--menu item exit-->
                <li><a href="../logout.php"><i class="fa fa-power-off"></i> Exit Application </a></li>

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
                        <i class="fa fa-chevron-right"></i> View Applications </h5>
                    </div>
                </div>
        <hr />
                
            <div class="row">
                <div class="col-lg-12">
                    <div class="box">
                        <header>
                        <div class="icons"><i class="fa fa-folder-open"></i>
                        </div>
                        <h5>MY SUBMITTED APPLICATIONS</h5></header>
                        
                        <div class="panel panel-default">
                            
                            
						<!--  new code with ajax-pagination-->
							 <div id="container">
								<div id="inner-container">

									<div id="results"></div>
									<div id="loader"></div>

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
    
      <!-- GLOBAL SCRIPTS -->
<!--    <script src="../admin/assets/js/jquery-2.0.3.min.js"></script>-->
<!--     <script src="../admin/assets/plugins/bootstrap/js/bootstrap.min.js"></script>-->
<!--    <script src="../admin/assets/js/modernizr-2.6.2-respond-1.1.0.min.js"></script>-->
    <!-- END GLOBAL SCRIPTS -->
    <!-- PAGE LEVEL SCRIPTS -->
    
	
    <script src="../admin/assets/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="../admin/assets/plugins/dataTables/dataTables.bootstrap.js"></script>
     
        <script>
			 $(document).ready(function () {
				 $('#dataTables-example').dataTable();
			 });
    	</script>
         <!--END PAGE LEVEL SCRIPTS -->     

	<!--     get records-->
     <script type="text/javascript">
         function showRecords(perPageCount, pageNumber) {
             $.ajax({
                  type: "GET",
                  url: "getUserSubmittedApplications.php",
                  data: "pageNumber=" + pageNumber,
                  cache: false,
                  beforeSend: function() {
                      $('#loader').html('<img src="../assets/images/loader.gif" alt="reload" width="20" height="20" style="margin-top:10px;">');

                    },
                  success: function(html) {
                      $("#results").html(html);
                      $('#loader').html(''); 
                    }
                });
            }

                $(document).ready(function() {
                    showRecords(10, 1);
                }); 
    </script>
                
      <!-- bootstrap validation scripts-->
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
                group: '.col-lg-4',
                validators: {
                    notEmpty: {
                            message: 'Specify the propose development name'
                        },
                    regexp: {
                        regexp: /^[a-zA-Z ]+$/,
                        message: 'Occupation can only consist of alphabets'
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
    
		//this function triggers when form data is submitted
	//    $("#form-adduser").submit(function(){
	//        var num_val = $("#mobile").substring(0, 3);
	//        if (num_val !== '024') && (num_val !== '054') && (num_val !== '055') && (num_val !== '059') && (num_val !== '027') && (num_val !== '057') && (num_val !== '056') && (num_val !== '026') && (num_val !== '020') && (num_val !== '050') && (num_val !== '023'){
	//            alert('Phone number is invalid.');
	//        }
	//    });
    
    // keypress event
    //phone-number validation
    jQuery("#mobile").keypress(function(ev){
    var x = $(this).val();
    if (ev.keyCode < 48 || ev.keyCode > 57) {
      ev.preventDefault();
        }
    });
    
    //contact number
      jQuery("#contactnumber").keypress(function(ev){
    var x = $(this).val();
    if (ev.keyCode < 48 || ev.keyCode > 57) {
      ev.preventDefault();
        }
    });
    
    //validate number format
    jQuery("#mobile").onblur(function(ev){
        var x = $(this).val();
        var num = this.substring(0, 3);
        if (num !== '054' && num !== '024'){
            alert('Phone number is invalid.');
        }
    });
    
    //first-name validation
    jQuery("#name").keypress(function(ev){
        var x = $(this).val();
        if ((ev.keyCode < 65 || ev.keyCode > 90) && (ev.keyCode < 97 || ev.keyCode > 122 )){
            ev.preventDefault();
        }
    });
    
    //last-name validation
    jQuery("#contactname").keypress(function(ev){
        var x = $(this).val();
        if ((ev.keyCode < 65 || ev.keyCode > 90) && (ev.keyCode < 97 || ev.keyCode > 122 ) && (ev.keyCode == 32)){
            ev.preventDefault();
        }
    });
    
    //residence
      jQuery("#residence").keypress(function(ev){
        var x = $(this).val();
        if ((ev.keyCode < 65 || ev.keyCode > 90) && (ev.keyCode < 97 || ev.keyCode > 122 ) && (ev.keyCode == 32)){
            ev.preventDefault();
        }
    });
    
    //location
      jQuery("#location").keypress(function(ev){
        var x = $(this).val();
        if ((ev.keyCode < 65 || ev.keyCode > 90) && (ev.keyCode < 97 || ev.keyCode > 122 ) && (ev.keyCode == 32)){
            ev.preventDefault();
        }
    });
    
    //project name
      jQuery("#project").keypress(function(ev){
        var x = $(this).val();
        if ((ev.keyCode < 65 || ev.keyCode > 90) && (ev.keyCode < 97 || ev.keyCode > 122 ) && (ev.keyCode == 32)){
            ev.preventDefault();
        }
    });

    //occupation
      jQuery("#occupation").keypress(function(ev){
        var x = $(this).val();
        if ((ev.keyCode < 65 || ev.keyCode > 90) && (ev.keyCode < 97 || ev.keyCode > 122 ) && (ev.keyCode == 32)){
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
