<?php

/**
 * Farmer Model
 *
 */
class Packaging_detail extends Abstract_model {

    public $table           = "detail_packaging";
    public $pkey            = "dp_id";
    public $alias           = "dp";

    public $fields          = array(
                                'dp_id'            => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ID Stock Material'),
                                'smd_id'             => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'SM ID'),
                                'pkg_id'             => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'RM ID'),
                                'dp_qty'           => array('nullable' => false, 'type' => 'float', 'unique' => false, 'display' => 'Qty'),
                                'created_date'      => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updated_date'      => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'updated_by'        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = " dp.dp_id, dp.smd_id, smd.smd_batch_number, dp.dp_qty,
                                to_char(dp.created_date,'yyyy-mm-dd') as created_date, dp.created_by,
                                to_char(dp.updated_date,'yyyy-mm-dd') as updated_date, dp.updated_by";

    public $fromClause      = " detail_packaging dp
                                left join packaging pkg on dp.pkg_id = pkg.pkg_id
                                left join stock_material_detail smd on dp.smd_id = smd.smd_id ";

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