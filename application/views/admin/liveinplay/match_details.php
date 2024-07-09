<?php include(APPPATH . "views/admin/common/header.php"); ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<style>
	.table {
		font-size: 12px;
	}

	/* HIDE RADIO */
	[type=radio] {
		position: absolute;
		opacity: 0;
		width: 0;
		height: 0;
	}

	/* IMAGE STYLES */
	[type=radio] + img {
		cursor: pointer;
	}

	/* CHECKED STYLES */
	[type=radio]:checked + img {
		outline: 2px solid #f00;
	}

	.imgGray{
		filter: gray; /* IE6-9 */
	  	-webkit-filter: grayscale(1); /* Google Chrome, Safari 6+ & Opera 15+ */
	  	filter: grayscale(1);
	}
</style>

<?php include(APPPATH . "views/admin/common/flash.php"); ?>
<div class="content">
	<div class="animated fadeIn">
		<div class="row">

			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<strong class="card-title">Match Details</strong>
						<div class="float-right">
							<a data-toggle="modal" data-target="#scrollmodal" style="font-size: 13px;color:#fff"
							   class="btn btn-success btn-sm">Add New</a>
						</div>
					</div>
					<div class="card-body">
						<table id="dataTable" class="table table-striped table-bordered">
							<thead class="thead-dark">
							<tr>
								<th>Serial</th>
								<th>Sports Name</th>
								<th>Match Title</th>
								<th>Match Transaction</th>
								<th>Match Type</th>
								<th>Score</th>
								<th>Notification</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
							</thead>
							<label class="label-succes"></label>
							<tbody>
							<?php foreach ($matches as $val) : ?>
								<tr>
									<td><?= $val->serial; ?></td>
									<td><?= $val->name; ?></td>
									<td><img src="<?php echo base_url() ?>assets/img/flag/<?php echo $val->icon1; ?>"
											 width="30;" alt=""> &nbsp;<?= $val->title; ?>&nbsp;<img
											src="<?php echo base_url() ?>assets/img/flag/<?php echo $val->icon2; ?>"
											width="30;" alt=""></td>
									<td>TB: <font color="green"><?= get_total_match_bet_running($val->id) ?></font> <br> TR: <font color="red"><?= get_total_match_bet_return($val->id) ?></font></td>
									<td>
										<?php
										if ($val->active_status == 1) {
											echo '<a href="'.base_url("admin/change_match_status/2/".$val->id).'"><span style="font-size:10px" class="badge badge-success">In Play</span></a>';
										} else if ($val->active_status == 2) {
											echo '<a href="'.base_url("admin/change_match_status/1/".$val->id).'"><span style="font-size:10px" class="badge badge-warning">Advance Bet</span></a>';
										}
										?>
									</td>

									<td>
										<?php echo $val->score_1 ?> : <?php echo $val->score_2 ?>

										&nbsp;&nbsp;&nbsp;
										<a onclick="return change_score(<?= $val->id ?>,'<?php echo $val->score_1 ?>','<?php echo $val->score_2 ?>')" title="Edit Score"><i
												class="fa fa-edit icon-edit"></i></a>

										&nbsp;&nbsp;&nbsp;

										<select name="show_in_game" onchange="return show_to_game_in(<?= $val->id ?>,this);" id="show_in_game">
											<option value="None" <?= $val->score_show_in=="None"?"selected":"" ?>>None</option>
											<option value="Football" <?= $val->score_show_in=="Football"?"selected":"" ?>>Football</option>
											<option value="Cricket" <?= $val->score_show_in=="Cricket"?"selected":"" ?>>Cricket</option>
										</select>
									</td>
									<td><?= $val->notification; ?></td>
									<td>
										<?php
										if ($val->status == 2) {
											echo '<a href="'.base_url("admin/change_match_details_status_c/1/".$val->id).'"><span class="badge badge-danger">Hide</span></a>';
										} else if ($val->status == 1) {
											echo '<a href="'.base_url("admin/change_match_details_status_c/2/".$val->id).'"><span class="badge badge-success">Active</span></a>';
										} else if ($val->status == 3) {
											echo '<span class="badge badge-warning">Match End</span>';
										} else if ($val->status == 4) {
											echo '<span class="badge badge-danger">Match Cancelled</span>';
										}
										?>
										&nbsp;&nbsp;&nbsp;&nbsp;
										<?php if ($val->isBetCancelable=="Yes"): ?>
										<a href="<?= base_url("admin/change_bet_cancelable/No/".$val->id) ?>"><span class="badge badge-info">Bet Cancel: <?= $val->isBetCancelable; ?></span></a>
										<?php else: ?>
										<a href="<?= base_url("admin/change_bet_cancelable/Yes/".$val->id) ?>"><span class="badge badge-primary">Bet Cancel: <?= $val->isBetCancelable; ?></span></a>
										<?php endif; ?>
									</td>
									<td style="width:180px">


										<a href="<?php echo base_url('match_details/view/' . $val->id); ?>"
										   title="View Match Option"><i style="color:black"
																		class="fa fa-eye icon-edit"></i></a>
										&nbsp;&nbsp;&nbsp;
										<a class="match-edit-modal" data-id="<?php echo $val->id; ?>"
										   data-toggle="modal" data-target="#scrollmodal2" title="Edit"><i
												class="fa fa-edit icon-edit"></i></a>
										&nbsp;&nbsp;&nbsp;
										<a class="change-status-modal" data-id="<?php echo $val->id; ?>"
										   data-toggle="modal" data-target="#scrollmodal4" title="Change Status"><i
												style="color:gray" class="fa fa-dot-circle-o icon-delete"></i></a>
										&nbsp;&nbsp;&nbsp;
										<a class="change-flag-modal" data-id="<?php echo $val->id; ?>"
										   data-toggle="modal" data-target="#scrollmodalFlag" title="Change Flag"><i
												style="color:rebeccapurple" class="fa fa-flag flag-icon-fk"></i></a>
										&nbsp;&nbsp;&nbsp;
										<?php if ($val->isLive=="Yes"): ?>
										<a href="<?= base_url("admin/change_bet_live_status/No/".$val->id) ?>"><img src="<?= base_url("assets/img/live.png") ?>" style="width: 23px;height: 18px;"></a>
										<?php else: ?>
										<a href="<?= base_url("admin/change_bet_live_status/Yes/".$val->id) ?>"><img class="imgGray" src="<?= base_url("assets/img/live.png") ?>" style="width: 23px;height: 18px;"></a>
										<?php endif; ?>
									</td>
								</tr>
							<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

		</div>


		<!-- Modal Start -->


		<!-- create match form -->
		<div class="modal fade" id="scrollmodal" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel"
			 aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">

						<div class="container" style="padding-top: 0px">
							<div class="animated fadeIn">
								<div class="row">

									<div class="col-lg-12">
										<div class="card">
											<div class="card-header">
												<strong class="card-title">Create Match</strong>
											</div>
											<div class="card-body">
												<!-- Credit Card -->
												<div id="pay-invoice">
													<div class="card-body">

														<form
															action="<?php echo base_url('admin/post_create_match'); ?>"
															method="post">
															<div class="form-group">
																<label for="sports_name" class="control-label mb-1">Sports
																	Name</label>
																<select name="sports_name" class="form-control"
																		required>
																	<option value="">--- select ---</option>
																	<?php foreach ($sports as $val) : ?>
																		<option
																			value="<?php echo $val->id; ?>"><?php echo $val->name; ?></option>
																	<?php endforeach; ?>
																</select>
															</div>

															<div class="row">
																<div class="col-md-6">
																	<div class="form-group has-success">
																		<label for="score_1" class="control-label mb-1">Team
																			1</label>
																		<input id="team_1" required name="team_1"
																			   type="text" class="form-control">
																	</div>
																</div>
																<div class="col-md-6">
																	<div class="form-group has-success">
																		<label for="score_2" class="control-label mb-1">Team
																			2</label>
																		<input id="team_2" required name="team_2"
																			   type="text" class="form-control">
																	</div>
																</div>
															</div>


															<div class="form-group has-success">
																<label for="league_title" class="control-label mb-1">League
																	Title</label>
																<input name="league_title" type="text"
																	   class="form-control" required>
															</div>

															<div class="form-group">
																<label for="match_status" class="control-label mb-1">Match
																	Status</label>
																<select name="match_status" class="form-control"
																		id="matchSts" onclick="return adv_time();"
																		required>
																	<option value="">--- select ---</option>
																	<option value="1">In-play</option>
																	<option value="2">Advance-bet</option>
																</select>
															</div>

															<div class="form-group has-success" id="adv_time_show"
																 style="display: none;">
																<label for="starting_time" class="control-label mb-1">Match
																	Start time (for advanced bet)</label>
																<input name="starting_time" id="st_time"
																	   type="datetime-local" class="form-control">
															</div>


															<div class="form-group has-success">
																<label for="notification" class="control-label mb-1">Match
																	Notification</label>
																<input name="notification" type="text"
																	   class="form-control" required>
															</div>

															<div class="form-group has-success">
																<label for="notification" class="control-label mb-1">Youtube Link</label>
																<input name="youtubeLinkCreate" type="text"
																	   class="form-control">
															</div>

															<div class="form-group has-success">
																<label for="match_serial" class="control-label mb-1">Serial</label>
																<input required name="match_serial" type="text"
																	   class="form-control">
															</div>

															<div class="form-group">
																<label for="active_status" class="control-label mb-1">Status</label>
																<select name="active_status" class="form-control"
																		required>
																	<option value="">--- select ---</option>
																	<option value="1" selected>Active</option>
																	<option value="2">Inactive</option>
																</select>
															</div>
															<div>
																<input class="btn btn-lg btn-info btn-block"
																	   type="submit" name="submit" value="Submit">
															</div>
														</form>
													</div>
												</div>

											</div>
										</div> <!-- .card -->

									</div><!--/.col-->

								</div>
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
						<!-- <button type="button" class="btn btn-primary">Confirm</button> -->
					</div>
				</div>
			</div>
		</div>

		<!-- edit create match form -->
		<div class="modal fade" id="scrollmodal2" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel"
			 aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">

						<div class="container" style="padding-top: 0px">
							<div class="animated fadeIn">
								<div class="row">

									<div class="col-lg-12">
										<div class="card">
											<div class="card-header">
												<strong class="card-title">Edit Match</strong>
											</div>
											<div class="card-body">
												<!-- Credit Card -->
												<div id="pay-invoice">
													<div class="card-body">

														<form action="<?php echo base_url('admin/post_edit_match'); ?>"
															  method="post">
															<input id="hidden_match_edit_id" type="hidden"
																   name="match_edit_id">
															<div class="form-group">
																<label for="sports_name" class="control-label mb-1">Sports
																	Name</label>
																<select id="edit_sports_name" name="sports_name"
																		class="form-control" required>
																	<option value="">--- select ---</option>
																	<?php foreach ($sports as $val) : ?>
																		<option
																			value="<?php echo $val->id; ?>"><?php echo $val->name; ?></option>
																	<?php endforeach; ?>
																</select>
															</div>
															<div class="row">
																<div class="col-md-6">
																	<div class="form-group has-success">
																		<label for="score_1" class="control-label mb-1">Team
																			1</label>
																		<input id="eteam_1" required name="team_1"
																			   type="text" class="form-control">
																	</div>
																</div>
																<div class="col-md-6">
																	<div class="form-group has-success">
																		<label for="score_2" class="control-label mb-1">Team
																			2</label>
																		<input id="eteam_2" required name="team_2"
																			   type="text" class="form-control">
																	</div>
																</div>
															</div>
															<div class="form-group has-success">
																<label for="league_title" class="control-label mb-1">League
																	Title</label>
																<input name="league_title" id="league_title" type="text"
																	   class="form-control" required>
															</div>

															<div class="form-group">
																<label for="match_status" class="control-label mb-1">Match
																	Status</label>
																<select id="edit_match_status" name="match_status"
																		class="form-control" required>
																	<option value="">--- select ---</option>
																	<option value="1">In-play</option>
																	<option value="2">Advance-bet</option>
																</select>
															</div>
															<div class="form-group has-success" id="adv_time_show">
																<label for="starting_time" class="control-label mb-1">Match
																	Start time (for advanced bet)</label>
																<input name="starting_time" id="sts_time"
																	   type="datetime-local" class="form-control">
															</div>
															<div class="form-group has-success">
																<label for="notification" class="control-label mb-1">Match
																	Notification</label>
																<input id="edit_notification" name="notification"
																	   type="text" class="form-control" required>
															</div>

															<div class="form-group has-success">
																<label for="youtubeLInk" class="control-label mb-1">Youtube Link</label>
																<input id="youtubeLInk" name="youtubeLInk"
																	   type="text" class="form-control">
															</div>

															<div class="row">
																<div class="col-md-6">
																	<div class="form-group has-success">
																		<label for="score_1" class="control-label mb-1">1st
																			Score</label>
																		<input id="score_1" required name="score_1"
																			   type="text" class="form-control">
																	</div>
																</div>
																<div class="col-md-6">
																	<div class="form-group has-success">
																		<label for="score_2" class="control-label mb-1">2nd
																			Score</label>
																		<input id="score_2" required name="score_2"
																			   type="text" class="form-control">
																	</div>
																</div>
															</div>

															<div class="form-group has-success">
																<label for="match_serial" class="control-label mb-1">Serial</label>
																<input id="edit_match_serial" name="match_serial"
																	   type="text" class="form-control" required>
															</div>
															<div class="form-group">
																<label for="match_status" class="control-label mb-1">Status</label>
																<select id="edit_active_status" name="active_status"
																		class="form-control" required>
																	<option value="">--- select ---</option>
																	<option value="1">Active</option>
																	<option value="2">Inactive</option>
																</select>
															</div>
															<div>
																<input class="btn btn-lg btn-info btn-block"
																	   type="submit" name="submit" value="Submit">
															</div>
														</form>
													</div>
												</div>

											</div>
										</div> <!-- .card -->

									</div><!--/.col-->

								</div>
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
						<!-- <button type="button" class="btn btn-primary">Confirm</button> -->
					</div>
				</div>
			</div>
		</div>

		<!-- change status -->
		<div class="modal fade" id="scrollmodal4" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel"
			 aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">

						<div class="container" style="padding-top: 0px">
							<div class="animated fadeIn">
								<div class="row">

									<div class="col-lg-12">
										<div class="card">
											<div class="card-header">
												<strong class="card-title">Change Status</strong>
											</div>
											<div class="card-body">
												<!-- Credit Card -->
												<div id="pay-invoice">
													<div class="card-body">

														<form
															action="<?php echo base_url('admin/change_match_details_status'); ?>"
															method="post">
															<input id="hidden_change_status_id" type="hidden"
																   name="match_id">
															<div class="form-group">
																<label for="match_status" class="control-label mb-1">Status</label>
																<select name="match_status" class="form-control"
																		required>
																	<option value="">--- select ---</option>
																	<option value="1">Active</option>
																	<option value="2">Hide</option>
																	<option value="3">Match End</option>
																	<option value="4">Match Cancelled</option>
																</select>
															</div>
															<div>
																<button type="submit"
																		class="btn btn-lg btn-info btn-block">
																	<span>Submit</span>
																</button>
															</div>
														</form>
													</div>
												</div>

											</div>
										</div> <!-- .card -->

									</div><!--/.col-->

								</div>
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
						<!-- <button type="button" class="btn btn-primary">Confirm</button> -->
					</div>
				</div>
			</div>
		</div>

		<!-- view match option table -->
		<div class="modal fade" id="scrollmodal7" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel"
			 aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">

						<div class="container" style="padding-top: 0px">
							<div class="animated fadeIn">
								<div class="row">

									<div class="col-lg-12">
										<div class="card">
											<div class="card-header">
												<strong class="card-title">View Match Options</strong>
											</div>
											<div class="card-body">
												<!-- Credit Card -->
												<div id="pay-invoice">
													<div id="content_data" class="card-body">

														Content will be here

													</div>
												</div>

											</div>
										</div> <!-- .card -->

									</div><!--/.col-->

								</div>
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
						<!-- <button type="button" class="btn btn-primary">Confirm</button> -->
					</div>
				</div>
			</div>
		</div>

		<!-- add team flag -->
		<div class="modal fade" id="scrollmodalFlag" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel"
			 aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">

						<div class="container" style="padding-top: 0px">
							<div class="animated fadeIn">
								<div class="row">

									<div class="col-lg-12">
										<div class="card">
											<div class="card-header">
												<strong class="card-title">Add Team Flag</strong>
											</div>
											<div class="card-body">
												<!-- Credit Card -->

												<div class="card-body">

													<form
														action="<?php echo base_url('admin/add_match_flag'); ?>"
														method="post">
														<input id="hidden_matchname_id" type="hidden"
															   name="match_matchname_id" value="">

														<div class="row">
															<div class="col-lg-8">
																<div class="form-group has-success">
																	<label for="match_option_name"
																		   class="control-label mb-1">Team 1</label>
																	<input id="teamOne"
																		   name="teamOne" type="text"
																		   class="form-control" readonly>
																</div>
															</div>

															<div class="col-lg-10">
																<div class="form-group has-success">

																	<label class="control-label">Flag Name</label>
																	<input type="text" class="form-control" name="icon_name1" id="icon_name1" onchange="getFlag1();" autocomplete="off">
 																	<input type="hidden" name="team1_icon" id="team1_icon">
																	<label for="sports_icon1"
																		   class="control-label mb-1">Icon</label>
																		<p id="flag1"></p>
																	</label> 
																</div>
															</div>
														</div>

														<div class="row">
															<div class="col-lg-8">
																<div class="form-group has-success">
																	<label for="match_option_name"
																		   class="control-label mb-1">Team 2</label>
																	<input id="teamTwo"
																		   name="teamTwo" type="text"
																		   class="form-control" readonly>
																</div>
															</div>

															<div class="col-lg-10">
																<div class="form-group has-success">
																	<label class="control-label">Flag Name</label>
																	<input type="text" class="form-control" name="icon_name2" id="icon_name2" onchange="getFlag2();" autocomplete="off">
																	<input type="hidden" name="team2_icon" id="team2_icon">
																	<label for="sports_icon1"
																		   class="control-label mb-1">Icon</label>
																		<p id="flag2"></p>
																	</label> 
																</div>
															</div>
														</div>
														<input type="submit" name="submit" value="Submit"
															   class="btn btn-lg btn-info btn-block">

													</form>

												</div>


											</div>
										</div> <!-- .card -->

									</div><!--/.col-->

								</div>
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
						<!-- <button type="button" class="btn btn-primary">Confirm</button> -->
					</div>
				</div>
			</div>
		</div>

		<!-- Modal End -->

	</div>
