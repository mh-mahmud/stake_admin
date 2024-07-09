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
						<strong class="card-title">User Balance Statement</strong>
						<div class="form-inline">
							<b>From: </b><input type="date" class="form-control" value="" name="date1" id="date1">&nbsp;
							<b>To: </b><input type="date" class="form-control" value="" name="date2" id="date2">&nbsp;
							<b>User:</b><input type="text" placeholder="type username here" class="form-control input-group-lg" value="" name="user"
											   id="user" autocomplete="off">&nbsp;
							<input type="submit" id="user_search" name="submit" class="btn btn-info" value="User Search">
						</div>

					</div>
					<div class="card-body">
						<table id="data-table" class="table table-striped table-bordered">
							<thead class="thead-dark">
							<tr>
								<th>#</th>
								<th>Username</th>
								<th>Club</th>
								<th>Trans Type</th>
								<th>Bet Type</th>
								<th>Transaction Date</th>
								<th>Debit (Out)</th>
								<th>Credit (In).</th>
								<th>Current Balance</th>
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

<div id="showBetDetails" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"> 
                <h4 class="modal-title">Multibet Details</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12"> 
                            <table class="table table-bordered ajax-tbl display" style="width:100%">
                                <thead>
                                <tr role="row">
                                    <th>Match</th>
                                    <th>Question</th>
                                    <th>Answer</th>
                                    <th>Ratio</th> 
                                    <th>Win/Loss</th>
                                </tr>
                                </thead>
                                <tbody id="multiBetDetailsContent2">

                                </tbody>
                            </table> 
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn dark btn-outline">Close</button>
            </div>
        </div>
    </div>
</div>

<?php include(APPPATH . "views/admin/common/footer.php"); ?>

<script>

	function fetch_data(date1 = '', date2 = '', user) {
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
				url: base_url + "admin/user_statement_dt",
				type: "POST",
				data: {
					date1: date1,
					date2: date2,
					user: user
				}
			},
			drawCallback: function (settings) {

			}
		});
	}

	$("#user_search").on('click', function () {
		$("#user_search").val("Please Wait");
		var from_date = $("#date1").val();
		var to_date = $("#date2").val();
		var user = $("#user").val();
		var d1 = formatDate(from_date);
		var d2 = formatDate(to_date);
		if (user===""){
			swal(
				{
					title: "Give any user",
					type: "warning",
					timer: 1500
				}
			);
			$("#user_search").val("user_search");
			return false;
		}

		$('#data-table').DataTable().destroy();
		fetch_data(d1, d2, user);
		$("#user_search").val("user_search");
	});

	$(document).ready(function () {
		$("#user").typeahead({
			source: function (query,result) {
				$.ajax({
					url: '<?= base_url()?>admin/user_ajax_call',
					method: "POST",
					data:{user:query},
					dataType: "JSON",
					success:function (data) {
						result($.map(data,function (item) {
							return item;
						}));
					}
				});
			}
		});
	});


	function get_statement_details(type,argument) {
		var url = "<?php echo(base_url())?>";
		$.ajax({
			type:'post',
			url:url+"admin/user_statement_details",
			data: {
				post_id:argument,
				type:type
			},
			dataType:'JSON'
		}).done(function (data) {
			$('#showBetDetails').modal('show');
			console.log(data);
		}).fail(function (fail) {
			console.log(fail);
		});
	}

	

</script>
