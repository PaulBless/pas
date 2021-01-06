
 
<?php
session_start();

include '../functions/db_connection.php';


// If the user is not logged in, redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: logout.php');
	exit;
}


 // get settings record
$select = "select * from settings";
$fetch=mysqli_query($connect_db, $select);
$rows=mysqli_fetch_array($fetch);


## process form data
if(isset($_POST['btnSubmit']))
{
//get post data
$district = $_POST['district'];
$town = $_POST['town'];                 
$address = $_POST['address'];        
$description = $_POST['appdesc'];
    
    //bind variables to save
    $ins_name = strtoupper($district);
    $ins_town = ucwords($town);
    $ins_address = ucwords($address);
    $ins_desc = ucwords($description);
    
   //preparing the SQL statement will prevent SQL injection.
    if ($stmt = $connect_db->prepare('SELECT * FROM settings')) {
	// Bind parameters (s = string, i = int, b = blob, etc), 
//	$stmt->bind_param('s', $district);
	$stmt->execute();
	$stmt->store_result(); 	//store the result, and check it availability.
    //check if record exists in database
    if ($stmt->num_rows > 0) {
        echo "<script>alert('The record you are trying to add already exists.. Record will be updated')</script>";
	$stmt->bind_result($distID,$distName,$distTown,$distAddress,$Description,$distLogo);
	$stmt->fetch();  //record exists,
        $stmt = $connect_db->prepare('UPDATE `settings` SET `dist_name`= ?, `dist_town`= ?, `dist_address`=?, `description`=? WHERE `id`= ?');
        $stmt->bind_param('ssssi', $ins_name, $ins_town, $ins_address, $ins_desc, $distID);
        $stmt->execute();
            
        echo "<div class='alert alert-info fade in col-lg-6 col-md-offset-2' style='top: 10px; transition: all 0.3s ease-in-out 0s'>"
        . "<a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a>"
        . "<strong><span class='fa fa-info'></span> </strong>" 
        . "<strong>&nbsp;&nbsp;System Settings updated!</strong>."
        . "</div>";
    }else{ 
            $sql_save=mysqli_query($connect_db, "INSERT INTO settings (`dist_name`, `dist_town`, `dist_address`, `description`) VALUES ('".$ins_name."', '".$ins_town."', '".$ins_address."', '".$ins_desc."')");
            
        echo "<div class='alert alert-success fade in col-lg-6 col-md-offset-3' style='top: 10px; transition: all 0.3s ease-in-out 0s'>"
        . "<a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a>"
        . "<strong><span class='fa fa-info'></span> </strong>" 
        . "<strong>&nbsp;&nbsp;Systen Settings saved!</strong>."
        . "</div>";
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
    <link rel="icon" href="../assets/images/logo.jpg" type="image/jpg">    
    <!-- GLOBAL STYLES -->
    <link rel="stylesheet" href="../admin/assets/plugins/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="../admin/assets/css/main.css" />
    <link rel="stylesheet" href="../admin/assets/css/theme.css" />
    <link rel="stylesheet" href="../admin/assets/css/MoneAdmin.css" />
    <link rel="stylesheet" href="../assets/font-awesome/css/fontawesome-all.css" />
    <!--END GLOBAL STYLES -->

      <!--page level scripts-->
<!--   <link rel="stylesheet" href="../third-party/vendor/bootstrap/css/bootstrap.css">-->
    <link rel="stylesheet" href="../third-party/dist/css/bootstrapValidator.css">
    <!--scripts-->
    <script type="text/javascript" src="../third-party/vendor/jquery/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="../third-party/vendor/bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="../third-party/dist/js/bootstrapValidator.js"></script>
    
    <script>
		function pageLoading(){
			$('.loading').show();
			setTimeout(function(){
				$('.loading').fadeOut();
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
/*            background-color: #33b35a;*/
/*            color: white;*/
            background: #343a40;
            transition: transform .3s ease, -webkit-transform .3s ease, -moz-transform .3s ease, -o-transform .3s ease;
        }
      
        .loading{
            position: fixed;
            width: 100%;
            height: 100%;
            opacity:  1.5;
			top: 0px;
			left: 0px;
            background:#fff url(../assets/images/LoaderIcon.gif) center no-repeat;
            z-index: 99999;
			display: none;
        }
    </style>
  
   </head>    <!-- END HEAD -->
    
    
<!-- BEGIN BODY -->
<body class="padTop53" onload="displayLoader()" >
<div class="loading" id="loader"></div>

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
                        <h5><span class="fa fa-home"></span> E-Permit <i class="fa fa-chevron-right"></i> General App Settings </h5>
                    </div>
                </div>
                  <hr />
                 
                 <div class="col-lg-12">
                   <a href="dashboard.php" class="btn btn-warning btn-sm"><i class="fa fa-home" style="margin-right: 3px;"></i> Main Menu</a>
                <div class="box">
                    <header>
                        <div class="icons"><i class="fa fa-bolt"></i></div>
                        <h5>General Settings</h5>

                        <div class="toolbar">
                            <ul class="nav pull-right">
                                <li>
                                    <a class="accordion-toggle minimize-box" data-toggle="collapse" href="#div-4">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>

                    
                    </header>
                    <div id="div-4" class="accordion-body collapse in body">
                        <form class="form-horizontal" method="post" id="formAdd">
                           <?php
                                // get settings record
//                                $select = "select * from settings";
//                                $fetch=mysqli_query($connect_db, $select);
//                                while($rows=mysqli_fetch_array($fetch))
//                                    {   
//                                        $id = $rows['id'];
//                                        $name = $rows['dist_name'];
//                                        $location = $rows['dist_town'];
//                                        $addr = $rows['dist_address'];
//                                        $desc= $rows['description'];
//                                    }
                            ?>
                            <!--district name-->
                                <div class="form-group">
                                    <label class="control-label col-lg-4">District name</label>
                                    <div class="col-lg-6">
                                        <input name="district" id="district" value="<?php if(isset($rows['dist_name'])) echo $rows['dist_name']; ?>" class="form-control" />
                                    </div>
                                </div>
                                <!--district capital town-->
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Town of district </label>
                                    <div class="col-lg-6">
                                        <input name="town" id="town" value="<?php if(isset($rows['dist_town'])) echo $rows['dist_town']; ?>" class="form-control"/>
                                    </div>
                                </div>
                                <!--district address-->
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Address or location</label>
                                    <div class="col-lg-6">
                                        <input name="address" id="address" class="form-control" value="<?php if(isset($rows['dist_address'])) echo $rows['dist_address']; ?>" />
                                    </div>
                                </div>
                                <!--description-->
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Name of Department to use System </label>
                                    <div class="col-lg-6">
                                        <textarea style="" class="form-control" id="appdesc" name="appdesc" cols="6" rows="3"><?php if(isset($rows['description'])) echo $rows['description']; ?></textarea>
                                    </div>
                                </div>

                                 <!--action button -->
                                <div class="form-actions no-margin-bottom" style="text-align:center; padding-top: 20px; padding-left: 250px;">
                                    <button style="font-weight: bold" class="btn btn-success" type="submit" name="btnSubmit"><i class="fa fa-paper-plane"></i>  Save Settings</button>
                                </div>


                        </form>
                    </div>
                </div>
            </div>
                </div>

            </div>
        <!--END PAGE CONTENT -->
        </div>
            <!--END MAIN WRAPPER -->

    <!-- FOOTER -->
    <div id="footer">
        <p>&copy; E-Permit 2020. &nbsp;Developed by <a class="app-developer" style="" href="">Jecmas </a>&nbsp;</p>
    </div>
    <!--END FOOTER -->
    
        
    <!--END PAGE LEVEL SCRIPT-->
   <!-- validation scripts-->
<script type="text/javascript">
$(document).ready(function() {
     
    //bootstrap form-control fields validation
    $('#formAdd').bootstrapValidator({
//        live: 'disabled',
        message: 'This value is not valid',
        feedbackIcons: {
//            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            district: {
                group: '.col-lg-6',
                validators: {
                    notEmpty: {
                        message: 'Name of district is required!'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z ]+$/,
                        message: 'The district name can only consist of alphabets'
                    },
                }
            },
//            town: {
//                group: '.col-lg-6',
//                validators: {
//                    notEmpty: {
//                        message: ''
//                    },
//                     regexp: {
//                        regexp: /^[a-zA-Z ]+$/,
//                        message: 'Enter only alphabets'
//                    },
//                }
//            },
//            address: {
//                group: '.col-lg-6',
//                validators: {
//                    notEmpty: {
//                            message: ''
//                        },
//                        }
//                    },
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
        if ((ev.keyCode < 65 || ev.keyCode > 90) && (ev.keyCode < 97 || ev.keyCode > 122 ) && (ev.keyCode == 32)){
            ev.preventDefault();
        }
    });
    
    //usertype on selected value changes
    $('#usertype').change(function(){
        var x = $(this).val();
        var get_username = $("#firstname").substring(0, 5);
        var get_password = "eps12345";
        if (x !== ''){
            $("#username").val() = get_username;
            $("#password").val() = get_password;
            alert("usernam is "+get_username);
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

     
$('#btnSave').click(function(){
        var addBtn = document.querySelector('.btn-success');
        
        addBtn.addEventListener("click", function(){
            addBtn.innerHTML = "Saving..";
            addBtn.classList.add('saving');
            
            setTimeout(function(){
                addBtn.classList.remove('saving');
                addBtn.innerHTML = "Save";
            }, 4000);
        }, false);
        
    });
</script>

<!--preloading-->
 <script>
        var preloader = document.getElementById('loader');
        function displayLoader(){
            preloader.style.display = 'block';
        }
        setTimeout(function(){
            $('.loading').fadeOut();
        }, 1500);
    </script>
   
    </body>
</html>






