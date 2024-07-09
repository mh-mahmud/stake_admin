                        <?php if($this->session->flashdata('msg')) { ?>
                            <div class="col-md-12 alert-success" style="padding: 15px;">
                                <?php echo $this->session->flashdata('msg'); ?>
                            </div>
                        <?php } ?>
                        <?php if($this->session->flashdata('error')){ ?>
                            <div class="col-md-12 alert-danger" style="padding: 15px;">
                                <?php echo $this->session->flashdata('error'); ?>
                            </div>
                        <?php } ?>