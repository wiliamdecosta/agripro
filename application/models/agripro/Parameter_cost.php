<?php

/**
 * Provinsi Model
 *
 */
class Parameter_cost extends Abstract_model {

    public $table           = "parameter_cost";
    public $pkey            = "parameter_cost_id";
    public $alias           = "pcost";

    public $fields          = array(
                                'parameter_cost_id'     => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ID Parameter Cost'),
                                'parameter_cost_code'   => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'Code'),
                                'created_date'          => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updated_date'          => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'updated_by'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = "pcost.*";
    public $fromClause      = "parameter_cost pcost";

    public $refs            = array('shipping_cost' => 'parameter_cost_id');

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