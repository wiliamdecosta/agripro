<?php

/**
 * Farmer Model
 *
 */
class Stock_material extends Abstract_model {

    public $table           = "stock_material";
    public $pkey            = "sm_id";
    public $alias           = "sm";

    public $fields          = array(
                                'sm_id'             => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ID Stock Material'),
                                'fm_id'             => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Warehouse'),
                                'sm_tgl_masuk'      => array('nullable' => false, 'type' => 'date', 'unique' => false, 'display' => 'Tgl Masuk'),
                                'sm_no_trans'  => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Transaction Code'),
                                'sm_jenis_pembayaran' => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Jenis Pembayaran'),
                                'sm_no_po'          => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Nomor PO'),
                                'sm_jml_karung'     => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'Batch Total'),

                                'created_date'      => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updated_date'      => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'updated_by'        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = "sm.sm_id, sm.fm_id, to_char(sm.sm_tgl_masuk,'yyyy-mm-dd') as sm_tgl_masuk, sm.sm_no_trans, sm.sm_jenis_pembayaran,
                                    sm.sm_no_po,sm.sm_jml_karung,
                                    to_char(sm.created_date,'yyyy-mm-dd') as created_date, sm.created_by,
                                    to_char(sm.updated_date,'yyyy-mm-dd') as updated_date, sm.updated_by,
                                    fm.fm_code, fm.fm_name";
    public $fromClause      = "stock_material sm
                                left join farmer as fm on sm.fm_id = fm.fm_id";

    public $refs            = array('stock_material_detail' => 'sm_id');

    function __construct() {
        parent::__construct();
    }

    function validate() {
        $ci =& get_instance();
        $userdata = $ci->ion_auth->user()->row();

        if($this->actionType == 'CREATE') {
            //do something
            // example :

            $this->record['sm_no_trans'] = $this->getSerialNumber();
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


    function getSerialNumber() {

        $format_serial = 'RMP-FMCODE-DATE-XXXX';

        $sql = "select max(substr(sm_no_trans, length(sm_no_trans)-4 + 1 )::integer) as total from stock_material
                    where to_char(sm_tgl_masuk,'yyyymmdd') = '".str_replace('-','',$this->record['sm_tgl_masuk'])."'";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        if(empty($row)) {
            $row = array('total' => 0);
        }

        $format_serial = str_replace('XXXX', str_pad(($row['total']+1), 4, '0', STR_PAD_LEFT), $format_serial);
        $format_serial = str_replace('DATE', str_replace('-','',$this->record['sm_tgl_masuk']), $format_serial);

        $ci = & get_instance();
        $ci->load->model('agripro/farmer');
        $tFarmer = $ci->farmer;

        $itemfarmer = $tFarmer->get( $this->record['fm_id'] );
        $format_serial = str_replace('FMCODE', $itemfarmer['fm_code'], $format_serial);

        return $format_serial;
    }

}

/* End of file Groups.php */