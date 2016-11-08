<?php

/**
 * Raw Material Model
 *
 */
class Sortir_bizhub_detail extends Abstract_model {

    public $table           = "sortir_bizhub_detail";
    public $pkey            = "sortir_bizhub_det_id";
    public $alias           = "sort_det";

    public $fields          = array(
                                'sortir_bizhub_det_id'   => array('pkey' => true, 'type' => 'int', 'nullable' => false, 'unique' => true, 'display' => 'ID Sortir'),
                                'product_id'             => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Product ID'),
                                'sortir_bizhub_id'       => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Sortir ID'),
                                'sortir_bizhub_det_qty'  => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'QTY')
                            );

    public $selectClause    = "sort_det.sortir_bizhub_det_id, sort_det.sortir_bizhub_id, sort_det.product_id, sort_det.sortir_bizhub_det_qty,
                                sr.sortir_bizhub_tgl,
                                pr.product_name, pr.product_code";
    public $fromClause      = " sortir_bizhub_detail as sort_det
                                left join sortir_bizhub sr on sort_det.sortir_bizhub_id = sr.sortir_bizhub_id
							    left join product pr on sort_det.product_id = pr.product_id
								";

    public $refs            = array("packing_bizhub_detail" => "sortir_bizhub_det_id");

    function __construct() {
        parent::__construct();
    }

    function validate() {
        $ci =& get_instance();
        $userdata = $ci->ion_auth->user()->row();

        if($this->actionType == 'CREATE') {
            //do something
            // example :
            $this->record[$this->pkey] = $this->generate_id($this->table,$this->pkey);
        }else {
            //do something
            //example:
            //if false please throw new Exception
        }
        return true;
    }

}

/* End of file Groups.php */