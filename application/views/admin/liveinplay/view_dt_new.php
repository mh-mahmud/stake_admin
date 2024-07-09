<?php include(APPPATH . "views/admin/common/header.php"); ?>
<style>
	.table .thead-dark th {
		font-size: 14px;
	}
	.badge{
		padding: 3px!important;
	}
	.table td,.table th, .table tr {
		padding: 5px!important;
		vertical-align: center!important;
	}
	 
</style>
<?php include(APPPATH . "views/admin/common/flash.php"); ?>

<div class="breadcrumbs">
	<div class="breadcrumbs-inner">
		<div class="row m-0">
			<div class="col-sm-7">
				<div class="page-header float-left">
					<div class="page-title">
						<h1>
							<img src="<?= base_url() ?>assets/img/flag/<?= $icon1; ?>" alt="" width="35">
							&nbsp;&nbsp;<?php echo $match_name; ?>&nbsp;&nbsp;
							<img src="<?= base_url() ?>assets/img/flag/<?= $icon2; ?>" alt="" width="35">
						</h1>
					</div>
				</div>
			</div>
			<div class="col-sm-5">
				<div class="page-header float-right">
					<div class="page-title">
						<ol class="breadcrumb text-right">
							<li><a style="font-size: 13px;color:#fff" class="btn btn-danger btn-sm btn-go-back">Go
									Back</a></li>
							<li><a style="font-size: 13px;color:#fff" class="btn btn-success btn-sm"
								   id="match-option-modal" data-id="<?php echo $matchId; ?>" data-toggle="modal"
								   data-target="#scrollmodal6" title="Add Match Option">Add New</a></li>
							<?php if (empty($matches)): ?>
								<li><a style="font-size: 13px;color:#fff" id="add_bulk_option"
									   class="btn btn-info btn-sm"
									   title="Add Match Option Bluk">Bulk Add Option</a></li>
							<?php else: ?>
								<li><a style="font-size: 13px;color:#fff" href="<?= base_url('match_details/view_add/'.$matchId); ?>" 
									   class="btn btn-info btn-sm"
									   title="Add Match More Option">Add More Option</a></li>
							<?php endif; ?>
								<li><a style="font-size: 13px;color:#fff" href="<?= base_url('match_details/view_end/'.$matchId); ?>" 
									   class="btn btn-primary btn-sm"
									   title="End match Option">End Option</a></li>
						</ol>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>


