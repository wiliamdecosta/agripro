<?php

/**
 * Raw Material Model
 *
 */
class Packing extends Abstract_model {

    public $table           = "packing";
    public $pkey            = "packing_id";
    public $alias           = "pack";

    public $fields          = array(
                                'packing_id'            => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ID Packaging'),
                                'product_id'            => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'Product ID'),
                                'warehouse_id'          => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'Warehouse ID'),
                                'packing_batch_number'  => array('nullable' => true, 'type' => 'str', 'unique' => true, 'display' => 'Batch Number'),
                                'packing_serial'        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Serial Number'),
                                'packing_kg'            => array('nullable' => true, 'type' => 'float', 'unique' => false, 'display' => 'Kg'),
                                'packing_tgl'           => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Packing Date'),
                                'created_date'          => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updated_date'          => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'updated_by'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );


    public $selectClause    = "pack.*, prod.product_code, prod.product_name, to_char(pack.packing_tgl,'yyyy-mm-dd') as packing_tgl";
    public $fromClause      = "packing pack
                                left join product prod
                                on pack.product_id = prod.product_id";

    public $refs            = array('packing_detail' => 'packing_id');

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

            //$this->record['pkg_serial_number'] = $this->getSerialNumber();
            //$this->record['pkg_batch_number'] = $this->getBatchNumber($this->record['pkg_serial_number'] );
        }else {
            //do something
            //example:
            $this->record['updated_date'] = date('Y-m-d');
            $this->record['updated_by'] = $userdata->username;
            //if false please throw new Exception
        }
        return true;
    }

   function getBatchNumber() {

        $format_serial = 'WHKODE-PRODUCTCODE-DATE-XXXX';

        $sql = "select substr(packing_batch_number, length(packing_batch_number)-4 + 1 )::integer as total from packing
                    where to_char(packing_tgl,'yyyymmdd') = '".str_replace('-','',$this->record['packing_tgl'])."'";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        if(empty($row)) {
            $row = array('total' => 0);
        }

        $ci = & get_instance();
        $ci->load->model('agripro/warehouse');
        $tWarehouse = $ci->warehouse;

        $itemwh = $tWarehouse->get($this->record['warehouse_id']);

        $format_serial = str_replace('XXXX', str_pad(($row['total']+1), 4, '0', STR_PAD_LEFT), $format_serial);
        $format_serial = str_replace('DATE', str_replace('-','',$this->record['packing_tgl']), $format_serial);
        $format_serial = str_replace('WHKODE', $itemwh['wh_code'], $format_serial);

        $ci->load->model('agripro/product');
        $tProduct = $ci->product;

        $itemproduct = $tProduct->get( $this->record['product_id'] );
        $format_serial = str_replace('PRODUCTCODE', $itemproduct['product_code'], $format_serial);

        return array(
            'batch_number' => $format_serial,
            'serial_number' => str_pad(($row['total']+1), 4, '0', STR_PAD_LEFT)
        );
    }


}
/* End of file Groups.php */