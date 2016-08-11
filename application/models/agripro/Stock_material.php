<?php

/**
 * Farmer Model
 *
 */
class Stock_material extends Abstract_model
{

    public $table = "stock_material";
    public $pkey = "sm_id";
    public $alias = "sm";

    public $fields = array(
        'sm_id' => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ID Stock Material'),
        'fm_id' => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Warehouse'),
        'plt_id' => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Plantation'),
        'product_id' => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Product ID'),
        'sm_qty_kotor' => array('nullable' => false, 'type' => 'float', 'unique' => false, 'display' => 'Total Weight (KGs)'),
        'sm_harga_per_kg' => array('nullable' => false, 'type' => 'float', 'unique' => false, 'display' => 'Price / Kgs'),
        'sm_tgl_masuk' => array('nullable' => false, 'type' => 'date', 'unique' => false, 'display' => 'Date'),
        'sm_tgl_panen' => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Harvest Date'),
        'sm_no_trans' => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Transaction Code'),
        'sm_jenis_pembayaran' => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Payment Type'),
        'sm_no_po' => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'PO Number'),
        'sm_jml_karung' => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'Batch Total'),

        'created_date' => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
        'created_by' => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
        'updated_date' => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
        'updated_by' => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

    );

    public $selectClause = "sm.sm_id, sm.fm_id, to_char(sm.sm_tgl_masuk,'yyyy-mm-dd') as sm_tgl_masuk, sm.sm_no_trans, sm.sm_jenis_pembayaran,
                                    sm.sm_no_po,sm.sm_jml_karung,sm.product_id,pr.product_code,sm.sm_qty_kotor,sm.sm_harga_per_kg,sm.sm_harga_total,
                                    sm.sm_tgl_panen,sm.sm_harga_total,plt.plt_code,sm.plt_id,sm.sm_tgl_panen,
                                    sm.sm_tgl_pengeringan,sm.sm_qty_bersih,sm.sm_tgl_produksi,
                                    to_char(sm.created_date,'yyyy-mm-dd') as created_date, sm.created_by,
                                    to_char(sm.updated_date,'yyyy-mm-dd') as updated_date, sm.updated_by,
                                    fm.fm_code, fm.fm_name";
    public $fromClause = "stock_material sm
                                inner join farmer as fm on sm.fm_id = fm.fm_id
                                inner join product as pr on sm.product_id = pr.product_id
                                inner join plantation as plt on sm.plt_id = plt.plt_id";

    public $refs = array('stock_material_detail' => 'sm_id');

    function __construct()
    {
        parent::__construct();
    }

    function validate()
    {
        $ci =& get_instance();
        $userdata = $ci->ion_auth->user()->row();

        if ($this->actionType == 'CREATE') {
            //do something
            // example :

            $this->record['sm_no_trans'] = $this->getSerialNumber();
            $this->record['sm_harga_total'] = $this->getTotalPrice();
            $this->record['created_date'] = date('Y-m-d');
            $this->record['created_by'] = $userdata->username;
            $this->record['updated_date'] = date('Y-m-d');
            $this->record['updated_by'] = $userdata->username;

        } else {
            //do something
            //example:
            $this->record['sm_harga_total'] = $this->getTotalPrice();
            $this->record['updated_date'] = date('Y-m-d');
            $this->record['updated_by'] = $userdata->username;
            //if false please throw new Exception
        }
        return true;
    }


    function getSerialNumber()
    {

        $format_serial = 'RMP-FMCODE-DATE-XXXX';

        $sql = "select max(substr(sm_no_trans, length(sm_no_trans)-4 + 1 )::integer) as total from stock_material
                    where to_char(sm_tgl_masuk,'yyyymmdd') = '" . str_replace('-', '', $this->record['sm_tgl_masuk']) . "'";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        if (empty($row)) {
            $row = array('total' => 0);
        }

        $format_serial = str_replace('XXXX', str_pad(($row['total'] + 1), 4, '0', STR_PAD_LEFT), $format_serial);
        $format_serial = str_replace('DATE', str_replace('-', '', $this->record['sm_tgl_masuk']), $format_serial);

        $ci = &get_instance();
        $ci->load->model('agripro/farmer');
        $tFarmer = $ci->farmer;

        $itemfarmer = $tFarmer->get($this->record['fm_id']);
        $format_serial = str_replace('FMCODE', $itemfarmer['fm_code'], $format_serial);

        return $format_serial;
    }

    function getTotalPrice(){

        $price = $this->record['sm_harga_per_kg'];
        $qty = $this->record['sm_qty_kotor'];
        $total_price = $price * $qty;
        return $total_price;
    }

}

/* End of file Groups.php */