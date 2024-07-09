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
                        <strong class="card-title">Notice Panel</strong>
                        <div class="float-right">
							<a data-toggle="modal" data-target="#scrollmodal" style="font-size: 13px;color:#fff" class="btn btn-success btn-sm">Add New</a>
						</div>
                    </div>
                    <div class="card-body">
						<table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead class="thead-dark">
                            <tr>
                                <th>Notice Details</th>
                                <th>Status</th>
                                <th>Created at</th>
                                <th>Change Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach($get_data as $val) : ?>
                                    <tr>
                                        <td><?= $val->description; ?></td>
                                        <td>
                                            <?php
                                                if($val->status == 1) {
                                                    echo 'Active';
                                                }
                                                else if($val->status == 0) {
                                                    echo 'Inactive';
                                                }
                                            ?>
                                        </td>
                                        <td><?=$val->created_at?></td>
                                        <td>
                                            <?php if($val->status == 1) : ?>
                                                <a onclick="return confirm('Are you sure change this status?');" title="Delete Notice" href="<?= base_url('admin/notice_inactive_status/'.$val->id); ?>"><i style="color:green" class="fa fa-check icon-delete"></i></a>
                                            <?php elseif($val->status == 0) : ?>
                                                <a onclick="return confirm('Are you sure change this status?');" title="Delete Notice" href="<?= base_url('admin/notice_active_status/'.$val->id); ?>"><i class="fa fa-times icon-delete"></i></a>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a
                                            class="notice-modal"
                                            data-id="<?php echo $val->id; ?>"
                                            data-message="<?php echo $val->description; ?>"
                                            data-toggle="modal"
                                            data-target="#scrollmodal2"
                                            title="Edit Notice">
                                                <i style="color:green" class="fa fa-pencil-square-o icon-edit"></i>
                                            </a>

                                            <a onclick="return confirm('Are you sure to remove this notice?');" title="Delete Notice" href="<?= base_url('admin/remove_notice/'.$val->id); ?>"><i class="fa fa-trash icon-delete"></i></a>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>


        <!-- Modal Start -->


        <!-- add notice modal -->
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
                                        <strong class="card-title">Add Notice</strong>
                                    </div>
                                    <div class="card-body">
                                        <!-- Credit Card -->
                                        <div id="pay-invoice">
                                            <div class="card-body">

                                                <form action="<?php echo base_url('admin/add_notice'); ?>" method="POST">

                                                    <div class="form-group">
                                                        <label for="match_status" class="control-label mb-1">Notice Description</label>
                                                        <textarea name="description" class="form-control" rows="6" required></textarea>
                                                    </div>

                                                    <div>
                                                        <input type="submit" class="btn btn-lg btn-info btn-block" name="submit" value="Submit">
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

        <!-- edit notice modal -->
        <div class="modal fade" id="scrollmodal2" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
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
                                        <strong class="card-title">Edit Notice</strong>
                                    </div>
                                    <div class="card-body">
                                        <!-- Credit Card -->
                                        <div id="pay-invoice">
                                            <div class="card-body">

                                                <form action="<?php echo base_url('admin/edit_notice'); ?>" method="POST">
                                                    <input id="notice_id" type="hidden" name="notice_id">

                                                    <div class="form-group">
                                                        <label for="match_status" class="control-label mb-1">Notice Description</label>
                                                        <textarea id="description" name="description" class="form-control" rows="6" required></textarea>
                                                    </div>

                                                    <div>
                                                        <input type="submit" class="btn btn-lg btn-info btn-block" name="submit" value="Submit">
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

    $(document).on('show.bs.modal', function (e) {
        $('body').css('padding-right', '0px');
    });

    $('.notice-modal').on('click', function() {
        var data_id = $(this).attr('data-id');
        var data_message = $(this).attr('data-message');
        $('#notice_id').attr('value', data_id);
        $('textarea#description').val(data_message);
    });

</script>
