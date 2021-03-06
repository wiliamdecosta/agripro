<!-- breadcrumb -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php base_url();?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="#">Tracking</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>View Packing Bizhub Form</span>
        </li>
    </ul>
</div>

<div class="space-4"></div>
<div class="row">
    <div class="col-md-12">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">View Packing Bizhub Form</div>
            </div>

            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form method="post" action="" class="form-horizontal" id="form-packing">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <input type="hidden" name="packing_bizhub_id" value="<?php echo $this->input->post('packing_bizhub_id'); ?>">
                    <div class="form-body">

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="packing_product_id">Product</label>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <input type="hidden" name="product_id" id="packing_product_id" value="<?php echo $this->input->post('product_id'); ?>" class="form-control">
                                    <input type="text" name="product_code" readonly="" id="packing_product_code" value="<?php echo $this->input->post('product_code'); ?>" readonly="" class="form-control" placeholder="Choose Product">
                                    <!-- <span class="input-group-btn">
                                        <button class="btn btn-success" type="button" onclick="showLovProduct('packing_product_id','packing_product_code')">
                                            <span class="fa fa-search icon-on-right bigger-110"></span>
                                        </button>
                                    </span> -->
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-3 control-label" for="packing_bizhub_kg">Weight(Kg)</label>
                            <div class="col-md-3">
                                <input type="text" name="packing_bizhub_kg" id="packing_bizhub_kg" value="<?php echo $this->input->post('packing_bizhub_kg'); ?>" class="form-control required">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-3 control-label" for="packing_bizhub_date">Packing Date</label>
                            <div class="col-md-2">
                                <input type="text" name="packing_bizhub_date" id="packing_bizhub_date" value="<?php echo $this->input->post('packing_bizhub_date'); ?>" class="form-control required">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="packing_bizhub_batch_number">Batch Number</label>
                            <div class="col-md-3">
                                <input type="text" name="packing_bizhub_batch_number" readonly="" value="<?php echo $this->input->post('packing_bizhub_batch_number'); ?>" class="form-control" placeholder="Batch Generated By System">
                            </div>
                            <label class="col-md-2 control-label" for="packing_bizhub_serial">Serial Number</label>
                            <div class="col-md-3">
                                <input type="text" name="packing_bizhub_serial" readonly="" value="<?php echo $this->input->post('packing_bizhub_serial'); ?>" class="form-control" placeholder="Serial Generated By System">
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-offset-1 col-md-10">
                                <h3>Source Package</h3>

                                <div class="form-group">
                                    <!--
                                    <label class="col-md-3 control-label">Source Material</label>
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <input type="hidden" name="source_sortir_id" id="source_sortir_id" class="form-control">
                                            <input type="hidden" name="source_product_id" id="source_product_id" class="form-control">
                                            <input type="text" name="source_product_code" id="source_product_code" readonly="" class="form-control" placeholder="Choose Source">
                                            <span class="input-group-btn">
                                                <button class="btn btn-success" type="button" onclick="showLovSortir('source_sortir_id','source_product_code','product_weight_compare','source_product_id')">
                                                    <span class="fa fa-search icon-on-right bigger-110"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>


                                    <div class="col-md-3">
                                        <input type="text" id="source_product_weight" name="source_product_weight" class="form-control" placeholder="Weight(Kg)">
                                        <input type="hidden" id="product_weight_compare">
                                    </div>
                                    <div class="col-md-1">
                                        <button class="btn btn-primary" type="button" id="btn-add-source"> Add Source </button>
                                    </div>
                                    -->
                                </div>

                                <table class="table table-bordered table-striped" id="tbl-packing-detail">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Source Material</th>
                                            <th>Weight(Kg)</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody-packing-detail">

                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>

                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="button" name="back" id="btn-back" class="btn btn-danger"><i class="fa fa-arrow-left"></i>Back</button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- END FORM-->
            </div>
        </div>
    </div>
</div>

<script>

    /**
     * Load data detail
     */

    $(function() {

        $.ajax({
            url: '<?php echo WS_JQGRID."agripro.packing_bizhub_detail_controller/getDetail"; ?>',
            type: "POST",
            data: {packing_bizhub_id : <?php echo $this->input->post('packing_bizhub_id'); ?>},
            success: function (response) {
                $( "#tbody-packing-detail" ).html( response );
            },
            error: function (xhr, status, error) {
                swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
            }
        });

    });


    $(function() {
        $("#packing_bizhub_date").datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
            orientation: 'bottom',
            todayHighlight: true
        });

        $("#btn-back").on('click', function(e) {
            loadContentWithParams('agripro.packing_bizhub',{});
        });

    });
</script>