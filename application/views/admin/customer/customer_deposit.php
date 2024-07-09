<?php include(APPPATH."views/admin/common/header.php"); ?>
<style>
    /*.table .thead-dark th {
        font-size: 14px;
    }*/
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
                        <strong class="card-title">Customer Deposit</strong>
                    </div>
                    <div class="card-body">
                       <table id="data-table" class="table table-striped table-bordered">
                            <thead class="thead-dark">
                            <tr role="row">
                                <th>#</th>
                                <th>User Name</th>
                                <th>Club Name</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Rate</th>
                                <th>Coin</th>
                                <th>Method</th>
                                <th>Transaction No.</th>
                                <th>Customer Acc</th>
                                <th>Admin Acc</th>
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

<!--deposit approved modal-->

<div id="open-modal" class="modal-window">
	<div>
		<a title="Close" class="modal-close close">close &times;</a>

		<div class="card">
			<div class="card-header">
				<strong class="card-title" onclick="zero_click_dp();">Approve Deposit</strong>
			</div>
			<div class="card-body">
				<!-- Credit Card -->
				<div id="pay-invoice">
					<div class="card-body">

						<form id="#deposit_aprv_form" method="post" accept-charset="utf-8" action="<?php echo base_url('approve_deposit'); ?>">
							<input id="deposit_id" type="hidden" name="deposit_id">
							<!--<input name="submit" id="submit" value="Submit" type="hidden">-->
							<div class="form-group">
								<label for="status" class="control-label mb-1">Select status</label>
								<select required name="status" id="status" class="form-control deposit-status">
									<option value="">--- select ---</option>
									<option value="SUCCESS">Success</option>
									<option value="CANCEL">Cancel</option>
								</select>
							</div>
							<div id="send-coin" class="form-group">
								<label for="status" class="control-label mb-1">Send Coin</label>
								<input id="coin" type="text" name="coin" class="form-control">
								<input id="dpcoin" type="hidden" value="" name="dpcoin" class="form-control">
							</div>
							<div>
								<input type="submit" name="submit" id="submit" class="btn btn-lg btn-info btn-block" value="Submit">
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

	function approve_diposit(id,coin,dp,status) {
		// window.location.href="#open-modal";
		$("#open-modal").fadeIn();
		$("#deposit_id").val(id);
		$("#coin").val(coin);
		$("#dpcoin").val(dp);
	}

	function zero_click_dp() {
		$("#dpcoin").val('0');
	}
	
	$('#submit').on('click', function() {
        $("#open-modal").fadeOut();
    });

	$('#deposit_aprv_form').submit(function (e) {
		e.preventDefault();
		$("#open-modal").fadeOut();
// 		$.ajax({
// 			type: 'POST',
// 			url: "<?php //echo base_url('approve_deposit'); ?>",
// 			data: $(this).serialize(),
// 			dataType: 'json',
// 		}).done(function (data) {
// 			if (data.st == 200) {
// 				swal(
// 					{
// 						title: data.msg,
// 						type: "success",
// 						timer:1500,
// 						confirmButtonText: "Done",
// 					});
// 				$("#open-modal").fadeOut();
// 				$("#deposit_id").val("");
// 				$("#coin").val("");
// 				$('#data-table').DataTable().destroy();
// 				fetch_data('PENDING');
// 				return;
// 			}
// 		});
	});

	function del_deposit(id) {
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
						url: "<?php echo base_url('admin/remove_deposit'); ?>",
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
				url: base_url+"admin/customer_deposit_dt",
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
