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
                        <strong class="card-title">Customer Balance Transfer</strong>
                    </div>
                    <div class="card-body">
						<table id="data-table" class="table table-striped table-bordered">
                            <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Transferred To</th>
                                <th>Amount</th>
                                <th>Transferred By</th>
                                <th>Date</th>
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

<script>
	fetch_data();
	function fetch_data()
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
				url: base_url+"admin/customer_balance_transfer_dt",
				type: "POST"
			},
			drawCallback:function (settings)
			{

			}
		});
	}
</script>
