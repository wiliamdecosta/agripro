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
            <span>Shipping Cost Form</span>
        </li>
    </ul>
</div>

<div class="space-4"></div>
<div class="row">
    <div class="col-md-12">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">Shipping Cost Form</div>
            </div>

            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form method="post" action="" class="form-horizontal" id="form-shipping">
                    <div class="form-body">

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="shipping_date">Shipping Date</label>
                            <div class="col-md-2">
                                <input type="text" readonly="" name="shipping_date" id="shipping_date" class="form-control" value="<?php echo $this->input->post('shipping_date'); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="shipping_driver_name">Driver Name:</label>
                            <div class="col-md-3">
                                <input type="text" readonly="" name="shipping_driver_name" id="shipping_driver_name" class="form-control" value="<?php echo $this->input->post('shipping_driver_name'); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="shipping_notes">Notes:</label>
                            <div class="col-md-6">
                                <textarea readonly="" name="shipping_notes" id="shipping_notes" class="form-control"><?php echo $this->input->post('shipping_notes'); ?></textarea>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-offset-1 col-md-10">
                                <h3>Cost Details</h3>
                                <div class="row row-cost-detail">
                                    <div class="col-md-12">
                                        <table id="grid-table"></table>
                                        <div id="grid-pager"></div>
                                    </div>
                                </div>
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

<?php $this->load->view('lov/lov_parameter_cost.php'); ?>

<script>
    function showLovParameterCost(id, code) {
        modal_lov_parameter_cost_show(id, code);
    }

    function clearLovParameterCode() {
        $('#form_parameter_cost_id').val('');
        $('#form_parameter_cost_code').val('');
    }
</script>

