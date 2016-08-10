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
                                'sortir_id'  => array('pkey' => true, 'type' => 'int', 'nullable' => false, 'unique' => true, 'display' => 'ID Sortir'),
                                'product_id'       => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Product ID'),
                                'sm_id'      => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Stock Material ID'),
                                'sortir_tgl'      => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Tanggal'),
                                'sortir_qty'      => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'QTY')

                            );

    public $selectClause    = "sr.sortir_id, sr.product_id, sr.sm_id, sr.sortir_tgl, sr.sortir_qty, 
								sm.sm_no_trans, sm.sm_qty_bersih, pr.product_id, pr.product_name, pr.product_code";
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
	
	function get_availableqty($sm_id){
		
		$sql = "SELECT (select sm_qty_bersih from stock_material where sm_id = $sm_id ) - COALESCE (sum(sortir_qty),0) as avaqty from sortir where sm_id = $sm_id ";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        $query->free_result();
		
        return floatval($row['avaqty']);
			
	}
	
	function list_product($sm_id){
			
        $sql = "SELECT * FROM product WHERE parent_id = (select product_id from stock_material where sm_id = $sm_id) 
				UNION ALL
				SELECT * FROM product WHERE product_code IN ('LOST') ";
        $q = $this->db->query($sql);
        return $q->result_array();
		
    }
}

/* End of file Groups.php */