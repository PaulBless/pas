<?php
//start session.
session_start();
//include database connection
include '../functions/db_connection.php';

// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: ../index.php');
	exit;
}


//oop invoke methods
require_once '../functions/databaseController.php';
require_once '../functions/Users.php';
//instance of db controller class
$db_handle = new databaseController();

// We don't have the password or email info stored in sessions so instead we can get the results from the database.
$stmt = $connect_db->prepare('SELECT fullname, mobileno, email, department_name, username, password, role, status, regdate FROM users_account WHERE userid = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($fullname,$mobile,$email,$department,$uname, $password, $usertype,$status,$regdate);
$stmt->fetch();
$stmt->close();

if(isset($_POST['test']))
{
	$password_length = strlen($_POST['newPassword']);
 	## validations
	if(md5($_POST['oldPassword'])==md5($password))	//valid old password
	{
		if(md5($_POST['newPassword']) !== md5($password))//different old and new pass
		{
			if($_POST['newPassword'] == $_POST['confirmPassword']) ##password identical
			{
				if($password_length >= 6 ) ## check password length
				{
					echo "<script>alert('wow... all validations passed..')</script>";
				}else { echo "<script>alert('new password weak, must be atleast 6 characters long')</script>";}
			}else{ echo "<script>alert('new password and confirm new password must match (be the same values)')</script>";}
		}else{ echo "<script>alert('old and new passwords can't be the same..')";}
	}else{	echo "<script>alert('old password wrong!!!')</script>";
	}
}

//script to change password
if(isset($_POST['btnChange'])){
    $username = $_POST['username'];
    $oldpwd = ($_POST['oldPassword']);
    $newpwd = $_POST['newPassword'];
    $confirmpwd = $_POST['confirmPassword'];
	$check_oldpwd=$oldpwd;
	$entered_newpwd=md5($newpwd);
    
    $pwd_length = strlen($newpwd); //check length of password
    $stored_pwd =  "";
		
	//check validity of old password
	if(md5($_POST['oldPassword'])==md5($password))
	{
		//do nothing
	}else{
		 $msg = "Passwords Match Error\\nThe old password you entered is incorrect, please check..";
        echo "<script>alert('".$msg."'); window.location='update-password.php';</script>";
	}
		
	//check old and new passwords are identical
	if(md5($_POST['newPassword'])==md5($password))
	{
		//do nothing
		 $msg = "Error\\n \\nThe old password and the new password cannot be the same you, please enter different values..";
        echo "<script>alert('".$msg."'); window.location='update-password.php';</script>";
	}else{
		 //do nothing
	}
	
    //check new passwords values identical
    if($newpwd !== $confirmpwd){
        $msg = "Error\\n \\nNew password and confirm password do not match";
        echo "<script>alert('".$msg."'); window.location='update-password.php';</script>";
    }
	
    //check the password length: must be 6 characters long
    if($pwd_length < 6){
         $msg = "Error\\n \\nWeak password, atleast '6' characters length accepted";
        echo "<script>alert('".$msg."'); window.location='update-password.php';</script>";
    }
	
    //continue to update password if no error found
    if($newpwd === $confirmpwd){
    //new instance of the user class
    $new_user = new Users();
    $hash_pwd = password_hash($newpwd, PASSWORD_DEFAULT);	//hashing password
    $new_user->changePassword($entered_newpwd, $_SESSION['id']);
    
    //display success message
    $msg = "Success\\n \\nPassword successfully changed. You will be required to login again... \\n\\nNew password is: ".$newpwd;
    echo "<script type='text/javascript'>alert('".$msg."'); window.location='../restart_session.php';</script>";
//    header ('Location: ../restart_session.php');
    }else{
        $msg = "Error\\n \\nNew password and confirm password do not match";
        echo "<script>alert('".$msg."') window.location='update-password.php';</script>";
    }
    
    
}

?>

<?php include('../includes/header.php'); ?>

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
<!--                <img src="../assets/images/uwada-logo.jpg" width="25" height="25">-->
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
                            <i id="icon" class="fa fa-user" style=""></i>&nbsp;Welcome, <?=$_SESSION['name']?>
                            <i id="icon" class="fa fa-chevron-down"></i>
                        </a>

                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="user-profile.php"><i class="fa fa-user-circle"></i> My Profile </a>
                            </li>
                            <li><a href=""><i class="fa fa-tags"></i> My Tasks </a>
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
                    <h5 class="media-heading"><i class="fa fa-user"></i> Login As: <?=$_SESSION['role']?></h5>
                    <ul class="list-unstyled user-info">
                        <li><a class="btn btn-success btn-xs btn-circle" style="width: 10px;height: 12px;"></a> Online  
                        </li>
                    </ul>
                </div>
                <br />
            </div>
            
            <ul id="menu" class="collapse">
                <li class="panel active">
                    <a href="homepage.php" >
                        <i class="fa fa-home"></i> Main Menu
                    </a>                                   
                </li>

                <!--menu item -->
                <li><a href="new-application.php"><i class="fa fa-plus"></i> Add New Application </a></li>
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
                        <h5><span class="fa fa-home"></span> E-Permit <i class="fa fa-chevron-right"></i> User Dashboard <i class="fa fa-chevron-right"></i> My Profile <i class="fa fa-chevron-right"></i> Change Password </h5>
                    </div>
                </div>
                  <hr />
                  
                 <!--HOME SECTION -->
                 <div class="row">
                     <div class="col-lg-12">
                        <div class="box">
                            <header>
                                <div class="icons"><i class="fa fa-th-large"></i>
                                </div>
                                <h5>CHANGE PASSWORD</h5>
                                <div class="toolbar">
                                <ul class="nav">
                                <li>
                                </li>
                                </ul>
                                </div>
                            </header>                 
                        <!--  content-->
                        <div class="panel panel-default">
<!--
                        <div class="panel-heading">
                            Fill out the form to change your password
                        </div>
-->
                        <div class="panel-body">
                        <form id="defaultForm" method="post" class="form-horizontal" action=""
                      data-bv-message="This value is not valid"
                      data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
                      data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
                      data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Username</label>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" name="username" value="<?php echo $uname;?> "data-bv-message="The username is not valid" required data-bv-notempty-message="The username is required and cannot be empty" readonly/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Old Password</label>
                        <div class="col-lg-5">
                            <input class="form-control" name="oldPassword" placeholder="Enter your old password" type="password" data-by-message="Old password is not valid" required data-by-notempty-message="The old password is required" data-bv-different="true" data-bv-different-field="newPassword" data-bv-different-message="The old password cannot be the same as new password"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">New Password</label>
                        <div class="col-lg-5">
                            <input type="password" class="form-control" name="newPassword" placeholder="Enter your new password" minlength="6" maxlength="30" required data-bv-notempty-message="The password is required and cannot be empty" data-bv-identical="true" data-bv-identical-field="confirmPassword" data-bv-identical-message="The password and its confirm are not the same" data-bv-different="true" data-bv-different-field="username" data-bv-different-message="The password cannot be the same as username"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Confirm New Password</label>
                        <div class="col-lg-5">
                            <input type="password" class="form-control" name="confirmPassword" placeholder="Confirm your new password" min="6" required data-bv-notempty-message="The confirm password is required"
                            data-bv-identical="true" data-bv-identical-field="newPassword" data-bv-identical-message="The password and its confirm are not the same"/>
                        </div>
                    </div>
                     <!--buttons group-->
                        <div class="form-actions no-margin-bottom" style="text-align:center;">
                        <input type="submit" name="btnChange" value="Change Password" class="btn btn-primary" style="margin-right: 15px; font-weight: bold">
                       
<!--                         <input type="submit" name="test" value="Test Password" class="btn btn-success" style="margin-right: 15px; font-weight: bold">-->
                        <a class="btn btn-danger" type="reset" href="homepage.php" style="margin-left: 15px; font-weight: bold"><i class="fa fa-times"></i> Cancel</a>
                        </div>
<!--
                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-3" style="">
                            <button type="submit" class="btn btn-primary ">Submit</button>
                        </div>
                    </div>
-->
                </form>
                            </div>
                    </div>
               
                        </div>
                    </div>
                </div>   
                
            </div>

        </div>
        <!--END PAGE CONTENT -->


        </div>
         <!-- END RIGHT STRIP  SECTION -->

    <!--END MAIN WRAPPER -->

<?php include('../includes/footer.php'); ?>

<!--page scripts-->
<script type="text/javascript">
    $(document).ready(function() {
        $('#defaultForm').bootstrapValidator();
        
        //check password length
        
    });
</script>


