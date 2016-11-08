<?php

/**
 * Raw Material Model
 *
 */
class Production extends Abstract_model {

    public $table           = "production";
    public $pkey            = "production_id";
    public $alias           = "a";

    public $fields          = array(
                                'production_id'         => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ID Packaging'),
                                'product_id'            => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Product ID'),
                                'warehouse_id'           => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'WH ID'),
                               // 'product_category_id'   => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Product Category ID'),
                                'production_code'       => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'Production Code'),
                                'production_date'       => array('nullable' => false, 'type' => 'date', 'unique' => false, 'display' => 'Production Date'),
                                'production_qty'        => array('nullable' => false, 'type' => 'float', 'unique' => false, 'display' => 'Production Quantity'),
                                'production_qty_init'        => array('nullable' => false, 'type' => 'float', 'unique' => false, 'display' => 'Production Quantity'),

                               /* 'created_date'          => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updated_date'          => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'updated_by'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),*/

                            );


    public $selectClause    = "a.production_id, a.production_code,to_char(a.production_date,'yyyy-mm-dd') as production_date,a.production_qty,
                               b.product_id, b.product_name,b.product_code,b.product_category_id, a.production_qty
                                ";
    public $fromClause      = "production a
                                left join product b
                                on a.product_id = b.product_id";

    public $refs            = array();

    function __construct() {
        parent::__construct();
    }

    function validate() {
        $ci =& get_instance();
        $userdata = $ci->ion_auth->user()->row();

        if($this->actionType == 'CREATE') {

            /*$this->record['created_date'] = date('Y-m-d');
            $this->record['created_by'] = $userdata->username;
            $this->record['updated_date'] = date('Y-m-d');
            $this->record['updated_by'] = $userdata->username;*/

            //$this->record['pkg_serial_number'] = $this->getSerialNumber();
            //$this->record['pkg_batch_number'] = $this->getBatchNumber($this->record['pkg_serial_number'] );
        }else {
            //do something
            //example:
            /*$this->record['updated_date'] = date('Y-m-d');
            $this->record['updated_by'] = $userdata->username;*/
            //if false please throw new Exception
        }
        return true;
    }

    function genProductionCode()
    {

        $sql = "select max(substring(production_code, 5 )) as total from production
                    where to_char(production_date,'yyyymm') = '" . substr(str_replace('-', '', $this->record['production_date']),0,6) . "'";

        $query = $this->db->query($sql);

        $row = $query->row_array();
        if (empty($row)) {
            $row = array('total' => 0);
        }

        $production_code =   substr(str_replace('-', '', $this->record['production_date']),2,4) ."".str_pad(($row['total'] + 1), 4, '0', STR_PAD_LEFT);
        return $production_code;
    }

    function insertStock($prod) {
        $ci = & get_instance();

        $ci->load->model('agripro/stock');
        $tStock = $ci->stock;
        $tStock->actionType = 'CREATE';

        $ci->load->model('agripro/production_detail');
        $prod_det = $ci->production_detail;

        $ci->load->model('agripro/stock_category');
        $tStockCategory = $ci->stock_category;

        $prod_det->setCriteria('pd.production_id = '.$prod['production_id']);
        $details = $prod_det->getAll();


        foreach($details as $production_detail) {
            $record = array();
            $record['stock_tgl_keluar'] = $prod['production_date'];
            $record['stock_kg'] = $production_detail['production_detail_qty'];
            $record['stock_ref_id'] = $production_detail['production_detail_id'];
            $record['stock_ref_code'] = 'DRYING_OUT';
            $record['sc_id'] = $tStockCategory->getIDByCode('DRYING_STOCK');
            $record['wh_id'] = $prod['warehouse_id'];
            $record['product_id'] = $production_detail['product_id'];
            $record['stock_description'] = 'Drying Stock has used for Production Detail';
            $tStock->setRecord($record);
            $tStock->create();
        }



        ######################################
        ### Update Raw Material Qty (Decrease)
        ######################################

        foreach($details as $pd_det) {

            $decrease_kg = (float) $pd_det['production_detail_qty'];
            $sql = "UPDATE stock_material SET 
                      sm_qty_bersih = sm_qty_bersih - ".$decrease_kg."
                        WHERE sm_id = ".$pd_det['sm_id'];
            $prod_det->db->query($sql);
        }

    }

    public function removePacking($packing_id) {

        $ci = & get_instance();

        $ci->load->model('agripro/stock');
        $tStock = $ci->stock;

        $ci->load->model('agripro/packing_detail');
        $tPackingDetail = $ci->packing_detail;

        $ci->load->model('agripro/sortir');
        $tSortir = $ci->sortir;

        /**
         * Steps to Delete Packing
         *
         * 1. Remove all stock_detail first
         * 2. When loop for delete stock_detail, save data sortir in array
         * 3. Delete data packing in stock
         * 4. Loop data sortir for delete data sortir in stock and restore qty to sortir
         * 5. Delete data master packing
         */

        $data_sortir = array();
        $tPackingDetail->setCriteria('pd.packing_id = '.$packing_id);
        $details = $tPackingDetail->getAll();
        $loop = 0;
        foreach($details as $packing_detail) {
            $data_sortir[$loop]['sortir_id'] = $packing_detail['sortir_id'];
            $data_sortir[$loop]['restore_store_qty'] = $packing_detail['pd_kg'];
            $loop++;

            $tPackingDetail->remove($packing_detail['pd_id']);
        }

        /**
         * Delete data stock by packing_id
         */
        $tStock->deleteByReference($packing_id, 'PACKING');

        /**
         * loop for delete data stock by sortir_id and restore store_qty in table sortir
         */
        foreach($data_sortir as $sortir) {
            //delete data stock by sortir_id
            $tStock->deleteByReference($sortir['sortir_id'], 'SORTIR');

            //restore store qty
            $increase_kg = (float) $sortir['restore_store_qty'];
            $sql = "UPDATE sortir SET sortir_qty = sortir_qty + ".$increase_kg."
                        WHERE sortir_id = ".$sortir['sortir_id'];

            $tSortir->db->query($sql);

        }

        /**
         * Delete data master packing
         */
        $this->remove($packing_id);
    }

}
/* End of file Groups.php */