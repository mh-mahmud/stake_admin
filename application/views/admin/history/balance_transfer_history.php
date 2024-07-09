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
                        <h1>Customer Balance Transfer</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <!-- <li><a data-toggle="modal" data-target="#scrollmodal" style="font-size: 13px;color:#fff" class="btn btn-success btn-sm">Add New</a></li> -->
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="content">
    <div class="animated fadeIn">

      <form action="" method="post">
        <div class="row">
            <!-- <div class="col-lg-5">
                <input type="text" class="form-control datepicker" placeholder="Start Date">
            </div>
            <div class="col-lg-5">
                <input type="text" class="form-control datepicker" placeholder="End Date">
            </div> -->
            <div class="col-lg-3">
                <input type="text" class="form-control" name="search_data" required>
            </div>
            <div class="col-lg-2">
                <input type="submit" name="submit" class="form-control btn btn-success" value="Submit">
            </div>
        </div>
      </form><br>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">&nbsp;</strong>
                        <?php include(APPPATH."views/admin/common/flash.php"); ?>
                    </div>
                    <div class="card-body">
                       <table id="" class="table table-striped table-bordered" style="max-width:1840px">
                        <!-- <table class="table table-striped table-bordered"> -->
                            <thead class="thead-dark">
                            <tr>
                                <th>Transferred To</th>
                                <th>Amount</th>
                                <th>Transferred By</th>
                                <th>Date</th>
                                <!-- <th>Action</th> -->
                            </tr>
                            </thead>
                            <label class="label-succes"></label>
                            <tbody>
                                <?php foreach($transfer_data as $val) : ?>
                                    <tr>
                                        <td><?= $val->transfer_to_name; ?></td>
                                        <td><?= $val->amount; ?></td>
                                        <td><?= $val->transfer_by_name; ?></td>
                                        <td><?=$val->created_at?></td>
                                        <!-- <td>
                                            <a onclick="return confirm('Are you sure to remove this transfer?');" title="Delete Withdraw" href="<?php //echo base_url('remove_transfer/'.$val->id); ?>"><i class="fa fa-times icon-delete"></i></a>
                                        </td> -->
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


        <!-- approve deposit -->
        <div class="modal fade" id="scrollmodal6" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
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
                                        <strong class="card-title">Approve Withdraw</strong>
                                    </div>
                                    <div class="card-body">
                                        <!-- Credit Card -->
                                        <div id="pay-invoice">
                                            <div class="card-body">

                                                <form action="#" method="post" novalidate="novalidate">
                                                    <div class="form-group">
                                                        <label for="match_status" class="control-label mb-1">Select status</label>
                                                        <select name="match_status" class="form-control">
                                                            <option value="">--- select ---</option>
                                                            <option value="option 1">Option 1</option>
                                                            <option value="option 2">Option 2</option>
                                                            <option value="option 3">Option 3</option>
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <button type="submit" class="btn btn-lg btn-info btn-block">
                                                            <span>Submit</span>
                                                        </button>
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

        <!-- Modal End -->


    </div><!-- .animated -->
</div>

<?php include(APPPATH."views/admin/common/footer.php"); ?>
