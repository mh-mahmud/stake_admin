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
                        <strong class="card-title">Customer User</strong>

                    	<select onchange="get_all_club_user(this.value);" class="float-right">
                    		<option value="">--Select One--</option>
                    		<?php $get_club = $this->db->query("SELECT * FROM `club_users`")->result(); ?>
                    		<?php foreach ($get_club as $key => $value): ?>
                    		<option value="<?php echo $value->id; ?>"><?php echo $value->club_name; ?></option>
                    		<?php endforeach ?>
                    	</select>
                   	<label class="float-right">Search By Club: &nbsp;</label>
                    </div>
                    
                    <div class="card-body">
						<table id="dataTable" class="table table-striped table-bordered">
                            <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Username</th>
                                <th>User Coin</th>
                                <th>Club Name</th>
                                <th>Club Bonus(%)</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Country</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                             
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include(APPPATH."views/admin/common/footer.php"); ?>
<script type="text/javascript">

    $(document).on('show.bs.modal', function (e) {
        $('body').css('padding-right', '0px');
    });

    $(document).ready(function(){

		fetch_data();

    });



    function fetch_data(id='') {
		var base_url = '<?php echo base_url()?>';
		let dataTable;
		dataTable = $('#dataTable').DataTable({
			"footerCallback": function () {
				let api = this.api(), data;
			},
			'bProcessing': true,
			"serverSide": true,
			searchHighlight: true,
			"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
			"columnDefs": [
				{"className": "dt-center", "targets": "_all", "orderable": false}
			],
			"order": [],
			oLanguage: {sProcessing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'},
			"ajax": {
				url: base_url + "admin/customer_user_dt",
				type: "POST",
				data: {
					 club_id:id
				}
			},
			drawCallback: function (settings) {
					
			}
		});
	}

	function get_all_club_user(id) {
		$('#dataTable').DataTable().destroy();
		fetch_data(id);
	}


   function statusChangeUser(id,sts) {
		window.location='<?php echo base_url(); ?>admin/change_user_status/'+id+'/'+sts;
   } 

	function update_club_bonus(id){
   		var base_url = '<?= base_url() ?>';
		swal({
			title: "User Club Bonus Update",
			text: "",
			type: "input",
			showCancelButton: true,
			closeOnConfirm: false,
			animation: "slide-from-top",
			inputPlaceholder: "Write Something"
		}, function (inputValue) {
			if (inputValue === false) return false;
			if (inputValue === "") {
				swal.showInputError("You need to write Something!"); return false
			}

			$.ajax({
				url: base_url+ "admin/update_club_bonus",
				method: "POST",
				data:{
					id:id,club_bonus:inputValue
				},
				dataType: "JSON",
				success: function (data) {
					if (data.st==200){
						swal({title:"Done!", text:data.msg, type:"success"},function (isConfirm) {
							var clubBonus = $('#dataTable').DataTable(); 
                			clubBonus.draw(false);
						});
					}
				}
			});
		});
	}
 

	  

	function change_user_password(id) {
		var base_url = '<?= base_url() ?>';
		swal({
			title: "Password change for this user",
			text: "",
			type: "input",
			showCancelButton: true,
			closeOnConfirm: false,
			animation: "slide-from-top",
			inputPlaceholder: "Give new password"
		}, function (inputValue) {
			if (inputValue === false) return false;
			if (inputValue === "") {
				swal.showInputError("You need to write any password!"); return false
			}

			$.ajax({
				url: base_url+ "admin/change_user_password",
				method: "POST",
				data:{
					id:id,password:inputValue
				},
				dataType: "JSON",
				success: function (data) {
					if (data.st==200){
						swal({title:"Done!", text:data.msg, type:"success"},function (isConfirm) {
							$('#dataTable').DataTable().destroy();
							fetch_data();
						});
					}
				}
			});
		});
	}
</script>
