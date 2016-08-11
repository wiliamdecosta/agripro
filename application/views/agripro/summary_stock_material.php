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
            <span>Summary Stock Material</span>
        </li>
    </ul>
</div>

<div class="space-4"></div>
<div class="row">
    <div class="col-md-12">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">Summary Stock Material</div>
            </div>

            <div class="portlet-body form">
                 <table class="table table-bordered table-striped" id="tbl-stock-summary">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product Code</th>
                            <th>Product Name</th>
                            <th>Warehouse Code</th>
                            <th>Stock Qty(KGs)</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-stock-summary">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script>
    $(function() {

        $.ajax({
            url: '<?php echo WS_JQGRID."agripro.stock_material_controller/summary_stock"; ?>',
            type: "POST",
            success: function (response) {
                $( "#tbody-stock-summary" ).html( response );
            },
            error: function (xhr, status, error) {
                swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
            }
        });

    });

</script>