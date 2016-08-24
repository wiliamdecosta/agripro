<?php

/**
 * Stock Model
 *
 */
class Stock extends Abstract_model {

    public $table           = "stock";
    public $pkey            = "stock_id";
    public $alias           = "";

    public $fields          = array(
                                'stock_id'           => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ID Stock'),
                                'sc_id'              => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'ID Stock Category'),
                                'wh_id'              => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'ID Warehouse'),
                                'product_id'         => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'ID Product'),

                                'stock_kg'           => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Weight KGs'),
                                'stock_tgl_masuk'    => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'In Date'),
                                'stock_tgl_keluar'   => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Out Date'),

                                'stock_ref_id'       => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Ref ID'),
                                'stock_ref_code'     => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Ref Code'),


                                'created_date'      => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updated_date'      => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'updated_by'        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),
                            );

    public $selectClause    = "stock.*, sc.sc_code, prod.product_name, wh.wh_code, wh.wh_name";
    public $fromClause      = "stock as stock
                                left join stock_category as sc on stock.sc_id = sc.sc_id
                                left join product as prod on stock.product_id = prod.product_id
                                left join warehouse as wh on stock.wh_id = wh.wh_id";

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