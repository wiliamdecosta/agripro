<?php

/**
 * Farmer Model
 *
 */
class Farmer extends Abstract_model {

    public $table           = "farmer";
    public $pkey            = "fm_id";
    public $alias           = "fm";

    public $fields          = array(
                                'fm_id'             => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ID Farmer'),
                                'wh_id'             => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Warehouse'),
                                'fm_code'           => array('nullable' => true, 'type' => 'str', 'unique' => true, 'display' => 'Kode'),
                                'fm_name'           => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'Nama'),
                                'fm_jk'             => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'Jenis Kelamin'),
                                'fm_address'        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Alamat'),
                                'fm_no_sertifikasi' => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Nomor Sertifikasi'),
                                'fm_no_hp'          => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Nomor HP'),
                                'fm_email'          => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Email'),
                                'fm_tgl_lahir'      => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Tgl Lahir'),

                                'created_date'      => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updated_date'      => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'updated_by'        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = "fm.fm_id, fm.wh_id, fm.fm_code, fm.fm_name, fm.fm_jk,
                                    fm.fm_address, fm.fm_no_sertifikasi, fm.fm_no_hp,
                                    fm.fm_email, to_char(fm.fm_tgl_lahir,'yyyy-mm-dd') as fm_tgl_lahir,
                                    to_char(fm.created_date,'yyyy-mm-dd') as created_date, fm.created_by,
                                    to_char(fm.updated_date,'yyyy-mm-dd') as updated_date, fm.updated_by,
                                    wh.wh_code, wh.wh_name";
    public $fromClause      = "farmer fm
                                left join warehouse as wh on fm.wh_id = wh.wh_id";

    public $refs            = array('plantation' => 'fm_id');

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