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
            <span>Selection</span>
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
	
	<!-- <div class="col-md-4">
		<div class="input-group">
			<div class="input-icon">
				<i class="fa fa-calendar-plus-o fa-fw"></i>
			<input id="tgl_produksi" class="form-control" type="text" name="tgl_produksi" placeholder="Production Date" readonly /> </div>
			<span class="input-group-btn">
				<button class="btn btn-success" type="button" id="save_tgl_prod">
				<i class="fa fa-save fa-fw" /></i> Save</button>
		</span>
	</div>
</div> -->
	<div class="col-md-8">
			<div class="caption">
				<i class="glyphicon glyphicon-circle-arrow-right font-green"></i>
				<span class="caption-subject font-green bold uppercase" id="info_qty">Sorting Qty 0 (Kg)</span>
			</div>
			<div class="caption">
				<i class="glyphicon glyphicon-circle-arrow-right font-blue"></i>
				<span class="caption-subject font-blue bold uppercase" id="net_qty">Production Quantity : 0 (Kg)</span>
			</div>
			<div class="caption">
				<i class="glyphicon glyphicon-circle-arrow-right font-red"></i>
				<span class="caption-subject font-red bold uppercase" id="info_avaqty">Available Quantity : 0 (Kg)</span>
			</div>
	</div>
	
</div>
</div>
<input type="hidden" id="temp_production_id">
<input type="hidden" id="temp_sortir_id">
<input type="hidden" id="temp_qty_available">
<input type="hidden" id="temp_product_id">
<input type="hidden" id="temp_rowid">
<div class="row" id="detail_placeholder" >
    <div class="col-xs-12">
        <table id="grid-table-detail"></table>
        <div id="grid-pager-detail"></div>
    </div>
</div>


<?php $this->load->view('lov/lov_production.php'); ?>

