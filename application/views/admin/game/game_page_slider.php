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
						<h1>Manage Game Page Slider Image</h1>
					</div>
				</div>
			</div>
			<div class="col-sm-8">
				<div class="page-header float-right">
					<div class="page-title">
						<ol class="breadcrumb text-right">
							<li>
								<a style="font-size: 13px;" class="btn btn-success btn-sm" href="#"
								   data-toggle="modal" data-target="#addSportsIcon">Add New</a>
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
			<?php include(APPPATH."views/admin/common/flash.php"); ?>
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
								<th>Image</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
							</thead>
							<label class="label-succes"></label>
							<tbody>
							<?php $i=1; foreach ($get_game_slider as $val) : ?>
								<tr>
									<td><?= $val->serial; ?></td>
									<td>
										<img width="150" src="<?php echo base_url()."assets/game/". $val->file_name; ?>">
									</td>
									<td>
										<?php
										if ($val->status == 1) {
											echo '<span class="badge badge-success">Active</span>';
										} else {
											echo '<span class="badge badge-danger">Inactive</span>';
										}
										?>
									</td>
									<td>
										<a href="javascript:void(0);" onclick="return change_serial(<?= $val->id ?>);"><i class="fa fa-edit icon-edit"></i></a>
										&nbsp;&nbsp;&nbsp;
										<a href="javascript:void(0);" onclick="return gamesliderStChange(<?= $val->id; ?>,<?= $val->status==1?0:1; ?>);"><i class="fa fa-check-square"></i></a>
										&nbsp;&nbsp;&nbsp;
										<a href="javascript:void(0);" onclick="return deletesliderGame(<?= $val->id; ?>);"><i style="color: red" class="fa fa-close"></i></a>
									</td>
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


<div class="modal fade" id="addSportsIcon" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel"
	 aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<strong class="card-title">Create Game slider</strong>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<div class="container">


					<div class="card-body">

						<form id="upload_form">
							<div class="row">
								<div class="col-lg-10">
									<div class="form-group has-success">
										<label for="sports_serial" class="control-label mb-1">Image</label>
										<input id="image_file" name="image_file" type="file"
											   class="form-control" required>
										<input type="hidden" value="<?= $game_id; ?>" name="game_page_id">
									</div>
								</div>

								<div class="col-lg-10">
									<div class="form-group has-success">
										<label for="sports_serial" class="control-label mb-1">Serial</label>
										<input id="slider_serial" name="slider_serial" type="number"
											   class="form-control" required>
									</div>
								</div>
							</div>
					</div>
				</div>
				<div id ="uploaded_image" style="height:auto; width:auto; float:left; margin: 20px;"></div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" id="cancel_upload" data-dismiss="modal">Cancel</button>
				<button type="submit" class="btn btn-info" name="upload" id="upload">Upload</button>
			</div>
			</form>
		</div>
	</div>
</div>


<?php include(APPPATH . "views/admin/common/footer.php"); ?>


<script>
	$(document).ready(function(){
		$("#cancel_upload").on('click',function () {
			location.reload();
		});
		$('#upload_form').on('submit', function(e){
			e.preventDefault();
			if($('#image_file').val() == '')
			{
				swal(
					{
						title: "Please Select the File",
						type: "error",
						timer: 1500
					}
				);
				return false;
			}
			else
			{
				$.ajax({
					url:"<?php echo base_url(); ?>admin/add_game_page_slider",
					method:"POST",
					data:new FormData(this),
					contentType: false,
					cache: false,
					processData:false,
					success:function(data)
					{
						$('#uploaded_image').html(data);
					}
				});
			}
		});
	});

	function gamesliderStChange(id,status) {
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
						url: '<?php echo base_url()?>admin/game_page_slider_status_change',
						data: {
							id: id, status: status
						},
						dataType: 'json'
					})
						.done(function (data) {
							if (data.st==200){

								location.reload();
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

	function deletesliderGame(id) {
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
						url: '<?php echo base_url()?>admin/game_page_slider_delete',
						data: {
							id: id
						},
						dataType: 'json'
					})
						.done(function (data) {
							if (data.st==200){

								location.reload();
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

	var base_url = '<?= base_url() ?>';
	var game_id = '<?= $game_id; ?>';
	function change_serial(id){
		swal({
			title: "",
			text: "Change Game Page Serial",
			type: "input",
			showCancelButton: true,
			closeOnConfirm: false,
			animation: "slide-from-top",
			inputPlaceholder: "Give serial"
		}, function (inputValue) {
			if (inputValue === false) return false;
			if (inputValue === "") {
				swal.showInputError("You need to write something!"); return false
			}
			window.location=base_url+'admin/change_game_page_slider_serial/'+inputValue+'/'+id+'/'+game_id;
		});
	}


</script>
