<?php

/**
 * Farmer Model
 *
 */
class Stock_material_detail extends Abstract_model {

    public $table           = "stock_material_detail";
    public $pkey            = "smd_id";
    public $alias           = "smd";

    public $fields          = array(
                                'smd_id'            => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ID Stock Material'),
                                'sm_id'             => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'SM ID'),
                                'rm_id'             => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'RM ID'),
                                'smd_qty'           => array('nullable' => false, 'type' => 'float', 'unique' => false, 'display' => 'Qty'),
                                'smd_harga'         => array('nullable' => false, 'type' => 'float', 'unique' => false, 'display' => 'Harga'),
                                'smd_batch_number'  => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Batch Number'),
                                'smd_plt_id'        => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'Plantation ID'),

                                'smd_tgl_panen'      => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Tgl Panen'),
                                'smd_tgl_pengeringan' => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Tgl Pengeringan'),

                                'created_date'      => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updated_date'      => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'updated_by'        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = " smd.smd_id, smd.sm_id, smd.rm_id, smd.smd_qty, smd.smd_harga, smd.smd_batch_number, smd.smd_plt_id,
                                to_char(smd.smd_tgl_panen,'yyyy-mm-dd') as smd_tgl_panen,
                                to_char(smd.smd_tgl_pengeringan,'yyyy-mm-dd') as smd_tgl_pengeringan,
                                to_char(smd.created_date,'yyyy-mm-dd') as created_date, smd.created_by,
                                to_char(smd.updated_date,'yyyy-mm-dd') as updated_date, smd.updated_by,
                                sm.sm_serial_number,
                                rm.rm_code, rm.rm_name,
                                plt.plt_code";
    public $fromClause      = "stock_material_detail smd
                                left join stock_material as sm on smd.sm_id = sm.sm_id
                                left join raw_material as rm on smd.rm_id = rm.rm_id
                                left join plantation as plt on smd.smd_plt_id = plt.plt_id";

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

            $this->record['smd_batch_number'] = $this->getBatchNumber();
            if(empty($this->record['smd_tgl_panen']))
                unset($this->record['smd_tgl_panen']);
            if(empty($this->record['smd_tgl_pengeringan']))
                unset($this->record['smd_tgl_pengeringan']);

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
            if(empty($this->record['smd_tgl_panen']))
                unset($this->record['smd_tgl_panen']);
            if(empty($this->record['smd_tgl_pengeringan']))
                unset($this->record['smd_tgl_pengeringan']);
        }
        return true;
    }


    function getBatchNumber() {

        $ci = & get_instance();
        $ci->load->model('agripro/stock_material');
        $tStockMaterial = $ci->stock_material;

        $itemSM = $tStockMaterial->get( $this->record['sm_id'] );
        $format_serial = $itemSM['sm_serial_number']."/"."XXXX";   //format of SM serial number plus /XXXX


        $sql = "select max(smd_batch_number) as last_batch from stock_material_detail
                    where smd_batch_number ilike '".$itemSM['sm_serial_number']."/%'";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        if(empty($row)) {
            $format_serial = str_replace('XXXX', str_pad('1', 4, '0', STR_PAD_LEFT), $format_serial);
        }else {
            $last_batch = (int)substr($row['last_batch'], strlen($row['last_batch'])-4 + 1 );
            $format_serial = str_replace('XXXX', str_pad( ($last_batch+1), 4, '0', STR_PAD_LEFT), $format_serial);
        }


        return $format_serial;
    }

}

/* End of file Groups.php */