<div class="clearfix"></div>

<footer class="site-footer" style="width:100%;overflow:hidden !important;">
    <div class="footer-inner bg-white">
        <div class="row">
            <div class="col-sm-6">
                Copyright &copy; 2020 B24 Admin
            </div>
            <div class="col-sm-6 text-right">
                Designed by <a href="#" target="_blank">BS24</a>
            </div>
        </div>
    </div>
</footer>

</div>
<!-- /#right-panel -->

<!-- Right Panel -->

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
<script src="<?=base_url('assets/admin/assets/js/main.js')?>"></script>


<script src="<?=base_url('assets/admin/assets/js/lib/data-table/datatables.min.js')?>"></script>
<script src="<?=base_url('assets/admin/assets/js/lib/data-table/dataTables.bootstrap.min.js')?>"></script>
<script src="<?=base_url('assets/admin/assets/js/lib/data-table/dataTables.buttons.min.js')?>"></script>
<script src="<?=base_url('assets/admin/assets/js/lib/data-table/buttons.bootstrap.min.js')?>"></script>
<script src="<?=base_url('assets/admin/assets/js/lib/data-table/jszip.min.js')?>"></script>
<script src="<?=base_url('assets/admin/assets/js/lib/data-table/vfs_fonts.js')?>"></script>
<script src="<?=base_url('assets/admin/assets/js/lib/data-table/buttons.html5.min.js')?>"></script>
<script src="<?=base_url('assets/admin/assets/js/lib/data-table/buttons.print.min.js')?>"></script>
<script src="<?=base_url('assets/admin/assets/js/lib/data-table/buttons.colVis.min.js')?>"></script>
<script src="<?=base_url('assets/admin/assets/js/init/datatables-init.js')?>"></script>
<script src="<?=base_url('assets/admin/assets/js/sweetalert/sweetalert.min.js')?>"></script>
<script src="<?=base_url('assets/admin/assets/js/sweetalert/jquery.sweet-modal.js')?>"></script>
<script src="<?=base_url('assets/admin/assets/js/newtypehead.js')?>"></script>

</body>
</html>


<script>
	var modal = document.getElementById("open-modal");
	var modal2 = document.getElementById("open-modal-status");
	var span = document.getElementsByClassName("close")[0];

	$(".close").on('click',function () {
		modal.style.display = "none";
		modal2.style.display = "none";
	});
	window.onclick = function(event) {
		if (event.target == modal) {
			modal.style.display = "none";
		}
		if (event.target == modal) {
			modal2.style.display = "none";
		}
	}
	function formatDate(date) {
		var d = new Date(date),
			month = '' + (d.getMonth() + 1),
			day = '' + d.getDate(),
			year = d.getFullYear();

		if (month.length < 2)
			month = '0' + month;
		if (day.length < 2)
			day = '0' + day;

		var rs = [year, month, day].join('-')
		return rs;
	}
	
	function change_admin_password() {
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
				url: base_url+ "admin/admin_password_change",
				method: "POST",
				data:{
					password:inputValue
				},
				dataType: "JSON",
				success: function (data) {
					if (data.st==200){
						swal({title:"Done!", text:data.msg, type:"success"},function (isConfirm) {
							window.location='<?php echo base_url('login/logout'); ?>';
						});
					}
				}
			});
		});
	}
</script>
