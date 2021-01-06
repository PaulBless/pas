
<!--begin server scripting/processing-->
<?php

session_start();
error_reporting(E_ALL ^ E_NOTICE);

require_once '../functions/databaseController.php';
require_once '../functions/Users.php';
require_once '../functions/Admin.php';

//invoke database controller class
$db_handle = new databaseController();

if(isset($_POST['btnRegister'])){
     //get form data
    $firstname = $_POST['firstName'];
    $lastname = $_POST['lastName'];
    $phonenumber = $_POST['phone'];
    $emailid = $_POST['email'];
    $password = $_POST['password'];
    $username = $_POST['username'];
    $status = 'Active';
    $userType = 'Admin';
    $dept = 'Physical Planning';
    $activity = '';
    $fullname = $firstname. ' '. $lastname; //concatenate firstname and lastname into fullname
    $name = "{$firstname} {$lastname}";
    $regdate = ($_GET['regdate']);
//    $regdate = date("d/m/Y h:i:sa");
       
        
    //check phone, verify valid mtn, airteltigo, vodafone or glo
    $chk_phone = substr($phonenumber, 0, 3);        
    if($chk_phone != '024' && $chk_phone != '054' && $chk_phone != '055' && $chk_phone != '056' && $chk_phone != '059' && $chk_phone != '027' && $chk_phone != '057' && $chk_phone != '026' && $chk_phone != '050' && $chk_phone != '020' && $chk_phone != '023'){
    echo "<script>alert('Sorry! Could not process\\n \\nThe phone number you entered is not valid..'); document.location.href='register.php'</script>";
    }
        
    //check if the details exists in the database
    
    //new object instantiation
    $admin_user = new Admin();  
    $newUser = new Users();  
    $hashpwd = password_hash($password, PASSWORD_DEFAULT);  //hash the password
    //invoke the add new admin account method, to save record
    $insertId = $admin_user->addAdmin($fullname, $phonenumber, $emailid, $username, $hashpwd, $status, $regdate);
//    $insertId = $newUser->addUser($fullname, $phonenumber, $emailid, $dept, $username, $hashpwd, $userType, $status, $regdate);
    if(empty($insertId)){
        $response = array(
        "message" => "Account registration failed..",
        "type" => "error"
        );
    header ('location: register.php');
    } else{
        $message = "Successfully registered.\\n \\nUsername: ".$username. "\\nPassword: ".$password. "\\n\\nProceed to login.";
        echo "<script>alert('".$message."'); document.location.href='index.php'</script>";;
        } 
    
}

    
?>    

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="">
    <title>E-Permit System - Admin Account Registration</title>
    <!--favicon-->
    <link rel="icon" type="image/jpg" href="../assets/images/logo.jpg">
    <!-- stylesheets-->
    <link rel="stylesheet" href="../third-party/vendor/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../third-party/dist/css/bootstrapValidator.css">
    <link rel="stylesheet" href="../assets/font-awesome/css/fontawesome-all.css">
    <!--scripts-->
    <script type="text/javascript" src="../third-party/vendor/jquery/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="../third-party/vendor/bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="../third-party/dist/js/bootstrapValidator.js"></script>
    
    <!--page style-->
    <style type="text/css">
        #page{
            border: 1px solid #2f3947;
        }
        .form-horizontal{
        
        }
        .top-title{
            text-align: center;
            align-content: center;
            justify-content: center;
            color: #fff;
            background-color: #2f3947;
            padding: 3px 3px;
        }
        .top-title img{
/*            border: 5px solid #3a6248;*/
/*            border-radius: 50%;*/
            margin-top: 20px;
        }
        .top-title h2{
            text-transform: uppercase;
            font-size: 16px;
            font-weight: bold;
        }
        span{
            display: block;
        }
        legend{
           font-size: 15px;
            font-weight: bold;

        }
        #fst{margin-top: 4px;}
        .btn-custom{
            width: 100%;
            color: #2f3947;
            background-color: transparent;
            border: 2px solid #2f3947;
            text-transform: capitalize;
            font-size: 16px;
            font-weight: 600;
        }
        .btn-custom:hover{
            background-color: #2f3947;
            color: #fff;
            transition: background-color 0.3;
        }
        
        .lower-text{
            padding-top: 5px;
            font-size: 14px;
        }
        .lower-text a{
            color: #2f3947;
        }
        .lower-text a:hover{
            color: #3a6248;
        }
    </style>
    
</head>

<body>
   
    <div class="container" id="page">
        <div class="row">
           <!-- top title: -->
            <div class="top-title">
