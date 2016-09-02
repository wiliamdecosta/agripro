<?php

/**
 * Raw Material Model
 *
 */
class Sortir_detail extends Abstract_model {

    public $table           = "sortir_detail";
    public $pkey            = "sortir_detail_id";
    public $alias           = "sort_det";

    public $fields          = array(
                                'sortir_detail_id'       => array('pkey' => true, 'type' => 'int', 'nullable' => false, 'unique' => true, 'display' => 'ID Sortir'),
                                'product_id'             => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Product ID'),
                                'sortir_id'              => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Sortir ID'),
                                'sortir_detail_qty'      => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'QTY')
                            );

    public $selectClause    = "sort_det.sortir_detail_id, sort_det.sortir_id, sort_det.product_id, sort_det.sortir_detail_qty,
                                sr.sortir_tgl, fm.fm_code, fm.fm_name,
                                pr.product_name, pr.product_code";
    public $fromClause      = " sortir_detail as sort_det
                                left join sortir sr on sort_det.sortir_id = sr.sortir_id
								left join stock_material sm on sr.sm_id = sm.sm_id
								left join product pr on sort_det.product_id = pr.product_id
								left join farmer fm on sm.fm_id = fm.fm_id
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

        }else {
            //do something
            //example:
            //if false please throw new Exception
        }
        return true;
    }

}

/* End of file Groups.php */