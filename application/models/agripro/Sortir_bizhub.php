<?php

/**
 * Sortir Bizhub Model
 *
 */
class Sortir_bizhub extends Abstract_model {

    public $table           = "sortir_bizhub";
    public $pkey            = "sortir_bizhub_id";
    public $alias           = "sr";

    public $fields          = array(
                                'sortir_bizhub_id'  => array('pkey' => true, 'type' => 'int', 'nullable' => false, 'unique' => true, 'display' => 'ID Sortir'),
                                'product_id'        => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Product ID'),
                                'in_biz_det_id'     => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Bizhub Detail ID'),
                                'production_bizhub_id' => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Production ID'),

                                'sortir_bizhub_tgl'      => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Tanggal'),
                                'sortir_bizhub_qty'      => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'QTY')
                            );

    public $selectClause    = "sr.sortir_bizhub_id, sr.product_id, sr.in_biz_det_id, sr.production_bizhub_id, sr.sortir_bizhub_tgl, sr.sortir_bizhub_qty,
								sm.packing_batch_number, sm.qty_source, sm.qty_rescale, sm.qty_bruto, sm.qty_netto, pr.product_name, pr.product_code, production_bizhub.production_bizhub_code";
    public $fromClause      = "sortir_bizhub sr
								left join incoming_bizhub_detail sm on sr.in_biz_det_id = sm.in_biz_det_id
                                left join production_bizhub on sr.production_bizhub_id = production_bizhub.production_bizhub_id
								left join product pr on sr.product_id = pr.product_id
								";

    public $refs            = array("sortir_bizhub_detail"=>"sortir_bizhub_id");

    function __construct() {
        parent::__construct();
    }

    function validate() {
        $ci =& get_instance();
        $userdata = $ci->ion_auth->user()->row();

        if($this->actionType == 'CREATE') {
            //do something
            // example :
            $this->record['sortir_bizhub_tgl'] = date('Y-m-d');

        }else {
            //do something
            //example:
            $this->record['sortir_bizhub_tgl'] = date('Y-m-d');
            //if false please throw new Exception
        }
        return true;
    }

    function is_packing($sm_id){

        $sql = " SELECT COUNT(*) total
                        from packing_bizhub_detail
                            where sortir_bizhub_det_id = $sm_id";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        $query->free_result();

        return $row['total'];
    }

}

/* End of file Groups.php */