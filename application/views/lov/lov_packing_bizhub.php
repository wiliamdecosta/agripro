<div id="modal_lov_packing_bizhub" class="modal fade" tabindex="-1" style="overflow-y: scroll;">
    <div class="modal-dialog" style="width:700px;">
        <div class="modal-content">
            <!-- modal title -->
            <div class="modal-header no-padding">
                <div class="table-header">
                    <span class="form-add-edit-title"> Data Packing</span>
                </div>
            </div>
            <input type="hidden" id="modal_lov_packing_bizhub_id_val" value="" />
            <input type="hidden" id="modal_lov_packing_bizhub_code_val" value="" />
            <input type="hidden" id="modal_lov_product_code_val" value="" />

            <!-- modal body -->
            <div class="modal-body">
                <div>
                  <button type="button" class="btn btn-sm btn-success" id="modal_lov_packing_bizhub_btn_blank">
                    <span class="fa fa-pencil-square-o" aria-hidden="true"></span> BLANK
                  </button>
                </div>
                <table id="modal_lov_packing_bizhub_grid_selection" class="table table-striped table-bordered table-hover">
                <thead>
                  <tr>
                     <th data-column-id="packing_bizhub_id" data-sortable="false" data-visible="false">ID Packing</th>
                     <th data-header-align="center" data-align="center" data-formatter="opt-edit" data-sortable="false" data-width="100">Options</th>
                     <th data-column-id="packing_bizhub_batch_number" data-width="270">Serial Number</th>
                     <th data-column-id="product_code">Product Code</th>
                     <th data-column-id="packing_kg">Weight(Kg)</th>
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
        $("#modal_lov_packing_bizhub_btn_blank").on('click', function() {
            $("#"+ $("#modal_lov_packing_bizhub_id_val").val()).val("");
            $("#"+ $("#modal_lov_packing_bizhub_code_val").val()).val("");
            $("#"+ $("#modal_lov_product_code_val").val()).val("");
            $("#modal_lov_packing_bizhub").modal("toggle");
        });
    });

    function modal_lov_packing_bizhub_show(the_id_field, the_code_field, product_code) {
        modal_lov_packing_bizhub_set_field_value(the_id_field, the_code_field, product_code);
        $("#modal_lov_packing_bizhub").modal({backdrop: 'static'});
        modal_lov_packing_bizhub_prepare_table();
    }


    function modal_lov_packing_bizhub_set_field_value(the_id_field, the_code_field, product_code) {
         $("#modal_lov_packing_bizhub_id_val").val(the_id_field);
         $("#modal_lov_packing_bizhub_code_val").val(the_code_field);
         $("#modal_lov_product_code_val").val(product_code);
    }

    function modal_lov_packing_bizhub_set_value(the_id_val, the_code_val, product_code) {
         $("#"+ $("#modal_lov_packing_bizhub_id_val").val()).val(the_id_val);
         $("#"+ $("#modal_lov_packing_bizhub_code_val").val()).val(the_code_val);
         $("#"+ $("#modal_lov_product_code_val").val()).val(product_code);
         $("#modal_lov_packing_bizhub").modal("toggle");

         $("#"+ $("#modal_lov_packing_bizhub_id_val").val()).change();
         $("#"+ $("#modal_lov_packing_bizhub_code_val").val()).change();
    }

    function modal_lov_packing_bizhub_prepare_table() {
        $("#modal_lov_packing_bizhub_grid_selection").bootgrid({
             formatters: {
                "opt-edit" : function(col, row) {
                    return '<a href="javascript:;" title="Set Value" onclick="modal_lov_packing_bizhub_set_value(\''+ row.packing_bizhub_id +'\', \''+ row.packing_bizhub_batch_number +'\', \''+ row.product_code +'\')" class="blue"><i class="fa fa-pencil-square-o bigger-130"></i></a>';
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
             url: '<?php echo WS_BOOTGRID."agripro.packing_bizhub_controller/readLov"; ?>',
             selection: true,
             sorting:true
        });

        $('.bootgrid-header span.glyphicon-search').removeClass('glyphicon-search')
        .html('<i class="fa fa-search"></i>');
    }

</script>