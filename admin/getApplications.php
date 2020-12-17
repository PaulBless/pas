<?php
session_start();
require_once ("../functions/db_connection.php");

if (! (isset($_GET['pageNumber']))) {
    $pageNumber = 1;
} else {
    $pageNumber = $_GET['pageNumber'];
}


$perPageCount = 10; //pagecount
//$name = $_SESSION['name'];

//$sql = "SELECT * FROM applications WHERE createdby={$_SESSION['name']}";
$sql = "SELECT * FROM  applications WHERE 1";

if ($result = mysqli_query($connect_db, $sql)) {
    $rowCount = mysqli_num_rows($result);
    mysqli_free_result($result);
}

$pagesCount = ceil($rowCount / $perPageCount);  //number of pages

$lowerLimit = ($pageNumber - 1) * $perPageCount;

$sqlQuery = " SELECT * FROM applications WHERE 1 limit " . ($lowerLimit) . " ,  " . ($perPageCount) . " ";
$results = mysqli_query($connect_db, $sqlQuery);

$cnt=1; //counter for serial nos
$i=0;
$start_num =((($pageNumber*$perPageCount)-$perPageCount)+1);
?>


<table class="table table-hover table-responsive">
    <tr>
<!--       <th align="center">No.</th>-->
<!--        <th align="center">App ID</th>-->
        <th align="center">Name</th>
        <th align="center">Gender<br></th>
        <th align="center">Phone Number</th>
        <th align="center">Town</th>
        <th align="center">Occupation</th>
        <th align="center">Contact Name</th>
        <th align="center">Contact Number</th>
        <th align="center">Site Location</th>
        <th align="center">Project Name</th>
        <th align="center">Application ID</th>
        <th align="center">Actions</th>
    </tr>
    <?php foreach ($results as $data) 
//    $slNo = $i+$start_num;
    { ?>
    <tr>
<!--       <td align="left"><?php //echo $cnt++;?></td>-->
<!--        <td align="left"><?php //echo $data['applicationid'] ?></td>-->
        <td align="left"><?php echo $data['name'] ?></td>
        <td align="left"><?php echo $data['gender'] ?></td>
        <td align="left"><?php echo $data['phoneno'] ?></td>
        <td align="left"><?php echo $data['town'] ?></td>
        <td align="left"><?php echo $data['occupation'] ?></td>
        <td align="left"><?php echo $data['contactname'] ?></td>
        <td align="left"><?php echo $data['contactnumber'] ?></td>
        <td align="left"><?php echo $data['location'] ?></td>
        <td align="left"><?php echo $data['project_type'] ?></td>
        <td align="left"><?php echo $data['application_no'] ?></td>
        <td>
           <!--process dta button-->
            <button id="update" type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-keyboard="false" data-backdrop="static" data-target="#updateApp" data-id="<?=$data['applicationid'];?>" data-name="<?=$data['name'];?>" data-gender="<?=$data['gender'];?>" data-phone="<?=$data['phoneno'];?>" data-town="<?=$data['town'];?>" data-location="<?=$data['location'];?>" data-project="<?=$data['project_type'];?>" data-appno="<?=$data['application_no'];?>"> Process</button>
            <!--button-->
        </td>
    </tr>
    <?php
//    $cnt +=1;
    }
    
    ?>
</table>

<div style="height: 30px;"></div>
<table width="50%" align="center">
    <tr>

        <td valign="top" align="left"></td>


        <td valign="top" align="center">
 
	<?php
	for ($i = 1; $i <= $pagesCount; $i ++) {
    if ($i == $pageNumber) {
        ?>
	      <a href="javascript:void(0);" class="current"><?php echo $i ?></a>
<?php
    } else {
        ?>
	      <a href="javascript:void(0);" class="pages"
            onclick="showRecords('<?php echo $perPageCount;  ?>', '<?php echo $i; ?>');"> <?php echo $i ?></a>
<?php
    } // endIf
    } // endFor

?>
</td>
    <td align="right" valign="top">
    Page <?php echo $pageNumber; ?> of <?php echo $pagesCount; ?>
	</td>
    </tr>
</table>