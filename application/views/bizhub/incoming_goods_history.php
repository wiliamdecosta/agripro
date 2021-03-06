<!-- breadcrumb -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php base_url();?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="#">Incoming Raw Material</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>

            <span>Incoming Raw Material History</span>
        </li>
    </ul>
</div>
<!-- end breadcrumb -->
<div class="space-4"></div>


<div class="space-4"></div>
<div class="row">
    <div class="col-md-12">
        <table id="grid-table"></table>
        <div id="grid-pager"></div>
    </div>
</div>
<div class="space-4"></div>
<div class="row" id="detail_placeholder" style="display:none;">
    <div class="col-xs-12">
        <table id="grid-table-detail"></table>
        <div id="grid-pager-detail"></div>
    </div>
</div>

<script>
    function editIncoming(rowId) {
        var rowData = jQuery("#grid-table").getRowData(rowId);
        loadContentWithParams('agripro.incoming_goods_add_form', {
            in_biz_id : rowData.in_biz_id,
            in_biz_date : rowData.in_biz_date,
            shipping_id : rowData.in_shipping_id,
            shipping_date : rowData.shipping_date,
            shipping_driver_name : rowData.shipping_driver_name,
            shipping_notes : rowData.shipping_notes,
            wh_shipping_name : rowData.wh_shipping_name
        });
        
    }

    function costShipping(rowId) {
        var rowData = jQuery("#grid-table").getRowData(rowId);
        loadContentWithParams('agripro.shipping_cost_form', {
            shipping_id : rowData.in_shipping_id,
            shipping_date : rowData.shipping_date,
            shipping_driver_name : rowData.shipping_driver_name,
            shipping_notes : rowData.shipping_notes
        });
    }
    
</script>

