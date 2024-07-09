<div class="breadcrumbs">
	<div class="breadcrumbs-inner">
		<div class="row m-0">
			<div class="col-sm-8">
				<div class="page-header float-left">
					<div class="page-title">
						<h1><?php echo $team_title; ?></h1>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="page-header float-right">
					<div class="page-title">
						<ol class="breadcrumb text-right">
							<li><a style="font-size: 13px;color:#fff" class="btn btn-danger btn-sm btn-go-back">Go Back</a></li>
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

			<div class="col-md-10">
				<form id="submit_new_question_form">
					<div class="card">
						<div class="card-header">
							<strong class="card-title">Bet Question Edit Form For: <?= $team_title;?></strong>
						</div>
						<div class="card-body">
							<input type="hidden" value="<?= $match_id; ?>" name="match_id">
						</div>

						<div class="card-body">

							<?php
							$sports_q = $this->db->query("SELECT * FROM `bet_question` WHERE `sports_id` = '{$sports_id}' ORDER BY id ASC")->result();
							$i=1;

							foreach ($sports_q as $val):
								?>
								<table class="option_menu_<?= $i; ?>">
									<thead>
									<tr>
										<th colspan="4" style="text-align: center">Question Form <?= $i; ?></th>
									</tr>
									<tr>
										<th><input type="checkbox" class="itemMenu" id="question_ck_<?= $i; ?>" name="question_ck"></th>
										<th colspan="2"><input type="text" class="form-control" id="question_<?= $i; ?>" name="question[<?= $i; ?>]" value="<?= $val->question;	 ?>" placeholder="type question here"></th>
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
											<td><input type="checkbox" class="itemRow" id="option_ck_<?= $i; ?>"></td>
											<td><input type="text" class="form-control" id="question_option_<?= $i; ?>" value="<?= $val_op->option_title; ?>" name="question_option[<?= $i; ?>][]"></td>
											<td><input type="text" class="form-control" id="option_coin_<?= $i; ?>" value="<?= $val_op->option_coin; ?>" name="option_coin[<?= $i; ?>][]"></td>
											<td><input type="text" class="form-control" id="multi_option_coin_<?= $i; ?>" value="<?= $val_op->multi_option_coin; ?>" name="multi_option_coin[<?= $i; ?>][]"></td>
											<td><input type="number" class="form-control" id="option_serial_<?= $i; ?>" value="<?= $val_op->option_serial; ?>" name="option_serial[<?= $i; ?>][]"></td>
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
			url: '<?= base_url('admin/create_bulk_match_option_viewpage')?>',
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
				window.location='<?= base_url("match_details/view/") ?>'+data.sid;
			}

		}).fail(function () {

		});
	});

	$('.btn-go-back').click(function () {
		history.go(-1);
		return false;
	});
</script>