<div class="content">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-md-12">
				<?php if (empty($matches)): ?>
					<div class="row" id="add_bulk_op" style="display: none;">
						<div class="col-md-6">
							<div class="form-group">
								<select name="sport_ids" id="sport_ids" class="form-control" required>
									<option value="">--select a sport--</option>
									<?php
									$sports = $this->db->query("SELECT id,name FROM sportscategory")->result();
									foreach ($sports as $sval):
										?>
										<option value="<?= $sval->id ?>"><?= $sval->name ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<input type="hidden" value="<?= $matchId ?>" id="match_id">
						<div class="col-md-6">
							<button type="text" id="get_sports" onclick="return submitSportIdFindQuestion();"
									class="btn btn-primary">Get Question & Option
							</button>
						</div>
					</div>
					<div class="row">
						<div class="col-md-8" id="match_option_show_here">
						</div>
					</div>

				<?php endif; ?>

				<div class="card">
					<div class="card-body">
						<table id="" class="table table-bordered"
							   style="width:100%">
							<thead class="thead-dark">
							<tr>
								<th>Match Bet Name</th>
								<th>Serial</th>
								<th>Status</th>
								<th>Created at</th>
								<th>Action</th>
								<th>
									<select onchange="col_expnd_all(<?php echo($matchId)?>,value)">
										<option value="">Select Col or Expand</option>
										<option value="collapse">Collapse</option>
										<option value="expand">Expand</option>
									</select>
								</th>
								<th>
									<select onchange="active_inactive_all(<?php echo($matchId)?>,value)">
										<option value="">Select Active or Inactive</option>
										<option value="1">Active</option>
										<option value="0">Inactive</option>
									</select>
								</th>
							</tr>
							</thead> 
							<tbody>
						<?php 
							foreach ($matches as $val) : 
							$option_data = $this->db->query("SELECT * FROM match_option_details WHERE match_option_id='{$val->id}'")->result();
							$c_or_e = $val->collapse_or_expand == 'collapse' ? 'expand' : 'collapse';
						?> 
								<tr style="cursor: pointer; background: #283048; background: -webkit-linear-gradient(to right, #283048, #859398); background: linear-gradient(to right, #283048, #859398);">
									<td style="color: white;"><?php echo $val->match_option_title;  ?> &nbsp;&nbsp;
										<a href="<?= base_url('admin/option_collapse_or_expand/' . $val->id . '/' . $c_or_e . '/' . $val->match_id) ?>"title="Option Collapse or Expand"><?php echo $val->collapse_or_expand ?></a></td>
									<td style="text-align: center;"><?php echo $val->match_option_serial; ?></td> 

									<td style="text-align: center;">
										<?php
										if ($val->status == 1) {
											echo '<span class="badge badge-success">Active</span>';
										} else if ($val->status == 0) {
											echo '<span class="badge badge-danger">Inactive</span>';
										} else if ($val->status == 3) {
											echo '<span class="badge badge-primary">Result Published</span>';
										} else if ($val->status == 4) {
											echo '<span class="badge badge-warning">Bet Cancelled</span>';
										}

										$sts = $val->is_score_show == 'YES' ? 'NO' : 'YES';
										$op_icon = $val->is_score_show == 'YES' ? 'fa-eye' : 'fa-eye-slash';

										?>
									</td>
									<td style="text-align: center;"><?php echo $val->created_at; ?></td>
									<td style="text-align: center;" colspan="2">
										<a class="new-bet-add-modal"
										   data-bettitle="<?php echo $val->match_option_title; ?>"
										   data-id="<?php echo $val->id; ?>"
										   data-match_id="<?php echo $val->match_id; ?>"
										   data-toggle="modal"
										   data-target="#addnewbetoption"
										   title="Add New Option"><i style="color: rebeccapurple"
																	 class="fa fa-plus icon-plus"></i></a>

										&nbsp;&nbsp;&nbsp;<a
											href="<?= base_url('admin/bet_show_hide_right_side/' . $val->id . '/' . $sts . '/' . $val->match_id) ?>"

											title="Side Menu show/hide"><i style="color: #c16808;"
																		   class="fa  <?= $op_icon; ?> icon-edit"></i></a>

										&nbsp;&nbsp;&nbsp;<a class="bet-edit-modal"
															 data-bettitle="<?php echo $val->match_option_title; ?>"
															 data-id="<?php echo $val->id; ?>"
															 data-match_option_serial="<?php echo $val->match_option_serial; ?>"
															 data-toggle="modal"
															 data-target="#scrollmodal2"
															 title="Edit"><i class="fa fa-edit icon-edit"></i></a>

										<?php if ($val->status == 0) : ?>
											&nbsp;&nbsp;&nbsp;<a class="bet-result-modal"
																 data-bettitle="<?php echo $val->match_option_title; ?>"
																 data-id="<?php echo $val->id; ?>"
																 data-match_option_serial="<?php echo $val->match_option_serial; ?>"
																 data-toggle="modal"
																 data-target="#scrollmodal5"
																 title="Result"><i class="fa fa-list icon-edit"></i></a>
										<?php endif; ?>


										<?php if ($val->status == 1) : ?>
											&nbsp;&nbsp;&nbsp;<a title="Inactive"
																 href="<?php echo base_url('admin/option_inactive/' . $val->id) ?>"><i
													style="color:red" class="fa fa-times icon-edit"></i></a>
										<?php elseif ($val->status == 0) : ?>
											&nbsp;&nbsp;&nbsp;<a title="Active"
																 href="<?php echo base_url('admin/option_active/' . $val->id) ?>"><i
													style="color:green" class="fa fa-check icon-edit"></i></a>
										<?php endif; ?>

										
									</td>
									<td  colspan="2">
									    <?php if ($val->status == 0) : ?>
											&nbsp;&nbsp;&nbsp;
											<a title="Bet Cancelled" href="<?php echo base_url('admin/bet_match_cancel/' . $val->id) ?>">
											    <i style="color:red" class="fa fa-money icon-edit"></i>
											</a> 
											<!-- <p style="font-size:8px;color: whitesmoke;">Bet Cancel</p> -->
										<?php endif; ?>
										<?php if ($val->status == 4): ?>
											&nbsp;&nbsp;&nbsp;<a
												class="option-modal"
												onclick="return confirm('Are you sure to rollback this bet?');"
												href="<?= base_url('admin/bet_rollback_if_failed/' . $val->id . '/'.$matchId) ?>"
												title="Rollback If Full Option Cancel"><i class="fa fa-rotate-left icon-edit"
																	  style="color: #9e1317"></i></a>
										<?php endif; ?>
									</td>
								  	<tr>
										<tr style="background: #bbd2c5;background: -webkit-linear-gradient(to right, #bbd2c5, #536976, #292e49);  background: linear-gradient(to right, #bbd2c5, #536976, #292e49);">
											<td>Option Name</td>
											<td style="width: 90px;">Coin</td>
											<td style="width: 90px;">Multi Coin</td>
											<td style="width: 90px;">Limit</td>
											<td style="color: white;">Serial</td>
											<td style="color: white;">Status</td>
											<td style="color: white;" colspan="2">Action</td>
										</tr>
									<?php foreach ($option_data as $op) : ?>
										<tr>
											<td><?php echo $op->option_title; ?>  <span style="background:green; color: whitesmoke;padding: 1.5px;border-radius: 5px;margin-left: 1px;">T.B: <?= get_total_bet_running($op->id); ?> </span><span style="background:#dc3545; color: whitesmoke;padding: 1.5px;border-radius: 5px;margin-left: 1px;"> T.R: <?= get_total_bet_return($op->id); ?></span> </td>
											<td>
												<input class="form-control input-sm" onchange="return onBlurEnterPress(<?= $op->id ?>);" id="option_coin_<?= $op->id ?>" value="<?php echo $op->option_coin; ?>" style="width: 90px;">
												<p id="coin_cng_result_<?= $op->id ?>"></p>
	                                        </td>
	                                        <td>
	                                        	<input class="form-control input-sm" onchange="return onBlurEnterPressMulti(<?= $op->id ?>);" id="multi_option_coin_<?= $op->id ?>" value="<?php echo $op->multi_option_coin; ?>" style="width: 90px;">
	                                        	<p id="multi_coin_cng_result_<?= $op->id ?>"></p>
	                                        </td>
											<td>
												<input class="form-control input-sm" onchange="return onBlurEnterPressLimit(<?= $op->id ?>);" id="option_limit_<?= $op->id ?>" value="<?php echo $op->limit_option_coin; ?>" style="width: 90px;">
	                                        	<p id="option_limit_change_<?= $op->id ?>"></p>
	                                        </td>
											<td><?php echo $op->option_serial; ?></td>
											<td>
												<?php
													if ($op->status == 4) {
														echo '<span class="badge badge-warning">Hide</span>';
														$sts = 0;
													}
													if ($op->status == 3) {
														echo '<span class="badge badge-danger">Failed</span>';
													}
													if ($op->status == 2) {
														echo '<span class="badge badge-success">Win</span>';
													}
													if ($op->status == 1) {
														echo '<span class="badge badge-complete">Active</span>';
														$sts = 0;
													}
													if ($op->status == 0) {
														echo '<span class="badge badge-pending">Inactive</span>';
														$sts = 1;
													}
												?>
											</td>
											<td colspan="2">
												<!-- <a class="coin-modal" data-value="<?php //echo $op->option_coin; ?>"
												   data-id="<?php //echo $op->id; ?>" data-toggle="modal"
												   data-target="#scrollmodal3" title="Update Coin"><i
														class="fa fa-btc icon-edit" style="color:red"></i></a> -->

												&nbsp;&nbsp;&nbsp;<a
													class="option-modal"
													data-title="<?php echo $op->option_title; ?>"
													data-id="<?php echo $op->id; ?>"
													data-option_serial="<?php echo $op->option_serial; ?>"
													data-toggle="modal"
													data-target="#scrollmodal4"
													title="Edit Option"><i class="fa fa-edit icon-edit"
																		   style="color:green"></i></a>

												<?php if ($op->status == 0 || $op->status == 1 || $op->status == 4): ?>
													&nbsp;&nbsp;&nbsp;<a
														class="option-modal"
														href="<?= base_url('admin/status_change_option_coin/' . $op->id . '/' . $sts . '/' . $op->match_id) ?>"
														title="Active/Inactive"><i class="fa fa-power-off icon-edit"
																				   style="color:<?= $op->status = 1 ? "red" : "green"; ?>"></i></a>
												<?php elseif ($op->status == 2): ?>
													&nbsp;&nbsp;&nbsp;<a
														class="option-modal"
														onclick="return confirm('Are you sure to rollback this bet?');"
														href="<?= base_url('admin/bet_rollback/' . $op->id . '/' . $op->match_id . '/' . $op->match_option_id) ?>"
														title="Win Cancel"><i class="fa fa-rotate-left icon-edit"
																			  style="color: #9e1317"></i></a>
												<?php endif; ?>


												<?php if ($op->status != 4): ?>

												&nbsp;&nbsp;&nbsp;<a
													class="option-modal"
													onclick="return confirm('Are you sure to hide this bet?');"
													href="<?= base_url('admin/bet_option_details_hide_show/' . $op->id . '/' . $op->match_id) ?>"
													title="Hide Bet Option Details"><i class="fa fa-feed icon-edit"
																					   style="color: #dd4242"></i></a>
												<?php endif; ?>

											</td>
										</tr>
									<?php endforeach; ?> 
									</tr>
								</tr> 
							<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>


		<!-- Modal Start -->

		<!-- edit bet option -->
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
												<strong class="card-title">Match Bet Name</strong>
											</div>
											<div class="card-body">
												<!-- Credit Card -->
												<div id="pay-invoice">
													<div class="card-body">

														<form
															action="<?php echo base_url('admin/edit_match_bet_name'); ?>"
															method="post">
															<input id="hidden_match_bet_id" type="hidden"
																   name="hidden_match_bet_id">

															<div class="form-group has-success">
																<label for="match_option_title"
																	   class="control-label mb-1">Match Bet
																	Title</label>
																<input id="match_option_title" name="match_option_title"
																	   type="text" class="form-control" required>
															</div>
															<div class="form-group has-success">
																<label for="match_option_title"
																	   class="control-label mb-1">Match Serial</label>
																<input id="match_option_serial"
																	   name="match_option_serial" type="text"
																	   class="form-control" required>
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

		<!-- update coin -->
		<div class="modal fade" id="scrollmodal3" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel"
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
												<strong class="card-title">Update Coin</strong>
											</div>
											<div class="card-body">
												<!-- Credit Card -->
												<div id="pay-invoice">
													<div class="card-body">

														<form action="<?php echo base_url('admin/edit_option_coin'); ?>"
															  method="post">
															<input id="hidden_match_coin" type="hidden"
																   name="hidden_match_coin">

															<div class="form-group has-success">
																<label for="option_coin" class="control-label mb-1">Coin
																	Value</label>
																<input id="option_coin" name="option_coin" type="text"
																	   class="form-control" required>
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

		<!-- change option -->
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
												<strong class="card-title">Change Option Title</strong>
											</div>
											<div class="card-body">
												<!-- Credit Card -->
												<div id="pay-invoice">
													<div class="card-body">

														<form
															action="<?php echo base_url('admin/edit_option_title'); ?>"
															method="post">
															<input id="hidden_option_title" type="hidden"
																   name="hidden_option_title">

															<div class="form-group has-success">
																<label for="option_title" class="control-label mb-1">Option
																	Title</label>
																<input id="option_title" name="option_title" type="text"
																	   class="form-control" required>
															</div>

															<div class="form-group has-success">
																<label for="option_serial" class="control-label mb-1">Option
																	Serial</label>
																<input id="option_serial" name="option_serial"
																	   type="text" class="form-control" required>
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

		<!-- Result Modal -->
		<div class="modal fade" id="scrollmodal5" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel"
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
												<strong class="card-title">Result</strong>
											</div>
											<div class="card-body">
												<!-- Credit Card -->
												<div id="pay-invoice">
													<div class="card-body">

														<form
															action="<?php echo base_url('admin/published_bet_result'); ?>"
															method="post">
															<input id="hidden_bet_id" type="hidden"
																   name="hidden_bet_id">

															<div class="form-group has-success">
																<label for="match_bet_title" class="control-label mb-1">Match
																	Bet Title</label>
																<input id="match_bet_title" name="match_bet_title"
																	   type="text" class="form-control" required>
															</div>

															<div class="form-group has-success">
																<label for="option_coin" class="control-label mb-1">Bet
																	Option Name</label>
																<select id="bet_option_id" name="bet_option_id"
																		class="form-control" required="true">
																	<option value="">-- select --</option>
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

		<!-- add match option -->
		<div class="modal fade" id="scrollmodal6" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel"
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
												<strong class="card-title">Create Match Option for team
													: <?php echo $match_name; ?></strong>
											</div>
											<div class="card-body">
												<!-- Credit Card -->
												<div id="pay-invoice">
													<div class="card-body">

														<form
															action="<?php echo base_url('admin/create_match_option_viewpage'); ?>"
															method="post">
															<input id="hidden_match_option_id" type="hidden"
																   name="match_option_id" value="">

															<div class="row">
																<div class="col-lg-8">
																	<div class="form-group has-success">
																		<label for="match_option_name"
																			   class="control-label mb-1">Match Option
																			Name</label>
																		<input id="match_option_name"
																			   name="match_option_name" type="text"
																			   class="form-control" required>
																	</div>
																</div>
																<div class="col-lg-2">
																	<div class="form-group has-success">
																		<label for="match_option_serial"
																			   class="control-label mb-1">Serial</label>
																		<input required name="match_option_serial"
																			   type="number"
																			   class="form-control">
																	</div>
																</div>
																<div class="col-lg-1">
																	<div class="form-group">
																		<a id="add" style="color:#fff;margin-top:25px;"
																		   class="btn btn-success "> <i
																				class="fa fa-plus"></i> </a>
																	</div>
																</div>
																<div class="col-lg-1">
																	<div class="form-group">
																		<a id="minus"
																		   style="color:#fff;margin-top:25px;"
																		   class="btn btn-danger "> <i
																				class="fa fa-minus"></i> </a>
																	</div>
																</div>
															</div>


															<div class="row">
																<div class="col-lg-1">
																	<div class="form-group">
																		<label for="first_option_title"
																			   class="control-label mb-1">#</label>
																		<input type="checkbox"
																			   class="itemRow form-control">
																	</div>
																</div>
																<div class="col-lg-7">
																	<div class="form-group has-success">
																		<label for="first_option_title"
																			   class="control-label mb-1">Title</label>
																		<input name="first_option_title[]" type="text"
																			   class="form-control" required>
																	</div>
																</div>

																<div class="col-lg-2">
																	<div class="form-group has-success">
																		<label for="first_option_coin"
																			   class="control-label mb-1">Coin</label>
																		<input name="first_option_coin[]" type="text"
																			   class="form-control" required>
																	</div>
																</div>

																<div class="col-lg-2">
																	<div class="form-group has-success">
																		<label for="first_multi_option_coin"
																			   class="control-label mb-1">Multi Coin</label>
																		<input name="first_multi_option_coin[]" type="text"
																			   class="form-control" required>
																	</div>
																</div>

																<div class="col-lg-2">
																	<div class="form-group has-success">
																		<label for="first_option_serial"
																			   class="control-label mb-1">Serial</label>
																		<input name="first_option_serial[]"
																			   type="number" min="1"
																			   class="form-control" required>
																	</div>
																</div>

															</div>


															<div class="add-options"></div>
															
															<div class="form-group">
																<label for="status" class="control-label mb-1">Status</label>
																<select name="status" class="form-control" required>
																	<option value="">--- select ---</option>
																	<option value="1" selected>Active</option>
																	<option value="0">Inactive</option>
																</select>
															</div>

															<div>
																<input type="submit" name="submit" value="Submit"
																	   class="btn btn-lg btn-info btn-block">
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
					</div>
				</div>
			</div>
		</div>

		<!-- add new bet option-->
		<div class="modal fade" id="addnewbetoption" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel"
			 aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<strong class="card-title">Create Match Option for team : <?php echo $match_name; ?></strong>
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
												<strong class="card-title">Option Title : <b id="op_title"></b></strong>
											</div>
											<div class="card-body">
												<!-- Credit Card -->
												<div id="pay-invoice">
													<div class="card-body">

														<form
															action="<?php echo base_url('admin/create_new_option_foroldmatch'); ?>"
															method="post">
															<input id="add_hdn_match_op_id" type="hidden"
																   name="add_hdn_match_op_id" value="">

															<input id="add_hdn_match_id" type="hidden"
																   name="add_hdn_match_id" value="">

															<div class="row">
																<div class="col-lg-1">
																	<div class="form-group">
																		<label for="first_option_title"
																			   class="control-label mb-1">#</label>
																		<input type="checkbox"
																			   class="itemRow form-control">
																	</div>
																</div>
																<div class="col-lg-7">
																	<div class="form-group has-success">
																		<label for="first_option_title"
																			   class="control-label mb-1">Title</label>
																		<input name="first_option_title[]" type="text"
																			   class="form-control" required>
																	</div>
																</div>

																<div class="col-lg-2">
																	<div class="form-group has-success">
																		<label for="first_option_coin"
																			   class="control-label mb-1">Coin</label>
																		<input name="first_option_coin[]" type="text"
																			   class="form-control" required>
																	</div>
																</div>

																<div class="col-lg-2">
																	<div class="form-group has-success">
																		<label for="first_multi_option_coin"
																			   class="control-label mb-1">Multi Coin</label>
																		<input name="first_multi_option_coin[]" type="text"
																			   class="form-control" required>
																	</div>
																</div>

																<div class="col-lg-2">
																	<div class="form-group has-success">
																		<label for="first_option_serial"
																			   class="control-label mb-1">Serial</label>
																		<input name="first_option_serial[]"
																			   type="number" min="1"
																			   class="form-control" required>
																	</div>
																</div>

															</div>


															<div class="add-options-n"></div>


															<div class="row">

																<div class="col-lg-1">
																	<div class="form-group">
																		<a id="addn" style="color:#fff;margin-top:5px;"
																		   class="btn btn-success "> <i
																				class="fa fa-plus"></i> </a>
																	</div>
																</div>
																<div class="col-lg-1">
																	<div class="form-group">
																		<a id="minusn"
																		   style="color:#fff;margin-top:5px;"
																		   class="btn btn-danger "> <i
																				class="fa fa-minus"></i> </a>
																	</div>
																</div>
																<div class="col-lg-10">
																	<div class="form-group">
																		<input type="submit" name="submit"
																			   value="Submit"
																			   class="btn btn-lg btn-info btn-block">
																	</div>
																</div>

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
					</div>
				</div>
			</div>
		</div>

		<!-- Modal End -->


	</div>
