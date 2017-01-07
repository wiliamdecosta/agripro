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
            <span>Add Production Planning</span>
        </li>
    </ul>
</div>

<div class="space-4"></div>
<div class="row">
    <div class="col-md-12">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">Add Production Planning Form</div>
            </div>

            <div class="portlet light portlet-fit portlet-form bordered">
                <!-- BEGIN FORM-->
                <form method="post" action="#" class="form-horizontal" id="planningmod">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                           value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <div class="form-body">
<!--                        <h3 class="form-section">PO Detail</h3>-->
                        <div class="tabbable-custom nav-justified">
                            <ul class="nav nav-tabs nav-justified">
                                <li class="active">
                                    <a href="#tab_1_1_1" data-toggle="tab" aria-expanded="true"> PO Detail </a>
                                </li>
                                <li class="">
                                    <a href="#tab_1_1_2" data-toggle="tab" aria-expanded="false"> Basis & Production Prepare </a>
                                </li>
                                <li class="">
                                    <a href="#tab_1_1_3" data-toggle="tab" aria-expanded="false"> Shipping </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1_1_1">
                                    &nbsp;
                                    &nbsp;
                                    <div class="row">
                                        <div class="col-md-6" id="left-col">

                                            <div class="form-group">
                                                <label class="col-md-4 control-label">PO Number
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-8">
                                                    <input type="text" name="inPONumber" id="inPONumber" class="form-control"
                                                           placeholder="Ex : ATN-0000001">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4 control-label" for="tgl">Planning Start Date
                                                    <span class="required">  </span>
                                                </label>
                                                <div class="col-md-8">
                                                    <div class="input-group date date-picker">
                                                        <input type="text" name="inStartDate" id="inStartDate" class="form-control"
                                                               placeholder="Ex : <?php echo date('Y-m-d');?>">
                                                        <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-calendar"></i>
                                                            </button>
                                                        </span>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Status
                                                    <span class="required"> * </span>
                                                </label>
                                                <!--<div class="col-md-8">
                                                    <select name="status" id="status" class="form-control">
                                                        <option value="">-</option>
                                                        <option value="1" selected>Planned</option>
                                                        <option value="2">Shipped</option>
                                                        <option value="3">Done</option>
                                                    </select>
                                                </div>-->
                                                <div class="md-radio-inline col-md-8">
                                                    <div class="md-radio">
                                                        <input type="radio" id="radio14" value="Planned" name="rbStatus" class="md-radiobtn" checked="">
                                                        <label for="radio14">
                                                            <span class="inc"></span>
                                                            <span class="check"></span>
                                                            <span class="box"></span> Planned </label>
                                                    </div>
                                                    <div class="md-radio has-error">
                                                        <input type="radio" id="radio15" value="Shipped" name="rbStatus" class="md-radiobtn" >
                                                        <label for="radio15">
                                                            <span class="inc"></span>
                                                            <span class="check"></span>
                                                            <span class="box"></span> Shipped </label>
                                                    </div>
                                                    <div class="md-radio has-warning">
                                                        <input type="radio" id="radio16" value="Done" name="rbStatus" class="md-radiobtn">
                                                        <label for="radio16">
                                                            <span class="inc"></span>
                                                            <span class="check"></span>
                                                            <span class="box"></span> Done </label>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <!--                            Right Col                                    -->
                                        <!---------------------------------------------------------------------------->
                                        <div class="col-xs-6" id="right-col">

                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Client Name
                                                    <span class="required"> </span>
                                                </label>
                                                <div class="col-md-8">
                                                    <input type="text" name="inClientName" id="inClientName" class="form-control"
                                                           placeholder="Ex : Haba">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Planning End Date
                                                    <span class="required">  </span>
                                                </label>
                                                <div class="col-md-8">
                                                    <div class="input-group date date-picker">
                                                        <input type="text" name="inEndDate" id="inEndDate" class="form-control"
                                                               placeholder="Ex : <?php echo date('Y-m-d');?>">
                                                        <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-calendar"></i>
                                                            </button>
                                                        </span>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Sending Type
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-8">
                                                    <select name="slSendingType" id="slSendingType" class="form-control">
                                                        <option value="Full"> Full</option>
                                                        <option value="In Parts"> In Parts</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    </div>
                                <div class="tab-pane" id="tab_1_1_2">
                                    &nbsp;
                                    &nbsp;
                                    <div class="row">
                                        <div class="col-md-6" id="tab2Kiri">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Basis Prepare Date
                                                    <span class="required">  </span>
                                                </label>
                                                <div class="col-md-8">
                                                    <div class="input-group date">
                                                        <input type="text" name="inBasisPrepDate" id="inBasisPrepDate"
                                                               class="form-control"
                                                               placeholder="" disabled>
                                                        <span class="input-group-btn">
                                                                <button class="btn default" type="button">
                                                                    <i class="fa fa-calendar"></i>
                                                                </button>
                                                            </span>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Basis Real Date Arrived
                                                    <span class="required">  </span>
                                                </label>
                                                <div class="col-md-8">
                                                    <div class="input-group date date-picker">
                                                        <input type="text" name="inBasisRealDate" id="inBasisRealDate"
                                                               class="form-control"
                                                               placeholder="Ex : <?php echo date('Y-m-d');?>">
                                                        <span class="input-group-btn">
                                                                <button class="btn default" type="button">
                                                                    <i class="fa fa-calendar"></i>
                                                                </button>
                                                            </span>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Production Prep Date
                                                    <span class="required">  </span>
                                                </label>
                                                <div class="col-md-8">
                                                    <div class="input-group date date-picker">
                                                        <input type="text" name="inProdPrepDate" id="inProdPrepDate"
                                                               class="form-control"
                                                               placeholder="Ex : <?php echo date('Y-m-d');?>">
                                                        <span class="input-group-btn">
                                                                <button class="btn default" type="button">
                                                                    <i class="fa fa-calendar"></i>
                                                                </button>
                                                            </span>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6" id="tab2Kanan">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Basis Prepare QTY
                                                    <span class="required">  </span>
                                                </label>
                                                <div class="col-md-8">

                                                    <input type="text" name="inBasisPrepQTY" id="inBasisPrepQTY"
                                                           class="form-control"
                                                           placeholder="0 KG" disabled>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Basis Real QTY Arrived
                                                    <span class="required">  </span>
                                                </label>
                                                <div class="col-md-8">
                                                    <input type="text" name="inBasisRealQTY" id="inBasisRealQTY"
                                                           class="form-control"
                                                           placeholder="0 KG">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Production Prep QTY
                                                    <span class="required">  </span>
                                                </label>
                                                <div class="col-md-8">

                                                    <input type="text" name="inProdPrepQTY" id="inProdPrepQTY"
                                                           class="form-control"
                                                           placeholder="0 KG">
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <div class="tab-pane" id="tab_1_1_3">
                                    &nbsp;
                                    &nbsp;
                                    <div class="row">
                                        <div class="col-md-6" id="tab3Kiri">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Prep Performa Inv
                                                    <span class="required">  </span>
                                                </label>
                                                <div class="col-md-8">
                                                    <input type="text" name="inPrepPerformaInv" id="inPrepPerformaInv"
                                                           class="form-control"
                                                           placeholder="Ex : Stuffing 13 Sept 2016 on warehouse">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Planned Shipping from
                                                    <span class="required">  </span>
                                                </label>
                                                <div class="col-md-8">
                                                    <div class="input-group date date-picker">
                                                        <input type="text" name="inShippingStartDate" id="inShippingStartDate"
                                                               class="form-control"
                                                               placeholder="Ex : <?php echo date('Y-m-d');?>">
                                                        <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-calendar"></i>
                                                            </button>
                                                        </span>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Stuffing Date
                                                    <span class="required">  </span>
                                                </label>
                                                <div class="col-md-8 ">
                                                    <div class="input-group date date-picker">
                                                        <input type="text" name="inStuffingDate" id="inStuffingDate"
                                                               class="form-control"
                                                               placeholder="Ex : <?php echo date('Y-m-d');?>">
                                                        <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-calendar"></i>
                                                            </button>
                                                        </span>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div  class="col-md-6" id="tab3Kanan">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Vessel Feeder Name
                                                    <span class="required">  </span>
                                                </label>
                                                <div class="col-md-8">

                                                    <input type="text" name="inVesselName" id="inVesselName"
                                                           class="form-control"
                                                           placeholder="Ex : Chittagong 0680-004E ">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Planned Shipping to
                                                    <span class="required">  </span>
                                                </label>
                                                <div class="col-md-8">
                                                    <div class="input-group date date-picker">
                                                        <input type="text" name="inPlannedShippingTo" id="inPlannedShippingTo"
                                                               class="form-control"
                                                               placeholder="Ex : <?php echo date('Y-m-d');?>">
                                                        <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-calendar"></i>
                                                            </button>
                                                        </span>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Loading Date
                                                    <span class="required">  </span>
                                                </label>
                                                <div class="col-md-8">
                                                    <div class="input-group date date-picker">
                                                        <input type="text" name="inLoadingDate" id="inLoadingDate"
                                                               class="form-control"
                                                               placeholder="Ex : <?php echo date('Y-m-d');?>">
                                                        <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-calendar"></i>
                                                            </button>
                                                        </span>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <h3 class="form-section">Add Product Planning</h3>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Product</label>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <input type="hidden" name="production_product_id" id="production_product_id"
                                                   class="form-control">
                                            <input type="hidden" name="parent_id" id="parent_id"
                                                   class="form-control">
                                            <input type="text" name="production_product_code"
                                                   id="production_product_code" readonly=""
                                                   class="form-control" placeholder="Choose Product">
                                            <span class="input-group-btn">
                                        <button class="btn btn-success" type="button"
                                                onclick="showLovProduct('production_product_id','production_product_code','parent_id')">
                                            <span class="fa fa-search icon-on-right bigger-110"></span>
                                        </button>
                                    </span>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <input type="text" id="in_source_qty" name="in_source_qty" class="form-control"
                                               placeholder="Weight(Kg)">
                                    </div>
                                    <div class="col-md-1">
                                        <button class="btn btn-primary" type="button" id="btn-add-source"><i
                                                class="fa fa-plus"></i>Add Source
                                        </button>
                                    </div>
                                </div>
                                <table class="table table-bordered table-striped" id="tbl-product">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>Quantity(Kg)</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                                <!--<div class="panel-body scrollable p-t-n p-b-n">
                                    <div class="table-responsive">
                                        <table id="selectProductPurchase" class="table table-condensed">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Item<span class="error display-inline">*</span></th>
                                                <th width="110" class="center">Qty<span
                                                        class="error display-inline">*</span></th>
                                                <th width="110" class="text-center ng-binding">Qty<span
                                                        class="error display-inline">*</span></th>
                                                <th width="120" class="ng-binding">Tax</th>
                                                <th width="80" align="right" class="text-right">Total</th>
                                                <th width="10" align="right"></th>
                                            </tr>
                                            </thead>
                                            <tbody class="ui-sortable">
                                            <tr>
                                                <td rowspan="1">
                                                    <i class="fa fa-th-list fa-1x myHandle text-master-light"></i>
                                                    &nbsp;&nbsp;<h4>1</h4>
                                                </td>
                                                <td class="v-align-top">
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label" for="packing_batch_number">PO Number
                                                            <span class="required"> * </span>
                                                        </label>
                                                        <div class="col-md-8">
                                                            <input type="text" name="po_number" id="po_number" class="form-control input-sm"
                                                                   placeholder="PO Number">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label" for="packing_batch_number">PO Number
                                                            <span class="required"> * </span>
                                                        </label>
                                                        <div class="col-md-8">
                                                            <input type="text" name="po_number" id="po_number" class="form-control input-sm"
                                                                   placeholder="PO Number">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="v-align-top">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <input name="quantity" id="txtQuantity"
                                                                   class="form-control input-sm">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="v-align-top">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <input name="quantity" id="txtQuantity"
                                                                   class="form-control input-sm">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="v-align-top">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <input name="quantity" id="txtQuantity"
                                                                   class="form-control input-sm">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="v-align-top">
                                                    <div class="col-md-10">
                                                        <div class="form-group">
                                                            <input name="quantity" id="txtQuantity"
                                                                   class="form-control input-sm">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="v-align-top b-b-none" align="right">
                                                    <span class="btn-link pull-right">
                                                        <a>
                                                            <i class="fa fa-times"></i>
                                                        </a>
                                                    </span>
                                                </td>
                                            </tr>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th colspan="7">
                                                    <input type="button" ng-disabled="purchase.isBackToBack"
                                                           value="Add Item"
                                                           ng-show="purchase.purchaseOrderDetailsList_Items.length < maxDetailItems"
                                                           ng-click="addItem()"
                                                           class="btn btn-success btn-sm deactive-button">
                                                </th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>-->
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

