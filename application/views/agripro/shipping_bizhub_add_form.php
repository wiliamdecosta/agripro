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
            <span>Add Shipping Form</span>
        </li>
    </ul>
</div>

<div class="space-4"></div>
<div class="row">
    <div class="col-md-12">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">Add Shipping Form</div>
            </div>

            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form method="post" action="" class="form-horizontal" id="form-shipping">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <div class="form-body">

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="shipping_bizhub_date">Shipping Date</label>
                            <div class="col-md-2">
                                <input type="text" name="shipping_bizhub_date" id="shipping_bizhub_date" class="form-control required">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="shipping_bizhub_no">Shipping No:</label>
                            <div class="col-md-3">
                                <input type="text" name="shipping_bizhub_no" id="shipping_bizhub_no" class="form-control required">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="shipping_bizhub_notes">Notes:</label>
                            <div class="col-md-6">
                                <textarea name="shipping_bizhub_notes" id="shipping_bizhub_notes" class="form-control"></textarea>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-offset-1 col-md-10">
                                <h3>Shipping Details</h3>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Packing Box</label>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <input type="hidden" name="box_packing_id" id="box_packing_id" class="form-control">
                                            <input type="text" name="box_packing_batch_number" id="box_packing_batch_number" readonly="" class="form-control" placeholder="Choose Packing Box">
                                            <span class="input-group-btn">
                                                <button class="btn btn-success" type="button" onclick="showLovPacking('box_packing_id','box_packing_batch_number','box_product_code')">
                                                    <span class="fa fa-search icon-on-right bigger-110"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" id="box_product_code" readonly="" placeholder="Product Code">
                                    </div>
                                    <div class="col-md-1">
                                        <button class="btn btn-primary" type="button" id="btn-add-box"> <i class="fa fa-plus"></i>Add Packing Box </button>
                                    </div>
                                </div>

                                <table class="table table-bordered" id="tbl-packing-box">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Serial Number</th>
                                            <th>Product Code</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" name="submit" class="btn btn-success"> <i class="fa fa-save"></i> Save Data </button>
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

<?php $this->load->view('lov/lov_packing_bizhub.php'); ?>

<script>
    function showLovPacking(id, code, product_code) {
        modal_lov_packing_bizhub_show(id, code, product_code);
    }
</script>


<script>
    function insertDataRow() {

        var jumlah_baris = document.getElementById('tbl-packing-box').rows.length;

        var packing_bizhub_id = document.getElementById('box_packing_id').value;
        var packing_bizhub_batch_number = document.getElementById('box_packing_batch_number').value;
        var product_code = document.getElementById('box_product_code').value;

        var tr = document.getElementById('tbl-packing-box').insertRow(jumlah_baris);
        var tdNo = tr.insertCell(0);
        var tdSerialNumber = tr.insertCell(1);
        var tdProduct = tr.insertCell(2);
        var tdAction = tr.insertCell(3);

        tdNo.innerHTML = jumlah_baris;
        tdSerialNumber.innerHTML = '<input type="hidden" name="packing_bizhub_id[]" value="'+ packing_bizhub_id +'">'+ packing_bizhub_batch_number;
        tdProduct.innerHTML = product_code;
        tdAction.innerHTML = '<button type="button" onclick="deleteDataRow(this);"><i class="fa fa-trash"></i> Delete </button>';

        document.getElementById('box_packing_id').value = "";
        document.getElementById('box_packing_batch_number').value = "";
        document.getElementById('box_product_code').value = "";
    }

    function deleteDataRow(sender) {
        $(sender).parent().parent().remove();
    }

</script>

<script>
    $(function() {
        $("#shipping_bizhub_date").datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
            orientation: 'bottom',
            todayHighlight: true
        });

        $("#btn-back").on('click', function(e) {
            loadContentWithParams('agripro.shipping_bizhub',{});
        });


        $("#btn-add-box").on('click', function(e) {
            var packing_bizhub_id = $('#box_packing_id').val();

            if(packing_bizhub_id == "") {
                swal('Information','Please choose the packing box','info');
                return;
            }

            var packing_bizhub_ids = $('[name="packing_bizhub_id[]"]');
            if(packing_bizhub_ids.length > 0) {
                var error = false;
                $('[name="packing_bizhub_id[]"]').each(function(index) {
                    if(packing_bizhub_id == $(this).val()) {
                        swal('Information','Oops, we found double packing box. choose another box','info');
                        error = true;
                    }
                });
                if(error) return;
            }

            insertDataRow();
        });


        $("#form-shipping").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.

            if($("#form-shipping").valid() == true){
                var url = '<?php echo WS_JQGRID."agripro.shipping_bizhub_controller/createForm"; ?>';
                $.ajax({
                    type: "POST",
                    url: url,
                    dataType : 'json',
                    data: $("#form-shipping").serialize(),
                    success: function(response) {

                        if(response.success != true){
                            swal('Warning',response.message,'warning');
                        }else{
                            loadContentWithParams('agripro.shipping_bizhub',{});
                        }

                    }
                });
            }
        });
    });
</script>