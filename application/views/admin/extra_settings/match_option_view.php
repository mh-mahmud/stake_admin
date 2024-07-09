
<style>
	table {
		font-size: 14px;
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

</style>


<div class="content">
	<div class="animated fadeIn">
		<div class="row">

			<div class="col-md-10">
				<form id="submit_new_question_form">
					<div class="card">
						<div class="card-header">
							<strong class="card-title">Bet Question Edit Form</strong>
						</div>
						<div class="card-body">
							<input type="hidden" value="<?= $bet_question_sports_id; ?>" name="sports_old_id">
							<div class="form-group">
								<label for="sportsname">Select Sport</label>
								<select name="sport_id" id="sport_id" class="form-control">
									<option value="">--select--</option>
									<?php
									foreach ($sport_ids as $val):
										?>
										<option value="<?= $val->id ?>" <?= $bet_question_sports_id==$val->id?"selected":"" ?>><?= $val->name ?></option>
									<?php endforeach; ?>
								</select>
							</div>

						</div>

						<div class="card-body">



							<?php
							$sports_q = $this->db->query("SELECT * FROM `bet_question` WHERE sports_id = '{$bet_question_sports_id}' ORDER BY id ASC")->result();
							$i=1;
							foreach ($sports_q as $val):
								?>
								<table class="option_menu_<?= $i; ?>">
									<thead>
									<tr>
										<th colspan="4" style="text-align: center">Question Form <?= $i; ?></th>
									</tr>
									<tr>
										<th><input type="checkbox" class="itemMenu" id="question_ck" name="question_ck"></th>
										<th colspan="2"><input type="text" class="form-control" id="question" name="question[<?= $i; ?>]" value="<?= $val->question;	 ?>" placeholder="type question here"></th>
										<th><input type="number" class="form-control" id="question_serial_<?= $i; ?>" name="question_serial[<?= $i; ?>]" value="<?= $val->serial;	 ?>"></th>
										<th><button type="button" value="<?= $i; ?>" class="btn btn-success addNewOption_<?= $i; ?>" onclick="return addchildoption(this.value);">+</button>&nbsp;<button type="button" value="<?= $i; ?>" class="btn btn-danger removeOption_<?= $i; ?>" onclick="return removeChildOption(this.value);">-</button></th>
									</tr>
									<tr>
										<th>#</th>
										<th>Option</th>
										<th>Coin</th>
										<th>Multi Coin</th>
										<th>Serial</th>
									</tr>
									</thead>
									<tbody>
									<?php
									$q_op = $this->db->query("SELECT * FROM `bet_question_option` WHERE question_id = '{$val->id}' ORDER BY id ASC")->result();

									foreach ($q_op as $val_op):
										?>

										<tr>
											<td><input type="checkbox" class="itemRow" id="option_ck"></td>
											<td><input type="text" class="form-control" id="question_option" value="<?= $val_op->option_title; ?>" name="question_option[<?= $i; ?>][]"></td>
											<td><input type="text" class="form-control" id="option_coin" value="<?= $val_op->option_coin; ?>" name="option_coin[<?= $i; ?>][]"></td>
											<td><input type="text" class="form-control" id="multi_option_coin" value="<?= $val_op->multi_option_coin; ?>" name="multi_option_coin[<?= $i; ?>][]"></td>
											<td><input type="number" class="form-control" id="option_serial" value="<?= $val_op->option_serial; ?>" name="option_serial[<?= $i; ?>][]"></td>
										</tr>
									<?php endforeach; ?>
									</tbody>
								</table>
								<br>
								<?php $i++; endforeach; ?>
							<br>
							<div id="add_new_option">
							</div>
						</div>
					</div>

					<button class="btn btn-info float-right" type="submit" id="submit_value">Update</button>
				</form>
				<button type="button" class="btn btn-success addOptionMenu">+</button> &nbsp;
				<button type="button" class="btn btn-danger removeOptionMenu">-</button>
			</div>

		</div>
	</div>
</div>

<?php include(APPPATH . "views/admin/common/footer.php"); ?>


<script>
	$('#submit_new_question_form').submit(function (e) {
		e.preventDefault();

		$('#submit_value').attr("disabled", true);
		$('#submit_value').html("Please Wait");

		$.ajax({
			type: 'POST',
			url: '<?= base_url('extrasettings/edit_bet_question')?>',
			data: $(this).serialize(),
			dataType: 'json',
		}).done(function (data) {

			if (data.st==200){
				$('#submit_value').attr("disabled", false);
				$('#submit_value').html("Update");
				swal({
					title: data.msg,
					type: "success",
					timer:1500
				});
				window.location='<?= base_url("match_option_save") ?>';
			}

		}).fail(function () {

		});
	});
</script>