<script>

    jQuery(function($) {
        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID."agripro.shipping_cost_controller/crud"; ?>',
            datatype: "json",
            postData: {shipping_id : <?php echo $this->input->post('shipping_id'); ?>},
            mtype: "POST",
            colModel: [
                {label: 'ID', name: 'shipping_cost_id', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'Shipping ID', name: 'shipping_id', width: 120, align: "center", editable: true, hidden:true},
                {label: 'Cost Code', name: 'parameter_cost_code', width: 200, align: "left", editable: false},
                {label: 'Cost Code',
                    name: 'parameter_cost_id',
                    width: 200,
                    sortable: true,
                    editable: true,
                    hidden: true,
                    editrules: {edithidden: true, number:true, required:true},
                    edittype: 'custom',
                    editoptions: {
                        "custom_element":function( value  , options) {
                            var elm = $('<span></span>');

                            // give the editor time to initialize
                            setTimeout( function() {
                                elm.append('<input id="form_parameter_cost_id" type="text"  style="display:none;">'+
                                        '<input id="form_parameter_cost_code" disabled type="text" class="FormElement jqgrid-required" placeholder="Choose Cost Code">'+
                                        '<button class="btn btn-success" type="button" onclick="showLovParameterCost(\'form_parameter_cost_id\',\'form_parameter_cost_code\')">'+
                                        '   <span class="fa fa-search icon-on-right bigger-110"></span>'+
                                        '</button>');
                                $("#form_parameter_cost_id").val(value);
                                elm.parent().removeClass('jqgrid-required');
                            }, 100);

                            return elm;
                        },
                        "custom_value":function( element, oper, gridval) {

                            if(oper === 'get') {
                                return $("#form_parameter_cost_id").val();
                            } else if( oper === 'set') {
                                $("#form_parameter_cost_id").val(gridval);
                                var gridId = this.id;
                                // give the editor time to set display
                                setTimeout(function(){
                                    var selectedRowId = $("#"+gridId).jqGrid ('getGridParam', 'selrow');
                                    if(selectedRowId != null) {
                                        var code_display = $("#"+gridId).jqGrid('getCell', selectedRowId, 'parameter_cost_code');
                                        $("#form_parameter_cost_code").val( code_display );
                                    }
                                },100);
                            }
                        }
                    }
                },
                {label: 'Cost Value (Rp)',name: 'shipping_cost_value',width: 150, align: "left",editable: true,
                    editoptions: {
                        size: 30,
                        maxlength:32
                    },
                    editrules: {required: true}
                },
                {label: 'Description',name: 'shipping_cost_description',width: 150, align: "left",editable: true,
                    edittype:'textarea',
                    editoptions: {
                        size: 30,
                        maxlength:255
                    },
                    editrules: {required: false}
                }
            ],
            height: '100%',
            autowidth: true,
            viewrecords: true,
            rowNum: 10,
            rowList: [10,20,50],
            rownumbers: true, // show row numbers
            rownumWidth: 35, // the width of the row numbers columns
            altRows: true,
            shrinkToFit: true,
            multiboxonly: true,
            onSelectRow: function (rowid) {
                /*do something when selected*/

            },
            sortorder:'',
            pager: '#grid-pager',
            jsonReader: {
                root: 'rows',
                id: 'id',
                repeatitems: false
            },
            loadComplete: function (response) {
                if(response.success == false) {
                    swal({title: 'Attention', text: response.message, html: true, type: "warning"});
                }

            },
            //memanggil controller jqgrid yang ada di controller crud
            editurl: '<?php echo WS_JQGRID."agripro.shipping_cost_controller/crud"; ?>',
            caption: "Cost Details"

        });

        jQuery('#grid-table').jqGrid('navGrid', '#grid-pager',
            {   //navbar options
                edit: true,
                editicon: 'fa fa-pencil blue bigger-120',
                add: true,
                addicon: 'fa fa-plus-circle purple bigger-120',
                del: true,
                delicon: 'fa fa-trash-o red bigger-120',
                search: true,
                searchicon: 'fa fa-search orange bigger-120',
                refresh: true,
                afterRefresh: function () {
                    // some code here
                },

                refreshicon: 'fa fa-refresh green bigger-120',
                view: false,
                viewicon: 'fa fa-search-plus grey bigger-120'
            },

            {
                // options for the Edit Dialog
                closeAfterEdit: true,
                closeOnEscape:true,
                recreateForm: true,
                serializeEditData: serializeJSON,
                width: 'auto',
                errorTextFormat: function (data) {
                    return 'Error: ' + data.responseText
                },
                beforeShowForm: function (e, form) {
                    var form = $(e[0]);
                    style_edit_form(form);

                },
                afterShowForm: function(form) {
                    form.closest('.ui-jqdialog').center();
                },
                afterSubmit:function(response,postdata) {
                    var response = jQuery.parseJSON(response.responseText);
                    if(response.success == false) {
                        return [false,response.message,response.responseText];
                    }
                    return [true,"",response.responseText];
                }
            },
            {
                //new record form
                editData: {
                    shipping_id: function() {
                        return <?php echo $this->input->post('shipping_id'); ?>;
                    }
                },
                closeAfterAdd: false,
                clearAfterAdd : true,
                closeOnEscape:true,
                recreateForm: true,
                width: 'auto',
                errorTextFormat: function (data) {
                    return 'Error: ' + data.responseText
                },
                serializeEditData: serializeJSON,
                viewPagerButtons: false,
                beforeShowForm: function (e, form) {
                    var form = $(e[0]);
                    style_edit_form(form);

                    setTimeout(function() {
                        clearLovParameterCode();
                    },100);
                },
                afterShowForm: function(form) {
                    form.closest('.ui-jqdialog').center();
                },
                afterSubmit:function(response,postdata) {
                    var response = jQuery.parseJSON(response.responseText);
                    if(response.success == false) {
                        return [false,response.message,response.responseText];
                    }

                    $(".tinfo").html('<div class="ui-state-success">' + response.message + '</div>');
                    var tinfoel = $(".tinfo").show();
                    tinfoel.delay(3000).fadeOut();

                    clearLovParameterCode();

                    return [true,"",response.responseText];
                }
            },
            {
                //delete record form
                serializeDelData: serializeJSON,
                recreateForm: true,
                beforeShowForm: function (e) {
                    var form = $(e[0]);
                    style_delete_form(form);

                },
                afterShowForm: function(form) {
                    form.closest('.ui-jqdialog').center();
                },
                onClick: function (e) {
                    //alert(1);
                },
                afterSubmit:function(response,postdata) {
                    var response = jQuery.parseJSON(response.responseText);
                    if(response.success == false) {
                        return [false,response.message,response.responseText];
                    }
                    return [true,"",response.responseText];
                }
            },
            {
                //search form
                closeAfterSearch: false,
                recreateForm: true,
                afterShowSearch: function (e) {
                    var form = $(e[0]);
                    style_search_form(form);
                    form.closest('.ui-jqdialog').center();
                },
                afterRedraw: function () {
                    style_search_filters($(this));
                }
            },
            {
                //view record form
                recreateForm: true,
                beforeShowForm: function (e) {
                    var form = $(e[0]);
                }
            }
        );

    });

    function responsive_jqgrid(grid_selector, pager_selector) {
        var parent_column = $(grid_selector).closest('[class*="col-"]');
        $(grid_selector).jqGrid( 'setGridWidth', $(".row-cost-detail").width() );
        $(pager_selector).jqGrid( 'setGridWidth', parent_column.width() );
    }

</script>

<script>
    $(function() {

        $("#btn-back").on('click', function(e) {
            loadContentWithParams('agripro.shipping',{});
        });

    });
</script>