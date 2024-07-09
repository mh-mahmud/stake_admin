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
			<div class="col-sm-8">
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
			<div class="col-sm-4">
				<div class="page-header float-right">
					<div class="page-title">
						<ol class="breadcrumb text-right">
							<li><a style="font-size: 13px;color:#fff" class="btn btn-danger btn-sm btn-go-back">Go
									Back</a></li>
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
				<div class="row" id="add_bulk_op">
					<div class="col-md-6">
						<div class="form-group">
							<select name="sport_ids" id="sport_ids" class="form-control" required>
								<option value="">--select a sport--</option>
								<?php
									$sports = $this->db->query("SELECT more_bet_question.*,sportscategory.name FROM `more_bet_question` INNER JOIN sportscategory ON sportscategory.id=more_bet_question.sports_id WHERE status = 'Active'")->result();
									foreach ($sports as $sval):
								?>
									<option value="<?= $sval->id ?>"><?= $sval->name ?> || <?= $sval->option_title ?></option>
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
			</div>
		</div>
	</div>
</div>

<?php include(APPPATH . "views/admin/common/footer.php"); ?>

<script type="text/javascript">
 
	function submitSportIdFindQuestion() {
		$("#get_sports").html("Please Wait..");
		var id = $("#sport_ids").val();
		var match_id = $("#match_id").val();
		window.location = '<?= base_url("match_details/more_view/") ?>' + match_id + '/' + id;
	}
 
</script>