<script>


    function showLovproduction(id, code, id2, code2) {
        modal_lov_production_show(id, code,id2, code2 );
    }

    function clearLovproduction() {
        $('#form_production_id').val('');
        $('#form_production_code').val('');
    }

	function show_detail_grid(rowid){
		
		get_availableqty();
		
		$("#temp_rowid").val(rowid);
		
		var celValue = $('#grid-table').jqGrid('getCell', rowid, 'production_id');
		var celCode = $('#grid-table').jqGrid('getCell', rowid, 'production_code');
		var prod_date_1 = $('#grid-table').jqGrid('getCell', rowid, 'sm_tgl_produksi');
		
		$("#temp_production_id").val(celValue);
		
		if( $("#tgl_produksi").val().length > 0 ){
				
			$('#header_sortir').show();
			
			var grid_detail = jQuery("#grid-table-detail");
			if (rowid != null) {
				grid_detail.jqGrid('setGridParam', {
					url: '<?php echo WS_JQGRID . "agripro.sortir_production_controller/crud"; ?>',
					postData: {production_id: celValue}
				});
				var strCaption = 'Detail :: ' + celCode;
				$("#temp_production_id").val(celValue);
				grid_detail.jqGrid('setCaption', strCaption);
				$("#grid-table-detail").trigger("reloadGrid");
				$("#detail_placeholder").show();
				// get quantity
				get_availableqty();
				
				responsive_jqgrid('#grid-table-detail', '#grid-pager-detail');
			}
			console.log('masuk 1');
		}else{
			$('#header_sortir').show();
			console.log('masuk 2');
		}
		
		
			
	}
	
    function get_availableqty() {
		
			$('#temp_qty_available').val(0);
			production_id = $('#temp_production_id').val();
			sortir_id = $('#temp_sortir_id').val();
			$.ajax({
				url: "<?php echo WS_JQGRID . 'agripro.sortir_production_controller/get_availableqty_detail_prd'; ?>",
				type: "POST",
				dataType: 'json',
				data: {production_id: production_id, sortir_id:sortir_id},
				success: function (data) {
					
					$('#tgl_produksi').val(data.tgl_prod);
					$('#temp_qty_available').val(data.avaqty);
					$('#info_avaqty').html('Available Quantity : '+data.avaqty +' (Kg)');
					$('#info_qty').html('Sorting Quantity : ' + data.srqty +' (Kg)');
					$('#net_qty').html('Production Quantity : ' + data.qty_bersih +' (Kg)');
					
					if(data.tgl_prod.length > 0){
						$('#header_sortir').show();
						$("#detail_placeholder").show();
					}else{
						$('#header_sortir').show();
						//$("#detail_placeholder").hide();
					}
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
    function get_production_id() {
        return $('#temp_production_id').val();
    }
    
    function reset_detail(){
        
        
        
        }
    
		$(document).ready(function(){
		
		$('#header_sortir').hide();
		$('#detail_placeholder').hide();
		
		$('#tgl_produksi').datepicker({
			autoclose: true,
			format: 'yyyy-mm-dd',
			orientation: 'down',
			todayHighlight: true
		});
		
			
	})


    jQuery(function ($) {
        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID . "agripro.sortir_production_controller/crud"; ?>',
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'ID', name: 'sortir_id', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'Production Code', name: 'production_code', width: 350, align: "left", editable: false, editoptions: { size: 25}},
                {
                    label: 'Production Code',
                    name: 'production_id',
                    width: 150,
                    sortable: true,
                    editable: true,
                    hidden: true,
                    editrules: {edithidden: true, number: true, required: true},
                    edittype: 'custom',
                    editoptions: {
                        "custom_element": function (value, options) {
                            var elm = $('<span></span>');

                            // give the editor time to initialize
                            setTimeout(function () {
                                elm.append('<input id="form_production_id" type="text"  style="display:none;">' +
                                    '<input size="30" id="form_production_code" disabled type="text" class="FormElement jqgrid-required" placeholder="Production Code">' +
                                    '<button class="btn btn-success" id=lov_btn_prod"" type="button" onclick="showLovproduction(\'form_production_id\',\'form_production_code\', \'form_prod_id\', \'form_prod_name\')">' +
                                    '   <span class="fa fa-search icon-on-right bigger-110"></span>' +
                                    '</button>');
                                $("#form_production_id").val(value);
                                elm.parent().removeClass('jqgrid-required');
                            }, 100);

                            return elm;
                        },
                        "custom_value": function (element, oper, gridval) {

                            if (oper === 'get') {
                                return $("#form_production_id").val();
                            } else if (oper === 'set') {
                                $("#form_production_id").val(gridval);
                                var gridId = this.id;
                                // give the editor time to set display
                                setTimeout(function () {
                                    var selectedRowId = $("#" + gridId).jqGrid('getGridParam', 'selrow');
                                    if (selectedRowId != null) {
                                        var code_display = $("#" + gridId).jqGrid('getCell', selectedRowId, 'production_code');
                                        $("#form_production_code").val(code_display);
                                    }
                                }, 100);
                            }
                        }, size: 25
                    }
                },
                {
                    label: 'Product Name',
                    name: 'product_id',
                    width: 150,
                    sortable: true,
                    editable: true,
                    hidden: true,
                    editrules: {edithidden: true, number: true, required: true},
                    edittype: 'custom',
                    editoptions: {
                        "custom_element": function (value, options) {
                            var elm = $('<span></span>');

                            // give the editor time to initialize
                            setTimeout(function () {
                                elm.append('<input id="form_prod_id" type="text"  style="display:none;">' +
                                    '<input size="30" id="form_prod_name" disabled type="text" class="FormElement jqgrid-required" placeholder="Product Name">');
                                $("#form_prod_id").val(value);
                                elm.parent().removeClass('jqgrid-required');
                            }, 100);

                            return elm;
                        },
                        "custom_value": function (element, oper, gridval) {

                            if (oper === 'get') {
                                return $("#form_prod_id").val();
                            } else if (oper === 'set') {
                                $("#form_prod_id").val(gridval);
                                var gridId = this.id;
                                // give the editor time to set display
                                setTimeout(function () {
                                    var selectedRowId = $("#" + gridId).jqGrid('getGridParam', 'selrow');
                                    if (selectedRowId != null) {
                                        var code_display = $("#" + gridId).jqGrid('getCell', selectedRowId, 'product_code');
                                        //$("#form_prod_name").val(code_display);
                                        $("#form_prod_name").val('');
                                    }else{
										$("#form_prod_name").val('');
									}
                                }, 100);
                            }
                        }, size: 25
                    }
                },
                {label: 'Product Name', name: 'product_code', width: 170, align: "left", editable: false},
                 {
                    label: 'Quantity (Kg)',
                    name: 'sortir_qty',
                    width: 150,
                    sortable: true,
                    editable: true,
                    hidden: true,
                    editrules: {edithidden: true, number: true, required: true},
                    edittype: 'custom',
                    editoptions: {
                        "custom_element": function (value, options) {
                            var elm = $('<span></span>');

                            // give the editor time to initialize
                            setTimeout(function () {
                                elm.append('<input id="form_qty_id" type="text"  style="display:none;">' +
                                    '<input size="30" id="form_qty_name" readonly type="text" class="FormElement jqgrid-required" placeholder="Quantity">');
                                $("#form_qty_id").val(value);
                                elm.parent().removeClass('jqgrid-required');
                            }, 100);

                            return elm;
                        },
                        "custom_value": function (element, oper, gridval) {

                            if (oper === 'get') {
                                return $("#form_qty_id").val();
                            } else if (oper === 'set') {
                                $("#form_qty_id").val(gridval);
                                var gridId = this.id;
                                // give the editor time to set display
                                setTimeout(function () {
                                    var selectedRowId = $("#" + gridId).jqGrid('getGridParam', 'selrow');
                                    if (selectedRowId != null) {
                                        var code_display = $("#" + gridId).jqGrid('getCell', selectedRowId, 'production_qty');
                                        //$("#form_qty_name").val(code_display);
                                        $("#form_qty_name").val('');
                                    }else{
										$("#form_qty_name").val('');
									}
                                }, 100);
                            }
                        }, size: 25
                    }
                },
                {label: 'Quantity (Kg)', name: 'sortir_qty', width: 170, align: "left", editable: false},
                {
                    label: 'Selection Date', name: 'sortir_tgl', width: 120, editable: true,
                    edittype: "text",
                    editrules: {required: true},
                    editoptions: {
                        // dataInit is the client-side event that fires upon initializing the toolbar search field for a column
                        // use it to place a third party control to customize the toolbar
                       dataInit: function (element) {
							setTimeout(function(){
                            $(element).datepicker({
                                autoclose: true,
                                format: 'yyyy-mm-dd',
                                orientation: 'up',
                                todayHighlight: true
                            });
                        },10)},
                        size: 30
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
				
                //show_detail_grid(rowid);
				
				var celValue = $('#grid-table').jqGrid('getCell', rowid, 'sortir_id');
				var product_id = $('#grid-table').jqGrid('getCell', rowid, 'product_id');
				var production_id = $('#grid-table').jqGrid('getCell', rowid, 'production_id');
				var celCode = $('#grid-table').jqGrid('getCell', rowid, 'production_code');
				var prod_date_1 = $('#grid-table').jqGrid('getCell', rowid, 'sm_tgl_produksi');

				$("#temp_product_id").val(product_id);
				$("#temp_production_id").val(production_id);
				$("#temp_sortir_id").val(celValue);
				
					var grid_detail = jQuery("#grid-table-detail");
					if (rowid != null) {
						grid_detail.jqGrid('setGridParam', {
							url: '<?php echo WS_JQGRID . "agripro.sortir_detail_controller/crud"; ?>',
							postData: {sortir_id: celValue}
						});
						var strCaption = 'Detail :: ' + celCode;
						grid_detail.jqGrid('setCaption', strCaption);
						$("#grid-table-detail").trigger("reloadGrid");
						$("#detail_placeholder").show();
						// get quantity
						get_availableqty();
						
					}
                    
				responsive_jqgrid('#grid-table-detail', '#grid-pager-detail');
				

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
                get_availableqty();
				// reset 
				$('#temp_qty_available').val(0);
				$('#info_avaqty').html('Available Quantity : 0 (Kg)');
				$('#info_qty').html('Sorting Quantity : 0 (Kg)');
				$('#net_qty').html('Production Quantity : 0 (Kg)');
            },
            //memanggil controller jqgrid yang ada di controller crud
            editurl: '<?php echo WS_JQGRID . "agripro.sortir_production_controller/crud"; ?>',
            caption: "Stick Selection"

        });

        jQuery('#grid-table').jqGrid('navGrid', '#grid-pager',
            {   //navbar options
                edit: false,
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
                    //jQuery("#detail_placeholder").hide();
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
                width: '500',
                errorTextFormat: function (data) {
                    return 'Error: ' + data.responseText
                },
                beforeShowForm: function (e, form) {
                    var form = $(e[0]);
                    style_edit_form(form);
                    $("#production_code").prop("readonly", true);
                    clearLovproduction();
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
                width: '500',
                errorTextFormat: function (data) {
                    return 'Error: ' + data.responseText
                },
                serializeEditData: serializeJSON,
                viewPagerButtons: false,
                beforeShowForm: function (e, form) {
                    var form = $(e[0]);
                    style_edit_form(form);
					$('#form_qty_name').focus();
					console.log('haha');
                    /*form.css({"height": 0.70 * screen.height + "px"});
                     form.css({"width": 0.60 * screen.width + "px"});*/

                    $("#production_code").prop("readonly", true);
                    setTimeout(function () {
                        clearLovproduction();
                    }, 100);
                },
                afterShowForm: function (form) {
                    form.closest('.ui-jqdialog').center();
					$('#form_qty_name').focus();
					console.log('haha2');
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
                {label: 'ID', key: true, name: 'sortir_detail_id', width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'ID', key: false, name: 'sortir_id', width: 5, sorttype: 'number', editable: true, hidden: true},
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
                        dataUrl: '<?php echo WS_JQGRID . "agripro.sortir_production_controller/list_product"; ?>',
                        postData: {
                            product_id: function () {
                                return $('#temp_product_id').val()
                            }, sortir_id: function () {
                                return $('#temp_sortir_id').val()
                            }
                        },
                        dataInit: function (elem) {
                            $(elem).width(240);  // set the width which you need
                        }
                    }
                },
                {
                    label: 'Quantity(Kg)',
                    name: 'sortir_detail_qty',
                    index: 'sortir_detail_qty',
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
                $('#temp_qty_available').val(0);
				$('#info_avaqty').html('Available Quantity : 0 (Kg)');
				$('#info_qty').html('Sorting Quantity : 0 (Kg)');
				$('#net_qty').html('Production Quantity : 0 (Kg)');
            },
            //memanggil controller jqgrid yang ada di controller crud
            editurl: '<?php echo WS_JQGRID . "agripro.sortir_detail_controller/crud"; ?>',
            caption: "Sorting Raw Material Detail"

        });

        jQuery('#grid-table-detail').jqGrid('navGrid', '#grid-pager-detail',
            {   //navbar options
                edit: false,
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
            
            // new record 
            {
                editData: {
                    sortir_id: function () {
                        var selRowId = $("#grid-table").jqGrid('getGridParam', 'selrow');
                        var sortir_id = $("#grid-table").jqGrid('getCell', selRowId, 'sortir_id');

                        return sortir_id;
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
                 if($('#temp_qty_available').val() < postdata.production_qty){
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