<?php $this->load->view('lov/lov_product_planning.php'); ?>

<script>
    jQuery.validator.setDefaults({
        debug: true,
        success: "valid"
    });
    var form1 = $('#planningmod');
    var error1 = $('.alert-danger', form1);
    var success1 = $('.alert-success', form1);

    form1.validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "",  // validate all fields including form hidden input
        rules: {
            inPONumber: {
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
                .addClass('valid') // mark the current input as valid and display OK icon
                .closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
        },

        submitHandler: function (form) {
            success1.show();
            error1.hide();
        }
    });
</script>

<script>
    function showLovProduct(id, code, parent_id, p_cat) {
        var row_product_ids = $('[name="row_product_id[]"]');
        console.log(row_product_ids.val());
        modal_lov_product_show(id, code, parent_id, p_cat);
    }

    $('#production_product_code').change(function () {
        $('.tr_body').empty();
    })
</script>


<script>
    function insertDataRow() {

        var jumlah_baris = document.getElementById('tbl-product').rows.length;

        var production_product_id = document.getElementById('production_product_id').value;
        var production_product_code = document.getElementById('production_product_code').value;
        var weight = document.getElementById('in_source_qty').value;

        var tr = document.getElementById('tbl-product').insertRow(jumlah_baris);
        var tdNo = tr.insertCell(0);
        var tdProduct = tr.insertCell(1);
        var tdWeight = tr.insertCell(2);
        var tdAction = tr.insertCell(3);

        tdNo.innerHTML = jumlah_baris;
        tdProduct.innerHTML = '<input type="hidden" name="row_product_id[]" value="' + production_product_id + '">' + production_product_code;
        tdWeight.innerHTML = '<input type="hidden" name="weight[]" value="' + weight + '">' + weight;
        tdAction.innerHTML = '<button type="button" onclick="deleteDataRow(this);"><i class="fa fa-trash"></i> Delete </button>';


        document.getElementById('production_product_code').value = "";
        document.getElementById('production_product_id').value = "";
        document.getElementById('in_source_qty').value = "";
    }

    function deleteDataRow(sender) {
        $(sender).parent().parent().remove();
    }

