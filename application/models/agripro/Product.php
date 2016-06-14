<?php

/**
 * Product Model
 *
 */
class Product extends Abstract_model {

    public $table           = "product";
    public $pkey            = "prod_id";
    public $alias           = "prod";

    public $fields          = array(
                                'prod_id'             => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ID Raw Material'),
                                'prod_code'           => array('nullable' => true, 'type' => 'str', 'unique' => true, 'display' => 'Kode'),
                                'prod_name'           => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'Nama'),
                                'created_date'      => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updated_date'      => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'updated_by'        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = "prod.prod_id, prod.prod_code, prod.prod_name, to_char(prod.created_date,'yyyy-mm-dd') as created_date, prod.created_by,
                                    to_char(prod.updated_date,'yyyy-mm-dd') as updated_date, prod.updated_by";
    public $fromClause      = "product prod";

    public $refs            = array('packaging' => 'prod_id');

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