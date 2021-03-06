<div id="modal_lov_shipping" class="modal fade" tabindex="-1" style="overflow-y: scroll;">
    <div class="modal-dialog" style="width:1000px;">
        <div class="modal-content">
            <!-- modal title -->
            <div class="modal-header no-padding">
                <div class="table-header">
                    <span class="form-add-edit-title"> Shipping Data</span>
                </div>
            </div>
            <input type="hidden" id="modal_lov_shipping_id_val" value="" />
            <input type="hidden" id="modal_lov_shipping_date_val" value="" />
            <input type="hidden" id="modal_lov_shipping_driver_name_val" value="" />
            <input type="hidden" id="modal_lov_shipping_notes_val" value="" />

            <!-- modal body -->
            <div class="modal-body">
                <div>
                  <button type="button" class="btn btn-sm btn-success" id="modal_lov_shipping_btn_blank">
                    <span class="fa fa-pencil-square-o" aria-hidden="true"></span> BLANK
                  </button>
                </div>
                <table id="modal_lov_shipping_grid_selection" class="table table-striped table-bordered table-hover">
                <thead>
                  <tr>
                     <th data-column-id="shipping_id" data-sortable="false" data-visible="false">ID Produk</th>
                     <th data-header-align="center" data-align="center" data-formatter="opt-edit" data-sortable="false" data-width="100">Options</th>
                     <th data-column-id="shipping_date" data-width="300">Shipping Date</th>
                     <th data-column-id="shipping_driver_name">Driver Name</th>
                     <!-- <th data-column-id="product_code">Weight (Kg)</th> -->
                     <th data-column-id="shipping_notes">Notes</th>
                     <th data-column-id="wh_name">Warehouse </th>
                  </tr>
                </thead>
                </table>
            </div>

            <!-- modal footer -->
            <div class="modal-footer no-margin-top">
                <div class="bootstrap-dialog-footer">
                    <div class="bootstrap-dialog-footer-buttons">
                        <button class="btn btn-danger btn-xs radius-4" data-dismiss="modal">
                            <i class="fa fa-times"></i>
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.end modal -->

<script>

    jQuery(function($) {
        $("#modal_lov_shipping_btn_blank").on('click', function() {
            $("#"+ $("#modal_lov_shipping_id_val").val()).val("");
            $("#"+ $("#modal_lov_shipping_date_val").val()).val("");
            $("#"+ $("#modal_lov_shipping_driver_name_val").val()).val("");
            $("#"+ $("#modal_lov_shipping_notes_val").val()).val("");
            //$("#form_qty_id").val("");
            //$("#form_qty_name").val("");
            $("#modal_lov_shipping").modal("toggle");
        });
    });

    function modal_lov_shipping_show(the_id_field, the_code_field, the_id_field2, the_code_field2) {
        modal_lov_shipping_set_field_value(the_id_field, the_code_field, the_id_field2, the_code_field2);
        $("#modal_lov_shipping").modal({backdrop: 'static'});
        modal_lov_shipping_prepare_table();
    }


    function modal_lov_shipping_set_field_value(the_id_field, the_code_field, the_id_field2, the_code_field2, qty) {
         $("#modal_lov_shipping_id_val").val(the_id_field);
         $("#modal_lov_shipping_date_val").val(the_id_field2);
         $("#modal_lov_shipping_driver_name_val").val(the_code_field);
         $("#modal_lov_shipping_notes_val").val(the_code_field2);
         //$("#form_qty_name").val(qty);
         //$("#form_qty_id").val(qty);
    }

    function modal_lov_shipping_set_value(the_id_val, the_code_val, the_id_val2, the_code_val2,wh_name ) {
        
         $("#"+ $("#modal_lov_shipping_id_val").val()).val(the_id_val);
         $("#"+ $("#modal_lov_shipping_date_val").val()).val(the_id_val2);
         $("#"+ $("#modal_lov_shipping_driver_name_val").val()).val(the_code_val);
         $("#"+ $("#modal_lov_shipping_notes_val").val()).val(the_code_val2);
         $("#wh_name").val(wh_name);
         //$("#form_qty_name").val(qty);
         //$("#form_qty_id").val(qty);
         $("#modal_lov_shipping").modal("toggle");
       
    }

    function modal_lov_shipping_prepare_table() {
        $("#modal_lov_shipping_grid_selection").bootgrid({
             formatters: {
                "opt-edit" : function(col, row) {
                    return '<a href="javascript:;" title="Set Value" onclick="modal_lov_shipping_set_value(\''+ row.shipping_id +'\', \''+ row.shipping_date +'\', \''+ row.shipping_driver_name +'\', \''+ row.shipping_notes +'\', \''+ row.wh_name +'\')" class="blue"><i class="fa fa-pencil-square-o bigger-130"></i></a>';
                }
             },
             rowCount:[5,10],
             ajax: true,
             requestHandler:function(request) {
                if(request.sort) {
                    var sortby = Object.keys(request.sort)[0];
                    request.dir = request.sort[sortby];

                    delete request.sort;
                    request.sort = sortby;
                }
                return request;
             },
             responseHandler:function (response) {
                if(response.success == false) {
                    swal({title: 'Attention', text: response.message, html: true, type: "warning"});
                }
                return response;
             },
             url: '<?php echo WS_BOOTGRID."agripro.incoming_goods_controller/readLov_shipping"; ?>',
             selection: true,
             sorting:true
        });

        $('.bootgrid-header span.glyphicon-search').removeClass('glyphicon-search')
        .html('<i class="fa fa-search"></i>');
    }

</script>