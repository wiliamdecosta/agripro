<?php

/**
 * Warehouse_cost_detail Model
 *
 */
class Warehouse_cost_detail extends Abstract_model {

    public $table           = "warehouse_cost_detail";
    public $pkey            = "whcost_det_id";
    public $alias           = "whcost_det";

    public $fields          = array(
                                'whcost_det_id'             => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ID WHCost Detail'),
                                'whcost_id'                 => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'ID Warehouse'),
                                'parameter_cost_id'         => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'ID Parameter Cost'),
                                'whcost_det_value'          => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Cost Value'),

                                'created_date'              => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'                => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updated_date'              => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'updated_by'                => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By')
                            );

    public $selectClause    = "whcost_det.*, parameter_cost.parameter_cost_code";
    public $fromClause      = "warehouse_cost_detail whcost_det
                                left join parameter_cost on whcost_det.parameter_cost_id = parameter_cost.parameter_cost_id";

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