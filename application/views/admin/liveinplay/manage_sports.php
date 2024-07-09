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

<div class="breadcrumbs">
	<div class="breadcrumbs-inner">
		<div class="row m-0">
			<div class="col-sm-4">
				<div class="page-header float-left">
					<div class="page-title">
						<h1>Manage Sports</h1>
					</div>
				</div>
			</div>
			<div class="col-sm-8">
				<div class="page-header float-right">
					<div class="page-title">
						<ol class="breadcrumb text-right">
							<li>
								<a style="font-size: 13px;" class="btn btn-success btn-sm" href="#" data-toggle="modal" data-target="#addSportsModal">Add New</a>
							</li>
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
				<div class="card">
					<div class="card-header">
						<strong class="card-title">&nbsp;</strong>
					</div>
					<div class="card-body">
						<table id="bootstrap-data-table" class="table table-striped table-bordered">
							<thead class="thead-dark">
							<tr>
								<th>Serial</th>
								<th>Sports Name</th>
								<th>Image</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
							</thead>
							<label class="label-succes"></label>
							<tbody>
							<?php foreach ($names as $val) : ?>
								<tr>
									<td><?= $val->serial; ?></td>
									<td><?= $val->name; ?></td>
									<td>
										<img width="20"
											 src="<?php echo base_url(); ?>assets/img/icon/<?php echo $val->image; ?>">
									</td>
									<td>
										<?php
										if ($val->active_status == 1) {
											echo '<span class="badge badge-success">Active</span>';
										} else {
											echo '<span class="badge badge-danger">Inactive</span>';
										}
										?>
									</td>
									<td>
										<a href="javascript:void(0);" onclick="return sportsStatusChange(<?= $val->id; ?>,<?= $val->active_status==1?0:1; ?>);"><i class="fa fa-check-square"></i></a>
										&nbsp;&nbsp;&nbsp;
										<a href="javascript:void(0);" data-toggle="modal" data-target="#addSportsModal" onclick="return editSports(<?= $val->id; ?>);"><i class="fa fa-edit icon-edit"></i></a>
									</td>
								</tr>
							<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="addSportsModal" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel"
	 aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<strong class="card-title">Create Sports</strong>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<div class="container">


					<div class="card-body">

						<form id="createNewSports">
							<input type="hidden" name="edit_sports_id" id="edit_sports_id" value="">
							<div class="row">
								<div class="col-lg-10">
									<div class="form-group has-success">
										<label for="sports_name" class="control-label mb-1">Sports
											Name</label>
										<input id="sports_name" name="sports_name" type="text"
											   class="form-control" required>
									</div>
								</div>
								<div class="col-lg-10">
									<div class="form-group has-success">
										<label for="sports_serial" class="control-label mb-1">Serial</label>
										<input id="sports_serial" name="sports_serial" type="number"
											   class="form-control" required>
									</div>
								</div>

								<div class="col-lg-10">
									<div class="form-group has-success">
										<label for="sports_icon" class="control-label mb-1">Icon</label>
 										<?php foreach ($sports_icon as $val): ?>
											<label>
												<input type="radio" class="form-control" name="sports_icon" value="<?php echo $val->file_name; ?>" required>
												<img src="<?php echo base_url() ?>assets/img/icon/<?php echo $val->file_name; ?>" width="40;" alt="">
											</label>
										<?php endforeach; ?>
									</div>
								</div>
							</div>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<p id="error" style="color:red "></p>
				<p id="success" style="color:green "></p>
				<button type="button" class="btn btn-secondary" id="close" data-dismiss="modal">Cancel</button>
				 <button type="submit" id="submit_value" class="btn btn-primary">Confirm</button>
			</div>
			</form>
		</div>
	</div>
</div>


<?php include(APPPATH . "views/admin/common/footer.php"); ?>


<script>
	$("#success").html("");
	$("#error").html("");

	$(".close").on('click',function () {
		window.location='manage_sports';
	});
	$("#close").on('click',function () {
		window.location='manage_sports';
	});

	$('#createNewSports').submit(function () {
		$('#submit_value').attr("disabled", true);
		$('#submit_value').html("Please Wait");
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url()?>admin/sports_create',
			data: $(this).serialize(),
			dataType: 'json'
		})
		.done(function (data) {
			if (data.st==200){
				$("#success").html("");
				$("#success").html(data.msg);
				window.location='manage_sports';
			}

			if (data.st==400){
				$("#error").html("");
				$("#error").html(data.msg);
			}
		})
		.fail(function () {
			$("#error").html("");
			$("#error").html("Post failed");
		});
		return false;
	});


	function sportsStatusChange(id,status) {
		swal(
			{
				title: "Confirm",
				type: "warning",
				confirmButtonText: "OK",
				showCancelButton: true,
			}, function (isConfirm) {
				if (isConfirm) {
					$.ajax({
						type: 'POST',
						url: '<?php echo base_url()?>admin/sports_status_change',
						data: {
							id: id, status: status
						},
						dataType: 'json'
					})
						.done(function (data) {
							if (data.st==200){

								window.location='manage_sports';
							}

							if (data.st==400){
								swal({
									title: data.msg,
									type: "error",
									timer: 2000,
									confirmButtonText: "OK"
								});
								return false;
							}
						})
						.fail(function () {
							swal({
								title: "POST Failed",
								type: "error",
								timer: 2000,
								confirmButtonText: "OK"
							});
							return false;
						});
				}
			}
		);

		return false;
	}

	function editSports(id) {

		$.ajax({
			type: "POST",
			url: '<?php echo base_url()?>admin/sports_edit',
			data: {id:id},
			dataType: 'json',
			success: function(res) {
				$("#edit_sports_id").val(res.sport_id);
				$("#sports_name").val(res.name);
				$("#sports_serial").val(res.serial);

			},
			error:function(request, status, error) {
				console.log("ajax call went wrong:" + request.responseText);
			}
		});

	}

</script>
