<?php

/**
 * Provinsi Model
 *
 */
class Cost_category extends Abstract_model {

    public $table           = "cost_category";
    public $pkey            = "cost_category_id";
    public $alias           = "costcat";

    public $fields          = array(
                                'cost_category_id'     => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ID Cost Category'),
                                'cost_category_code'   => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'Category Code'),
                                'created_date'          => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updated_date'          => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'updated_by'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = "costcat.*";
    public $fromClause      = "cost_category costcat";

    public $refs            = array('parameter_cost' => 'cost_category_id');

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