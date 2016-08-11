<!-- breadcrumb -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php base_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="#">Tracking</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Sorting Raw Material</span>
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
<div class="m-heading-1 border-green m-bordered" id="header_sortir">
<div class="row">
	
	<div class="col-md-4">
		<div class="input-group">
			<div class="input-icon">
				<i class="fa fa-calendar-plus-o fa-fw"></i>
			<input id="tgl_produksi" class="form-control" type="text" name="tgl_produksi" placeholder="Production Date" readonly /> </div>
			<span class="input-group-btn">
				<button class="btn btn-success" type="button" id="save_tgl_prod">
				<i class="fa fa-save fa-fw" /></i> Save</button>
		</span>
	</div>
</div>
	<div class="col-md-8">
			<div class="caption">
				<i class="glyphicon glyphicon-circle-arrow-right font-green"></i>
				<span class="caption-subject font-green bold uppercase" id="info_qty">Sorting Qty 0 (Kg)</span>
			</div>
			<div class="caption">
				<i class="glyphicon glyphicon-circle-arrow-right font-blue"></i>
				<span class="caption-subject font-blue bold uppercase" id="net_qty">Stock Material Quantity : 0 (Kg)</span>
			</div>
			<div class="caption">
				<i class="glyphicon glyphicon-circle-arrow-right font-red"></i>
				<span class="caption-subject font-red bold uppercase" id="info_avaqty">Available Quantity : 0 (Kg)</span>
			</div>
	</div>
	
</div>
</div>
<input type="hidden" id="temp_sm_id">
<input type="hidden" id="temp_qty_available">
<input type="hidden" id="temp_product_id">
<input type="hidden" id="temp_rowid">
<div class="row" id="detail_placeholder" style="display:none;">
    <div class="col-xs-12">
        <table id="grid-table-detail"></table>
        <div id="grid-pager-detail"></div>
    </div>
</div>


<?php $this->load->view('lov/lov_farmer.php'); ?>
<?php $this->load->view('lov/lov_raw_material.php'); ?>
<?php $this->load->view('lov/lov_plantation.php'); ?>

