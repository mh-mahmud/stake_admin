<?php include(APPPATH."views/admin/common/header.php"); ?>
<style>
    .table {
        font-size: 12px;
    }
</style>


<?php include(APPPATH."views/admin/common/flash.php"); ?>

<div class="content">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">Club User</strong>
						<div class="float-right">
							<a data-toggle="modal" data-target="#scrollmodal" style="font-size: 13px;color:#fff" class="btn btn-success btn-sm">Add New</a>
						</div>
                    </div>
                    <div class="card-body">
						<table id="dataTable" class="table table-striped table-bordered">
                            <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Club Name</th>
                                <th>Club Email</th>
                                <th>Club Ratio</th>
                                <th>Show Ratio</th>
                                <th>Club Mobile</th>
                                <th>Serial</th>
                                <th>Club Coin</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <label class="label-succes"></label>
                            <tbody>
                                <?php $i=1; foreach($club_data as $val) : ?>
                                    <tr>
                                        <td><?= $i; ?></td>
                                        <td><?= $val->club_name; ?></td>
                                        <td><?= $val->club_email; ?></td>
                                        <td><?= $val->club_ratio; ?></td>
                                        <td><?= $val->show_ratio; ?></td>
                                        <td><?= $val->club_mobile; ?></td>
										<td><?=$val->serial?></td>
                                        <td><?= get_club_current_balance($val->id); ?></td>
                                        <td>
                                            <?php
                                                if($val->status == 1) {
                                                    echo '<span class="badge badge-success">Active</span>';
                                                } else {
                                                    echo '<span class="badge badge-danger">Inactive</span>';
                                                }
                                            ?>
                                        </td>
                                        <td><?=$val->created_at?></td>
                                        <td>
                                            <a
                                                data-id="<?php echo $val->id; ?>"
                                                data-name="<?php echo $val->club_name; ?>"
                                                data-email="<?php echo $val->club_email; ?>"
                                                data-club_ratio="<?php echo $val->club_ratio; ?>"
                                                data-show_ratio="<?php echo $val->show_ratio; ?>"
                                                data-mobile="<?php echo $val->club_mobile; ?>"
                                                data-serial="<?php echo $val->serial; ?>"
                                                data-status="<?php echo $val->status; ?>"
                                                data-toggle="modal"
                                                class="change-edit-modal"
                                                data-target="#scrollmodal6" title="Edit Club Option">
                                                <i style="color:green" class="fa fa-edit icon-edit"></i>
                                            </a>

                                            <a
                                                data-id="<?php echo $val->id; ?>"
                                                data-toggle="modal"
                                                class="change-password-modal"
                                                data-target="#scrollmodal5" title="Approve Deposit">
                                                <i style="color:green" class="fa fa-cog icon-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php $i++; endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal Start -->

        <!-- create club form -->
        <div class="modal fade" id="scrollmodal" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="container" style="padding-top: 0px">
                            <div class="animated fadeIn">
                                <div class="row">

                                <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">Create Club</strong>
                                    </div>
                                    <div class="card-body">
                                        <!-- Credit Card -->
                                        <div id="pay-invoice">
                                            <div class="card-body">

                                                <form action="<?php echo base_url('admin/post_create_club'); ?>" method="post">
                                                    <div class="form-group has-success">
                                                        <label for="club_name" class="control-label mb-1">Club Name</label>
                                                        <input name="club_name" type="text" class="form-control" required>
                                                    </div>

                                                    <div class="form-group has-success">
                                                        <label for="club_email" class="control-label mb-1">Club Email</label>
                                                        <input name="club_email" type="text" class="form-control" required>
                                                    </div>

                                                    <div class="form-group has-success">
                                                        <label for="club_ratio" class="control-label mb-1">Club Ratio</label>
                                                        <input name="club_ratio" type="text" class="form-control" required>
                                                    </div>

                                                    <div class="form-group has-success">
                                                        <label for="show_ratio" class="control-label mb-1">Show Ratio</label>
                                                        <input name="show_ratio" type="text" class="form-control" required>
                                                    </div>

                                                    <div class="form-group has-success">
                                                        <label for="club_mobile" class="control-label mb-1">Club Phone Number</label>
                                                        <input name="club_mobile" type="text" class="form-control" required>
                                                    </div>

													<div class="form-group has-success">
                                                        <label for="club_serial" class="control-label mb-1">Club Serial</label>
                                                        <input name="club_serial" type="text" class="form-control" required>
                                                    </div>

                                                    <div class="form-group has-success">
                                                        <label for="password" class="control-label mb-1">Password</label>
                                                        <input min="6" name="password" type="password" class="form-control" required>
                                                    </div>
                                                    
                                                    <div>
                                                        <input class="btn btn-lg btn-info btn-block" type="submit" name="submit" value="Submit">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                </div> <!-- .card -->

                            </div><!--/.col-->

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- change password -->
        <div class="modal fade" id="scrollmodal5" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="container" style="padding-top: 0px">
                            <div class="animated fadeIn">
                                <div class="row">

                                <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">Change Password</strong>
                                    </div>
                                    <div class="card-body">
                                        <!-- Credit Card -->
                                        <div id="pay-invoice">
                                            <div class="card-body">

                                                <form action="<?php echo base_url('admin/club_user_change_password'); ?>" method="post">

                                                    <input id="hidden_club_id" type="hidden" name="hidden_club_id">
                                                    <div class="form-group has-success">
                                                        <label for="password" class="control-label mb-1">Password</label>
                                                        <input min="6" name="password" type="password" class="form-control" required>
                                                    </div>
                                                    
                                                    <div>
                                                        <input class="btn btn-lg btn-info btn-block" type="submit" name="submit" value="Submit">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                </div> <!-- .card -->

                            </div><!--/.col-->

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <!-- <button type="button" class="btn btn-primary">Confirm</button> -->
                    </div>
                </div>
            </div>
        </div>

        <!-- edit club -->
        <div class="modal fade" id="scrollmodal6" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="container" style="padding-top: 0px">
                            <div class="animated fadeIn">
                                <div class="row">

                                <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">Edit Club User</strong>
                                    </div>
                                    <div class="card-body">
                                        <!-- Credit Card -->
                                        <div id="pay-invoice">
                                            <div class="card-body">

                                                <form action="<?php echo base_url('admin/post_edit_club'); ?>" method="post">
                                                    <input id="club_id" type="hidden" name="club_id">
                                                    <div class="form-group has-success">
                                                        <label for="club_name" class="control-label mb-1">Club Name</label>
                                                        <input id="club_name" name="club_name" type="text" class="form-control" required>
                                                    </div>

                                                    <div class="form-group has-success">
                                                        <label for="club_email" class="control-label mb-1">Club Email</label>
                                                        <input id="club_email" name="club_email" type="text" class="form-control" required>
                                                    </div>

                                                    <div class="form-group has-success">
                                                        <label for="club_ratio" class="control-label mb-1">Club Ratio</label>
                                                        <input id="club_ratio" name="club_ratio" type="text" class="form-control" required>
                                                    </div>

                                                    <div class="form-group has-success">
                                                        <label for="show_ratio" class="control-label mb-1">Show Ratio</label>
                                                        <input id="show_ratio" name="show_ratio" type="text" class="form-control" required>
                                                    </div>

                                                    <div class="form-group has-success">
                                                        <label for="club_mobile" class="control-label mb-1">Club Phone Number</label>
                                                        <input id="club_mobile" name="club_mobile" type="text" class="form-control" required>
                                                    </div>

													<div class="form-group has-success">
                                                        <label for="club_serial" class="control-label mb-1">Club Serial</label>
                                                        <input id="club_serial" name="club_serial" type="text" class="form-control" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="status" class="control-label mb-1">Select status</label>
                                                        <select id="status" name="status" class="form-control" required>
                                                            <option value="">--- select ---</option>
                                                            <option value="1">Active</option>
                                                            <option value="0">Inactive</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div>
                                                        <input class="btn btn-lg btn-info btn-block" type="submit" name="submit" value="Submit">
                                                    </div>
                                                </form>
                                                
                                            </div>
                                        </div>

                                    </div>
                                </div> <!-- .card -->

                            </div><!--/.col-->

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <!-- <button type="button" class="btn btn-primary">Confirm</button> -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal End -->


    </div><!-- .animated -->
