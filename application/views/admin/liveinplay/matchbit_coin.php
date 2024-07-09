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
						<strong class="card-title">Running Match Bit Coin</strong>
						<span class="badge badge-warning " id="running_bet">Bet Running: 0.00</span>
						<span class="badge badge-info " id="total_bet">Today Bet: 0.00</span>
						<span class="badge badge-primary" id="total_win">Today Win: 0.00</span>
						<span class="badge badge-danger" id="total_fail">Today Failed: 0.00</span>
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


<div id="open-modal" class="modal-window">
	<div>
		<a title="Close" class="modal-close close">close &times;</a>

		<div class="card">
			<div class="card-header">
				<strong class="card-title">Change Rate for : <b id="userId"></b></strong>
			</div>
			<div class="card-body">
				<!-- Credit Card -->
				<div id="pay-invoice">
					<div class="card-body">

						<form id="submit_option_edit">
							<input id="match_bet_id" type="hidden" name="match_bet_id">

							<div class="form-group">
								<label for="match_rate" class="control-label mb-1">Bet Rate</label>
								<input type="text" id="bet_rate" class="form-control" name="bet_rate">
							</div>

							<div class="form-group">
								<label for="match_rate_total" class="control-label mb-1">Bet Rate</label>
								<input type="text" id="bet_rate_total" class="form-control" name="bet_rate_total">
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


<div id="open-modal-status" class="modal-window">
	<div>
		<a title="Close" class="modal-close close">close &times;</a>

		<div class="card">
			<div class="card-header">
				<strong class="card-title">Change Status for : <b id="userId_st"></b></strong>
			</div>
			<div class="card-body">
				<!-- Credit Card -->
				<div id="pay-invoice">
					<div class="card-body">

						<form id="submit_option_status">
							<input id="match_bet_id_st" type="hidden" name="match_bet_id_st">
							<div class="form-group">
								<select name="bet_status" id="bet_status" class="form-control">
									<option value="">--select status--</option>
									<option value="WIN">WIN</option>
									<option value="LOST">LOST</option>
									<option value="CANCEL_ADMIN">CANCEL ADMIN</option>
									<option value="MATCH_RUNNING">MATCH RUNNING</option>
								</select>
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

<div id="change-option" class="modal-window">
	<div>
		<a id="close-btn" title="Close" class="modal-close close">close &times;</a>

		<div class="card">
			<div class="card-header">
				<strong class="card-title">Update Option</strong>
			</div>
			<div class="card-body">
				<!-- Credit Card -->

				<div class="option-card-body">

					<form method="POST" action="<?php echo base_url('admin/update_matchbet_option'); ?>">
						<input id="matchbet_option_id" type="hidden" name="matchbet_option_id">
						<div class="form-group">
							<select name="matchbet_option" id="matchbet_option" class="form-control">

							</select>
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

<?php include(APPPATH . "views/admin/common/footer.php"); ?>
<script type="text/javascript">

	function edit_bet_op(id, user, op_coin, total_coin) {
		$("#open-modal").fadeIn();
		$("#match_bet_id").val(id);
		$("#userId").html(user);
		$("#bet_rate").val(op_coin);
		$("#bet_rate_total").val(total_coin);
	}

	function change_status_bet(id, user) {
		$("#open-modal-status").fadeIn();
		$("#match_bet_id_st").val(id);
		$("#userId_st").html(user);
	}

	$('#submit_option_status').submit(function (e) {
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: "<?php echo base_url('admin/post_running_bet_status'); ?>",
			data: $(this).serialize(),
			dataType: 'json',
		}).done(function (data) {
			if (data.st == 200) {
				swal({
						title: data.msg,
						type: "success",
						timer: 1500,
						confirmButtonText: "Done",
					});
				$("#open-modal-status").fadeOut();
				$("#userId_st").html("");
				$("#match_bet_id_st").val("");
				$('#data-table').DataTable().destroy();
				fetch_data("MATCH_RUNNING','WIN','LOST','USER_CANCEL','CANCEL_ADMIN","<?php echo($date_7days)?>","<?php echo($date_today)?>");
				return;
			}
			if (data.st == 400) {
				swal({
						title: data.msg,
						type: "error",
						timer: 1500,
						confirmButtonText: "Done",
					});
			}

		});
	});


	$('#submit_option_edit').submit(function (e) {
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: "<?php echo base_url('admin/post_running_bet_rate'); ?>",
			data: $(this).serialize(),
			dataType: 'json',
		}).done(function (data) {
			if (data.st == 200) {
				swal(
					{
						title: data.msg,
						type: "success",
						timer: 1500,
						confirmButtonText: "Done",
					});
				$("#open-modal").fadeOut();
				$("#userId").html("");
				$("#bet_rate").val("");
				$("#bet_rate_total").val("");
				$('#data-table').DataTable().destroy();
				fetch_data("MATCH_RUNNING','WIN','LOST','USER_CANCEL','CANCEL_ADMIN","<?php echo($date_7days)?>","<?php echo($date_today)?>");
				return;
			}
		});
	});

