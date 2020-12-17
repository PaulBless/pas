<?php
session_start();
//include db connection file
include '../functions/db_connection.php';

// get full applications-->
<?php 
    //if (! (isset($_GET['pageNumber']))) {
//    $pageNumber = 1;
//} else {
//    $pageNumber = $_GET['pageNumber'];
//}
//
//$perPageCount = 5;
//
//$sql = "SELECT * FROM users_account  WHERE 1";
//
//if ($result = mysqli_query($connect_db, $sql)) {
//    $rowCount = mysqli_num_rows($result);
//    mysqli_free_result($result);
//}
//
//$pagesCount = ceil($rowCount / $perPageCount);
//
//$lowerLimit = ($pageNumber - 1) * $perPageCount;
//
//$sqlQuery = " SELECT * FROM users_account WHERE 1 limit " . ($lowerLimit) . " ,  " . ($perPageCount) . " ";
//$results = mysqli_query($connect_db, $sqlQuery);

?>

<table class="table table-stripped table-hover table-responsive">
<!--
    <tr>
        <th align="center">Full Name</th>
        <th align="center">Mobile Number</th>
        <th align="center">Email ID</th>
        <th align="center">Department</th>
        <th align="center">Username</th>
        <th align="center">Password</th>
        <th align="center">Role</th>
        <th align="center">Status</th>
    </tr>
-->
    <?php // foreach ($results as $data) { ?>
<!--
    <tr>
        <td align="left"><?php // echo $data['fullname'] ?></td>
        <td align="left"><?php  //echo $data['mobileno'] ?></td>
        <td align="left"><?php //echo $data['email'] ?></td>
        <td align="left"><?php //echo $data['department_name'] ?></td>
        <td align="left"><?php //echo $data['username'] ?></td>
        <td align="left"><?php //echo $data['password'] ?></td>
        <td align="left"><?php //echo $data['role'] ?></td>
        <td align="left"><?php //echo $data['status'] ?></td>

    </tr>
-->
    <?php
    }
    ?>
</table>

<div style="height: 30px;"></div>
<table width="50%" align="center">
    <tr>

        <td valign="top" align="left"></td>


        <td valign="top" align="center">
 
	<?php
	//for ($i = 1; $i <= $pagesCount; $i ++) {
    //if ($i == $pageNumber) {
        ?>
	      <a href="javascript:void(0);" class="current"><?php //echo $i ?></a>
<?php
    //} else {
        ?>
	      <a href="javascript:void(0);" class="pages"
            onclick="showRecords('<?php echo $perPageCount;  ?>', '<?php echo $i; ?>');"><?php //echo $i ?></a>
<?php
    } // endIf
} // endFor

?>
</td>
        <td align="right" valign="top">
	     Page <?php //echo $pageNumber; ?> of <?php //echo $pagesCount; ?>
	</td>
    </tr>
</table>

?>