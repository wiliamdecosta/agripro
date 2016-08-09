<?php

/**
 * Farmer Model
 *
 */
class Packing_detail extends Abstract_model {

    public $table           = "packing_detail";
    public $pkey            = "pd_id";
    public $alias           = "pd";

    public $fields          = array(
                                'pd_id'             => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ID Packing Detail'),
                                'packing_id'        => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'ID Packing'),
                                'sortir_id'         => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'ID Sortir'),
                                'pd_kg'             => array('nullable' => false, 'type' => 'float', 'unique' => false, 'display' => 'Qty Kg'),

                                'created_date'      => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updated_date'      => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'updated_by'        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = "pd.*, product.product_code";

    public $fromClause      = "packing_detail as pd
                                left join sortir on pd.sortir_id = sortir.sortir_id
                                left join product on sortir.product_id = product.product_id";

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
        }
        return true;
    }



}

/* End of file Groups.php */