</div>


<!-- score change modal -->

<div id="open-modal" class="modal-window">
	<div>
		<a title="Close" class="modal-close close">close &times;</a>

		<div class="card">
			<div class="card-header">
				<strong class="card-title">Change Score</strong>
			</div>
			<div class="card-body">
				<!-- Credit Card -->
				<div id="pay-invoice">
					<div class="card-body">

						<form action="<?php echo base_url('change_live_score') ?>" method="post">
							<input id="match_name_id" type="hidden" name="match_name_id">
							 
							<div class="form-group">
								<label for="status" class="control-label mb-1">Score 1</label>
								<input type="text" name="score_1" id="s1" class="form-control">
							</div>

							<div class="form-group">
								<label for="status" class="control-label mb-1">Score 2</label>
								<input type="text" name="score_2" id="s2" class="form-control">
							</div>
							<div>
								<input type="submit" name="submit" class="btn btn-lg btn-info btn-block" value="Submit">
							</div>
						</form>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

 

<?php include(APPPATH . "views/admin/common/footer.php"); ?>
<script type="text/javascript">

	// $("#dataTable").dataTable();

	$(document).on('show.bs.modal', function (e) {
		$('body').css('padding-right', '0px');
	});

	$('.change-status-modal').on('click', function () {
		var data_id = $(this).attr('data-id');
		$('#hidden_change_status_id').attr('value', data_id);
	});

	$('.match-status-modal').on('click', function () {
		var data_id = $(this).attr('data-id');
		$('#hidden_change_match_status_id').attr('value', data_id);
	});

	$('.match-option-modal').on('click', function () {
		var data_id = $(this).attr('data-id');
		$('#hidden_match_option_id').attr('value', data_id);
	});

	$('.match-edit-modal').on('click', function (e) {
		var data_id = $(this).attr('data-id');
		$('#hidden_match_edit_id').attr('value', data_id);
		var url_prefix = "<?php echo base_url(); ?>";
		url = url_prefix + 'edit_match_data';

		// ajax request
		$.ajax({
			type: "POST",
			url: url_prefix + 'admin/edit_match_data',
			data: {
				match_id: data_id
			},
			dataType: 'json',
			success: function (data) {
				$("#edit_match_title").attr("value", data.title);
				$("#edit_sports_name").val(data.sportscategory_id);
				$("#edit_match_status").val(data.active_status);
				$("#edit_active_status").val(data.status);
				$("#edit_notification").attr("value", data.notification);
				$("#youtubeLInk").attr("value", data.youtubeLInk);
				$("#edit_match_serial").attr("value", data.serial);
				$("#score_1").attr("value", data.score_1);
				$("#score_2").attr("value", data.score_2);
				$("#sts_time").attr("value", data.match_time_local);
				$("#eteam_1").attr("value", data.team1);
				$("#eteam_2").attr("value", data.team2);
				$("#league_title").attr("value", data.league_title);
			},
			error: function (exception) {
				console.log(exception);
			}
		});
	});

	$('.match-view-modal').on('click', function (e) {
		var data_id = $(this).attr('data-id');
		//$('#hidden_match_edit_id').attr('value', data_id);
		var url_prefix = "<?php echo base_url(); ?>";
		url = url_prefix + 'view_match_data';

		// ajax request
		$.ajax({
			type: "POST",
			url: url_prefix + 'admin/view_match_data',
			data: {
				match_id: data_id
			},
			dataType: 'html',
			success: function (data) {
				console.log(data);
				$("#content_data").html("");
				$("#content_data").append(data);
			},
			error: function (exception) {
				console.log(exception);
				alert(exception);
			}
		});
	});

	$('.change-flag-modal').on('click', function (e) {
		var data_id = $(this).attr('data-id');

		var url_prefix = "<?php echo base_url(); ?>";
		// ajax request
		$.ajax({
			type: "POST",
			url: url_prefix + 'admin/view_team_for_flag',
			data: {
				match_id: data_id
			},
			dataType: 'json',
			success: function (data) {
				$("#teamOne").val("");
				$("#teamOne").val(data.team1);
				$("#teamTwo").val("");
				$("#teamTwo").val(data.team2);
				$("#hidden_matchname_id").val("");
				$("#hidden_matchname_id").val(data.id);
			},
			error: function (exception) {
				console.log(exception);
			}
		});
	});
