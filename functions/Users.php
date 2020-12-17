<?php 
require_once ("databaseController.php");

class Users
{
    private $db_handle;
    
    function __construct() {
        $this->db_handle = new databaseController();
    }
    
      //check if account exists
    function checkAccount($name, $username){
        $query = "SELECT * FROM users_account WHERE fullname = ? OR username = ?";
        $paramType = "ss";
        $paramValue = array(
        $name,
        $username
        );
        $result = $this->db_handle->runquery($query, $paramType, $paramValue);
        return $result;
    }
    
    function addUser($name, $phone, $email, $department, $username, $password, $role, $status, $regdate) {
        $query = "INSERT INTO users_account (fullname,mobileno,email,department_name, username, password,role,status,regdate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $paramType = "sssssssss";
        $paramValue = array(
            strtoupper($name),
            $phone,
            $email,
            $department,
            $username,
            $password,
            $role,
            $status,
            $regdate
        );
        
        $insertId = $this->db_handle->insert($query, $paramType, $paramValue);
        return $insertId;
    }
    
    //change account state
    function changeAccountState($status, $userid){
        $query = "UPDATE users_account SET status=? WHERE userid=?"  ;
        $paramType = "si";
        $paramValue = array(
        $status,
        $userid
        );
    }
    
    //update users account info
    function updateProfile($name, $phone, $email, $username,  $userid) {
        $query = "UPDATE users_account SET fullname = ?,mobileno = ?,email = ?,username WHERE userid = ?";
        $paramType = "ssssi";
        $paramValue = array(
            $name,
            $phone,
            $email,
            $username,
            $userid
        );
        
        $this->db_handle->update($query, $paramType, $paramValue);
    }
    
    //function to trigger user account password change
    function changePassword($password, $userid){
        $query = "UPDATE users_account SET password = ? WHERE userid = ?";
        $paramType = "si";
        $paramValue = array(
            $password,
            $userid
        );
        $this->db_handle->update($query, $paramType, $paramValue);
    }
    
    //function to lock user account
    function lockAccount($userid){
        $query = "UPDATE users_account SET status ='Locked' WHERE userid = ?";
        $paramType = "i";
        $paramValue = array(
            $userid
        );
        $this->db_handle->update($query, $paramType, $paramValue);
    } 
	
	//function to unlock(reactivate) user account
    function unlockAccount($userid){
        $query = "UPDATE users_account SET status ='Active' WHERE userid = ?";
        $paramType = "i";
        $paramValue = array(
            $userid
        );
        $this->db_handle->update($query, $paramType, $paramValue);
    }
    
    //delete user
    function deleteUser($userid) {
        $query = "DELETE FROM users_account WHERE userid = ?";
        $paramType = "i";
        $paramValue = array(
        $userid
        );
        $this->db_handle->update($query, $paramType, $paramValue);
    }
    
    //get user by id
    function getUserById($user_id) {
        $query = "SELECT * FROM users_account WHERE userid = ?";
        $paramType = "i";
        $paramValue = array(
            $user_id
        );
        
        $result = $this->db_handle->runQuery($query, $paramType, $paramValue);
        return $result;
    }
    
    //get all users
    function getAllUsers() {
        $sql = "SELECT * FROM users_account ORDER BY userid";
        $result = $this->db_handle->runBaseQuery($sql);
        return $result;
    }
}
?>