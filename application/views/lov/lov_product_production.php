<div id="modal_lov_product" class="modal fade" tabindex="-1" style="overflow-y: scroll;">
    <div class="modal-dialog" style="width:700px;">
        <div class="modal-content">
            <!-- modal title -->
            <div class="modal-header no-padding">
                <div class="table-header">
                    <span class="form-add-edit-title">Product List</span>
                </div>
            </div>
            <input type="hidden" id="modal_lov_product_id_val" value=""/>
            <input type="hidden" id="modal_lov_product_code_val" value=""/>
            <input type="hidden" id="modal_lov_parent_id_val" value=""/>

            <!-- modal body -->
            <div class="modal-body">
                <div>
                    <button type="button" class="btn btn-sm btn-success" id="modal_lov_product_btn_blank">
                        <span class="fa fa-pencil-square-o" aria-hidden="true"></span> BLANK
                    </button>
                </div>
                <table id="modal_lov_product_grid_selection" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th data-column-id="product_id" data-sortable="false" data-visible="false">ID Produk</th>
                        <th data-header-align="center" data-align="center" data-formatter="opt-edit"
                            data-sortable="false" data-width="100">Options
                        </th>
                        <th data-column-id="product_code">Code</th>
                        <th data-column-id="product_name">Name</th>
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

    jQuery(function ($) {
        $("#modal_lov_product_btn_blank").on('click', function () {
            $("#" + $("#modal_lov_product_id_val").val()).val("");
            $("#" + $("#modal_lov_product_code_val").val()).val("");
            $("#" + $("#modal_lov_parent_id_val").val()).val("");
            $("#modal_lov_product").modal("toggle");
        });
    });

    function modal_lov_product_show(the_id_field, the_code_field, parent_id, p_cat) {
        modal_lov_product_set_field_value(the_id_field, the_code_field, parent_id);
        $("#modal_lov_product").modal({backdrop: 'static'});
        modal_lov_product_prepare_table(p_cat);
    }

    function modal_lov_product_set_field_value(the_id_field, the_code_field, parent_id) {
        $("#modal_lov_product_id_val").val(the_id_field);
        $("#modal_lov_product_code_val").val(the_code_field);
        $("#modal_lov_parent_id_val").val(parent_id);
    }

    function modal_lov_product_set_value(the_id_val, the_code_val, parent_id) {
        $("#" + $("#modal_lov_product_id_val").val()).val(the_id_val);
        $("#" + $("#modal_lov_product_code_val").val()).val(the_code_val);
        $("#" + $("#modal_lov_parent_id_val").val()).val(parent_id);
        $("#modal_lov_product").modal("toggle");

        $("#" + $("#modal_lov_product_id_val").val()).change();
        $("#" + $("#modal_lov_product_code_val").val()).change();
        $("#" + $("#modal_lov_parent_id_val").val()).change();
    }

    function modal_lov_product_prepare_table(p_cat) {
        $("#modal_lov_product_grid_selection").bootgrid({
            formatters: {
                "opt-edit": function (col, row) {
                    return '<a href="javascript:;" title="Set Value" onclick="modal_lov_product_set_value(\'' + row.product_id + '\', \'' + row.product_name + '\',\'' + row.parent_id + '\')" class="blue"><i class="fa fa-pencil-square-o bigger-130"></i></a>';
                }
            },
            rowCount: [5, 10],
            ajax: true,
            requestHandler: function (request) {
                if (request.sort) {
                    var sortby = Object.keys(request.sort)[0];
                    request.dir = request.sort[sortby];

                    delete request.sort;
                    request.sort = sortby;
                }
                return request;
            },
            responseHandler: function (response) {
                if (response.success == false) {
                    swal({title: 'Attention', text: response.message, html: true, type: "warning"});
                }
                return response;
            },
            post: {
                p_cat: p_cat
            },
            url: '<?php echo WS_BOOTGRID . "agripro.production_controller/readLovProductProduction"; ?>',
            selection: true,
            sorting: true
        });

        $('.bootgrid-header span.glyphicon-search').removeClass('glyphicon-search')
            .html('<i class="fa fa-search"></i>');
    }

</script>