</script>

<script>
    $(function () {

        $(".date-picker").datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
            orientation: 'bottom',
            todayHighlight: true
        });


        $("#btn-back").on('click', function (e) {
            loadContentWithParams('agripro.production_planning', {});
        });

        $("#btn-add-source").on('click', function (e) {

            var inPONumber = $('#inPONumber').val();
            var tgl = $('#tgl').val();

            if (inPONumber == "") {
                swal('Information', 'PO Number must be filled first', 'info');
                return;
            }

            var production_product_id = $('#production_product_id').val();
            var in_source_qty = $('#in_source_qty').val();

            if (production_product_id == "" || in_source_qty == "") {
                swal('Information', 'Product and Weight must be filled', 'info');
                return;
            }

            var row_product_id = $('[name="row_product_id[]"]');
            if (row_product_id.length > 0) {
                var error = false;
                row_product_id.each(function (index) {
                    if (production_product_id == $(this).val()) {
                        swal('Information', 'Oops, we found double source package. choose another source', 'info');
                        error = true;
                    }
                });
                if (error) return;
            }

            insertDataRow();
        });


        $("#planningmod").submit(function (e) {
            e.preventDefault();

            if ($("#planningmod").valid() == true) {
                var url = '<?php echo WS_JQGRID . "agripro.production_planning_controller/createForm"; ?>';
                $.ajax({
                    type: "POST",
                    url: url,
                    dataType: 'json',
                    data: $("#planningmod").serialize(),
                    success: function (response) {

                        if (response.success != true) {
                            swal('Warning', response.message, 'warning');
                        } else {
                            loadContentWithParams('agripro.production_planning', {});
                        }

                    }
                });
            }

        });


    });
</script>