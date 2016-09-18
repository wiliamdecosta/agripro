<?php

/**
 * Shipping_detail Model
 *
 */
class Shipping_cost extends Abstract_model {

    public $table           = "shipping_cost";
    public $pkey            = "shipping_cost_id";
    public $alias           = "shipcost";

    public $fields          = array(
                                'shipping_cost_id'          => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ID Packaging'),
                                'shipping_id'               => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'ID Shipping'),
                                'parameter_cost_id'         => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'ID Cost Parameter'),
                                'shipping_cost_value'       => array('nullable' => false, 'type' => 'float', 'unique' => false, 'display' => 'Cost'),
                                'shipping_cost_description' => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created Date'),

                                'created_date'          => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updated_date'          => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'updated_by'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );


    public $selectClause    = "shipcost.*, ship.shipping_date, ship.shipping_driver_name,
                                parameter_cost.parameter_cost_code";
    public $fromClause      = "shipping_cost as shipcost
                                left join shipping as ship on shipcost.shipping_id = ship.shipping_id
                                left join parameter_cost on shipcost.parameter_cost_id = parameter_cost.parameter_cost_id";

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