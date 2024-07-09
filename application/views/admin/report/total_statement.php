<?php include(APPPATH."views/admin/common/header.php"); ?>

<div class="content">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">
						<strong class="card-title">Total Statement</strong>
						<div class="float-right">
							Date From: <input type="date" name="date1" id="date1" value="">&nbsp;&nbsp;
							Date To: <input type="date" name="date2" id="date2" value="">&nbsp;&nbsp;
							<input type="text" placeholder="type club name here"
											   class="form-control input-group-lg" value="" name="user"
											   id="user" autocomplete="off">
							<button style="font-size: 13px;color:#fff" class="btn btn-success btn-sm" type="button" id="search">Search</button>
						</div>
					</div>
					<div class="card-body">

						<div class="col-md-12">
							<aside class="profile-nav alt">
								<section class="card">
									<ul class="list-group list-group-flush">
										<li class="list-group-item">
											<i class="fa fa-arrow-right"></i> Single Bet Running <span class="badge badge-info pull-right" id="running_bet">0.00</span>
										</li>
										<li class="list-group-item">
											<i class="fa fa-arrow-right"></i> Single Bet Total <span class="badge badge-primary pull-right" id="total_bet">0.00</span>
										</li>
										<li class="list-group-item">
											<i class="fa fa-arrow-right"></i> Total Single Bet Win <span class="badge badge-success pull-right" id="total_win">0.00</span>
										</li>
										<li class="list-group-item">
											<i class="fa fa-arrow-right"></i> Total Single Bet Failed <span class="badge badge-danger pull-right" id="total_fail">0.00</span>
										</li>
										<li class="list-group-item">
											<i class="fa fa-arrow-right"></i> Total Multi Bet Running <span class="badge badge-info pull-right" id="total_multi_bet_running">0.00</span>
										</li>
										<li class="list-group-item">
											<i class="fa fa-arrow-right"></i> Total Multi Bet Win <span class="badge badge-success pull-right" id="total_multi_bet_win">0.00</span>
										</li>
										<li class="list-group-item">
											<i class="fa fa-arrow-right"></i> Total Multi Bet Failed <span class="badge badge-danger pull-right" id="total_multi_bet_failed">0.00</span>
										</li>
										<li class="list-group-item">
											<i class="fa fa-arrow-right"></i> User Bet Cancel <span class="badge badge-warning pull-right r-activity" id="total_cancel_u">0.00</span>
										</li>
										<li class="list-group-item">
											<i class="fa fa-arrow-right"></i> Admin Bet Cancel <span class="badge badge-warning pull-right r-activity" id="total_cancel_a">0.00</span>
										</li>
										<li class="list-group-item">
											<i class="fa fa-arrow-right"></i> Deposit <span class="badge badge-info pull-right r-activity" id="total_deposit">0.00</span>
										</li>
										<li class="list-group-item">
											<i class="fa fa-arrow-right"></i> User Withdraw <span class="badge badge-complete pull-right r-activity" id="total_withdraw_u">0.00</span>
										</li>
										<li class="list-group-item">
											<i class="fa fa-arrow-right"></i> Club Withdraw <span class="badge badge-complete pull-right r-activity" id="total_withdraw_c">0.00</span>
										</li>
										
										<li class="list-group-item">
											<i class="fa fa-arrow-right"></i> Customer Total Coin <span class="badge pull-right r-activity" id="total_user_coin" style="background-color:#333;font-weight:bold;">0.00</span>
										</li>
									</ul>
								</section>
							</aside>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<?php include(APPPATH."views/admin/common/footer.php"); ?>


<script>
	get_data('<?=  @date("Y-m-d") ?>','<?= @date("Y-m-d") ?>');
	$("#search").on('click',function () {
		var dt1 = $("#date1").val();
		var dt2 = $("#date2").val();
		var user = $("#user").val();
		get_data(dt1,dt2,user);
	});

	function get_data(dt1,dt2,club) {
		var url = '<?= base_url('admin/get_total_statement') ?>';
		$.ajax({
			type:"POST",
			url: url,
			data:{
				date1:dt1,date2:dt2,user:club
			},
			dataType:"JSON",
			success:function (result) {
				if (result.total_bet){
					$("#total_bet").html(result.total_bet);
				}
				else{
					$("#total_bet").html("0.00");
				}
				if (result.running_bet){
					$("#running_bet").html(result.running_bet);
				}
				else{
					$("#running_bet").html("0.00");
				}
				if (result.total_win){
					$("#total_win").html(result.total_win);
				}
				else{
					$("#total_win").html("0.00");
				}
				if (result.total_fail){
					$("#total_fail").html(result.total_fail);
				}
				else{
					$("#total_fail").html("0.00");
				}
				if (result.total_cancel_u){
					$("#total_cancel_u").html(result.total_cancel_u);
				}
				else{
					$("#total_cancel_u").html("0.00");
				}
				if (result.total_cancel_a){
					$("#total_cancel_a").html(result.total_cancel_a);
				}
				else{
					$("#total_cancel_a").html("0.00");
				}
				if (result.total_deposit){
					$("#total_deposit").html(result.total_deposit);
				}
				else{
					$("#total_deposit").html("0.00");
				}
				if (result.total_withdraw_u){
					$("#total_withdraw_u").html(result.total_withdraw_u);
				}
				else{
					$("#total_withdraw_u").html("0.00");
				}
				if (result.total_withdraw_c){
					$("#total_withdraw_c").html(result.total_withdraw_c);
				}
				else{
					$("#total_withdraw_c").html("0.00");
				}
				
				if (result.total_user_coin){
					$("#total_user_coin").html(result.total_user_coin);
				}
				else{
					$("#total_user_coin").html("0.00");
				}

				if (result.running_multi_bet){
					$("#total_multi_bet_running").html(result.running_multi_bet);
				}
				else{
					$("#total_multi_bet_running").html("0.00");
				}

				if (result.total_multi_bet_win){
					$("#total_multi_bet_win").html(result.total_multi_bet_win);
				}
				else{
					$("#total_multi_bet_win").html("0.00");
				}

				if (result.total_multi_bet_failed){
					$("#total_multi_bet_failed").html(result.total_multi_bet_failed);
				}
				else{
					$("#total_multi_bet_failed").html("0.00");
				}
			}
		});
	}

	$(document).ready(function () {
		$("#user").typeahead({
			source: function (query, result) {
				$.ajax({
					url: '<?= base_url()?>admin/club_ajax_call',
					method: "POST",
					data: {user: query},
					dataType: "JSON",
					success: function (data) {
						result($.map(data, function (item) {
							return item;
						}));
					}
				});
			}
		});
	});
</script>