</div>

<?php include(APPPATH . "views/admin/common/footer.php"); ?>
<script type="text/javascript">

	$("#minus").hide();
	$("#minusn").hide();

	$("#add").on("click", function () {
		var addOtionHtml = "<div class=\"row option-data\">\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"col-lg-1\">\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"form-group\">\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<label for=\"first_option_title\"\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   class=\"control-label mb-1\">#</label>\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" class=\"itemRow form-control\">\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</div>\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</div>\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"col-lg-7\">\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"form-group has-success\">\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<label for=\"first_option_title\"\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   class=\"control-label mb-1\">Title</label>\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<input name=\"first_option_title[]\" type=\"text\"\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   class=\"form-control\" required>\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</div>\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</div>\n" +
			"\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"col-lg-2\">\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"form-group has-success\">\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<label for=\"first_option_coin\"\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   class=\"control-label mb-1\">Coin</label>\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<input name=\"first_option_coin[]\" type=\"text\"\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   class=\"form-control\" required>\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</div>\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</div>\n" +
			"\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"col-lg-2\">\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"form-group has-success\">\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<label for=\"first_multi_option_coin\"\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   class=\"control-label mb-1\">Multi Coin</label>\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<input name=\"first_multi_option_coin[]\" type=\"text\"\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   class=\"form-control\" required>\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</div>\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</div>\n" +
			"\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"col-lg-2\">\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"form-group has-success\">\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<label for=\"first_option_serial\"\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   class=\"control-label mb-1\">Serial</label>\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<input name=\"first_option_serial[]\"\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   type=\"number\" min=\"1\"\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   class=\"form-control\" required>\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</div>\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</div>\n" +
			"\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</div>";

		$(".add-options").append(addOtionHtml);
		if ($(".option-data").length > 0) $("#minus").show();
	});

	$("#minus").on("click", function () {
		$(".itemRow:checked").each(function () {
			$(this).closest('div.option-data').remove();
		});
		if ($(".option-data").length < 1) $("#minus").hide();
	});

	$("#addn").on("click", function () {
		var addOtionHtml = "<div class=\"row option-data-n\">\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"col-lg-1\">\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"form-group\">\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<label for=\"first_option_title\"\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   class=\"control-label mb-1\">#</label>\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" class=\"itemRow form-control\">\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</div>\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</div>\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"col-lg-7\">\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"form-group has-success\">\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<label for=\"first_option_title\"\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   class=\"control-label mb-1\">Title</label>\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<input name=\"first_option_title[]\" type=\"text\"\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   class=\"form-control\" required>\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</div>\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</div>\n" +
			"\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"col-lg-2\">\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"form-group has-success\">\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<label for=\"first_option_coin\"\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   class=\"control-label mb-1\">Coin</label>\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<input name=\"first_option_coin[]\" type=\"text\"\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   class=\"form-control\" required>\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</div>\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</div>\n" +
			"\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"col-lg-2\">\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"form-group has-success\">\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<label for=\"first_multi_option_coin\"\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   class=\"control-label mb-1\">Multi Coin</label>\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<input name=\"first_multi_option_coin[]\" type=\"text\"\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   class=\"form-control\" required>\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</div>\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</div>\n" +
			"\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"col-lg-2\">\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"form-group has-success\">\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<label for=\"first_option_serial\"\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   class=\"control-label mb-1\">Serial</label>\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<input name=\"first_option_serial[]\"\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   type=\"number\" min=\"1\"\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   class=\"form-control\" required>\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</div>\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</div>\n" +
			"\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</div>";

		$(".add-options-n").append(addOtionHtml);
		if ($(".option-data-n").length > 0) $("#minusn").show();
	});

	$("#minusn").on("click", function () {
		$(".itemRow:checked").each(function () {
			$(this).closest('div.option-data-n').remove();
		});
		if ($(".option-data-n").length < 1) $("#minusn").hide();
	});

	$('#match-option-modal').on('click', function () {
		var data_id = $(this).attr('data-id');
		$('#hidden_match_option_id').attr('value', data_id);
	});

	$('.new-bet-add-modal').on('click', function () {
		var data_id = $(this).attr('data-id');
		var data_bettitle = $(this).attr('data-bettitle');
		var data_match_id = $(this).attr('data-match_id');
		$('#add_hdn_match_op_id').attr('value', data_id);
		$('#add_hdn_match_id').attr('value', data_match_id);
		$('#op_title').html(data_bettitle);
	});

	$(document).on('show.bs.modal', function (e) {
		$('body').css('padding-right', '0px');
	});

	$('.bet-edit-modal').on('click', function () {
		var data_id = $(this).attr('data-id');
		var data_bettitle = $(this).attr('data-bettitle');
		var data_match_option_serial = $(this).attr('data-match_option_serial');
		$('#hidden_match_bet_id').attr('value', data_id);
		$('#match_option_title').attr('value', data_bettitle);
		$('#match_option_serial').attr('value', data_match_option_serial);
	});

	$('.bet-result-modal').on('click', function () {
		var data_id = $(this).attr('data-id');
		var data_bettitle = $(this).attr('data-bettitle');
		$('#hidden_bet_id').attr('value', data_id);
		$('#match_bet_title').attr('value', data_bettitle);

		var url_prefix = "<?php echo base_url(); ?>";
		url = url_prefix + 'get_bet_option';

		// ajax request
		$.ajax({
			type: "POST",
			url: url_prefix + 'admin/get_bet_options_for_result',
			data: {
				hidden_bet_id: data_id
			},
			dataType: 'html',
			success: function (data) {
				console.log(data);
				$("#bet_option_id").html("");
				$("#bet_option_id").append(data);
			},
			error: function (exception) {
				console.log(exception);
				alert(exception);
			}
		});

	});

	$('.coin-modal').on('click', function () {
		var data_id = $(this).attr('data-id');
		var data_value = $(this).attr('data-value');
		$('#hidden_match_coin').attr('value', data_id);
		$('#option_coin').attr('value', data_value);
	});

	$('.option-modal').on('click', function () {
		var data_id = $(this).attr('data-id');
		var data_value = $(this).attr('data-title');
		var data_option_serial = $(this).attr('data-option_serial');
		$('#hidden_option_title').attr('value', data_id);
		$('#option_title').attr('value', data_value);
		$('#option_serial').attr('value', data_option_serial);
	});

	$('.btn-go-back').click(function () {
		history.go(-1);
		return false;
	});

	function changeOpStatus(id, sts, mid) {
		// $.ajax({
		// 	type: 'POST',
		// 	url: '<?= base_url() ?>admin/status_change_option_coin',
		// 	data: {
		// 		match_op_id: id, option_status: sts, match_id: mid
		// 	}
		// }).done(function (d) {

		// });
	}

	function tr_col_expand(id) {
		// $("#child_expand_col_"+id);
	}

	function submitSportIdFindQuestion() {
		$("#get_sports").html("Please Wait..");
		var id = $("#sport_ids").val();
		var match_id = $("#match_id").val();
		window.location = '<?= base_url("match_details/view/") ?>' + match_id + '/' + id;
	}

	$("#add_bulk_option").on('click', function () {
		$("#add_bulk_op").fadeIn();
	});



	function onBlurEnterPress(id) {

        // On blur and on enter pressed, call the textChanged function
        $("#option_coin_" + id).blur(optionCoinChanged(id));
        $("#option_coin_" + id).keypress(function (e) {
            var key = e.which;
            if (key == 13)  // the enter key code
            {
                optionCoinChanged(id);
                return false;
            }
        });

    }

    function optionCoinChanged(id) { 
        $('#coin_cng_result_'+id).html("Please Wait");
        var url = '<?php echo base_url('admin/edit_option_coin_new'); ?>';
        var newData = $("#option_coin_" + id).val(); 
        $.ajax({
            url: url,
            type: "POST",
            data: {
                hidden_match_coin: id,
                option_coin: newData
            },
            dataType: 'json',
            success: function (data) {
                if (data.st == 200) {
                	$('#coin_cng_result_'+id).html(""); 
                }
            }
        });
    }

    function onBlurEnterPressMulti(id) {

        // On blur and on enter pressed, call the textChanged function
        $("#option_coin_" + id).blur(optionCoinChangedMulti(id));
        $("#option_coin_" + id).keypress(function (e) {
            var key = e.which;
            if (key == 13)  // the enter key code
            {
                optionCoinChangedMulti(id);
                return false;
            }
        });

    }

    function onBlurEnterPressLimit(id) {

        // On blur and on enter pressed, call the textChanged function
        $("#option_limit_" + id).blur(optionCoinChangedLimit(id));
        $("#option_limit_" + id).keypress(function (e) {
            var key = e.which;
            if (key == 13)  // the enter key code
            {
                optionCoinChangedLimit(id);
                return false;
            }
        });

    }

    function optionCoinChangedMulti(id) { 
        $('#multi_coin_cng_result_'+id).html("Please Wait");
        var url = '<?php echo base_url('admin/edit_multi_option_coin_new'); ?>';
        var newMultiCoinData = $("#multi_option_coin_" + id).val(); 
        $.ajax({
            url: url,
            type: "POST",
            data: {
                hidden_match_coin: id,
                multi_option_coin: newMultiCoinData
            },
            dataType: 'json',
            success: function (data) {
                if (data.st == 200) {
                	$('#multi_coin_cng_result_'+id).html(""); 
                }
            }
        });
    }

    function optionCoinChangedLimit(id) { 
        $('#option_limit_change_'+id).html("Please Wait");
        var url = '<?php echo base_url('admin/edit_limit_option_coin_new'); ?>';
        var newLimitCoinData = $("#option_limit_" + id).val(); 
        $.ajax({
            url: url,
            type: "POST",
            data: {
                hidden_match_coin: id,
                limit_option_coin: newLimitCoinData
            },
            dataType: 'json',
            success: function (data) {
                if (data.st == 200) {
                	$('#option_limit_change_'+id).html(""); 
                }
            }
        });
    }

    function col_expnd_all(match_id,value) {
    	var url = '<?php echo base_url('admin/option_collapse_or_expand_all'); ?>';
    	$.ajax({
            url: url,
            type: "POST",
            data: {
                match_id: match_id,
                value: value
            },
            dataType: 'json',
            success: function (data) {
                if (data.st == 200) {
                	location.reload();
                }
            }
        });
    }
    function active_inactive_all(match_id,value) {
    	var url = '<?php echo base_url('admin/active_inactive_all'); ?>';
    	$.ajax({
            url: url,
            type: "POST",
            data: {
                match_id: match_id,
                value: value
            },
            dataType: 'json',
            success: function (data) {
                if (data.st == 200) {
                	location.reload();
                }
            }
        });
    }

</script>
