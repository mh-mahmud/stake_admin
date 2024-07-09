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
						<strong class="card-title">Customer Complain History</strong>
					</div>
					<div class="card-body">
						<table id="data-table" class="table table-striped table-bordered">
							<thead class="thead-dark">
							<tr>
								<th>#</th>
								<th>Customer Name</th>
								<th>Complain To</th>
								<th>Subject</th>
								<th>Message</th>
								<th>Admin Reply</th>
								<th>Date</th>
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

<!--admin reply modal-->

<div id="open-modal" class="modal-window">
	<div>
		<a title="Close" class="modal-close close">close &times;</a>

		<div class="card">
			<div class="card-header">
				<strong class="card-title">Admin Reply from : <b id="userId"></b></strong>
			</div>
			<div class="card-body">
				<!-- Credit Card -->
				<div id="pay-invoice">
					<div class="card-body">
						<b>Q: </b><p style="text-align: justify" id="question"></p>
						<form action="<?php echo base_url('reply_complain'); ?>" method="POST">
							<input id="complain_id" type="hidden" name="complain_id">

							<div class="form-group">
								<label for="match_status" class="control-label mb-1">Send a reply</label>
								<textarea name="reply" class="form-control" rows="6" required></textarea>
							</div>

							<div>
								<input type="submit" class="btn btn-lg btn-info btn-block" name="submit" value="Submit">
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
    
    $('body').css('padding-right', '0px');
 
	function relpyAns(id,user,question) {
		$("#open-modal").fadeIn();
		$("#userId").html(user);
		$("#complain_id").val(id);
		$("#question").html(question);
	}

</script>

<script>
	fetch_data('all');
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
				url: base_url+"admin/customer_complain_dt",
				type: "POST",
				data: {
					all: status
				}
			},
			drawCallback:function (settings)
			{

			}
		});
	}
</script>
