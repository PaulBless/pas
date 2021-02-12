<?php 


session_start();
error_reporting(E_ALL ^ E_NOTICE);

include '../functions/db_connection.php';
include '../functions/databaseController.php';
include '../functions/Admin.php';

$db_handle = new databaseController();

## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value


## Search 
$searchQuery = " ";
if($searchValue != ''){
	$searchQuery = " and (name like '%".$searchValue."%' or 
        application_no like '%".$searchValue."%' or 
        phoneno like'%".$searchValue."%' ) ";
}

## Total number of records without filtering
$sel = mysqli_query($connect_db,"select count(*) as allcount from applications");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel = mysqli_query($connect_db,"select count(*) as allcount from applications WHERE 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$appQuery = "select * from applications WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
$appRecords=mysqli_query($connect_db, $appQuery);
$data = array();

while ($row = mysqli_fetch_assoc($appRecords)) {
    $data[] = array(
    		"name"=>$row['name'],
            "gender"=>$row['gender'],
    		"phoneno"=>$row['phoneno'],
            "town"=>$row['town'],
            "occupation"=>$row['occupation'],
            "contactname"=>$row['contactname'],
            "contactnumber"=>$row['contactnumber'],
    		"location"=>$row['location'],
    		"project_type"=>$row['project_type'],
            "datecreated"=>$row['datecreated'],
    		"application_no"=>$row['application_no'],
            "createdby"=>$row['createdby']
    	);
}

## Response
$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecordwithFilter,
    "aaData" => $data
);

echo json_encode($response);

//end ajax request pull section here


//begin process to lock user account




?>