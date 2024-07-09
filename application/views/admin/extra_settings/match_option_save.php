<?php include(APPPATH . "views/admin/common/header.php"); ?>

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

			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<strong class="card-title">Bet Question</strong>
						<div class="float-right">
							<a style="font-size: 13px;" class="btn btn-success btn-sm"
							   href="<?= base_url('extrasettings/new_question_form') ?>">Add New</a>
						</div>
					</div>
					<div class="card-body">
						<table id="bootstrap-data-table" class="table table-striped table-bordered">
							<thead class="thead-dark">
							<tr>
								<th>#</th>
								<th>Sport</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
							</thead>
							<label class="label-succes"></label>
							<tbody>
							<?php $i=1; foreach ($save_match as $val): ?>
								<tr>
									<td><?= $i; ?></td>
									<td><?= $val->name; ?></td>
									<td><?= $val->status=="Active"?"<a href='".base_url('match_save_st/Inactive/'.$val->sports_id)."'><span class='badge badge-complete'>Active</span></a>":"<a href='".base_url('match_save_st')."/Active/$val->sports_id'><span class='badge badge-cancel'>Inactive</span></a>"; ?></td>
									<td><button type="button" value="<?= $val->sports_id; ?>" onclick="return showQuestion(this.value);" class="btn btn-info">View Questions</button></td>
								</tr>
							<?php $i++; endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<?php include(APPPATH . "views/admin/common/footer.php"); ?>

<script>
	function showQuestion(id) {
		window.location='<?= base_url("match_option_view/")?>'+id;
	}
</script>
