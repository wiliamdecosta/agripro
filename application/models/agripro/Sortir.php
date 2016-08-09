<?php

/**
 * Raw Material Model
 *
 */
class Sortir extends Abstract_model {

    public $table           = "sortir";
    public $pkey            = "sortir_id";
    public $alias           = "sr";

    public $fields          = array(
                                'sortir_id'        => array('pkey' => true, 'type' => 'int', 'nullable' => false, 'unique' => true, 'display' => 'ID Sortir'),
                                'product_id'       => array('nullable' => false, 'type' => 'int', 'unique' => true, 'display' => 'Product ID'),
                                'sm_id'      => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'Stock Material ID'),
                                'sortir_tgl'      => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'Tanggal'),
                                'sortir_qty'      => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'QTY')

                            );

    public $selectClause    = "sr.sortir_id, sr.product_id, sr.sm_id, sr.sortir_tgl, sr.sortir_qty, sm.sm_no_trans, pr.product_name, pr.product_code ";
    public $fromClause      = "sortir sr
								JOIN stock_material sm ON sr.sm_id = sm.sm_id
								JOIN product pr ON sr.product_id = pr.product_id 
								
								";

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
            $this->record['sortir_tgl'] = date('Y-m-d');

        }else {
            //do something
            //example:
            $this->record['sortir_tgl'] = date('Y-m-d');
            //if false please throw new Exception
        }
        return true;
    }


}

/* End of file Groups.php */