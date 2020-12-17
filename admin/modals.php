       
<!--Modal: edit permit application-->
       <div class="modal fade" id="edit<?php echo $last['applicationid']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" arial-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="">Edit Application Details</h4>
                    </div>
                    <div class="modal-body">
                       <?php 
                        //query select record based on unique id
                        $edit_sql = mysqli_query($connect_db, "select * from applications where applicationid='".$last['applicationid']."'");
                        $edit_res = mysqli_fetch_array($edit_sql);
                        ?>
                        <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>

                                    </thead>
                                   <tbody>
                                      <tr>
                                            <td>ID: </td>
                                            <td class="text-danger"><?php echo $edit_res['applicationid']; ?></td>
                                        </tr>
                                       <tr>
                                            <td>Applicant Name: </td>
                                            <td>
                                               <div class="form-group">
                                                <input type="text" class="form-control" value="<?php echo $edit_res['name']; ?>" name="name" id="name">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Gender:</td>
                                            <td></td>
                                        </tr>
                                         <!--item data usertype-->
                                       <tr>
                                            <td>Mobile No: </td>
                                            <td>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Status:</td>
                                            <td><?=$status?></td>
                                        </tr>
                                         <!--item data registration date-->
                                       <tr>
                                            <td>Registration Date: </td>
                                            <td><?=$regdate?></td>
                                        </tr>
                                   </tbody>
                                </table>
                            </div>
                            
                    </div>  
                    <div class="modal-footer">
                        <a href=""><button type="button" class="btn btn-primary update" ><i class="fa fa-plus-circle"></i> Update</button></a>
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                    </div> 
                </div>
            </div>        
    </div>
      <!--end this modal-->
      
      
       