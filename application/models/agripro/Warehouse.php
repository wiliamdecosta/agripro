<?php

/**
 * Warehouse Model
 *
 */
class Warehouse extends Abstract_model {

    public $table           = "warehouse";
    public $pkey            = "wh_id";
    public $alias           = "wh";

    public $fields          = array(
                                'wh_id'             => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ID Warehouse'),
                                'wh_code'           => array('nullable' => true, 'type' => 'str', 'unique' => true, 'display' => 'Kode'),
                                'wh_name'           => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'Nama'),
                                'wh_location'       => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Lokasi'),
                                'created_date'      => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updated_date'      => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'updated_by'        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = "wh.*, to_char(wh.created_date,'yyyy-mm-dd') as created_date,
                                    to_char(wh.updated_date,'yyyy-mm-dd') as updated_date";
    public $fromClause      = "warehouse wh";

    public $refs            = array('farmer' => 'wh_id');

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