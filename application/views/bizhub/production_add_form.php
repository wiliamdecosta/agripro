<!-- breadcrumb -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php base_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="#">Production</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Add Production Form</span>
        </li>
    </ul>
</div>

<div class="space-4"></div>
<div class="row">
    <div class="col-md-12">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">Add Production Form</div>
            </div>

            <div class="portlet light portlet-fit portlet-form bordered">
                <!-- BEGIN FORM-->
                <form method="post" action="" class="form-horizontal" id="form-production">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                           value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <div class="form-body">
                        <h3 class="form-section">Product Detail</h3>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="packing_product_id">Product
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <input type="hidden" name="product_id" id="production_product_id"
                                           class="form-control">
                                    <input type="hidden" name="parent_id" id="parent_id"
                                           class="form-control">
                                    <input type="text" name="product_code" id="production_product_code" readonly=""
                                           class="form-control" placeholder="Choose Product">
                                    <span class="input-group-btn">
                                        <button class="btn btn-success" type="button"
                                                onclick="showLovProduct('production_product_id','production_product_code','parent_id')">
                                            <span class="fa fa-search icon-on-right bigger-110"></span>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-3 control-label" for="packing_kg">Weight(Kg)
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-3">
                                <input type="text" name="qty" id="qty" class="form-control">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-3 control-label" for="tgl">Production Date
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-3">
                                <input type="text" name="tgl" id="tgl" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="packing_batch_number">Production Code</label>
                            <div class="col-md-3">
                                <input type="text" name="production_code" readonly="" class="form-control"
                                       placeholder="Generated By System">
                            </div>
                        </div>
                        <h3 class="form-section">Source Package</h3>
                        <div class="row">

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Source Material</label>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <input class="form-control" placeholder="" type="text" name="new_source_trx_code" id="new_source_trx_code" disabled>
                                            <input type="hidden" name="source_sm_id" id="source_sm_id" class="form-control">
                                            <input type="hidden" name="new_source_qty" id="new_source_qty" class="form-control">
                                            <span class="input-group-btn">
                                                <button class="btn btn-success" type="button" onclick="showLovRM('source_sm_id','new_source_trx_code','new_source_qty')">
                                                    <span class="fa fa-search icon-on-right bigger-110"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <input type="text" id="source_product_weight" name="source_product_weight" class="form-control" placeholder="Weight(Kg)">
                                        <input type="hidden" id="product_weight_compare">
                                    </div>
                                    <div class="col-md-1">
                                        <button class="btn btn-primary" type="button" id="btn-add-source"> <i class="fa fa-plus"></i>Add Source </button>
                                    </div>
                                </div>

                                <table class="table table-bordered table-striped" id="tbl-packing-detail">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Source Material</th>
                                        <th>Weight(Kg)</th>
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
                                <button type="submit" name="submit" class="btn btn-success"><i class="fa fa-save"></i>
                                    Save Data
                                </button>
                                <button type="button" name="back" id="btn-back" class="btn btn-danger"><i
                                        class="fa fa-arrow-left"></i>Back
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- END FORM-->
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('lov/lov_product_production.php'); ?>
<?php $this->load->view('lov/lov_incoming.php'); ?>

<script>
    function edit_row(no) {
        document.getElementById("edit_button" + no).style.display = "none";
        document.getElementById("save_button" + no).style.display = "inline";

        var source_trx_code = document.getElementById("source_trx_code_row" + no);
        var source_qty = document.getElementById("source_qty_row" + no);

        var source_trx_code_data = source_trx_code.innerHTML;
        var source_qty_data = source_qty.innerHTML;

        source_trx_code.innerHTML = "<input type='text' id='source_trx_code_text" + no + "' value='" + source_trx_code_data + "'>";
        source_qty.innerHTML = "<input type='text' id='source_qty_text" + no + "' value='" + source_qty_data + "'>";
    }

    function save_row(no) {
        var source_trx_code_val = document.getElementById("source_trx_code_text" + no).value;
        var source_qty_val = document.getElementById("source_qty_text" + no).value;

        document.getElementById("source_trx_code_row" + no).innerHTML = source_trx_code_val;
        document.getElementById("source_qty_row" + no).innerHTML = source_qty_val;

        document.getElementById("edit_button" + no).style.display = "inline";
        document.getElementById("save_button" + no).style.display = "none";
    }

    function delete_row(no) {
        document.getElementById("row" + no + "").outerHTML = "";
    }

    function add_row() {
        var new_source_trx_code = document.getElementById("new_source_trx_code").value;
        var new_source_qty = document.getElementById("new_source_qty").value;

        var table = document.getElementById("data_table");
        var table_len = (table.rows.length) - 2;
        var row = table.insertRow(table_len).outerHTML = "<tr class='tr_body' id='row" + table_len + "'><td>" + table_len + "</td><td id='source_trx_code_row" + table_len + "'>" + new_source_trx_code + "</td><td id='source_qty_row" + table_len + "'>" + new_source_qty + "</td><td><input type='button' id='edit_button" + table_len + "' value='Edit' class='edit' onclick='edit_row(" + table_len + ")'> <input type='button' id='save_button" + table_len + "' value='Save' class='save' onclick='save_row(" + table_len + ")'> <input type='button' value='Delete' class='delete' onclick='delete_row(" + table_len + ")'></td></tr>";
        document.getElementById("save_button" + table_len).style.display = "none";
        document.getElementById("new_source_trx_code").value = "";
        document.getElementById("new_source_qty").value = "";
    }
</script>

