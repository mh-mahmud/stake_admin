
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
							<strong class="card-title">Bet Question Add Form</strong>
						</div>
						<div class="card-body">

							<div class="form-group">
								<label for="sportsname">Select Sport</label>
								<select name="sport_id" id="sport_id" class="form-control">
									<option value="">--select--</option>
									<?php
									foreach ($sport_ids as $val):
										?>
										<option value="<?= $val->id ?>"><?= $val->name ?></option>
									<?php endforeach; ?>
								</select>
							</div>

							<div class="form-group">
								<label for="sportsoptiontitle">Title</label>
								<input type="text" name="option_title" value="" class="form-control" id="option_title" placeholder="Title is here">
							</div>

						</div>

						<div class="card-body">


							<table class="option_menu_1">
								<thead>
								<tr>
									<th colspan="4" style="text-align: center">Question Form 1</th>
								</tr>
								<tr>
									<th><input type="checkbox" class="itemMenu" id="question_ck" name="question_ck"></th>
									<th colspan="2"><input type="text" class="form-control" id="question" name="question[1]" placeholder="type question here"></th>
									<th><input type="number" class="form-control" id="question_serial" name="question_serial[1]"></th>
									<th><button type="button" value="1" class="btn btn-success addNewOption_1" onclick="return addchildoption(this.value);">+</button>&nbsp;<button type="button" value="1" class="btn btn-danger removeOption_1" onclick="return removeChildOption(this.value);">-</button></th>
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
								<tr>
									<td><input type="checkbox" class="form-control itemRow" id="option_ck"></td>
									<td><input type="text" class="form-control" id="question_option" name="question_option[1][]"></td>
									<td><input type="text" class="form-control" id="option_coin" name="option_coin[1][]"></td>
									<td><input type="text" class="form-control" id="multi_option_coin" name="multi_option_coin[1][]"></td>
									<td><input type="number" class="form-control" id="option_serial" name="option_serial[1][]"></td>
								</tr>
								</tbody>
							</table>
							<br>
							<div id="add_new_option">
							</div>
						</div>
					</div>

					<button class="btn btn-info float-right" type="submit" id="submit_value">Submit</button>

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
			url: '<?= base_url('morequestion/save_bet_question')?>',
			data: $(this).serialize(),
			dataType: 'json',
		}).done(function (data) {

			if (data.st==200){
				$('#submit_value').attr("disabled", false);
				$('#submit_value').html("Submit");
				swal({
					title: data.msg,
					type: "success",
					timer:1500
				});
				window.location='<?= base_url("more_match_option_save") ?>';
			}

		}).fail(function () {

		});
	});
</script>