<!--                <img src="../assets/images/logo.jpg" width="60px" height="60px">-->
                <h2> E-Permit System </h2>
                <span><h4>Administrator Account Registration</h4></span>
            </div>
            
            <!-- form: -->
            <section class="register-frm"><!-- form: -->
                <div class="col-lg-8 col-lg-offset-2">
                    <legend id="fst">Personal Information</legend>
                    <form id="defaultForm" method="post" class="form-horizontal px-4 py-3" action="">
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Firstname</label>
                            <div class="col-lg-5">
                                <input type="text" class="form-control" name="firstName" placeholder="Your firstname" id="first-name" value="" />
                            </div>
                        </div>
                        <!--lastname-->
                        <div class="form-group">
                             <label class="col-lg-3 control-label">Lastname</label>
                            <div class="col-lg-5">
                                <input type="text" class="form-control" name="lastName" placeholder="Your lastname" id="last-name" value="" />
                            </div>
                        </div>
                        <!--email-->
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Email address</label>
                            <div class="col-lg-5">
                                <input type="text" class="form-control" name="email" placeholder="Your email address" value="" />
                            </div>
                        </div>
                        <!--phone number-->
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Phone Number</label>
                            <div class="col-lg-5">
                                <input onblur="chk_phone" type="tel" class="form-control" name="phone" placeholder="Your mobile number" pattern="[0][0-9]{9}" maxlength="10" id="phone-number" value=""/>
                            </div>
                        </div><!--end-->
                        
                        <!--account info-->
                        <legend>Account Information</legend>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Username</label>
                            <div class="col-lg-5">
                                <input type="text" class="form-control" name="username" value="" />
                            </div>
                        </div>
                        <!--password-->
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Password</label>
                            <div class="col-lg-5">
                                <input type="password" class="form-control" name="password" />
                            </div>
                        </div>
                        <!--confirm password-->
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Retype password</label>
                            <div class="col-lg-5">
                                <input type="password" class="form-control" name="confirmPassword" />
                            </div>
                        </div>
                        <!--captcha-->
                        <div class="form-group">
                            <label class="col-lg-3 control-label" id="captchaOperation"></label>
                            <div class="col-lg-2">
                                <input type="text" class="form-control" name="captcha" placeholder="" />
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="col-lg-4 control-label hidden">Date</label>
                            <div class="col-lg-4">
                               <input type="text" class="form-control hidden" value="<?php echo date("d/m/Y h:i:sa") ?>" name="regdate" id="regdate">
                            </div>
                        </div> 
                        <!-- register button-->
                        <div class="form-group">
                            <div class="col-lg-5 col-lg-offset-3">
                                <button type="submit" class="btn btn-custom btn-signup" name="btnRegister" value="Sign up"><i class="fa fa-paper-plane"></i> Register</button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
            <!-- :form -->
        </div>
    </div>
    <!--bottom text-->
    <div class="lower-text text-center">Already have an account? <a href="index.php">Login</a>
    </div>

       
<!-- validation scripts-->
<script type="text/javascript">
$(document).ready(function() {
    // Generate a simple captcha
    function randomNumber(min, max) {
        return Math.floor(Math.random() * (max - min + 1) + min);
    };
    $('#captchaOperation').html([randomNumber(1, 100), '+', randomNumber(1, 200), '='].join(' '));
    
    //bootstrap form-control fields validation
    $('#defaultForm').bootstrapValidator({
//        live: 'disabled',
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            firstName: {
                group: '.col-lg-5',
                validators: {
                    notEmpty: {
                        message: 'Firstname cannot be empty, required!'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z]+$/,
                        message: 'The firstname can only consist of alphabet'
                    },
                }
            },
            lastName: {
                group: '.col-lg-5',
                validators: {
                    notEmpty: {
                        message: 'Lastname cannot be empty, required!'
                    },
                     regexp: {
                        regexp: /^[a-zA-Z -]+$/,
                        message: 'The lastname can only consist of alphabet'
                    },
                }
            },
            username: {
                message: 'The username is not valid',
                validators: {
                    notEmpty: {
                        message: 'Username cannot be empty, required!'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_\.]+$/,
                        message: 'The username can only consist of alphabetical, number, dot and underscore'
                    },
//                    remote: {
//                        type: 'POST',
//                        url: '../functions/checkUsernameAvailabiility.php',
//                        message: 'The username is not available'
//                    },
                    different: {
                        field: 'password,confirmPassword',
                        message: 'The username and password cannot be the same as each other'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'Email address is required'
                    },
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'Password cannot be empty, required!'
                    },
                    stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The password must be more than 6 and less than 30 characters long'
                    },
                    identical: {
                        field: 'confirmPassword',
                        message: 'The password and its confirm are not the same'
                    },
                    different: {
                        field: 'username',
                        message: 'The password cannot be the same as username'
                    }
                }
            },
            confirmPassword: {
                validators: {
                    notEmpty: {
                        message: 'Retype your password to confirm!'
                    },
                    stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The password must be more than 6 and less than 30 characters long'
                    },
                    identical: {
                        field: 'password',
                        message: 'The passwords you entered do not match'
                    },
                    different: {
                        field: 'username',
                        message: 'Password cannot be the same as your Username'
                    }
                }
            },
            phone: {
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
            
            captcha: {
                validators: {
                    callback: {
                        message: 'Wrong answer',
                        callback: function(value, validator) {
                            var items = $('#captchaOperation').html().split(' '), sum = parseInt(items[0]) + parseInt(items[2]);
                            return value == sum;
                        }
                    }
                }
            }
        }
    });
    
    // keypress event
    //phone-number validation
    jQuery("#phone-number").keypress(function(ev){
    var x = $(this).val();
    if (ev.keyCode < 48 || ev.keyCode > 57) {
      ev.preventDefault();
        }
    });
    
    jQuery("#phone-number").onblur(function(ev){
        var x = $(this).val();
        var num = this.substring(0, 3);
        if (num != '054' && num != '024'){
            alert('Phone number is invalid.');
        }
    });
    
    //first-name validation
    jQuery("#first-name").keypress(function(ev){
        var x = $(this).val();
        if ((ev.keyCode < 65 || ev.keyCode > 90) && (ev.keyCode < 97 || ev.keyCode > 122 )){
            ev.preventDefault();
        }
    });
    
    //last-name validation
    jQuery("#last-name").keypress(function(ev){
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