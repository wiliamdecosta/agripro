<!-- breadcrumb -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php base_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="#">Production Planning</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Production Planning</span>
        </li>
    </ul>
</div>
<!-- end breadcrumb -->
<div class="space-4"></div>

<div class="row">
    <div class="col-md-12">
        <button class="btn green" id="add-planning"><i class="fa fa-plus bigger-120"></i> New Planning</button>
    </div>
</div>
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

    jQuery(function ($) {
        $('#add-planning').on('click', function (e) {
            loadContentWithParams('agripro.production_planning_form', {});
        });
    });

    jQuery(function ($) {
        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID . "agripro.production_planning_controller/crud"; ?>',
            datatype: "json",
            mtype: "POST",
            colModel: [
                {
                    label: 'ID',
                    name: 'planning_id',
                    key: true,
                    width: 5,
                    sorttype: 'number',
                    editable: true,
                    hidden: true
                },
                {label: 'PO Number', name: 'po_number', width: 150, align: "left", editable: true, hidden: false},
                {label: 'Client', name: 'client_name', width: 150, align: "left", editable: true, hidden: false},
                {label: 'Start Date', name: 'planning_start_date', width: 120, align: "right", editable: true},
                {label: 'End Date', name: 'planning_end_date', width: 120, align: "right", editable: true},
                {label: 'Send Type', name: 'sending_type', width: 100, align: "left", editable: true},
                {label: 'Status', name: 'planning_status', width: 100, align: "left", editable: true},
                {label: 'Base Prepare Date', name: 'basis_prepare_date', width: 150, align: "left", editable: true},
                {label: 'Base Prepare QTY', name: 'basis_prepare_qty_init', width: 150, align: "left", editable: true},
                {label: 'Base Real QTY Arrived', name: 'basis_real_qty', width: 150, align: "left", editable: true},
                {label: 'Base Real Arrived', name: 'basis_real_arrived', width: 150, align: "left", editable: true},
                {label: 'Production Prep Date', name: 'prod_prepare_date', width: 150, align: "left", editable: true},
                {label: 'Production Prep QTY', name: 'prod_prepare_qty', width: 150, align: "left", editable: true},
                {label: 'Prep Performa Inv', name: 'prep_performa_inv', width: 150, align: "left", editable: true},
                {label: 'Shipping Start Date', name: 'shipping_start_date', width: 150, align: "left", editable: true},
                {label: 'Shipping End Date', name: 'shipping_end_date', width: 150, align: "left", editable: true},
                {label: 'Vessel Feeder Name', name: 'vessel_feeder_name', width: 150, align: "left", editable: true},
                {label: 'Stuffing Date', name: 'stuffing_date', frozen:true, width: 150, align: "left", editable: true},
                {label: 'Loading Date', name: 'loading_date', frozen:true, width: 150, align: "left", editable: true}

            ],
            height: '100%',
            autowidth: true,
            viewrecords: true,
            rowNum: 10,
            rowList: [10, 20, 50],
            rownumbers: true, // show row numbers
            rownumWidth: 35, // the width of the row numbers columns
            altRows: true,
            shrinkToFit: false,
            multiboxonly: true,
            subGrid: true, // set the subGrid property to true to show expand buttons for each row
            subGridRowExpanded: showChildGrid, // javascript function that will take care of showing the child grid
            subGridOptions: {
                // load the subgrid data only once
                // and the just show/hide
                reloadOnExpand: false,
                // select the row when the expand column is clicked
                selectOnExpand: true,
                plusicon: "ace-icon fa fa-plus center bigger-110 blue",
                minusicon: "ace-icon fa fa-minus center bigger-110 blue"
                // openicon : "ace-icon fa fa-chevron-right center orange"
            },
            onSelectRow: function (rowid) {
                /*do something when selected*/
                var celValue = $('#grid-table').jqGrid('getCell', rowid, 'production_id');
                var celCode = $('#grid-table').jqGrid('getCell', rowid, 'product_name');

                var grid_detail = jQuery("#grid-table-detail");
                if (rowid != null) {
                    grid_detail.jqGrid('setGridParam', {
                        url: '<?php echo WS_JQGRID . "agripro.production_planning_detail_controller/crud"; ?>',
                        postData: {production_id: rowid}
                    });
                    var strCaption = 'Raw Material :: ' + celCode;
                    grid_detail.jqGrid('setCaption', strCaption);
                    $("#grid-table-detail").trigger("reloadGrid");
                    $("#detail_placeholder").show();

                    responsive_jqgrid('#grid-table-detail', '#grid-pager-detail');
                }
            },
            sortorder: '',
            pager: '#grid-pager',
            jsonReader: {
                root: 'rows',
                id: 'id',
                repeatitems: false
            },
            loadComplete: function (response) {
                if (response.success == false) {
                    swal({title: 'Attention', text: response.message, html: true, type: "warning"});
                }
            },
            //memanggil controller jqgrid yang ada di controller crud
            editurl: '<?php echo WS_JQGRID . "agripro.production_planning_controller/crud"; ?>',
            caption: "Production Planning"

        });



        function showChildGrid(parentRowID, parentRowKey) {
            var childGridID = parentRowID + "_table";
            var childGridPagerID = parentRowID + "_pager";

            // send the parent row primary key to the server so that we know which grid to show
            var childGridURL = "<?php echo WS_JQGRID . "agripro.production_planning_controller/showProductList"; ?>/" + encodeURIComponent(parentRowKey)

            // add a table and pager HTML elements to the parent grid row - we will render the child grid here
            $('#' + parentRowID).append('<table id=' + childGridID + '></table><div id=' + childGridPagerID + ' class=scroll></div>');

            $("#" + childGridID).jqGrid({
                url: childGridURL,
                mtype: "POST",
                datatype: "json",
                page: 1,
                rownumbers: true, // show row numbers
                rownumWidth: 35,
                shrinkToFit: false,
//              scrollbar : true,
                postData: {planning_id: encodeURIComponent(parentRowKey)},
                colModel: [
                    {
                        label: 'id',
                        name: 'product_planning_id',
                        key: true,
                        width: 10,
                        sorttype: 'number',
                        editable: false,
                        hidden: true
                    },
                    {label: 'Product Name', name: 'product_name', width: 225, align: "left", editable: false},
                    {label: 'Weight (Kg)', name: 'weight', width: 205, align: "right", editable: false}
                ],
//              loadonce: true,
                width: '100%',
                height: '100%',
                jsonReader: {
                    root: 'rows',
                    id: 'id',
                    repeatitems: false
                }
//            pager: "#" + childGridPagerID
            });

        }

        jQuery("#grid-table").jqGrid('setFrozenColumns');

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
                    jQuery("#detail_placeholder").hide();
                },

                refreshicon: 'fa fa-refresh green bigger-120',
                view: false,
                viewicon: 'fa fa-search-plus grey bigger-120'
            },

            {
                // options for the Edit Dialog
                closeAfterEdit: true,
                closeOnEscape: true,
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
                afterShowForm: function (form) {
                    form.closest('.ui-jqdialog').center();
                },
                afterSubmit: function (response, postdata) {
                    var response = jQuery.parseJSON(response.responseText);
                    if (response.success == false) {
                        return [false, response.message, response.responseText];
                    }
                    return [true, "", response.responseText];
                }
            },
            {
                //new record form
                closeAfterAdd: false,
                clearAfterAdd: true,
                closeOnEscape: true,
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
                afterShowForm: function (form) {
                    form.closest('.ui-jqdialog').center();
                },
                afterSubmit: function (response, postdata) {
                    var response = jQuery.parseJSON(response.responseText);
                    if (response.success == false) {
                        return [false, response.message, response.responseText];
                    }

                    $(".tinfo").html('<div class="ui-state-success">' + response.message + '</div>');
                    var tinfoel = $(".tinfo").show();
                    tinfoel.delay(3000).fadeOut();


                    return [true, "", response.responseText];
                }
            },
            {
                //delete record form
                serializeDelData: serializeJSON,
                recreateForm: true,
                width: 400,
                caption: 'Delete data production',
                msg: "Once You delete selected record, it cannot be restored.<br>Are You sure to delete selected record?",
                beforeShowForm: function (e) {
                    var form = $(e[0]);
                    style_delete_form(form);
                },
                afterShowForm: function (form) {
                    form.closest('.ui-jqdialog').center();
                },
                onClick: function (e) {
                    //alert(1);
                },
                afterSubmit: function (response, postdata) {
                    var response = jQuery.parseJSON(response.responseText);
                    if (response.success == false) {
                        return [false, response.message, response.responseText];
                    }
                    return [true, "", response.responseText];
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
            colModel: [
                {
                    label: 'ID',
                    key: true,
                    name: 'planning_part_id',
                    width: 5,
                    sorttype: 'number',
                    editable: true,
                    hidden: true
                },
                {
                    label: 'production_planning_id',
                    name: 'production_planning_id',
                    width: 5,
                    sorttype: 'number',
                    editable: true,
                    hidden: true
                },
                {
                    label: 'PO Number',
                    name: 'planning_part_number',
                    width: 150,
                    sorttype: 'number',
                    editable: true,
                    hidden: false
                },

                {label: 'Due Date', name: 'planning_part_start_date', width: 200, align: "left", editable: false},
                {label: 'Quantity', name: 'planning_part_qty_init', width: 200, align: "right", editable: false}
            ],
            height: '100%',
            width: 500,
            autowidth: true,
            viewrecords: true,
            rowNum: 10,
            rowList: [10, 20, 50],
            rownumbers: true, // show row numbers
            rownumWidth: 35, // the width of the row numbers columns
            altRows: true,
            shrinkToFit: true,
            multiboxonly: true,
            onSelectRow: function (permission_name) {
                /*do something when selected*/
            },
            sortorder: '',
            pager: '#grid-pager-detail',
            jsonReader: {
                root: 'rows',
                id: 'id',
                repeatitems: false
            },
            loadComplete: function (response) {
                if (response.success == false) {
                    swal({title: 'Attention', text: response.message, html: true, type: "warning"});
                }

            },
            //memanggil controller jqgrid yang ada di controller crud
            // editurl: '<?php echo WS_JQGRID . "agripro.packing_detail_controller/crud"; ?>',
            caption: "Production Detail"

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
                view: false,
                viewicon: 'fa fa-search-plus grey bigger-120'
            },

            {
                closeAfterEdit: true,
                closeOnEscape: true,
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
                    form.css({"height": 0.50 * screen.height + "px"});
                    form.css({"width": 0.60 * screen.width + "px"});

                    $("#smd_batch_number").prop("readonly", true);
                },
                afterShowForm: function (form) {
                    form.closest('.ui-jqdialog').center();
                },
                afterSubmit: function (response, postdata) {
                    var response = jQuery.parseJSON(response.responseText);
                    if (response.success == false) {
                        return [false, response.message, response.responseText];
                    }
                    return [true, "", response.responseText];
                }

            },
            {

                //new record form
                editData: {
                    pkg_id: function () {
                        var selRowId = $("#grid-table").jqGrid('getGridParam', 'selrow');
                        var pkg_id = $("#grid-table").jqGrid('getCell', selRowId, 'pkg_id');
                        return pkg_id;
                    }
                },
                closeAfterAdd: true,
                clearAfterAdd: true,
                closeOnEscape: true,
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
                    form.css({"height": 0.50 * screen.height + "px"});
                    form.css({"width": 0.60 * screen.width + "px"});

                    $("#smd_batch_number").prop("readonly", true);
                    setTimeout(function () {
                        clearLovstock_material_detail();
                        clearLovPlantation();
                    }, 100);
                },
                afterShowForm: function (form) {
                    form.closest('.ui-jqdialog').center();
                },
                afterSubmit: function (response, postdata) {
                    var response = jQuery.parseJSON(response.responseText);
                    if (response.success == false) {
                        return [false, response.message, response.responseText];
                    }

                    $(".tinfo").html('<div class="ui-state-success">' + response.message + '</div>');
                    var tinfoel = $(".tinfo").show();
                    tinfoel.delay(3000).fadeOut();

                    return [true, "", response.responseText];
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
                afterShowForm: function (form) {
                    form.closest('.ui-jqdialog').center();
                },
                onClick: function (e) {
                    //alert(1);
                },
                afterSubmit: function (response, postdata) {
                    var response = jQuery.parseJSON(response.responseText);
                    if (response.success == false) {
                        return [false, response.message, response.responseText];
                    }
                    return [true, "", response.responseText];
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
        $(grid_selector).jqGrid('setGridWidth', $(".page-content").width());
        $(pager_selector).jqGrid('setGridWidth', parent_column.width());
    }

</script>