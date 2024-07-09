<?php include(APPPATH . "views/admin/common/header.php"); ?>

<style>
	.table {
		font-size: 12px;
	}
</style>

<div class="content">
	<div class="animated fadeIn">
		<div class="row">

			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<strong class="card-title">Match Bet Coin History</strong>
						<div class="form-inline">
							<b>From: </b><input type="date" class="form-control" value="" name="date1" id="date1">&nbsp;
							<b>To: </b><input type="date" class="form-control" value="" name="date2" id="date2">&nbsp;
							<b>Status:</b><select name="status" id="status" class="form-control">&nbsp;
								<option value="MATCH_RUNNING','WIN','LOST','USER_CANCEL','CANCEL_ADMIN">----select type----</option>
								<option value="MATCH_RUNNING">RUNNING</option>
								<option value="WIN">Winner</option>
								<option value="LOST">Losser</option>
								<option value="USER_CANCEL">User Cancel</option>
								<option value="CANCEL_ADMIN">Admin Cancel</option>
							</select>&nbsp;
							<b>User:</b><input type="text" placeholder="type username here" class="form-control" value="" name="user"
								   id="user">&nbsp;
							<input type="submit" id="search" name="submit" class="btn btn-info" value="Search">
						</div>

					</div>
					<div class="card-body">
						<table id="data-table" class="table table-striped table-bordered">
							<thead class="thead-dark">
							<tr>
								<th>#</th>
								<th>Username</th>
								<th>Match Details</th>
								<th>Match Bit Coin</th>
								<th>Rate</th>
								<th>Return Amount</th>
								<th>Previous Balance</th>
								<th>Current Balance</th>
								<th>Date</th>
								<th>Status</th>
							</tr>
							</thead>
							<label class="label-succes"></label>
							<tbody>

							</tbody>
							<tfoot  class="thead-dark">
								<tr>
									<th colspan="3" style="text-align: right">Total:</th>
									<th id="total_bet"></th>
									<th></th>
									<th id="total_bet_return"></th>
									<th colspan="4"></th>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>


<?php include(APPPATH . "views/admin/common/footer.php"); ?>

<script>
	fetch_data("MATCH_RUNNING','WIN','LOST','USER_CANCEL','CANCEL_ADMIN");

	function fetch_data(status, date1 = '', date2 = '', user = '') {
		var base_url = '<?php echo base_url()?>';
		let dataTable;
		dataTable = $('#data-table').DataTable({
			"footerCallback": function () {
				let api = this.api(), data;
			},
			'bProcessing': true,
			"serverSide": true,
			searchHighlight: true,
			"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
			"columnDefs": [
				{"className": "dt-center", "targets": "_all", "orderable": false}
			],
			"order": [],
			oLanguage: {sProcessing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'},
			"ajax": {
				url: base_url + "admin/matchbit_coin_dt",
				type: "POST",
				data: {
					status: status,
					date1: date1,
					date2: date2,
					user: user
				}
			},
			drawCallback: function (settings) {
					$("#total_bet").html(settings.json.total_bet);
					$("#total_bet_return").html(settings.json.total_bet_return);
			}
		});
	}

	$("#search").on('click', function () {
		$("#search").val("Please Wait");
		var from_date = $("#date1").val();
		var to_date = $("#date2").val();
		var status = $("#status").val();
		var user = $("#user").val();
		var d1 = formatDate(from_date);
		var d2 = formatDate(to_date);
		$('#data-table').DataTable().destroy();
		fetch_data(status, d1, d2, user);
		$("#search").val("Search");
	});
</script>
