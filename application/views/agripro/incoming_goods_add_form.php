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
            <span>Incoming Goods Form</span>
        </li>
    </ul>
</div>

<div class="space-4"></div>
<div class="row">
    <div class="col-md-12">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">Add Data Incoming Goods</div>
            </div>

            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form method="post" action="" class="form-horizontal" id="form-shipping">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <div class="form-body">

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="shipping_date">Date</label>
                            <div class="col-md-2">
                                <input type="text" name="incoming_date" id="incoming_date" value="<?php echo @$this->input->post('in_biz_date'); ?>" <?php echo $this->input->post('in_biz_date') ? 'disabled' : ''; ?> class="form-control required">
                                <input type="hidden" name="in_biz_id" id="in_biz_id" value="<?php echo @$this->input->post('in_biz_id'); ?>"  class="form-control required">
                            </div>
                        </div>
						
						<div class="form-group">
                            <label class="col-md-3 control-label" for="packing_product_id">Shipping Date</label>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <input type="hidden" name="shipping_id" id="shipping_id" value="<?php echo @$this->input->post('shipping_id'); ?>" class="form-control">
                                    <input type="text" name="shipping_date" id="shipping_date" value="<?php echo @$this->input->post('shipping_date'); ?>" readonly="" class="form-control required" placeholder="Choose Shipping">
                                    <span class="input-group-btn">
                                        <button class="btn btn-success" type="button" onclick="showLovShipping('shipping_id','shipping_date','shipping_driver_name','shipping_notes')" <?php echo $this->input->post('in_biz_date') ? 'disabled' : ''; ?>>
                                            <span class="fa fa-search icon-on-right bigger-110"></span>
                                        </button>
                                    </span>
                                </div>
                            </div>
							
                        </div>
						
						 <div class="form-group">
                            <label class="col-md-3 control-label" for="shipping_driver_name">Driver Name </label>
                            <div class="col-md-3">
                                <input type="text" name="shipping_driver_name" id="shipping_driver_name" value="<?php echo @$this->input->post('shipping_driver_name'); ?>" class="form-control" readonly>
                            </div>
                        </div>
						
						<div class="form-group">
                            <label class="col-md-3 control-label" for="shipping_notes">Shipping Notes:</label>
                            <div class="col-md-6">
                                <textarea name="shipping_notes" id="shipping_notes" readonly class="form-control"><?php echo @$this->input->post('shipping_notes'); ?></textarea>
                            </div>
                        </div>
						
						<!--<div class="form-group">
                            <label class="col-md-3 control-label" for="shipping_notes">Notes:</label>
                            <div class="col-md-6">
                                <textarea name="notes" id="notes" class="form-control"></textarea>
                            </div>
                        </div> -->
						
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="shipping_driver_name">Warehouse </label>
                            <div class="col-md-3">
                                <input type="hidden" name="wh" id="wh" class="form-control" readonly value="<?php echo $this->session->userdata('wh_id'); ?>">
                                <input type="text" name="wh_name" id="wh_name" class="form-control" readonly value="<?php echo $this->input->post('wh_shipping_name'); ?>">
                            </div>
                        </div>
						
						<div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" id="submit_form" name="submit" class="btn btn-success"  <?php echo $this->input->post('in_biz_date') ? 'disabled' : ''; ?>> <i class="fa fa-save"></i> Save </button>
								 <button style="display:none;"type="button" id="del_form" name="delete" class="btn btn-danger"  <?php echo $this->input->post('in_biz_date') ? 'disabled' : ''; ?>> <i class="fa fa-trash"></i> Delete </button>
                            </div>
						
                        </div>
                        
						<hr>
                        <div class="row">
                            <div class="col-md-offset-1 col-md-10">
                                <h3>Details</h3>

                                <table class="table table-bordered" id="tbl-packing-box">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Packing Label</th>
                                            <th>Product Name</th>
											<th>Status</th>
                                            <th>Qty (Kg)</th>
                                            <th>New Qty (Kg)</th>
                                            <th>Depreciation (Kg)</th>
                                        </tr>
                                    </thead>
                                    <tbody id='btabdet'>

                                    </tbody>
                                </table>
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

<?php $this->load->view('lov/lov_shipping.php'); ?>

