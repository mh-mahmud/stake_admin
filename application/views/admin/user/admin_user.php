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
                        <h1>Admin User</h1>
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
                       <table id="dataTable" class="table table-striped table-bordered" style="width: 100%"> 
                            <thead class="thead-dark">
                            <tr>
                                <th>Admin Name</th>
                                <th>Email</th>
                                <th>Role Name</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <label class="label-succes"></label>
                            <tbody>
                                            <?php foreach($admin_data as $val) : ?>
                                                <tr class="odd gradeX">
                                                    <td><?= $val->full_name; ?></td>
                                                    <td><?= $val->email; ?></td>
                                                    <td>
                                                        <?php
                                                            $role = $this->db->query("SELECT role_name FROM role_management WHERE id='{$val->role_id}'")->row();
                                                            echo @$role->role_name;
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                            if($val->status == 1) {
                                                                echo '<span class="badge badge-success">Active</span>';
                                                            } else {
                                                                echo '<span class="badge badge-danger">Inactive</span>';
                                                            }
                                                        ?>
                                                    </td>
                                                    <td><?=$val->created_at?></td>
                                                    <td>
                                                        <?php if($val->id != 1) : ?>
                                                        <a
                                                        class="edit-modal"
                                                        data-id="<?php echo $val->id; ?>"
                                                        data-role_id="<?php echo $val->role_id; ?>"
                                                        data-admin_name="<?php echo $val->full_name; ?>"
                                                        data-email="<?php echo $val->email; ?>"
                                                        data-status="<?php echo $val->status; ?>"
                                                        data-toggle="modal"
                                                        data-target="#editAdminModal"
                                                        title="Edit Account">
                                                            <i style="color:green" class="fa fa-pencil fa-2x"></i>
                                                        </a>

                                                        <a onclick="return confirm('Are you sure to remove this admin user?');" title="Delete Admin User" href="<?= base_url('admin/remove_admin/'.$val->id); ?>">
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
                                <strong class="card-title">Create Admin</strong>
                            </div>
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">

                                        <form action="<?php echo base_url('admin/post_create_admin'); ?>" method="post">
                                            <div class="form-group has-success">
                                                <label for="full_name" class="control-label mb-1">Admin Name</label>
                                                <input name="full_name" type="text" class="form-control" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="role_id" class="control-label mb-1">Role Name</label>
                                                <select name="role_id" class="form-control" required>
                                                    <option value="">--- select ---</option>
                                                    <?php foreach($role_data as $val) : ?>
                                                        <option value="<?php echo $val->id ?>"><?php echo $val->role_name; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="form-group has-success">
                                                <label for="email" class="control-label mb-1">Admin Email</label>
                                                <input name="email" type="text" class="form-control" required>
                                            </div>

                                            <div class="form-group has-success">
                                                <label for="password" class="control-label mb-1">Password</label>
                                                <input min="6" name="password" type="password" class="form-control" required>
                                            </div>
                                            
                                            <div>
                                                <input class="btn btn-lg btn-info btn-block" type="submit" name="submit" value="Submit">
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

<div id="editAdminModal" class="modal fade" tabindex="-1" data-width="400">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Edit Admin</h4>
            </div>
            <div class="modal-body" style="padding:20px !important;">
                <div class="row">
                    <div class="col-md-12">

                        <form action="<?php echo base_url('admin/post_edit_admin'); ?>" method="POST">

                            <input id="admin_id" type="hidden" name="admin_id">

                            <div class="form-group">
                                <label for="full_name" class="control-label mb-1">Admin Name</label>
                                <input id="full_name" name="full_name" type="text" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label class="control-label mb-1">Role Name</label>
                                <select id="role_id" name="role_id" class="form-control" required>
                                    <option value="">--- select ---</option>
                                    <?php foreach($role_data as $val) : ?>
                                        <option value="<?php echo $val->id ?>"><?php echo $val->role_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="email" class="control-label mb-1">Admin Email</label>
                                <input id="email" name="email" type="text" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="password" class="control-label mb-1">Password</label>
                                <input min="6" name="password" type="password" class="form-control">
                            </div>

                            <div class="form-group">
                                <label class="control-label mb-1">Status</label>
                                <select id="status" name="status" class="form-control">
                                    <option value="">-- select --</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
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

<!-- Modal End -->


    </div><!-- .animated -->
</div>

<?php include(APPPATH."views/admin/common/footer.php"); ?>
<script type="text/javascript">
    $("#dataTable").dataTable();
    $(document).on('show.bs.modal', function (e) {
        $('body').css('padding-right', '0px');
    });

    $('.edit-modal').on('click', function() {
        var data_id = $(this).attr('data-id');
        var role_id = $(this).attr('data-role_id');
        var full_name = $(this).attr('data-admin_name');
        var email = $(this).attr('data-email');
        var status = $(this).attr('data-status');

        $('#admin_id').attr('value', data_id);
        $('#full_name').attr('value', full_name);
        $('#email').attr('value', email);
        $('#status').val(status);
        $('#role_id').val(role_id);
    });


</script>
