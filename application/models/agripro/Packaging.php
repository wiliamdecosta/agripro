<?php

/**
 * Raw Material Model
 *
 */
class Packaging extends Abstract_model {

    public $table           = "packaging";
    public $pkey            = "pkg_id";
    public $alias           = "pkg";

    public $fields          = array(
                                'pkg_id' => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ID Packaging'),
                                'prod_id' => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'Kode Produk'),
                                'pkg_date' => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Tanggal Packaging'),
                                'pkg_serial_number'  => array('nullable' => true, 'type' => 'str', 'unique' => true, 'display' => 'Serial Number'),
                                'pkg_batch_number'   => array('nullable' => true, 'type' => 'str', 'unique' => true, 'display' => 'Batch Number'),
                                'created_date'      => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updated_date'      => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'updated_by'        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );


    public $selectClause    = "pkg.pkg_id, pkg.prod_id, b.prod_code prod_code, to_char(pkg.pkg_date,'yyyy-mm-dd') as pkg_date, pkg.pkg_serial_number, pkg. pkg_batch_number, 
                                to_char(pkg.created_date,'yyyy-mm-dd') as created_date, pkg.created_by,
                                    to_char(pkg.updated_date,'yyyy-mm-dd') as updated_date, pkg.updated_by";
    public $fromClause      = " packaging pkg  
                                left join product b
                                on pkg.prod_id = b.prod_id
                                ";

    public $refs            = array('detail_packaging' => 'pkg_id');

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
            $this->record['pkg_serial_number'] = $this->getSerialNumber();
            $this->record['pkg_batch_number'] = $this->getBatchNumber($this->record['pkg_serial_number'] );
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

        $format_serial = 'ATN-PRDCODE-DATE-XXXX';

        $sql = "select substr(pkg_serial_number, length(pkg_serial_number)-4 + 1 )::integer as total from packaging
                    where to_char(created_date,'yyyymmdd') = '".str_replace('-','',$this->record['created_date'])."'";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        if(empty($row)) {
            $row = array('total' => 0);
        }

        $format_serial = str_replace('XXXX', str_pad(($row['total']+1), 4, '0', STR_PAD_LEFT), $format_serial);
        $format_serial = str_replace('DATE', str_replace('-','',$this->record['created_date']), $format_serial);

        $ci = & get_instance();
        $ci->load->model('agripro/product');
        $tFarmer = $ci->product;

        $itemfarmer = $tFarmer->get( $this->record['prod_id'] );
        $format_serial = str_replace('PRDCODE', $itemfarmer['prod_code'], $format_serial);

        return $format_serial;
    }

    function getBatchNumber($serial) {

       $format_serial = $serial . "/" .str_pad(substr($serial, -1,1), 4, '0', STR_PAD_LEFT);
        return $format_serial;

    }

}
/* End of file Groups.php */