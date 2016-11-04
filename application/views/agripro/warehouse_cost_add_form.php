<script src="<?php echo base_url(); ?>assets/js/jquery.number.min.js"></script>
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
            <span>Add Cost Form</span>
        </li>
    </ul>
</div>

<div class="space-4"></div>
<div class="row">
    <div class="col-md-12">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">Add Cost Form</div>
            </div>

            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form method="post" action="" class="form-horizontal" id="form-warehoust-cost">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <div class="form-body">

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="whcost_start_date">Start Date</label>
                            <div class="col-md-2">
                                <input type="text" name="whcost_start_date" id="whcost_start_date" class="form-control datepicker required">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="whcost_end_date">End Date</label>
                            <div class="col-md-2">
                                <input type="text" name="whcost_end_date" id="whcost_end_date" class="form-control datepicker required">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="whcost_description">Description:</label>
                            <div class="col-md-6">
                                <textarea name="whcost_description" id="whcost_description" class="form-control"></textarea>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-offset-1 col-md-10">
                                <h3>Cost Details</h3>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Parameter Cost</label>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <input type="hidden" name="parameter_cost_id" id="parameter_cost_id" class="form-control">
                                            <input type="text" name="parameter_cost_code" id="parameter_cost_code" readonly="" class="form-control" placeholder="Choose Parameter" onchange="enablingCostValue(this.value);">
                                            <span class="input-group-btn">
                                                <button class="btn btn-success" type="button" onclick="showLovCostParameter('parameter_cost_id','parameter_cost_code')">
                                                    <span class="fa fa-search icon-on-right bigger-110"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" id="whcost_det_value" placeholder="Fill Cost Value (Rp)">
                                    </div>
                                    <div class="col-md-1">
                                        <button class="btn btn-primary" type="button" id="btn-add-parameter"> <i class="fa fa-plus"></i>Add Parameter</button>
                                    </div>
                                </div>

                                <table class="table table-bordered" id="tbl-parameter">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Cost Parameter</th>
                                            <th>Cost Value (Rp)</th>
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

<?php $this->load->view('lov/lov_parameter_cost.php'); ?>

<script>
    function showLovCostParameter(id, code) {
        modal_lov_parameter_cost_show(id, code);
    }

    function enablingCostValue(parameter_code) {
        if(parameter_code == 'STOCK MATERIAL') {
            $("#whcost_det_value").prop("disabled", true);
            $("#whcost_det_value").val('Generated By System');
        }else {
            $("#whcost_det_value").prop("disabled", false);
            $("#whcost_det_value").val('');
        }
    }
</script>


<script>
    function insertDataRow() {

        var jumlah_baris = document.getElementById('tbl-parameter').rows.length;

        var parameter_cost_id = $('#parameter_cost_id').val();
        var parameter_cost_code = $('#parameter_cost_code').val();
        var whcost_det_value = $('#whcost_det_value').val();

        var tr = document.getElementById('tbl-parameter').insertRow(jumlah_baris);
        var tdNo = tr.insertCell(0);
        var tdCostCode = tr.insertCell(1);
        var tdCostValue = tr.insertCell(2);
        var tdAction = tr.insertCell(3);

        tdNo.innerHTML = jumlah_baris;
        tdCostCode.innerHTML = '<input type="hidden" name="parameter_cost_id[]" value="'+ parameter_cost_id +'"> <input type="hidden" name="parameter_cost_code[]" value="'+ parameter_cost_code +'">'+ parameter_cost_code;
        tdCostValue.innerHTML = '<input type="hidden" name="whcost_det_values[]" value="'+ whcost_det_value +'">'+ $.number(whcost_det_value, 2, '.', ',');
        tdAction.innerHTML = '<button type="button" onclick="deleteDataRow(this);"><i class="fa fa-trash"></i> Delete </button>';

        $('#parameter_cost_id').val("");
        $('#parameter_cost_code').val("");
        $('#whcost_det_value').val("");
        $("#whcost_det_value").prop("disabled", false);
    }

    function deleteDataRow(sender) {
        $(sender).parent().parent().remove();
    }

</script>

<script>
    $(function() {
        $(".priceformat").number( true, 2 , '.',','); /* price number format */
        $(".datepicker").datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
            orientation: 'bottom',
            todayHighlight: true
        });

        $("#btn-back").on('click', function(e) {
            loadContentWithParams('agripro.warehouse_cost',{});
        });

        $("#btn-add-parameter").on('click', function(e) {
            var parameter_cost_id = $('#parameter_cost_id').val();
            var whcost_det_value = $('#whcost_det_value').val();

            if(parameter_cost_id == "" || whcost_det_value == "") {
                swal('Information','Please choose the cost parameter and fill cost value','info');
                return;
            }

            var parameter_cost_ids = $('[name="parameter_cost_id[]"]');
            if(parameter_cost_ids.length > 0) {
                var error = false;
                $('[name="parameter_cost_id[]"]').each(function(index) {
                    if(parameter_cost_id == $(this).val()) {
                        swal('Information','Oops, we found double parameter. choose another parameter','info');
                        error = true;
                    }
                });
                if(error) return;
            }

            insertDataRow();
        });


        $("#form-warehoust-cost").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.

            if($("#form-warehoust-cost").valid() == true){
                var url = '<?php echo WS_JQGRID."agripro.warehouse_cost_controller/createForm"; ?>';
                $.ajax({
                    type: "POST",
                    url: url,
                    dataType : 'json',
                    data: $("#form-warehoust-cost").serialize(),
                    success: function(response) {

                        if(response.success != true){
                            swal('Warning',response.message,'warning');
                        }else{
                            loadContentWithParams('agripro.warehouse_cost',{});
                        }

                    }
                });
            }
        });
    });
</script>