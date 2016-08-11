<h4>Packaging</h4>
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>
                    Product Name
                </th>
                <th>
                    Weight
                </th>
                <th>
                    Packing Date
                </th>
                <th>
                    Warehouse
                </th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    <?php echo $packaging->product_name;?>
                </td>
                <td>
                    <?php echo $packaging->packing_kg;?> Kgs
                </td>
                <td>
                    <?php echo $packaging->packing_tgl;?>
                </td>
                <td>
                    <?php echo $packaging->wh_name;?> - <?php echo $packaging->wh_location;?>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<hr>
<h4> Detail Packaging Source</h4>
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>
                    Raw Material
                </th>
                <th>
                    Weight
                </th>
                <th>
                    Farmer Name
                </th>
                <th>
                    Farmer Code
                </th>
                <th>
                    Gender
                </th>
                <th>
                    Farmer Address
                </th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($detail_packing as $detail){;?>
            <tr>
                <td>
                    <?php echo $detail->rm_name;?>
                </td>
                <td>
                    <?php echo $detail->pd_kg;?>
                </td>
                <td>
                    <?php echo $detail->fm_name;?>
                </td>
                <td>
                    <?php echo $detail->fm_code;?>
                </td>
                <td>
                    <?php echo $detail->fm_jk;?>
                </td>
                <td>
                    <?php echo $detail->fm_address;?>
                </td>
            </tr>
            <?php  } ;?>
            </tbody>
        </table>
    </div>
</div>