<?php

/**
 * Farmer Model
 *
 */
class Drying extends Abstract_model
{

    public $table = "stock_material";
    public $pkey = "sm_id";
    public $alias = "sm";

    public $fields = array(
        'sm_id' => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ID Stock Material'),
        'fm_id' => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'FM ID'),
        'wh_id' => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'Warehouse'),
        'product_id' => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Product ID'),
        'sm_qty_kotor' => array('nullable' => false, 'type' => 'float', 'unique' => false, 'display' => 'Bruto'),
        'sm_qty_kotor_init' => array('nullable' => false, 'type' => 'float', 'unique' => false, 'display' => 'sm_qty_kotor_init'),
        'sm_qty_bersih' => array('nullable' => false, 'type' => 'float', 'unique' => false, 'display' => 'Net Weight'),

        'sm_tgl_pengeringan' => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Drying Date'),
        'sm_no_trans' => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Transaction Code'),

        'created_date' => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
        'created_by' => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
        'updated_date' => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
        'updated_by' => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

    );

    public $selectClause = "sm.sm_id, sm.fm_id, to_char(sm.sm_tgl_masuk,'yyyy-mm-dd') as sm_tgl_masuk, sm.sm_no_trans, sm.sm_jenis_pembayaran,
                                    sm.sm_no_po,sm.sm_jml_karung,sm.product_id,pr.product_code,sm.sm_qty_kotor,sm.sm_harga_per_kg,sm.sm_harga_total,
                                    sm.sm_tgl_panen,sm.sm_harga_total,plt.plt_code,sm.plt_id,sm.sm_tgl_panen,
                                    sm.sm_tgl_pengeringan,sm.sm_qty_bersih,
                                    sm.sm_qty_kotor_init,sm.sm_qty_bersih_init,
                                    sm.wh_id,
                                    pr.product_id,
                                    to_char(sm.created_date,'yyyy-mm-dd') as created_date, sm.created_by,
                                    to_char(sm.updated_date,'yyyy-mm-dd') as updated_date, sm.updated_by,
                                    fm.fm_code, fm.fm_name";
    public $fromClause = "stock_material sm
                                inner join farmer as fm on sm.fm_id = fm.fm_id
                                inner join product as pr on sm.product_id = pr.product_id
                                inner join plantation as plt on sm.plt_id = plt.plt_id";

    public $refs = array();

    function __construct()
    {
        parent::__construct();
    }

    function validate()
    {
        $ci =& get_instance();
        $userdata = $ci->ion_auth->user()->row();

        if ($this->actionType == 'CREATE') {

           /* $this->record['sm_no_trans'] = $this->getSerialNumber();
            $this->record['sm_qty_bersih'] = $this->record['sm_qty_bersih_init'];

            $this->record['created_date'] = date('Y-m-d');
            $this->record['created_by'] = $userdata->username;
            $this->record['updated_date'] = date('Y-m-d');
            $this->record['updated_by'] = $userdata->username;*/

        } else {

            $this->record['sm_qty_bersih_init'] = $this->record['sm_qty_bersih'];
            $this->record['updated_date'] = date('Y-m-d');
            $this->record['updated_by'] = $userdata->username;
        }
        return true;
    }

    function InsertStock($record){
        ######################################
        ### 1. Insert Stok DRYING_STOCK (IN)
        ### 2. Insert Stock RAW MATERIAL (Out)
        ### 3. Update QTY NETTO value
        ######################################

        $ci = & get_instance();
        $ci->load->model('agripro/stock');
        $tStock = $ci->stock;
        $tStock->actionType = 'CREATE';

        $ci->load->model('agripro/stock_category');
        $tStockCategory = $ci->stock_category;


        ################ Step 1 ###############
        $record1 = array();
        $record1['wh_id'] = $record['wh_id'];
        $record1['product_id'] = $record['product_id'];
        $record1['sc_id'] = $tStockCategory->getIDByCode('DRYING_STOCK');
        $record1['stock_tgl_masuk'] = $record['sm_tgl_pengeringan'];; //base on packing_tgl
        $record1['stock_kg'] = $record['sm_qty_bersih'];
        $record1['stock_ref_id'] = $record['sm_id'];
        $record1['stock_ref_code'] = 'DRYING IN';
        $record1['stock_description'] = 'Insert Stock Drying';
        $tStock->setRecord($record1);

        $tStock->create();

        ################ Step 2 ###############
        $ci->load->model('agripro/stock');
        $tStock = $ci->stock;
        $tStock->actionType = 'CREATE';

        $record2 = array();
        $record2['wh_id'] = $record['wh_id'];
        $record2['product_id'] = $record['product_id'];
        $record2['sc_id'] = $tStockCategory->getIDByCode('RAW_MATERIAL_STOCK');
        $record2['stock_tgl_keluar'] = $record['sm_tgl_pengeringan'];; //base on packing_tgl
        $record2['stock_kg'] = $record['sm_qty_kotor_init'];
        $record2['stock_ref_id'] = $record['sm_id'];
        $record2['stock_ref_code'] = 'RAW MATERIAL OUT';
        $record2['stock_description'] = 'Raw Material (OUT) for Drying';
        $tStock->setRecord($record2);

        $tStock->create();
    }

    function UpdateStock($rmp) {
        $ci = & get_instance();

        $ci->load->model('agripro/stock');
        $tStock = $ci->stock;
        $tStock->actionType = 'UPDATE';

        $ci->load->model('agripro/stock_category');
        $tStockCategory = $ci->stock_category;

        ###################################
        #### Update IN Stock (Drying)
        ###################################
        $record_stock = array();
        $record_stock['stock_tgl_masuk'] = $rmp['sm_tgl_pengeringan'];; //base on packing_tgl
        $record_stock['stock_kg'] = $rmp['sm_qty_bersih'];


        $this->db->where(array(
            'stock_ref_id' => $rmp['sm_id'],
            'stock_ref_code' => 'DRYING IN'
        ));
        $this->db->update($tStock->table, $record_stock);

        #####################################
        #### Update OUT Stock (Raw Material)
        #####################################
        $record_stock2 = array();
        $record_stock2['stock_tgl_keluar'] = $rmp['sm_tgl_pengeringan'];; //base on packing_tgl
        $record_stock2['stock_kg'] = $rmp['sm_qty_kotor_init'];

        $this->db->where(array(
            'stock_ref_id' => $rmp['sm_id'],
            'stock_ref_code' => 'RAW MATERIAL OUT'
        ));
        $this->db->update($tStock->table, $record_stock2);
    }

    function updateQtyRM($record){
        $this->db->set('sm_qty_kotor',0);
        $this->db->where('sm_id', $record['sm_id']);
        $this->db->update('stock_material');
    }

    function checkDryingQTY($record){
        $this->db->select('sm_qty_bersih');
        $this->db->where('sm_id', $record['sm_id']);
        $query = $this->db->get('stock_material');

        return $query->row()->sm_qty_bersih;
    }

}

/* End of file Groups.php */