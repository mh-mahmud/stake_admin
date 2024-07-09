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
                        <strong class="card-title">Club Withdraw History</strong>

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

		<?php include(APPPATH."views/admin/common/footer.php"); ?>

		<script type="text/javascript">

			$(document).on('show.bs.modal', function (e) {
				$('body').css('padding-right', '0px');
			});

			function approve_withdraw(id,coin,status) {
				swal(
					{
						title: "Are you want sure to "+status,
						text: status+ " Coin value "+coin,
						type: "input",
						confirmButtonColor: '#3ca7f5',
						showCancelButton: true,
						closeOnConfirm: false,
						animation: "slide-from-top",
						inputPlaceholder: "Put transaction details"
					}, function (inputCoin) {
						if (inputCoin === false) return false;
						if (inputCoin === "") {
							swal.showInputError("You need to give transaction comment!");
							return false;
						}
						else{
							$.ajax({
								type: 'POST',
								url: "<?php echo base_url('admin/approve_club_withdraw'); ?>",
								data: {submit:'Submit',from_no: inputCoin,withdraw_id:id,status:status},
								dataType: 'json',
							}).done(function (result) {
								if (result.st==200){
									swal({
										title: result.msg,
										type: "success",
										timer: 1500,
										confirmButtonColor: '#3ca7f5',
										animation: "slide-from-top"
									});
									$('#data-table').DataTable().destroy();
									fetch_data("SUCCESS','CANCEL");
								}
							});
						}
					}
				);
			}

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
									fetch_data("SUCCESS','CANCEL");
								}
							});
						}
					}
				);
			}

		</script>

		<script>
			fetch_data("SUCCESS','CANCEL");
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
