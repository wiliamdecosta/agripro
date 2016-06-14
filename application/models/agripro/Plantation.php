<?php

/**
 * Raw Material Model
 *
 */
class Plantation extends Abstract_model {

    public $table           = "plantation";
    public $pkey            = "plt_id";
    public $alias           = "plt";

    public $fields          = array(
                                'plt_id'             => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ID Raw Material'),
                                'fm_id'              => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Farmer ID'),
                                'prov_id'            => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Prov ID'),
                                'kota_id'            => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Kota ID'),
                                'plt_code'           => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'Kode'),
                                'plt_luas_lahan'     => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Luas Lahan'),
                                'plt_status'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Status'),
                                'plt_plot'           => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'Plot'),
                                'plt_year_planted'   => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Year Planted'),
                                'plt_date_contract'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Contract Date'),
                                'plt_date_registration'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Registration Date'),
                                'plt_coordinate'     => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Coordinate'),
                                'plt_nama_pemilik'   => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Nama Pemilik'),

                                'created_date'       => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updated_date'       => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'updated_by'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = "plt.*, to_char(plt.plt_date_contract,'yyyy-mm-dd') as plt_date_contract,
                                    to_char(plt.plt_date_registration,'yyyy-mm-dd') as plt_date_registration, to_char(plt.created_date,'yyyy-mm-dd') as created_date,
                                    to_char(plt.updated_date,'yyyy-mm-dd') as updated_date,
                                    prov.prov_code, kota.kota_name";
    public $fromClause      = "plantation plt
                                left join provinsi as prov on plt.prov_id = prov.prov_id
                                left join kota as kota on plt.kota_id = kota.kota_id";

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