</div>

<?php include(APPPATH."views/admin/common/footer.php"); ?>
<script type="text/javascript">
$(document).ready(function() {
    $("#dataTable").DataTable();
});
    $("#add").on("click", function() {
        $('.option-data:first').clone().appendTo('.add-options');
    });

    $(document).on('show.bs.modal', function (e) {
        $('body').css('padding-right', '0px');        
    });

    $('.change-edit-modal').on('click', function() {
        var data_id = $(this).attr('data-id');
        var sel_id = $(this).attr('data-status');
 
        $('#club_id').val("");
        $('#club_id').val(data_id);
        $('#club_name').val("");
        $('#club_name').val($(this).attr('data-name'));
        $('#club_email').val("");
        $('#club_email').val($(this).attr('data-email'));
        $('#club_ratio').val("");
        $('#club_ratio').val($(this).attr('data-club_ratio')); 
        $('#show_ratio').val("");
        $('#show_ratio').val($(this).attr('data-show_ratio')); 
        $('#club_mobile').val("");
        $('#club_mobile').val($(this).attr('data-mobile'));
        $('#club_serial').val("");
        $('#club_serial').val($(this).attr('data-serial'));
        $('#status').val("");
        $('#status').val(sel_id);
    });

    $('.change-password-modal').on('click', function() {
        var data_id = $(this).attr('data-id');
        $('#hidden_club_id').val("");
        $('#hidden_club_id').val(data_id);
    });

  

    
</script>
