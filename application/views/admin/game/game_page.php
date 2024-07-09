<?php include(APPPATH."views/admin/common/header.php"); ?>
<style>
	.table {
		font-size: 12px;
	}
</style>


<?php include(APPPATH."views/admin/common/flash.php"); ?>
<div class="content">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<strong class="card-title">Game Pages</strong>
					</div>
					<div class="card-body">
						<table id="dataTable" class="table table-striped table-bordered">
							<thead class="thead-dark">
							<tr>
								<th>#</th>
								<th>Game Name</th>
								<th>Page Image</th>
								<th>Created Date</th>
								<th>Status</th>
								<th>Page Serial</th>
								<th>Action</th>
							</tr>
							</thead>
							<tbody>
							<?php $i=1; foreach($get_data as $val) : ?>
								<tr>
									<td><?= $i; ?></td>
									<td><?= $val->page_name; ?></td>
									<td><img src="<?= base_url()."assets/game/". $val->page_image; ?>" width="100" height="40"></td>
									<td><?= $val->created_date; ?></td>
									<td><span class="badge <?= $val->status == "Active"?"badge-success":"badge-danger" ?>"><?= $val->status; ?></span></td>
									<td><?= $val->serial; ?></td>
									<td>
										<a href="<?= base_url() ?>game_page/view/<?= $val->id ?>"><i class="fa fa-eye icon-edit"></i></a>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<?php if($val->status == "Active") : ?>
											<a onclick="return confirm('Are you sure change this status?');"  href="<?= base_url('game_inactive/'.$val->id); ?>"><i class="fa fa-times icon-delete"></i></a>
										<?php elseif($val->status == "Inactive") : ?>
											<a onclick="return confirm('Are you sure change this status?');"  href="<?= base_url('game_active/'.$val->id); ?>"><i style="color:green" class="fa fa-check icon-delete"></i></a>
										<?php endif; ?>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

										<a href="javascript:void(0);" onclick="return change_serial(<?= $val->id ?>);"><i class="fa fa-edit icon-edit"></i></a>

										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

										<a href="#" class="game_img_upload" data-game_page_id = "<?= $val->id ?>" data-toggle="modal" data-target="#addSportsIcon"><i class="fa fa-upload icon-edit"></i></a>

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
				<strong class="card-title">Create game page image</strong>

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
										<input type="hidden" value="" id="game_page_id" name="game_page_id">
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


<?php include(APPPATH."views/admin/common/footer.php"); ?>
<script type="text/javascript">


		$("#dataTable").dataTable();

		var base_url = '<?= base_url() ?>';
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
				window.location=base_url+'admin/change_game_page_serial/'+inputValue+'/'+id;
			});
		}

		$('.game_img_upload').on('click', function (e) {
			var data_id = $(this).attr('data-game_page_id');
			$('#game_page_id').val(data_id);
		});

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
					url:"<?php echo base_url(); ?>admin/game_page_image",
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


</script>
