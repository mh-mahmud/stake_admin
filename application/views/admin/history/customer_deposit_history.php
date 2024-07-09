<?php include(APPPATH."views/admin/common/header.php"); ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
                        <strong class="card-title">Customer Deposit History</strong>
                    </div>
                    <div class="card-body">
						<table id="data-table" class="table table-striped table-bordered" style="width: 100%">
							<thead class="thead-dark">
                            <tr>
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

    function approve_diposit(id,coin,status) {
    	swal(
			{
				title: "Are you want sure to "+status,
				text: status+ " Coin value "+coin,
				type: "input",
				confirmButtonColor: '#3ca7f5',
				showCancelButton: true,
				closeOnConfirm: false,
				animation: "slide-from-top",
				inputValue: coin
			}, function (inputCoin) {
			    
				if (inputCoin === false) return false;
				if (inputCoin === "") {
					swal.showInputError("You need to give coin value!");
					return false;
				}
				else{
				    swal.close();
					$.ajax({
						type: 'POST',
						url: "<?php echo base_url('approve_deposit'); ?>",
						data: {submit:'Submit',coin: inputCoin,deposit_id:id,status:status},
						 
					}).done(function (result) {
				// 		if (result.st==200){
				// 			swal({
				// 				title: result.msg,
				// 				type: "success",
				// 				timer: 1500,
				// 				confirmButtonColor: '#3ca7f5',
				// 				animation: "slide-from-top"
				// 			});
							
				// 		}
				
						swal({
							title: "Update Deposit",
							type: "success",
							timer: 1500,
							confirmButtonColor: '#3ca7f5',
							animation: "slide-from-top"
						});
				        
						$('#data-table').DataTable().destroy();
						fetch_data("SUCCESS','CANCEL");
					});
				}
			}
		);
	}

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
							fetch_data("SUCCESS','CANCEL");
						}
					});
				}
			}
		);
	}

</script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $( ".datepicker" ).datepicker();
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