<script>
    function showLovShipping(id_1, id_2, id_3, id_4) {
        modal_lov_shipping_show(id_1, id_2, id_3, id_4);

    }
</script>


<script>
	function edit_mode(in_biz_id){
		if(in_biz_id){
			
			$.ajax({
				type: "POST",
				url: '<?php echo WS_JQGRID."agripro.incoming_goods_controller/read"; ?>',
				dataType : 'json',
				data: {in_biz_id:in_biz_id},
				success: function(response) {

					if(response.success != true){
						swal('Warning',response.message,'warning');
					}else{
						get_shipping_detail(shipping_id);
					}

				}
			});
			
		}
	}
	
	function show_form(id){
		
		$('#formQty'+id).css('display','block');
		$('#spanQty'+id).css('display','none');
		
	}
	
	function save_new_qty(in_biz_det_id, in_biz_id, packing_id){
	new_qty = $('#newqty'+packing_id).val();
	if(new_qty < 1){
		
		//alert(new_qty);
		
	}else{
		
		set_val_det(in_biz_det_id, in_biz_id, packing_id, col='qty_rescale', val=new_qty);
		$('#formQty'+packing_id).css('display','none');
		$('#spanQty'+packing_id).css('display','block');
		$('#spanNQty'+packing_id).html(new_qty);
		
	}
	 /*  var url = '<?php echo WS_JQGRID."agripro.incoming_goods_controller/createForm"; ?>';
		$.ajax({
			type: "POST",
			url: url,
			dataType : 'json',
			data: $("#form-shipping").serialize(),
			success: function(response) {

				if(response.success != true){
					swal('Warning',response.message,'warning');
				}else{
					//loadContentWithParams('agripro.incoming_goods',{});
					get_shipping_detail($('#shipping_id').val());
					$('#submit_form').prop('disabled','disabled');
				}

			}
		}); */
		
		
		
	}

    function insertDataRow() {

        var jumlah_baris = document.getElementById('tbl-packing-box').rows.length;

        var packing_id = document.getElementById('box_packing_id').value;
        var packing_batch_number = document.getElementById('box_packing_batch_number').value;
        var product_code = document.getElementById('box_product_code').value;

        var tr = document.getElementById('tbl-packing-box').insertRow(jumlah_baris);
        var tdNo = tr.insertCell(0);
        var tdSerialNumber = tr.insertCell(1);
        var tdProduct = tr.insertCell(2);
        var tdAction = tr.insertCell(3);

        tdNo.innerHTML = jumlah_baris;
        tdSerialNumber.innerHTML = '<input type="hidden" name="packing_id[]" value="'+ packing_id +'">'+ packing_batch_number;
        tdProduct.innerHTML = product_code;
        tdAction.innerHTML = '<button type="button" onclick="deleteDataRow(this);"><i class="fa fa-trash"></i> Delete </button>';

        document.getElementById('box_packing_id').value = "";
        document.getElementById('box_packing_batch_number').value = "";
        document.getElementById('box_product_code').value = "";
    }

    function deleteDataRow(sender) {
        $(sender).parent().parent().remove();
    }
	
	function get_shipping_detail(shipping_id){
		
		$.ajax({
                    type: "POST",
                    url: '<?php echo WS_JQGRID."agripro.incoming_goods_controller/get_detail_incoming"; ?>',
                    //dataType : 'json',
                    data: {shipping_id:shipping_id},
                    success: function(response) {

							$('#btabdet').html('');
							$('#btabdet').html(response);
							

                    }
                });
		
	}
	
	function is_edit_mode(id){
		
		return true;
	}
	
	function set_status_goods(in_biz_det_id, in_biz_id, pkg_id, val){
		id = 'pkgid'+pkg_id;
		if(val == 'L'){
			addtext = 'To Lost And The Quantity Will be set to 0 ';
			id_change = 'LOSTstatus'+pkg_id;
		}else{
			addtext = 'To Ok And You Have To Set New Quantity';
			id_change = 'OKstatus'+pkg_id;
		}
		
		if(is_edit_mode(id)){
			
			swal({
			  title: "Are you sure ?",
			  text: "This Action Will Change Goods Status "+addtext,
			  type: "warning",
			  showCancelButton: true,
			  //confirmButtonColor: "#DD6B55",
			  confirmButtonText: "Yes",
			  closeOnConfirm: false
			},
			function(){
			  set_val_det(in_biz_det_id, in_biz_id, pkg_id, col='in_biz_det_status', val);
			  
				if(val == 'L'){
					$('#LOSTstatus'+pkg_id).css('display','block');
					$('#OKstatus'+pkg_id).css('display','none');
					$('#spanNQty'+pkg_id).html(0);
					$('#spanEditQty'+pkg_id).css('visibility','hidden');
					console.log('aaaa');
				}else{
					$('#OKstatus'+pkg_id).css('display','block');
					$('#LOSTstatus'+pkg_id).css('display','none');
					$('#spanEditQty'+pkg_id).css('visibility','visible');
					console.log('aaaa');
				}
			});
			
		}else{
			 swal('Warning',response.message,'warning');
			
		}
		
	}
	
	function set_depresiation(id_val, id_dep, qty_old){
		var a = 0;
		var b = 0;
		
		var b = Number($('#'+id_val).val());
		var a = Number(qty_old) - b;
		
		if(b < qty_old){
			html = '<span style="color:red;"><b>-'+a+'</b></span>';
		}else if(b>qty_old){
			html = '<span style="color:green;"><b>+'+a+'</b></span>';
		}else{
			html = '<span style="color:green;"><b>'+a+'</b></span>';
		}
		//console.log(qty_old+'|'+b);
		/* if(b < qty_old){
			html = '<span style="color:red;"><b>'+a+'</b></span>';
		}else{
			html = '<span style="color:green;"><b>'+a+'</b></span>';
		} */
		$('#'+id_dep).val('');
		$('#'+id_dep).html(html);
		
	}
	
	function transition(id, mode){
		
	}
	
	//function set_val_det(in_biz_id, in_biz_det_id, col, val, pkg_id){
	function set_val_det(in_biz_det_id, in_biz_id, pkg_id, col, val){
		
		$.ajax({
                    type: "POST",
                    url: '<?php echo WS_JQGRID."agripro.incoming_goods_controller/update_detail"; ?>',
                    dataType : 'json',
                    data: {col:col, val:val, pkg_id:pkg_id, in_biz_det_id:in_biz_det_id,in_biz_id:in_biz_id },
                    success: function(response) {
						
						if(response.success != true){
                            swal('Warning',response.message,'warning');
                        }else{
							swal.close();
                        }


                    }
                });
		
	}
	function get_wh_name(whid){
		
		$.ajax({
                    type: "POST",
                    url: '<?php echo WS_JQGRID."agripro.incoming_goods_controller/getwhname"; ?>',
                    dataType : 'json',
                    data: {whid:whid},
                    success: function(response) {
						
						if(response.success != true){
                            swal('Warning',response.message,'warning');
                        }else{
							$('#wh_name').val(response.wh_name);
                        }


                    }
                });
		
	}
	
