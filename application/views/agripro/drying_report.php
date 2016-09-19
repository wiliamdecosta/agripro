<!-- breadcrumb -->

<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php base_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="#">Drying</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Drying Report</span>
        </li>
    </ul>
</div>
<!-- end breadcrumb -->
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
        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID . "agripro.drying_controller/crud"; ?>',
            datatype: "json",
            mtype: "POST",
            postData : {report: 1},
            colModel: [
                {label: 'ID', name: 'sm_id', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                {
                    label: 'Transaction Code', name: 'sm_no_trans', width: 250, align: "left", editable: true,
                    editoptions: {
                        size: 30,
                        maxlength: 32,
                        placeholder: 'Generate By Sistem'
                    },
                    editrules: {required: false}
                },
                {label: 'Farmer Code', name: 'fm_code', width: 150, align: "left", editable: false},
                {label: 'Farmer Name', name: 'fm_name', width: 170, align: "left", editable: false},
                {
                    label: 'RM Name', name: 'product_code', width: 120, align: "left", editable: false
                },
                {
                    label: 'Bruto (Kgs)', name: 'sm_qty_kotor', width: 120, align: "left", editable: true,
                    editoptions: {
                        size: 10,
                        maxlength: 4
                    },
                    editrules: {required: true}
                },
                {
                    label: 'Netto (Kgs)', name: 'sm_qty_bersih', width: 120, align: "left", editable: true,
                    editoptions: {
                        size: 10,
                        maxlength: 4
                    },
                    editrules: {required: true}
                },
                {
                    label: 'Lose %',
                    name: '',
                    width: 100,
                    align: "right",
                    editable: false,
                    formatter: function (cellvalue, options, rowObject) {
                        var bruto = rowObject.sm_qty_kotor;
                        var netto = rowObject.sm_qty_bersih;
                        var percentage =  ((bruto-netto)/bruto) * 100;
                        var percen =  percentage.toFixed(2) + " %";
                        //return percentage.toFixed(2) + "%";
                        return '<b><span style="color:red"> ' +percen+ ' </span></b>';

                    }
                },
                {
                    label: 'Drying Date', name: 'sm_tgl_pengeringan', width: 120, editable: true,
                    align: "right",
                    edittype: "text",
                    editrules: {required: true},
                    editoptions: {
                        // dataInit is the client-side event that fires upon initializing the toolbar search field for a column
                        // use it to place a third party control to customize the toolbar
                        dataInit: function (element) {
                            $(element).datepicker({
                                autoclose: true,
                                format: 'yyyy-mm-dd',
                                orientation: 'up',
                                todayHighlight: true
                            });
                        },
                        size: 25
                    }
                }
            ],
            height: '100%',
            width: '100%',
            autowidth: true,
            viewrecords: true,
            rowNum: 10,
            rowList: [10, 20, 50],
            rownumbers: true, // show row numbers
            rownumWidth: 35, // the width of the row numbers columns
            altRows: true,
            shrinkToFit: true,
            multiboxonly: true,
            onSelectRow: function (rowid) {

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
            editurl: '<?php echo WS_JQGRID . "agripro.drying_controller/crud"; ?>',
            caption: "Drying Report"

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
                    $("#sm_no_trans").prop("readonly", true);
                    clearLovFarmer();
                    clearLovPlantation();
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
                    /*form.css({"height": 0.70 * screen.height + "px"});
                    form.css({"width": 0.60 * screen.width + "px"});*/

                    $("#sm_no_trans").prop("readonly", true);
                    setTimeout(function () {
                        clearLovFarmer();
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