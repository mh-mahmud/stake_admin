<?php include(APPPATH."views/admin/common/header.php"); ?>
<style>
    .table {
        font-size: 12px;
    }
</style>

<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Admin Role Management</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a data-toggle="modal" data-target="#scrollmodal" style="font-size: 13px;color:#fff" class="btn btn-success btn-sm">Add New</a></li>
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
                        <?php include(APPPATH."views/admin/common/flash.php"); ?>
                    </div>
                    <div class="card-body">
                       <!-- <table id="" class="table table-striped table-bordered table-responsive" style="max-width:1840px"> -->
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">

                                <tr>
                                    <th>Role Name</th>
                                    <th>Role Data</th>
                                    <th>Created</th>
                                    <th>Action</th>
                                </tr>

                            </thead>
                            <label class="label-succes"></label>
                            <tbody>
                                <?php foreach($role_data as $val) : ?>
                                    <tr class="odd gradeX">
                                        <td><?= $val->role_name; ?></td>
                                        <td><?= $val->role_data; ?></td>
                                        <td><?=$val->created_at?></td>
                                        <td>
                                            <?php if($val->id != 1) : ?>
                                            <a
                                            class="edit-modal"
                                            data-id="<?php echo $val->id; ?>"
                                            data-role_name="<?php echo $val->role_name; ?>"
                                            data-role_data="<?php echo $val->role_data; ?>"
                                            data-toggle="modal"
                                            data-target="#editRoleModal"
                                            title="Edit Role">
                                                <i style="color:green" class="fa fa-pencil fa-2x"></i>
                                            </a>

                                            <a onclick="return confirm('Are you sure to remove this admin role?');" title="Delete Admin Role" href="<?= base_url('admin/remove_admin_role/'.$val->id); ?>">
                                                <i style="color:red" class="fa fa-trash fa-2x"></i>
                                            </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- <a data-toggle="modal" data-target="#scrollmodal" style="font-size: 13px;" class="btn btn-success btn-sm">Add New</a> -->

        </div>


<!-- Modal Start -->

<!-- create admin form -->
<div class="modal fade" id="scrollmodal" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="content" style="padding-top: 0px">
                    <div class="animated fadeIn">
                        <div class="row">

                        <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">Create Role</strong>
                            </div>
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">

                                        <form action="<?php echo base_url('admin/post_create_role'); ?>" method="post">
                                            <div class="form-group has-success">
                                                <label for="role_name" class="control-label mb-1">Role Name</label>
                                                <input name="role_name" type="text" class="form-control" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="role_id" class="control-label mb-1">Admin Role Option List</label><hr>
                                                
                                                <div class="form-check">
                                                    <?php foreach($roles as $r) : ?>
                                                    <div class="checkbox">
                                                        <label for="checkbox1" class="form-check-label ">
                                                            <input type="checkbox" id="<?php echo $r->name; ?>" name="role_data[]" value="<?php echo $r->name; ?>" class="form-check-input"><?php echo $r->screen_name; ?>
                                                        </label>
                                                    </div>
                                                <?php endforeach; ?>
                                                </div>

                                            </div>

                                            
                                            <div>
                                                <input class="btn btn-sm btn-info btn-block" type="submit" name="submit" value="Submit">
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div> <!-- .card -->

                    </div><!--/.col-->

                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <!-- <button type="button" class="btn btn-primary">Confirm</button> -->
            </div>
        </div>
    </div>
</div>

<div id="editRoleModal" class="modal fade" tabindex="-1" data-width="400">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Edit Role</h4>
            </div>
            <div class="modal-body" style="padding:20px !important;">
                <div class="row">
                    <div class="col-md-12">

                        <form action="<?php echo base_url('admin/post_edit_role'); ?>" method="post">
                            <input id="edit_role_id" type="hidden" name="edit_role_id">
                            <div class="form-group has-success">
                                <label for="role_name" class="control-label mb-1">Role Name</label>
                                <input id="role_name" name="role_name" type="text" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="role_id" class="control-label mb-1">Admin Role Option List</label><hr>
                                
                                <div class="form-check" style="padding-left:20px">
                                    <?php foreach($roles as $r) : ?>
                                    <div class="checkbox">
                                        <label for="checkbox1" class="form-check-label ">
                                            <input type="checkbox" name="role_data[]" value="<?php echo $r->name; ?>" class="form-check-input edit_role_data"><?php echo $r->screen_name; ?>
                                        </label>
                                    </div>
                                    <?php endforeach; ?>

                                </div>

                            </div>

                            <div>
                                <input class="btn btn-sm btn-info btn-block" type="submit" name="submit" value="Submit">
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



<!-- Modal End -->


    </div><!-- .animated -->
</div>

<?php include(APPPATH."views/admin/common/footer.php"); ?>
<script type="text/javascript">

    $("#add").on("click", function() {
        $('.option-data:first').clone().appendTo('.add-options');
    });

    $(document).on('show.bs.modal', function (e) {
        $('body').css('padding-right', '0px');
    });

    $('.edit-modal').on('click', function() {

        var data_id = $(this).attr('data-id');
        var role_name = $(this).attr('data-role_name');
        var role_data = $(this).attr('data-role_data');
        var roleArr = role_data.split(",");

        $('.edit_role_data').each(function() {
            var inputVal = $(this).val();
            if(jQuery.inArray(inputVal, roleArr) !== -1) {
                console.log(inputVal);
                $(this).attr('checked', 'checked');
            }
        });
        console.log(roleArr);

        $('#edit_role_id').attr('value', data_id);
        $('#role_name').attr('value', role_name);
        // $('.edit_role_data').attr('value', role_data);
    });

    $('.edit-modal').on('hidden.bs.modal', function () {
        // window.location.reload();
        alert("Hello");
    });
</script>