</script>

<script>
	$(document).ready(function(){
		var a = '<?php echo $this->input->post('in_biz_id'); ?>';
		if(a){
			shipping_id = '<?php echo $this->input->post('shipping_id'); ?>'
			get_shipping_detail(shipping_id);
		}
		
	});

    $(function() {
        $("#incoming_date").datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
            orientation: 'bottom',
            todayHighlight: true
        });

        $("#btn-back").on('click', function(e) {
            loadContentWithParams('agripro.incoming_goods',{});
        });


        $("#btn-add-box").on('click', function(e) {
            var packing_id = $('#box_packing_id').val();

            if(packing_id == "") {
                swal('Information','Please choose the packing box','info');
                return;
            }

            var packing_ids = $('[name="packing_id[]"]');
            if(packing_ids.length > 0) {
                var error = false;
                $('[name="packing_id[]"]').each(function(index) {
                    if(packing_id == $(this).val()) {
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
                var url = '<?php echo WS_JQGRID."agripro.incoming_goods_controller/createForm"; ?>';
                $.ajax({
                    type: "POST",
                    url: url,
                    dataType : 'json',
                    data: $("#form-shipping").serialize(),
                    success: function(response) {

                        if(response.success != true){
                            swal('Warning',response.message,'warning');
                        }else{
                            //loadContentWithParams('agripro.incoming_goods',{});
							get_shipping_detail($('#shipping_id').val());
							$('#submit_form').prop('disabled','disabled');
                        }

                    }
                });
            }
        });
    });
</script>