</script>

<script>
	fetch_data("MATCH_RUNNING','WIN','LOST','USER_CANCEL','CANCEL_ADMIN","<?php echo($date_7days)?>","<?php echo($date_today)?>");

	function fetch_data(status, date1, date2) {
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
					status: status, date1: date1, date2: date2
				}
			},
			drawCallback: function (settings) {

			}
		});
	}
	
	function change_bet_option(id, username) {
        var url_prefix = "<?php echo base_url('admin/get_bet_option_values'); ?>";
		$("#change-option").fadeIn();
		$("#matchbet_option_id").val(id);
		
        // ajax request
        $.ajax({
            type: "POST",
            url: url_prefix,
            data: {
                option_id: id,
                username: username,
            },
            dataType: 'html',
            success: function(data) {
                console.log(data);
                if(data) {
                    $("#matchbet_option").html(data);
                }

            },
            error:function(exception){
                console.log(exception);
            }
        });
        // return chk_error;
		
	    
	}
	
	$("#close-btn").on("click", function() {
	    $("#change-option").fadeOut();
	    $("#matchbet_option_id").val("");
	});
</script>


<script>
	get_data('<?=  @date("Y-m-d") ?>','<?= @date("Y-m-d") ?>');
	$("#search").on('click',function () {
		var dt1 = $("#date1").val();
		var dt2 = $("#date2").val();
		get_data(dt1,dt2);
	});

	function get_data(dt1,dt2) {
		var url = '<?= base_url('admin/get_total_statement') ?>';
		$.ajax({
			type:"POST",
			url: url,
			data:{
				date1:dt1,date2:dt2
			},
			dataType:"JSON",
			success:function (result) {
				if (result.total_bet){
					$("#total_bet").html("Today Bet: "+result.total_bet);
				}
				else{
					$("#total_bet").html("Today Bet: 0.00");
				}
				if (result.total_win){
					$("#total_win").html("Today Win: "+result.total_win);
				}
				else{
					$("#total_win").html("Today Win: 0.00");
				}
				if (result.total_fail){
					$("#total_fail").html("Today Failed: "+result.total_fail);
				}else{
					$("#total_fail").html("Today Failed: 0.00");
				}
				if (result.running_bet){
					$("#running_bet").html("Bet Running: "+result.running_bet);
				}else{
					$("#running_bet").html("Bet Running: 0.00");
				}
				// if (result.total_fail){
				// 	$("#total_fail").html(result.total_fail);
				// }
				// else{
				// 	$("#total_fail").html("0.00");
				// }
				// if (result.total_cancel_u){
				// 	$("#total_cancel_u").html(result.total_cancel_u);
				// }
				// else{
				// 	$("#total_cancel_u").html("0.00");
				// }
				// if (result.total_cancel_a){
				// 	$("#total_cancel_a").html(result.total_cancel_a);
				// }
				// else{
				// 	$("#total_cancel_a").html("0.00");
				// }
				// if (result.total_deposit){
				// 	$("#total_deposit").html(result.total_deposit);
				// }
				// else{
				// 	$("#total_deposit").html("0.00");
				// }
				// if (result.total_withdraw_u){
				// 	$("#total_withdraw_u").html(result.total_withdraw_u);
				// }
				// else{
				// 	$("#total_withdraw_u").html("0.00");
				// }
				// if (result.total_withdraw_c){
				// 	$("#total_withdraw_c").html(result.total_withdraw_c);
				// }
				// else{
				// 	$("#total_withdraw_c").html("0.00");
				// }
				
				// if (result.total_user_coin){
				// 	$("#total_user_coin").html(result.total_user_coin);
				// }
				// else{
				// 	$("#total_user_coin").html("0.00");
				// }
			}
		});
	}


</script>