</script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
	$(".datepicker").datepicker();

	function adv_time() {

		var x = document.getElementById("matchSts").value;
		if (x == 2) {
			$("#adv_time_show").show();
		} else {
			$("#st_time").val("");
			$("#adv_time_show").hide();
		}

	}

	function change_score(id,s1,s2) {
		$("#open-modal").fadeIn();
		$("#match_name_id").val(id); 
		$("#s1").val(s1);
		$("#s2").val(s2);
	}

	function show_to_game_in(id,data) {
		var this_data = (data.value || data.options[data.selectedIndex].value); 
		$.ajax({
		type: 'POST',
		url: "<?= base_url('show_to_slider') ?>",
		data: {
			id:id, show_in:this_data
		} 
		}).done(function (response) {

		});
	}




	$(document).ready(function () {
		$("#icon_name1").typeahead({
			source: function (query,result) {
				$.ajax({
					url: '<?= base_url()?>extrasettings/icon_flag_name_ajax_call',
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

		$("#icon_name2").typeahead({
			source: function (query,result) {
				$.ajax({
					url: '<?= base_url()?>extrasettings/icon_flag_name_ajax_call',
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

	function getFlag1(){
		var inputVal = document.getElementById("icon_name1").value;
		$.ajax({
			url:"<?php echo base_url(); ?>extrasettings/get_flag_icon_by_name",
			method:"POST",
			data:{icon_name:inputVal}, 
			dataType:"JSON",
			success:function(data)
			{
				$('#flag1').html(data.img);
				$('#team1_icon').val(data.file_name);
			}
		});
	}

	function getFlag2(){
		var inputVal = document.getElementById("icon_name2").value;
		$.ajax({
			url:"<?php echo base_url(); ?>extrasettings/get_flag_icon_by_name",
			method:"POST",
			data:{icon_name:inputVal}, 
			dataType:"JSON",
			success:function(data)
			{
				$('#flag2').html(data.img);
				$('#team2_icon').val(data.file_name);
			}
		});
	}
</script>