<script>

    jQuery(function($) {
        $('#add-incoming').on('click',function(e) {
            loadContentWithParams('agripro.incoming_goods_add_form',{});
        });
    });
    function status_item (cellvalue, options, rowObject){
       if (cellvalue == 'L')
        return "<span style='color:red;'>Lost</span>";
       else if (cellvalue == 2)
        return "<span style='color:green;'>Ok</span>";
    }
    jQuery(function($) {
        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID."agripro.incoming_goods_controller/crud"; ?>',
            datatype: "json",
            mtype: "POST",
            postData : {report: 1},
            colModel: [
                {label: 'ID', name: 'in_biz_id', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                /*{label: 'Edit Data',name: '',width: 50, align: "center",editable: false,
                    formatter:function(cellvalue, options, rowObject) {
                        return '<a class="btn green-meadow btn-xs" href="#" onclick="editIncoming('+rowObject['in_biz_id']+')"><i class="fa fa-pencil"></i>Edit</a>';
                    }
                },*/
                {label: 'Date', name: 'in_biz_date', width: 75, align: "left", editable: false},
                {label: 'Shipping id', name: 'in_shipping_id', width: 120, align: "center", editable: false, hidden: true},
                {label: 'Shipping Date', name: 'shipping_date', width: 75, align: "left", editable: false},
                {label: 'Driver Name', name: 'shipping_driver_name', width: 100, align: "left", editable: false},
                {label: 'Shipping Notes', name: 'shipping_notes', width: 100, align: "left", editable: false, hidden:false},
                {label: 'From', name: 'wh_shipping_name', width: 100, align: "left", editable: false, hidden:false}
               
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
                 var celValue = $('#grid-table').jqGrid('getCell', rowid, 'shipping_id');
                var celCode = $('#grid-table').jqGrid('getCell', rowid, 'in_biz_date');
                var wh_name = $('#grid-table').jqGrid('getCell', rowid, 'wh_shipping_name');

                var grid_detail = jQuery("#grid-table-detail");
                if (rowid != null) {
                    grid_detail.jqGrid('setGridParam', {
                        url: '<?php echo WS_JQGRID."agripro.incoming_goods_detail_controller/crud"; ?>',
                        postData: {in_biz_id: rowid}
                    });
                    var strCaption = 'Detail :: at ' + celCode + ' From : ' +wh_name ;
                    grid_detail.jqGrid('setCaption', strCaption);
                    $("#grid-table-detail").trigger("reloadGrid");
                    $("#detail_placeholder").show();

                    responsive_jqgrid('#grid-table-detail', '#grid-pager-detail');
                } 
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
            editurl: '<?php echo WS_JQGRID."agripro.incoming_goods_controller/crud"; ?>',
            caption: "Incoming Raw Material"

        });

        jQuery('#grid-table').jqGrid('navGrid', '#grid-pager',
            {   //navbar options
                edit: false,
                editicon: 'fa fa-pencil blue bigger-120',
                add: false,
                addicon: 'fa fa-plus-circle purple bigger-120',
                del: false,
                delicon: 'fa fa-trash-o red bigger-120',
                search: true,
                searchicon: 'fa fa-search orange bigger-120',
                refresh: true,
                afterRefresh: function () {
                    // some code here
                    jQuery("#detail_placeholder").hide();
                },

                refreshicon: 'fa fa-refresh green bigger-120',
                view: true,
                viewicon: 'fa fa-search-plus grey bigger-120'
            },

            {
                // options for the Edit Dialog
                closeAfterEdit: true,
                closeOnEscape:true,
                recreateForm: true,
                viewPagerButtons: false,
                serializeEditData: serializeJSON,
                width: 'auto',
                errorTextFormat: function (data) {
                    return 'Error: ' + data.responseText
                },
                beforeShowForm: function (e, form) {
                    var form = $(e[0]);
                    style_edit_form(form);
                    $("#pkg_serial_number").prop("readonly", true);
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


                    return [true,"",response.responseText];
                }
            },
            {
                //delete record form
                serializeDelData: serializeJSON,
                recreateForm: true,
                width:400,
                caption:'Delete data',
                msg: "This Action Will Delete Master & Detail Data. <br>Once You delete selected record, it cannot be restored.<br>Are You sure to delete selected record?",
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

        /* ------------------------------  detail grid --------------------------------*/
        jQuery("#grid-table-detail").jqGrid({
            datatype: "json",
            mtype: "POST",
            postData : {report: 1},
            colModel: [
                {label: 'ID', key:true, name: 'in_biz_det_id', width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'Packing Label', name: 'packing_batch_number', width: 120, align: "left", editable: false},
                {label: 'Product Name', name: 'product_code', width: 200, align: "left", editable: false},
                {label: 'Status', name: 'in_biz_det_status', width: 120, align: "left", editable: false,
                     formatter:function(cellvalue, options, rowObject) {
                         if (cellvalue == 'L')
                            return "<span style='color:red;'><b>Lost</b></span>";
                           else
                            return "<span style='color:green;'><b>OK</b></span>";
                    }
                },
                {label: 'Quantity(Kg)', name: 'qty_source', width: 100, align: "left", editable: false},
                {label: 'New Quantity(Kg)', name: 'qty_rescale', width: 100, align: "left", editable: false},
                {label: 'Differentiation', name: '', width: 100, align: "left", editable: false, hidden:true},
                {label: 'Used By', name: 'used_by', width: 100, align: "left", editable: false},

            ],
            height: '100%',
            width:500,
            autowidth: true,
            viewrecords: true,
            rowNum: 10,
            rowList: [10,20,50],
            rownumbers: true, // show row numbers
            rownumWidth: 35, // the width of the row numbers columns
            altRows: true,
            shrinkToFit: true,
            multiboxonly: true,
            onSelectRow: function (permission_name) {
                /*do something when selected*/
            },
            sortorder:'',
            pager: '#grid-pager-detail',
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
            editurl: '<?php echo WS_JQGRID."agripro.shipping_detail_controller/crud"; ?>',
            caption: "Shipping Detail"

        });

        jQuery('#grid-table-detail').jqGrid('navGrid', '#grid-pager-detail',
            {   //navbar options
                edit: false,
                editicon: 'fa fa-pencil blue bigger-120',
                add: false,
                addicon: 'fa fa-plus-circle purple bigger-120',
                del: false,
                delicon: 'fa fa-trash-o red bigger-120',
                search: true,
                searchicon: 'fa fa-search orange bigger-120',
                refresh: true,
                afterRefresh: function () {
                    // some code here
                },

                refreshicon: 'fa fa-refresh green bigger-120',
                view: true,
                viewicon: 'fa fa-search-plus grey bigger-120'
            },

            {
                closeAfterEdit: true,
                closeOnEscape:true,
                recreateForm: true,
                viewPagerButtons: false,
                serializeEditData: serializeJSON,
                width: 'auto',
                errorTextFormat: function (data) {
                    return 'Error: ' + data.responseText
                },

                beforeShowForm: function (e, form) {
                    var form = $(e[0]);
                    style_edit_form(form);
                    form.css({"height": 0.50*screen.height+"px"});
                    form.css({"width": 0.60*screen.width+"px"});

                    $("#smd_batch_number").prop("readonly", true);
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
                    pkg_id: function() {
                        var selRowId =  $("#grid-table").jqGrid ('getGridParam', 'selrow');
                        var pkg_id = $("#grid-table").jqGrid('getCell', selRowId, 'pkg_id');
                        return pkg_id;
                    }
                },
                closeAfterAdd: true,
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
                    form.css({"height": 0.50*screen.height+"px"});
                    form.css({"width": 0.60*screen.width+"px"});

                    $("#smd_batch_number").prop("readonly", true);
                    setTimeout(function() {
                        clearLovstock_material_detail();
                        clearLovPlantation();
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
        $(grid_selector).jqGrid( 'setGridWidth', $(".page-content").width() );
        $(pager_selector).jqGrid( 'setGridWidth', parent_column.width() );
    }

</script>