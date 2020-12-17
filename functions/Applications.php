<?php 
require_once ("../functions/databaseController.php");

class Applications {
    private $db_handle;
    
    //constructor of the database controller class
    function __construct() {
        $this->db_handle = new databaseController();
    }
    
    //this function to add new application record
    function addApplication($name, $gender, $phone, $town, $occupation, $contactname, $contactnumber, $location, $project, $date, $app_number, $creatdby, $status, $landuse_id, $category_id) {
        $query = "INSERT INTO applications (name,gender,phoneno,town,occupation,contactname,contactnumber,location,project_type,datecreated,application_no,createdby,status,landuse_id,category_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $paramType = "sssssssssssssii";
        $paramValue = array(
            strtoupper($name),
            $gender,
            $phone,
            ucwords($town),
            ucwords($occupation),
            strtoupper($contactname),
            $contactnumber,
            $location,
            strtoupper($project),
            $date,
            $app_number,
            $creatdby,
            $status,
            $landuse_id,
            $category_id
        );
        
        $insertId = $this->db_handle->insert($query, $paramType, $paramValue);
        return $insertId;
    }
    
    //this function triggers to edit application record
    function editApplication($name, $gender, $number, $town, $occupation, $contactname, $contactnumber, $location, $project, $application_id, $landuse_id) {
        $query = "UPDATE applications SET name = ?,gender = ?,phoneno = ?,town = ?, occupation = ?,contactname = ?,contactnumber = ?,location = ?,project_type = ?, WHERE applicationid = ?";
        $paramType = "sssssssssi";
        $paramValue = array(
            strtoupper($name),
            $gender,
            $number,
            ucwords($town),
            ucwords($occupation),
            strtoupper($contactname),
            $contactnumber,
            $location,
            strtoupper($project),
            $application_id
        );
        
        $this->db_handle->update($query, $paramType, $paramValue);
    }
    
    //funtion defer application
    function deferApplication($applicationID){
        $query = "UPDATE applications SET status='Deferred' WHERE applicationid = ?";
        $paramType = "i";
        $paramValue = array(
            $applicationID
        );
        $this->db_handle->update($query, $paramType, $paramValue);
    }
    
    //funtion review application
	//set application status to '-New-'
    function reviewApplication($applicationID){
        $query = "UPDATE applications SET status='New' WHERE applicationid = ?";
        $paramType = "i";
        $paramValue = array(
            $applicationID
        );
        $this->db_handle->update($query, $paramType, $paramValue);
    } 
    
    //funtion re-activate application
    function activateApplication($applicationID){
        $query = "UPDATE applications SET status='New' WHERE applicationid = ?";
        $paramType = "i";
        $paramValue = array(
            $applicationID
        );
        $this->db_handle->update($query, $paramType, $paramValue);
    }
    
    //funtion defer application
    function processApplication($applicationID){
        $query = "UPDATE applications SET status='Submitted' WHERE applicationid = ?";
        $paramType = "i";
        $paramValue = array(
            $applicationID
        );
        $this->db_handle->update($query, $paramType, $paramValue);
    }
    
    //funtion approve application
    function approveApplication($applicationID){
        $query = "UPDATE applications SET status='Approved' WHERE applicationid = ?";
        $paramType = "i";
        $paramValue = array(
            $applicationID
        );
        $this->db_handle->update($query, $paramType, $paramValue);
    }
    
	//funtion permit application
	//change application status to granted
    function grantPermit($applicationID){
        $query = "UPDATE applications SET status='Granted' WHERE applicationid = ?";
        $paramType = "i";
        $paramValue = array(
            $applicationID
        );
        $this->db_handle->update($query, $paramType, $paramValue);
    }
    
    //function delete application by id{primary key}
    function deleteApplication($application_id) {
        $query = "DELETE FROM `applications` WHERE applicationid = ?";
        $paramType = "i";
        $paramValue = array(
            $application_id
        );
        $this->db_handle->update($query, $paramType, $paramValue);
    }
    
    //function to delete application record by application number
    function deleteApplicationByNumber($application_number) {
        $query = "DELETE FROM applications WHERE application_no = ?";
        $paramType = "s";
        $paramValue = array(
            $application_number
        );
        $this->db_handle->update($query, $paramType, $paramValue);
    }
    
    //get application by id:primary_key
    function getApplicationByID($application_id) {    
        $query = "SELECT * FROM applications WHERE applicationid = ?";
        $paramType = "s";
        $paramValue = array(
            $application_id
        );
        
        $result = $this->db_handle->runQuery($query, $paramType, $paramValue);
      
		return $result;
    }
    
	//get application by name of created user 
    function getApplicationByCreatedUser($created_user) {    
        $query = "SELECT * FROM `applications` WHERE `createdby` = ?";
        $paramType = "s";
        $paramValue = array(
            $created_user
        );
        
        $result = $this->db_handle->runQuery($query, $paramType, $paramValue);
        return $result;
    }
       

    //get all applications, group by date encoded
    function getApplications() {
        $sql = "SELECT * FROM applications GROUP BY datecreated ASC ORDER BY datecreated ASC";
        $result = $this->db_handle->runBaseQuery($sql);
        return $result;
    }
    
    //function delete application by id{primary key}
    function addAppFiles($application_id, $check_id) {
        $query = "INSERT INTO app_processes (app_id,check_id,dateEncode) VALUES (?, ?, CURRENT_TIMESTAMP)";
        $paramType = "ii";
        $paramValue = array(
            $application_id,
            $check_id
        );
       $insertId = $this->db_handle->insert($query, $paramType, $paramValue);
        return $insertId;
    }
    
}
?>