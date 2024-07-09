<?php include(APPPATH . "views/admin/common/header.php"); ?>

<div style="margin-bottom:20px"><?php include(APPPATH . "views/admin/common/flash.php"); ?></div>

<div class="content">

	<div class="animated fadeIn">


		<div class="row">

			<div class="col-lg-12">


				<div class="card">
					<div class="card-header" style="border:1px solid #ddd">
						Software Settings
					</div>
					<div class="card-body card-block">
						<form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
						    <div class="row form-group">
								<div class="col col-md-3">
									<label for="text-input" class=" form-control-label" style="color:">Multibet Enable</label>
								</div>
								<div class="col-12 col-md-9">
									<select name="multibet_enable" id="" class="form-control">
										<option value="YES" <?= $get_data->multibet_enable=="YES"?"selected":"" ?>>Yes</option>
										<option value="NO" <?= $get_data->multibet_enable=="NO"?"selected":"" ?>>No</option>
									</select>
								</div>
							</div>
							
							<div class="row form-group">
								<div class="col col-md-3">
									<label for="text-input" class=" form-control-label" style="color:">Multibet Min Limit</label>
								</div>
								<div class="col-12 col-md-9">
									<input type="text" value="<?php echo $get_data->multibet_limit; ?>" name="multibet_limit" class="form-control" required>
								</div>
							</div>

							<div class="row form-group">
								<div class="col col-md-3">
									<label for="bet_limit_min" class=" form-control-label">Club Withdraw Min</label>
								</div>
								<div class="col-12 col-md-9">
									<input type="text" value="<?php echo $get_data->club_withdraw_limit; ?>" name="club_withdraw_limit" class="form-control" required>
								</div>
							</div>
							
							<div class="row form-group">
								<div class="col col-md-3">
									<label for="bet_limit_min" class=" form-control-label">Club Withdraw Max</label>
								</div>
								<div class="col-12 col-md-9">
									<input type="text" value="<?php echo $get_data->club_withdraw_limit_max; ?>" name="club_withdraw_limit_max" class="form-control" required>
								</div>
							</div>

							<div class="row form-group">
								<div class="col col-md-3">
									<label for="bet_limit_min" class=" form-control-label">User Min Balance for Bet</label>
								</div>
								<div class="col-12 col-md-9">
									<input type="text" value="<?php echo $get_data->min_balance_for_bet; ?>" name="min_balance_for_bet" class="form-control" required>
								</div>
							</div>

							<div class="row form-group">
								<div class="col col-md-3">
									<label for="bet_limit_min" class=" form-control-label">Bet Limit Min</label>
								</div>
								<div class="col-12 col-md-9">
									<input type="text" value="<?php echo $get_data->bet_limit_min; ?>" name="bet_limit_min" class="form-control" required>
								</div>
							</div>

							<div class="row form-group">
								<div class="col col-md-3">
									<label for="bet_limit_max" class=" form-control-label">Bet Limit Max</label>
								</div>
								<div class="col-12 col-md-9">
									<input type="text" value="<?php echo $get_data->bet_limit_max; ?>" name="bet_limit_max" class="form-control" required>
								</div>
							</div>

							<div class="row form-group">
								<div class="col col-md-3">
									<label for="withdraw_per_day" class=" form-control-label">Withdraw Request Per Day</label>
								</div>
								<div class="col-12 col-md-9">
									<input type="text" value="<?php echo $get_data->withdraw_per_day; ?>" name="withdraw_per_day" class="form-control" required>
								</div>
							</div>

							<div class="row form-group">
								<div class="col col-md-3">
									<label for="text-input" class=" form-control-label">Deposit Bonus Ratio</label>
								</div>
								<div class="col-12 col-md-9">
									<input type="text" value="<?php echo $get_data->deposit_bonus_ratio; ?>"
										   name="deposit_bonus_ratio" class="form-control" required>
								</div>
							</div>

							<div class="row form-group">
								<div class="col col-md-3">
									<label for="text-input" class=" form-control-label">Bet Cancel Rate</label>
								</div>
								<div class="col-12 col-md-9">
									<input type="text" value="<?php echo $get_data->user_balance_plus_minus; ?>"
										   name="user_balance_plus_minus" class="form-control" required>
								</div>
							</div>
							<input type="hidden" value="<?php echo $get_data->bet_cancel_rate; ?>"
										   name="bet_cancel_rate" class="form-control" required>

							<div class="row form-group">
								<div class="col col-md-3">
									<label for="text-input" class=" form-control-label">Withdraw Charge</label>
								</div>
								<div class="col-12 col-md-9">
									<input type="text" value="<?php echo $get_data->withdraw_charge; ?>"
										   name="withdraw_charge" class="form-control" required>
								</div>
							</div>

							

							

							<div class="row form-group">
								<div class="col col-md-3">
									<label for="text-input" class=" form-control-label">Contact No</label>
								</div>
								<div class="col-12 col-md-9">
									<input type="text" value="<?php echo $get_data->contact_no; ?>"
										   name="contact_no" class="form-control" required>
								</div>
							</div>

							<div class="row form-group">
								<div class="col col-md-3">
									<label for="text-input" class=" form-control-label">Facebook Link</label>
								</div>
								<div class="col-12 col-md-9">
									<input type="text" value="<?php echo $get_data->facebook; ?>"
										   name="facebook" class="form-control" required>
								</div>
							</div>

							<div class="row form-group">
								<div class="col col-md-3">
									<label for="text-input" class=" form-control-label">Youtube Link</label>
								</div>
								<div class="col-12 col-md-9">
									<input type="text" value="<?php echo $get_data->youtube; ?>"
										   name="youtube" class="form-control" required>
								</div>
							</div>

							<div class="row form-group">
								<div class="col col-md-3">
									<label for="text-input" class=" form-control-label">Customer Deposit</label>
								</div>
								<div class="col-12 col-md-9">
									<select name="isDeposit" id="" class="form-control">
										<option value="Yes" <?= $get_data->isDeposit=="Yes"?"selected":"" ?>>Yes</option>
										<option value="No" <?= $get_data->isDeposit=="No"?"selected":"" ?>>No</option>
									</select>
								</div>
							</div>

							<div class="row form-group">
								<div class="col col-md-3">
									<label for="text-input" class=" form-control-label">Minimum Deposit</label>
								</div>
								<div class="col-12 col-md-9">
									<input type="text" value="<?php echo $get_data->min_deposit; ?>"
										   name="min_deposit" class="form-control" required>
								</div>
							</div>

							<div class="row form-group">
								<div class="col col-md-3">
									<label for="text-input" class=" form-control-label">Maximum Deposit</label>
								</div>
								<div class="col-12 col-md-9">
									<input type="text" value="<?php echo $get_data->max_deposit; ?>"
										   name="max_deposit" class="form-control" required>
								</div>
							</div>

							<div class="row form-group">
								<div class="col col-md-3">
									<label for="text-input" class=" form-control-label">Customer Withdraw</label>
								</div>
								<div class="col-12 col-md-9">
									<select name="isWithdraw" id="" class="form-control">
										<option value="Yes" <?= $get_data->isWithdraw=="Yes"?"selected":"" ?>>Yes</option>
										<option value="No" <?= $get_data->isWithdraw=="No"?"selected":"" ?>>No</option>
									</select>
								</div>
							</div>
							
							<div class="row form-group">
								<div class="col col-md-3">
									<label for="text-input" class=" form-control-label">Club Withdraw</label>
								</div>
								<div class="col-12 col-md-9">
									<select name="isClubWithdraw" id="" class="form-control">
										<option value="Yes" <?= $get_data->isClubWithdraw=="Yes"?"selected":"" ?>>Yes</option>
										<option value="No" <?= $get_data->isClubWithdraw=="No"?"selected":"" ?>>No</option>
									</select>
								</div>
							</div>

							<div class="row form-group">
								<div class="col col-md-3">
									<label for="text-input" class=" form-control-label">Minimum Withdraw</label>
								</div>
								<div class="col-12 col-md-9">
									<input type="text" value="<?php echo $get_data->min_withdraw; ?>"
										   name="min_withdraw" class="form-control" required>
								</div>
							</div>

							<div class="row form-group">
								<div class="col col-md-3">
									<label for="text-input" class=" form-control-label">Maximum Withdraw</label>
								</div>
								<div class="col-12 col-md-9">
									<input type="text" value="<?php echo $get_data->max_withdraw; ?>"
										   name="max_withdraw" class="form-control" required>
								</div>
							</div>

							<div class="row form-group">
								<div class="col col-md-3">
									<label for="text-input" class=" form-control-label">Minimum Transfer</label>
								</div>
								<div class="col-12 col-md-9">
									<input type="text" value="<?php echo $get_data->min_transfer; ?>"
										   name="min_transfer" class="form-control" required>
								</div>
							</div>

							<div class="row form-group">
								<div class="col col-md-3">
									<label for="text-input" class=" form-control-label">Maximum Transfer</label>
								</div>
								<div class="col-12 col-md-9">
									<input type="text" value="<?php echo $get_data->max_transfer; ?>"
										   name="max_transfer" class="form-control" required>
								</div>
							</div>


							<div class="row form-group">
								<div class="col col-md-3">
									<label for="text-input" class=" form-control-label">Bet Cancel Time</label>
								</div>
								<div class="col-12 col-md-9">
									<textarea class="form-control" name="bet_cancel_time" placeholder="Give Bet Cancel Time as Formate"><?php echo $get_data->bet_cancel_time; ?></textarea>
								</div>
							</div>

							<div class="row form-group">
								<div class="col col-md-3">
									<label for="text-input" class=" form-control-label">Copyright Message</label>
								</div>
								<div class="col-12 col-md-9">
									<textarea type="text" value="<?php echo $get_data->copyright; ?>"
											  name="copyright" class="form-control" required><?php echo $get_data->copyright; ?></textarea>
								</div>
							</div>

							<div class="row form-group">
								<div class="col col-md-3">
									<label for="text-input" class=" form-control-label">&nbsp;</label>
								</div>
								<div class="col-12 col-md-9">
									<input type="submit" name="submit" class="btn btn-success" value="Update Settings">
								</div>
							</div>
						</form>
						
						<hr>

						<div class="row form-group">
							<div class="col col-md-3">
								<label for="text-input" class=" form-control-label">Database Backup</label>
							</div>
							<div class="col-12 col-md-9">
								<a class="btn btn-danger" href="<?php echo base_url(); ?>admin/backup_db">Download</a>
							</div>
						</div>
						
					</div>

				</div>

			</div>

		</div>

	</div>
</div>


	<?php include(APPPATH . "views/admin/common/footer.php"); ?>

