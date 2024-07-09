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
                        <strong class="card-title">Club Withdraw</strong>
                    </div>
                    <div class="card-body">
						<table id="data-table" class="table table-striped table-bordered">
                            <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Club Name</th>
                                <th>Date/Time</th>
                                <th>Account Number</th>
                                <th>Amount</th>
                                <th>Method</th>
                                <th>Type</th>
                                <th>From No</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <label class="label-succes"></label>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--withdraw approved modal-->

<div id="open-modal" class="modal-window">
	<div>
		<a title="Close" class="modal-close close">close &times;</a>

		<div class="card">
			<div class="card-header">
				<strong class="card-title">Approve Club Withdraw</strong>
			</div>
			<div class="card-body">
				<!-- Credit Card -->
				<div id="pay-invoice">
					<div class="card-body">
						<form id="withdraw_aprv_form">
							<input id="withdraw_id" type="hidden" name="withdraw_id">
							<input name="submit" id="submit" value="Submit" type="hidden">
							<div class="form-group">
								<label for="status" class="control-label mb-1">Select status</label>
								<select required name="status" id="status" class="form-control deposit-status">
									<option value="">--- select ---</option>
									<option value="SUCCESS">Success</option>
									<option value="CANCEL">Cancel</option>
								</select>
							</div>
							<div id="send-coin" class="form-group">
								<label for="status" class="control-label mb-1">Send From</label>
								<input id="coin" type="hidden" name="coin" class="form-control">
								<input id="from_no" type="text" name="from_no" class="form-control">
							</div>
							<div>
								<input type="submit" class="btn btn-lg btn-info btn-block" value="Submit">
							</div>
						</form>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>



<?php include(APPPATH."views/admin/common/footer.php"); ?>
<script type="text/javascript">

	$(document).on('show.bs.modal', function (e) {
		$('body').css('padding-right', '0px');
	});

	function approve_withdraw(id,coin,status) {
		// window.location.href="#open-modal";
		$("#open-modal").fadeIn();
		$("#withdraw_id").val(id);
		$("#coin").val(coin);
	}

	$('#withdraw_aprv_form').submit(function (e) {
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: "<?php echo base_url('approve_club_withdraw'); ?>",
			data: $(this).serialize(),
			dataType: 'json',
		}).done(function (data) {
			if (data.st == 200) {
				swal(
					{
						title: data.msg,
						type: "success",
						timer:1500,
						confirmButtonText: "Done",
					});
				$("#open-modal").fadeOut();
				$("#withdraw_id").val("");
				$("#coin").val("");
				$('#data-table').DataTable().destroy();
				fetch_data('PENDING');
				return;
			}
		});
	});

	function del_withdraw(id) {
		swal(
			{
				title: "Are you sure to delete?",
				type: "warning",
				confirmButtonText: "Yes!",
				showCancelButton: true,
			}, function (isConfirm) {
				if (isConfirm) {
					$.ajax({
						type: 'POST',
						url: "<?php echo base_url('admin/club_remove_withdraw'); ?>",
						data: {id:id},
						dataType: 'json',// getting filed value in serialize form
					}).done(function (data) {
						if (data.st==200){
							swal({
								title: data.msg,
								type: "success",
								confirmButtonText: "Done",
								timer:1500
							});
							$('#data-table').DataTable().destroy();
							fetch_data('PENDING');
						}
					});
				}
			}
		);
	}

</script>
<script>
	fetch_data('PENDING');
	function fetch_data(status)
	{
		var base_url = '<?php echo base_url()?>';
		let dataTable;
		dataTable = $('#data-table').DataTable({
			"footerCallback": function () {
				let api = this.api(), data;
			},
			'bProcessing': true,
			"serverSide": true,
			searchHighlight: true,
			"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
			"columnDefs": [
				{"className": "dt-center", "targets": "_all","orderable": false}
			],
			"order": [],
			oLanguage: {sProcessing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'},
			"ajax": {
				url: base_url+"admin/club_withdraw_dt",
				type: "POST",
				data: {
					status: status
				}
			},
			drawCallback:function (settings)
			{

			}
		});
	}
</script>