<script>
    jQuery.validator.setDefaults({
        debug: true,
        success: "valid"
    });
    var form1 = $('#form-production');
    var error1 = $('.alert-danger', form1);
    var success1 = $('.alert-success', form1);

    form1.validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "",  // validate all fields including form hidden input
        rules: {
            qty: {
                required: true,
                number: true
            },
            production_product_code: {
                required: true
            },
            tgl: {
                required: true
            }
        },
        invalidHandler: function (event, validator) { //display error alert on form submit
            success1.hide();
            error1.show();
            App.scrollTo(error1, -200);
        },

        highlight: function (element) { // hightlight error inputs
            $(element)
                .closest('.form-group').addClass('has-error'); // set error class to the control group
        },

        unhighlight: function (element) { // revert the change done by hightlight
            $(element)
                .closest('.form-group').removeClass('has-error'); // set error class to the control group
        },

        success: function (label) {
            label
                .closest('.form-group').removeClass('has-error'); // set success class to the control group
        },

        submitHandler: function (form) {
            success1.show();
            error1.hide();
        }
    });
</script>

<script>
    function showLovProduct(id, code, parent_id) {
        modal_lov_product_show(id, code, parent_id);
    }

    function showLovRM(id, code, qty_field) {
        var parent_id = $('#parent_id').val();
        var production_product_id = $('#production_product_id').val();
        if ( production_product_id == "") {
            swal("Information", "Choose product first", "info");
            return false;
        }
        modal_lov_incoming_show(id, code, qty_field, $('#production_product_id').val(),parent_id );
    }

    $('#production_product_code').change(function () {
        $('.tr_body').empty();
    })
</script>


<script>
    function insertDataRow() {

        var jumlah_baris = document.getElementById('tbl-packing-detail').rows.length;

        var sortir_detail_id = document.getElementById('source_sortir_detail_id').value;
        var product_id = document.getElementById('source_product_id').value;
        var product_code = document.getElementById('source_product_code').value;
        var weight = document.getElementById('source_product_weight').value;

        var tr = document.getElementById('tbl-packing-detail').insertRow(jumlah_baris);
        var tdNo = tr.insertCell(0);
        var tdProduct = tr.insertCell(1);
        var tdWeight = tr.insertCell(2);
        var tdAction = tr.insertCell(3);

        tdNo.innerHTML = jumlah_baris;
        tdProduct.innerHTML = '<input type="hidden" name="sortir_detail_id[]" value="' + sortir_detail_id + '"><input type="hidden" name="product_ids[]" value="' + product_id + '">' + product_code;
        tdWeight.innerHTML = '<input type="hidden" name="weight[]" value="' + weight + '">' + weight;
        tdAction.innerHTML = '<button type="button" onclick="deleteDataRow(this);"><i class="fa fa-trash"></i> Delete </button>';


        /* document.getElementById('source_sortir_detail_id').value = "";
         document.getElementById('source_product_id').value = "";
         document.getElementById('source_product_code').value = "";
         document.getElementById('source_product_weight').value = "";
         document.getElementById('product_weight_compare').value = "";*/
    }

    function deleteDataRow(sender) {
        $(sender).parent().parent().remove();
    }

</script>

<script>
    $(function () {
        $("#tgl").datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
            orientation: 'bottom',
            todayHighlight: true
        });

        $("#btn-back").on('click', function (e) {
            loadContentWithParams('agripro.production', {});
        });

        $("#btn-add-source").on('click', function (e) {

            var product_id = $('#production_product_id').val();
            var qty = $('#qty').val();
            var tgl = $('#tgl').val();

            if (product_id == "" || qty == "" || tgl == "") {
                swal('Information', 'Product, Weight, and Production Date must be filled first', 'info');
                return;
            }

            var sortir_detail_id = $('#source_sortir_detail_id').val();
            var packing_weight = $('#source_product_weight').val();
            var packing_weight_compact = $('#product_weight_compare').val();

            if (sortir_detail_id == "" || packing_weight == "") {
                swal('Information', 'Source Material and Weight must be filled', 'info');
                return;
            }

            var packing_kg_float = parseFloat(packing_kg);
            var packing_weight_float = parseFloat(packing_weight);
            var packing_weight_compact_float = parseFloat(packing_weight_compact);

            if (packing_weight_float > packing_weight_compact_float) {
                swal('Information', 'Weight greater than source weight', 'info');
                return;
            }

            if (packing_weight_float > packing_kg_float) {
                swal('Information', 'Weight greater than packing capacity weight', 'info');
                return;
            }

            var source_sortir_detail_ids = $('[name="sortir_detail_id[]"]');
            if (source_sortir_detail_ids.length > 0) {
                var error = false;
                $('[name="sortir_detail_id[]"]').each(function (index) {
                    if (sortir_detail_id == $(this).val()) {
                        swal('Information', 'Oops, we found double source package. choose another source', 'info');
                        error = true;
                    }
                });
                if (error) return;
            }

            insertDataRow();
        });


        $('#product_weight_compare').on('change', function (e) {
            $('#source_product_weight').val(this.value);
        });

        $("#form-packing").submit(function (e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.

            if ($("#form-packing").valid() == true) {
                var url = '<?php echo WS_JQGRID . "agripro.packing_controller/createForm"; ?>';
                $.ajax({
                    type: "POST",
                    url: url,
                    dataType: 'json',
                    data: $("#form-packing").serialize(),
                    success: function (response) {

                        if (response.success != true) {
                            swal('Warning', response.message, 'warning');
                        } else {
                            loadContentWithParams('agripro.packing', {});
                        }

                    }
                });
            }

        });


    });
</script>