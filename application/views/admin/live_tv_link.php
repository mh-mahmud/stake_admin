<?php include(APPPATH . "views/admin/common/header.php"); ?>

<div style="margin-bottom:20px"><?php include(APPPATH . "views/admin/common/flash.php"); ?></div>

<div class="content">

	<div class="animated fadeIn">


		<div class="row">

			<div class="col-lg-12">


				<div class="card">
					<div class="card-header" style="border:1px solid #ddd">
						Link Setup
					</div>
					<div class="card-body card-block">
						<form action="" method="post" enctype="multipart/form-data" class="form-horizontal">


							<div class="row form-group">
								<div class="col col-md-3">
									<label for="text-input" class=" form-control-label">Live TV Link</label>
								</div>
								<div class="col-12 col-md-9">
									<input type="text" value="<?php echo $get_data->live_tv; ?>"
										   name="live_tv" class="form-control" required>
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
					</div>

				</div>

			</div>

		</div>

	</div>
</div>


	<?php include(APPPATH . "views/admin/common/footer.php"); ?>

