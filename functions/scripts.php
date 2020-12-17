<?php    
  	$count = 1; //counter for table rows
							$search_parameter = $_POST['searchtxt'];
							$sql_get = "SELECT `name`, `phoneno`, `application_no`, `project_type` ,`location`, `datecreated` FROM `applications` WHERE `name` ='".$search_parameter."'";
							$filter = mysqli_query($connect_db, $sql_get);
							$result1 = $connect_db->query($sql_get);
						if($result1->num_rows > 0){
							while($row = $result1->fetch_assoc())
						{
						?>

					<tr>
							<td><?php echo $count; ?></td>
							<td><?php echo ($row['name']); ?></td>
							<td><?php echo $row['phoneno']; ?></td>
							<td><?php echo $row['application_no']; ?></td>
							<td ><?php echo $row['project_type']; ?></td>
							<td><?php 
							//get locality name by binding with id param
						$getSiteLocality=mysqli_query($connect_db, "select loc_name from locality where id='".$result1["location"]."'");
						$result = mysqli_fetch_array($getSiteLocality);
						//fetch corresponding data
						 if(empty($result['loc_name'])) echo "Invalid Location"; else
                    	echo $result['loc_name']; ?></td>
							<td><?php echo (date('d M, Y', strtotime($row['datecreated']))); ?></td>
						</tr>
						<?php
						$cnt=$count+1;        
					}
								} 
					else{
							echo "<script>alert('The name you entered does not match any record in the system');window.location='search-applications.php'</script>";
						}
											
									}

    
   // preloader plugin js 
    <!-- ============================================================== -->
    <script>
    $('[data-toggle="tooltip"]').tooltip();
    $(".preloader").fadeOut();

    // ============================================================== 
    // Login and Recover Password animation
    // ============================================================== 
    $('#to-recover').on("click", function() {
        $("#loginform").slideUp();
        $("#recoverform").fadeIn();
    });
    $('#to-login').click(function(){
        
        $("#recoverform").hide();
        $("#loginform").fadeIn();
    });
    </script>
        
      //check phone-number format
    jQuery("#defaultForm").on("submit", function){
        var x = $(this).val();
        var strPhone = $(this).value.substring(0,3);
        if((strPhone != '024') && (strPhone != '054')){
            alert ("Phone number is invalid..");
        }
    };
 ?>
