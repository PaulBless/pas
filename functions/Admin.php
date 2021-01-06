<?php 
require_once ("../functions/databaseController.php");

class Admin
{
    private $db_handle;
    
    function __construct() {
        $this->db_handle = new databaseController();
    }
    
    //check if account exists
    function checkAccount($name, $username){
        $query = "SELECT fullname, username FROM admin_account WHERE fullname = ? OR username = ?";
        $paramType = "ss";
        $paramValue = array(
        $name,
        $username
        );
        $result = $this->db_handle->runQuery($query, $paramType, $paramValue);
        return $result;
    }
    
    //add admin account
    function addAdmin($name, $phone, $email, $username, $password, $status, $regdate) {
        $query = "INSERT INTO admin_account (fullname,mobileno,email, username,password,status,regdate) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $paramType = "sssssss";
        $paramValue = array(
            ucwords($name),
            $phone,
            $email,
            $username,
            $password,
            $status,
            $regdate
        );   
        $insertId = $this->db_handle->insert($query, $paramType, $paramValue);
        return $insertId;
    }
    
    //change account state
    function changeAccountState($status, $adminid){
        $query = "UPDATE admin_account SET status=? WHERE adminid=?"  ;
        $paramType = "si";
        $paramValue = array(
        $status,
        $adminid
        );
        $this->db_handle->update($query, $paramType, $paramValue);
    }
    
    //update users account info
    function updateProfile($name, $phone, $email, $username, $adminid) {
        $query = "UPDATE `admin_account` SET fullname = ?,mobileno = ?,email = ?,username = ? WHERE adminid = ?";
        $paramType = "ssssi";
        $paramValue = array(
            $name,
            $phone,
            $email,
            $username,
            $adminid
        );
        
        $this->db_handle->update($query, $paramType, $paramValue);
    }
    
    //function to trigger admin account password change
    function changePassword($password, $adminid){
        $query = "UPDATE `admin_account` SET password = ? WHERE adminid = ?";
        $paramType = "si";
        $paramValue = array(
            $password,
            $adminid
        );
        $this->db_handle->update($query, $paramType, $paramValue);
    }
    
    //delete accout
    function deleteAdmin($adminid) {
        $query = "DELETE FROM admin_account WHERE adminid = ?";
        $paramType = "i";
        $paramValue = array(
            $adminid
        );
        $this->db_handle->update($query, $paramType, $paramValue);
    }
    
    //get admin by adminid
    function getAdminById($adminid) {
        $query = "SELECT * FROM admin_account WHERE adminid = ?";
        $paramType = "i";
        $paramValue = array(
            $adminid
        );
        
        $result = $this->db_handle->runQuery($query, $paramType, $paramValue);
        return $result;
    }
    
    //get admin login details
    function getLoginDetails($username){
        $query = "SELECT adminid,password FROM admin_account WHERE username = ?";
        $paramType = "s";
        $paramValue = array(
        $username);
        $result = $this->db_handle->runQuery($query, $paramType, $paramValue);
        return $result;
    }
    
    //fetch all admin account records
    function getAllAdmin() {
        $sql = "SELECT * FROM admin_account ORDER BY adminid";
        $result = $this->db_handle->runBaseQuery($sql);
        return $result;
    }
}

?>