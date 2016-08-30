<?php

/**
 * Shipping_detail Model
 *
 */
class Shipping_detail extends Abstract_model {

    public $table           = "shipping_detail";
    public $pkey            = "shipdet_id";
    public $alias           = "shipdet";

    public $fields          = array(
                                'shipdet_id'            => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ID Packaging'),
                                'packing_id'            => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'ID Packing'),

                                'created_date'          => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updated_date'          => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'updated_by'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );


    public $selectClause    = "shipdet.*, pack.packing_batch_number, pack.packing_serial, pack.packing_kg,
                                pack.packing_tgl, wh.wh_code, wh.wh_name,
                                prod.product_code, prod.product_name";
    public $fromClause      = "shipping_detail as shipdet
                                left join packing as pack on shipdet.packing_id = pack.packing_id
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

}
/* End of file Groups.php */