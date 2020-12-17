<?php



session_start();
require_once '../functions/db_connection.php';

    if(isset($_POST['btnRegister']))
    {
        //get form data
        $firstname = $_POST['firstName'];
        $lastname = $_POST['lastName'];
        $phonenumber = $_POST['phone'];
        $emailid = $_POST['email'];
        $password = $_POST['password'];
        $username = $_POST['username'];
        $status = 'Active';
        $activity = '';
        $fullname = $firstname. ' '. $lastname; //concatenate firstname and lastname into fullname
        $name = "{$firstname} {$lastname}";
        $regdate = date("Y-m-d H:i:s");
       
        
        //check phone, verify valid mtn, airteltigo, vodafone or glo
        $chk_phone = substr($phonenumber, 0, 3);        
        if($chk_phone != '024' && $chk_phone != '054' && $chk_phone != '055' && $chk_phone != '056' && $chk_phone != '059' && $chk_phone != '027' && $chk_phone != '057' && $chk_phone != '026' && $chk_phone != '050' && $chk_phone != '020' && $chk_phone != '023'){
            echo "<script>alert('The phone number you entered is not valid..')</script>";
        }
        
        if ($stmt = $connect_db->prepare('SELECT adminid, fullname, username FROM admin_account WHERE fullname=? OR username = ?')) {
	   // Bind parameters (s = string, i = int, b = blob, etc), 
        $stmt->bind_param('ss', $fullname, $username); //bind parameters (s=string, i=int, b=blob)
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0){
//            echo 'The name/username exists, please check..';
            echo "<script>alert('The name/username exists, please check..')</script>";
        } else{
//            //register new user
//            $hash_password = password_hash($password, PASSWORD_DEFAULT);
//            $query = "INSERT INTO `admin_account` (`adminid`,`fullname`, `mobileno`, `email`, `username`, `password`, `status`, `regdate`) VALUES ('DEFAULT','$fullname', '$phonenumber', '$emailid', '$username', '$hash_password', '$status', 'DEFAULT')";
//  	         mysqli_query($connect_db, $query);
//            echo "<script>alert('Registration successful. You can login with your passsword and username')</script>";
//            
        if($stmt = $connect_db->prepare('INSERT INTO employee-profile (fullname, mobileno, email, username, password) VALUES (?, ?, ?, ?, ?)'));{
        // hash the password and use password_verify when a user logs in.
        $hash_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt->bind_param('sssss', $fullname, $phonenumber, $emailid, $username, $hash_password);
        $stmt->execute();
         echo "<script>alert('Registration successful. Login now..')</script>";
        } 

        }
    }
     
    }



///////////////////////////////////////////
// process form data: save each checkitem value
if( isset($_POST['btnprocess'], $_POST['checklist'])){
        try{
            
            //first: save processing info; 
            //application checklist attached items
            $sql='insert into `app_processes`  (`appID`, `check_id`, `dateEncode`) values ( :value, :value, CURRENT_TIMESTAMP )';
            $stmt = $connect_db->prepare( $sql );

            if( $stmt ){

                foreach( $_POST['checkitem'] as $index => $value ) {
                    $result = $stmt->execute( [ ':value' => $app_id ], [ ':value' => $value ] );
                    if( !$result ) {
                        throw new Exception( sprintf( 'Failed to execute query %d for %s', $index, $value ) );
                    }
                }

                $connect_db->commit();
                exit();
            }
            
            //second: update application status
            //invoke process method in Applications class
            $objApplication = new Applications();
            $process = $objApplication->processApplication($app_id);
            
            //success message
            echo "<script>alert('Application successfully processed!\\nIt will be evaluated by the Technical Sub-Committee, and Statutory Planning Committee for possible approval.')</script>";
            echo "<script>window.location.href='process-application.php'</script>";
            
        }catch( Exception $e ){
            $conn->rollback();
            exit( $e->getMessage() );
        }
    }

?>