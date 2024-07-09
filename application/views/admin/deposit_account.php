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
						<strong class="card-title">Admin Deposit Account</strong>
						<div class="float-right">
							<a data-toggle="modal" data-target="#scrollmodal" style="font-size: 13px;color:#fff" class="btn btn-success btn-sm">Add New</a>
						</div>
					</div>
					<div class="card-body">
						<table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead class="thead-dark">
                            <tr>
                                <th>Account Name</th>
                                <th>Account Number</th>
                                <th>Status</th>
                                <th>Created at</th>
                                <th>Change Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach($get_data as $val) : ?>
                                    <tr>
                                        <td><?= $val->account_name; ?></td>
                                        <td><?= $val->account_no; ?></td>
                                        <td>
                                            <?php
                                                if($val->status == 1) {
                                                    echo 'Active';
                                                }else if($val->status == 3) {
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
                                                <a onclick="return confirm('Are you sure change this status?');"  href="<?= base_url('admin/account_inactive_status/'.$val->id); ?>"><i style="color:green" class="fa fa-check icon-delete"></i></a>
                                            
                                            <?php elseif($val->status == 0) : ?>
                                                <a onclick="return confirm('Are you sure change this status?');"  href="<?= base_url('admin/account_active_status/'.$val->id); ?>"><i class="fa fa-times icon-delete"></i></a>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a onclick="return confirm('Are you sure to remove this account?');" title="Delete Deposit Account" href="<?= base_url('admin/remove_deposit_account/'.$val->id); ?>"><i class="fa fa-trash icon-delete"></i></a>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


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
										<strong class="card-title">Add Account</strong>
									</div>
									<div class="card-body">
										<!-- Credit Card -->
										<div id="pay-invoice">
											<div class="card-body">

												<form action="<?php echo base_url('admin/add_deposit_account'); ?>" method="POST">

													<div class="form-group">
														<label for="match_status" class="control-label mb-1">Account Name</label>
														<input type="text" name="account_name" class="form-control">
													</div>

													<div class="form-group">
														<label for="match_status" class="control-label mb-1">Account Number</label>
														<input type="text" name="account_no" class="form-control">
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
			</div>
		</div>
	</div>
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
