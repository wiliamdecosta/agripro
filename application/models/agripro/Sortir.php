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
                                'sortir_id'     => array('pkey' => true, 'type' => 'int', 'nullable' => false, 'unique' => true, 'display' => 'ID Sortir'),
                                'product_id'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Product ID'),
                                'sm_id'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Stock Material ID'),
                                'production_id' => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Production ID'),

                                'sortir_tgl'      => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Tanggal'),
                                'sortir_qty'      => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'QTY')

                            );

    public $selectClause    = "sr.sortir_id, sr.product_id, sr.sm_id, sr.sortir_tgl, sr.sortir_qty, fm.fm_code, fm.fm_name,
								sm.sm_no_trans, sm.sm_qty_bersih, pr.product_id, pr.product_name, pr.product_code";
    public $fromClause      = "sortir sr
								left join stock_material sm on sr.sm_id = sm.sm_id
								left join product pr on sr.product_id = pr.product_id
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

		$sql = "SELECT (select sm_qty_bersih from stock_material where sm_id = $sm_id ) -
						COALESCE (sum(sortir_qty),0) as avaqty, COALESCE (sum(sortir_qty),0) as srtqty ,
						COALESCE((select sm_qty_bersih from stock_material where sm_id = $sm_id ),0) qty_bersih,
						(select sm_tgl_produksi from stock_material where sm_id = $sm_id ) tgl_prod
						from sortir where sm_id = $sm_id ";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        $query->free_result();

        return floatval($row['avaqty']) .'|'. floatval($row['srtqty']).'|'. floatval($row['qty_bersih']).'|'. $row['tgl_prod'];

	}


	function list_product($sm_id){

        $sql = "
				SELECT *
				FROM (
						SELECT *
							FROM product
								WHERE parent_id = (	select  coalesce(parent_id,product_id)
														from product
															where product_id = (select product_id
																					from stock_material
																					where sm_id = $sm_id)
															)
						UNION ALL
						SELECT *
							FROM product
								WHERE product_code IN ('LOST')
						) as a
					WHERE a.product_id not in (select distinct product_id
														from sortir
															where sm_id = $sm_id )
				";
        $q = $this->db->query($sql);
        return $q->result_array();

    }

	function upd_tgl_prod($sm_id,$tgl_prod){

        $sql = " UPDATE stock_material
					set sm_tgl_produksi = to_date('".$tgl_prod."','yyyy-mm-dd')
					where sm_id = $sm_id
		";
        $q = $this->db->query($sql);

    }

}

/* End of file Groups.php */