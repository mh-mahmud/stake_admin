<?php include(APPPATH . "views/admin/common/header.php"); ?>

<style>
	.table {
		font-size: 12px;
	}
</style>
<?php include(APPPATH . "views/admin/common/flash.php"); ?>
<div class="content">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<strong class="card-title">Running Multibet</strong>
					</div>
					<div class="card-body">
						<table id="data-table" class="table table-striped table-bordered">
							<thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Username</th>
                                    <th>Club Name</th>
                                    <th>Created at</th>
                                    <th>Total Stake</th>
                                    <th>Total Coin</th>
                                    <th>Possible Win</th>
                                    <th>Result</th>
                                    <th>Action</th>
                                </tr>
							</thead>
							<label class="label-succes"></label>

                            <tbody>
                                 
                            </tbody>

						</table>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

 
<!-- multibet modal -->
<div id="multibetModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content"  style="width: 107%!important;">
            <div class="modal-header"> 
                <h4 class="modal-title">Multibet Details</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12"> 
                            <table class="table table-bordered ajax-tbl display" style="width:100%">
                                <thead>
                                <tr role="row">
                                    <th>Match</th>
                                    <th>Question</th>
                                    <th>Answer</th>
                                    <th>Ratio</th> 
                                    <th>Win/Loss</th>
                                </tr>
                                </thead>
                                <tbody id="multiBetDetailsContent2">

                                </tbody>
                            </table> 
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn dark btn-outline">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="updateStatusModal" class="modal fade" tabindex="-1" data-width="400">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Multibet Result</h4>
            </div>
            <div class="modal-body" style="padding:20px !important;">
                <div class="row">
                    <div class="col-md-12">

                        <form action="<?php echo base_url('admin/set_multibet_result'); ?>" method="POST">

                            <input id="multibet_id" type="hidden" name="multibet_id">

                            <div class="form-group">
                                <label for="match_status" class="control-label mb-1">Select Multibet Status</label>
                                <select id="acc_status" name="status" class="form-control" required>
                                    <option value="">-- select --</option>
                                    <option value="LOST">LOST</option>
                                    <option value="WIN">WIN</option>
                                    <option value="ADMIN_CANCEL">ADMIN CANCEL</option>
                                </select>
                            </div>

                            <div>
                                <input type="submit" class="btn btn-sm btn-info btn-block" name="submit" value="Submit">
                            </div>
                        </form>

                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn dark btn-outline">Close</button>
            </div>
        </div>
    </div>
</div>


<?php include(APPPATH . "views/admin/common/footer.php"); ?>



<script>
	// $('#data-table').DataTable({
	//     "aaSorting": []
	// });
    $( document ).ready(function() {
        fetch_data();
    });

    function fetch_data() {
        var base_url = '<?php echo base_url()?>';
        let dataTable;
        dataTable = $('#data-table').DataTable({
            "footerCallback": function () {
                let api = this.api(), data;
            },
            'bProcessing': true,
            "serverSide": true,
            "searchHighlight": true,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "columnDefs": [
                {"className": "dt-center", "targets": "_all", "orderable": false}
            ],
            "order": [], 
            "oLanguage": {sProcessing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'},
            "ajax": {
                url: base_url + "admin/multibets_datatable",
                type: "POST",
                data: {
                    
                }
            },
            drawCallback: function (settings) {

            }
        });
    }

    function show_bets(id,user_id) { 

        var url_prefix = "<?php echo base_url(); ?>";
        url = url_prefix + 'admin/ajax_multibet_details';
        $("#multiBetDetailsContent2").html("");
        $.ajax({
            type: "POST",
            url: url,
            data: {
                option_detail_ids: id,
                user_id: user_id,
            },
            dataType: 'json',
            success: function(data) {
                // console.log(data.get_data);return;
                if(data.error==0) {
                    $("#multibetModal").modal('show');
                    $("#multiBetDetailsContent2").html(data.get_new_data); 
                }
                else if(data.error == 2) {

                }

            },
            error:function(exception){
                console.log(exception);
            }
        });
    }
     
    function status_modal(bet_id) {
        $("#multibet_id").attr("value", bet_id);
    } 


</script>