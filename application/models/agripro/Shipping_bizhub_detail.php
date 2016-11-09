<?php

/**
 * Shipping_bizhub_detail Model
 *
 */
class Shipping_bizhub_detail extends Abstract_model {

    public $table           = "shipping_bizhub_detail";
    public $pkey            = "shipdet_bizhub_id";
    public $alias           = "shipdet";

    public $fields          = array(
                                'shipdet_bizhub_id'     => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ID Packaging'),
                                'shipping_bizhub_id'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'ID Shipping'),
                                'packing_bizhub_id'     => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'ID Packing'),

                                'created_date'          => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updated_date'          => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'updated_by'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),
                            );


    public $selectClause    = "shipdet.*, pack.packing_bizhub_batch_number, pack.packing_bizhub_serial, pack.packing_bizhub_kg,
                                pack.packing_bizhub_date, wh.wh_code, wh.wh_name,
                                prod.product_code, prod.product_name";
    public $fromClause      = "shipping_bizhub_detail as shipdet
                                left join packing_bizhub as pack on shipdet.packing_bizhub_id = pack.packing_bizhub_id
                                left join product as prod on pack.product_id = prod.product_id
                                left join warehouse as wh on pack.warehouse_id = wh.wh_id";

    public $refs            = array();

    function __construct() {
        parent::__construct();
    }

    function validate() {
        $ci =& get_instance();
        $userdata = $ci->ion_auth->user()->row();

        if($this->actionType == 'CREATE') {
            //do something
            // example :

            $this->record['created_date'] = date('Y-m-d');
            $this->record['created_by'] = $userdata->username;
            $this->record['updated_date'] = date('Y-m-d');
            $this->record['updated_by'] = $userdata->username;

            //$this->record['pkg_serial_number'] = $this->getSerialNumber();
            //$this->record['pkg_batch_number'] = $this->getBatchNumber($this->record['pkg_serial_number'] );
        }else {
            //do something
            //example:
            $this->record['updated_date'] = date('Y-m-d');
            $this->record['updated_by'] = $userdata->username;
            //if false please throw new Exception
        }
        return true;
    }


    function insertStock($item_detail, $itemShipping) {

        $ci = & get_instance();

        $ci->load->model('agripro/stock');
        $tStock = $ci->stock;

        $ci->load->model('agripro/stock_category');
        $tStockCategory = $ci->stock_category;

        $ci->load->model('agripro/packing_bizhub');
        $tPacking = $ci->packing_bizhub;

        $record_stock = array();
        $item_packing = $tPacking->get($item_detail['packing_bizhub_id']);

        $record_stock['stock_tgl_keluar'] = $itemShipping['shipping_bizhub_date']; //base on shipping_date
        $record_stock['stock_kg'] = $item_packing['packing_bizhub_kg'];
        $record_stock['stock_ref_id'] = $item_detail['shipdet_bizhub_id'];
        $record_stock['stock_ref_code'] = 'SHIPPING_BIZHUB';
        $record_stock['sc_id'] = $tStockCategory->getIDByCode('PACKING_STOCK');
        $record_stock['wh_id'] = $item_packing['warehouse_id'];
        $record_stock['product_id'] = $item_packing['product_id'];
        $record_stock['stock_description'] = 'packing_kg out for shipping_detail used';
        $tStock->setRecord($record_stock);
        $tStock->create();

    }

    /**
     * [removeByPackingID called by Packing Model]
     * @param  [type] $packing_id [description]
     * @return [type]             [description]
     */
    function removeByPackingID($packing_bizhub_id) {
        $sql = "SELECT shipdet_bizhub_id FROM shipping_bizhub_detail WHERE packing_bizhub_id = ".$packing_bizhub_id;
        $query = $this->db->query($sql);
        $row = $query->row_array();

        $this->removeItems($row['shipdet_bizhub_id']);
    }

    function removeItems($shipdet_bizhub_id) {
        $this->remove($shipdet_bizhub_id); //delete data detail

        /**
         * Remove stock with
         * @var [type]
         */
        $ci = & get_instance();
        $ci->load->model('agripro/stock');
        $tStock = $ci->stock;
        $tStock->deleteByReference($shipdet_bizhub_id, 'SHIPPING_BIZHUB');
    }


}
/* End of file Groups.php */