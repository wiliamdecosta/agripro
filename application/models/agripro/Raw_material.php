<?php

/**
 * Raw Material Model
 *
 */
class Raw_material extends Abstract_model {

    public $table           = "raw_material";
    public $pkey            = "rm_id";
    public $alias           = "rm";

    public $fields          = array(
                                'rm_id'             => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ID Raw Material'),
                                'rm_code'           => array('nullable' => true, 'type' => 'str', 'unique' => true, 'display' => 'Kode'),
                                'rm_name'           => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'Nama'),
                                'created_date'      => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updated_date'      => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'updated_by'        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = "rm.rm_id, rm.rm_code, rm.rm_name, to_char(rm.created_date,'yyyy-mm-dd') as created_date, rm.created_by,
                                    to_char(rm.updated_date,'yyyy-mm-dd') as updated_date, rm.updated_by";
    public $fromClause      = "raw_material rm";

    public $refs            = array('stock_material_detail' => 'rm_id');

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