<script>

    function showLovFarmer(id, code) {
        modal_lov_farmer_show(id, code);
    }

    function clearLovFarmer() {
        $('#form_fm_id').val('');
        $('#form_fm_code').val('');
    }


    function showLovRawMaterial(id, code) {
        modal_lov_raw_material_show(id, code);
    }

    function clearLovRawMaterial() {
        $('#form_rm_id').val('');
        $('#form_rm_code').val('');
    }

    function showLovPlantation(id, code) {

        selRowId = $('#grid-table').jqGrid('getGridParam', 'selrow');
        // fm_id = $('#grid-table').jqGrid('getCell', selRowId, 'fm_id');
        if ($('#form_fm_id').val() == "") {
            swal({title: 'Attention', text: 'Please choose farmer', html: true, type: "info"});
            return;
        }
        modal_lov_plantation_show(id, code, $('#form_fm_id').val());
    }

    function clearLovPlantation() {
        $('#form_plt_id').val('');
        $('#form_plt_code').val('');
    }
	
	function show_detail_grid(rowid){
		
		get_availableqty();
		
		$("#temp_rowid").val(rowid);
		
		
		var celValue = $('#grid-table').jqGrid('getCell', rowid, 'sm_id');
		var celCode = $('#grid-table').jqGrid('getCell', rowid, 'sm_no_trans');
		var prod_date_1 = $('#grid-table').jqGrid('getCell', rowid, 'sm_tgl_produksi');
		$("#temp_sm_id").val(celValue);
		if(prod_date_1.length > 0 || $("#tgl_produksi").val().length>0){
				
			$('#header_sortir').show();
			var grid_detail = jQuery("#grid-table-detail");
			if (rowid != null) {
				grid_detail.jqGrid('setGridParam', {
					url: '<?php echo WS_JQGRID . "agripro.sortir_controller/crud"; ?>',
					postData: {sm_id: celValue}
				});
				var strCaption = 'Detail :: ' + celCode;
				$("#temp_sm_id").val(celValue);
				grid_detail.jqGrid('setCaption', strCaption);
				$("#grid-table-detail").trigger("reloadGrid");
				$("#detail_placeholder").show();
				// get quantity
				get_availableqty();
				
				responsive_jqgrid('#grid-table-detail', '#grid-pager-detail');
			}
			
		}else{
			$('#header_sortir').show();
            $("#detail_placeholder").hide();
		}
		
		
			
	}
	
    function get_availableqty() {
		
			$('#temp_qty_available').val(0);
			sm_id = $('#temp_sm_id').val();
			$.ajax({
				url: "<?php echo WS_JQGRID . 'agripro.sortir_controller/get_availableqty'; ?>",
				type: "POST",
				dataType: 'json',
				data: {sm_id: sm_id},
				success: function (data) {
					$('#tgl_produksi').val(data.tgl_prod);
					$('#temp_qty_available').val(data.avaqty);
					$('#info_avaqty').html('Available Quantity : '+data.avaqty +' (Kg)');
					$('#info_qty').html('Sorting Quantity : ' + data.srqty +' (Kg)');
					$('#net_qty').html('Stock Material Quantity : ' + data.qty_bersih +' (Kg)');
				},
				error: function (xhr, status, error) {
					swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
					return false;
				}
			});
		
    }
    function validation_qty(value) {
        ava_qty = $('#temp_qty_available').val();
        if ((value*1) > (ava_qty*1)) {
            return [false, "Available Quantity : " + ava_qty + " (Kg) "];
        } else {
            return [true, ''];
        }
        //return [false, "Available Quantity is : "+ava_qty+" (Kg) " +value];
    }
    function get_sm_id() {
        return $('#temp_sm_id').val();
    }
	$(document).ready(function(){
		
		$('#header_sortir').hide();
		
		$('#tgl_produksi').datepicker({
			autoclose: true,
			format: 'yyyy-mm-dd',
			orientation: 'down',
			todayHighlight: true
		});
		
		$('#save_tgl_prod').click(function(){
			
			sm_id = $('#temp_sm_id').val();
			tgl_produksi = $('#tgl_produksi').val();
			
			if(tgl_produksi.length > 0 ){
				$.ajax({
					url: "<?php echo WS_JQGRID . 'agripro.sortir_controller/upd_tgl_prod'; ?>",
					type: "POST",
					dataType: 'json',
					data: {sm_id: sm_id, tgl_prod:tgl_produksi},
					success: function (data) {
						swal({title: "Success!", text: 'Production Date Succesfully added ', html: true, type: "success"});
						$('#tgl_produksi').val(tgl_produksi);
						show_detail_grid($('#temp_rowid').val());
					},
					error: function (xhr, status, error) {
						swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
						return false;
					}
				});
			}else{
				swal({title: "Warning!", text: 'Please Choose Production Date', html: true, type: "warning"});
			}
				
			
				
		});
			
	})

    jQuery(function ($) {
        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID . "agripro.stock_material_controller/crud"; ?>',
            datatype: "json",
            mtype: "POST",
            postData: {is_sortir: '1'},
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
                    label: 'Netto (Kgs)', name: 'sm_qty_bersih', width: 120, align: "left", editable: true,
                    editoptions: {
                        size: 10,
                        maxlength: 4
                    },
                    editrules: {required: true}
                },
                {
                    label: 'Entry Date', name: 'sm_tgl_masuk', width: 120, editable: true,
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
                },
			{
				label: 'Production Date', name: 'sm_tgl_produksi', width: 120, editable: true, hidden: true,
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
                $("#detail_placeholder").hide();
                show_detail_grid(rowid);

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
				// reset 
				$('#temp_qty_available').val(0);
				$('#info_avaqty').html('Available Quantity : 0 (Kg)');
				$('#info_qty').html('Sorting Quantity : 0 (Kg)');
				$('#net_qty').html('Stock Material Quantity : 0 (Kg)');
            },
            //memanggil controller jqgrid yang ada di controller crud
            editurl: '<?php echo WS_JQGRID . "agripro.stock_material_controller/crud"; ?>',
            caption: "Sorting Raw Material"

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


        /* ------------------------------  detail grid --------------------------------*/
        jQuery("#grid-table-detail").jqGrid({
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'ID', key: true, name: 'sortir_id', width: 5, sorttype: 'number', editable: true, hidden: true},
                {
                    label: 'Stock Material ID',
                    name: 'sm_id',
                    width: 100,
                    sorttype: 'number',
                    editable: true,
                    hidden: true
                },
                {label: 'Product Code', name: 'product_code', width: 150, align: "left", editable: false},
                {
                    label: 'Product Code',
                    name: 'product_id',
                    width: 150,
                    align: "left",
                    editable: true,
                    edittype: 'select',
                    hidden: true,
                    editrules: {edithidden: true, required: true},
                    editoptions: {
                        dataUrl: '<?php echo WS_JQGRID . "agripro.sortir_controller/list_product"; ?>',
                        postData: {
                            sm_id: function () {
                                return $('#temp_sm_id').val()
                            }
                        },
                        dataInit: function (elem) {
                            $(elem).width(240);  // set the width which you need
                        }
                    }
                },
                {
                    label: 'Sorting Date', name: 'sortir_tgl', width: 120, editable: true,
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
                },
                {
                    label: 'Quantity(Kg)',
                    name: 'sortir_qty',
                    index: 'sortir_qty',
                    width: 120,
                    align: "right",
                    editable: true,
                    formatter: 'number',
                    edittype: 'text',
                    editrules: {edithidden: true, required: true, custom: true, custom_func: validation_qty},
                    formatoptions: {decimalSeparator: ".", thousandsSeparator: " "}

                }

            ],
            height: '100%',
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
                get_availableqty();
            },
            //memanggil controller jqgrid yang ada di controller crud
            editurl: '<?php echo WS_JQGRID . "agripro.sortir_controller/crud"; ?>',
            caption: "Sorting Raw Material"

        });

        jQuery('#grid-table-detail').jqGrid('navGrid', '#grid-pager-detail',
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
                    $("#rd_serial_number").prop("readonly", true);
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
                editData: {
                    sm_id: function () {
                        var selRowId = $("#grid-table").jqGrid('getGridParam', 'selrow');
                        var sm_id = $("#grid-table").jqGrid('getCell', selRowId, 'sm_id');

                        return sm_id;
                    }
                },
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

                    //$("#rd_serial_number").prop("readonly", true);
                },
                afterShowForm: function (form) {
                    form.closest('.ui-jqdialog').center();
                },
                /* beforeSubmit: function(postdata){
                 //postdata.something = 'somevalue';
                 if($('#temp_qty_available').val() < postdata.sortir_qty){
                 msg_txt = 'Please Insert Quantity no more than Available Quantity ('+$('#temp_qty_available').val()+' Kg)';
                 swal({title: "Warning!", text: msg_txt, html: true, type: "error"});
                 }
                 }, */
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