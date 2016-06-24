<h4>Packaging</h4>
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>
                    Product Code
                </th>
                <th>
                    Product Name
                </th>
                <th>
                    Serial Number
                </th>
                <th>
                    Batch Number
                </th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    <?php echo $packaging->prod_code;?>
                </td>
                <td>
                    <?php echo $packaging->prod_name;?>
                </td>
                <td>
                    <?php echo $packaging->pkg_serial_number;?>
                </td>
                <td>
                    <?php echo $packaging->pkg_batch_number;?>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<hr>
<h4> Detail Packaging</h4>
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>
                    Serial Number
                </th>
                <th>
                    Batch Number
                </th>
                <th>
                    Farmer
                </th>
                <th>
                    FM Sertification
                </th>
                <th>
                    Province
                </th>
                <th>
                    City
                </th>
                <th>
                    Tanggal Masuk
                </th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($detail_packing as $detail){;?>
            <tr>
                <td>
                    <?php echo $detail->sm_serial_number;?>
                </td>
                <td>
                    <?php echo $detail->smd_batch_number;?>
                </td>
                <td>
                    <?php echo $detail->fm_name;?>
                </td>
                <td>
                    <?php echo $detail->fm_no_sertifikasi;?>
                </td>
                <td>
                    <?php echo $detail->prov_code;?>
                </td>
                <td>
                    <?php echo $detail->kota_name;?>
                </td>
                <td>
                    <?php echo $detail->sm_tgl_masuk;?>
                </td>
            </tr>
            <?php  } ;?>
            </tbody>
        </table>
    </div>
</div>