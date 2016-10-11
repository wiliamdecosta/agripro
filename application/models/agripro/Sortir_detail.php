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

    public $refs            = array("packing_detail" => "sortir_detail_id");

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
    
    function get_sortir_id($par){
        
        $sql = " Select distinct sortir_id from sortir_detail where  ";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        $query->free_result();

        return floatval($row['avaqty']) .'|'. floatval($row['srtqty']).'|'. floatval($row['qty_bersih']).'|'. $row['tgl_prod'];
        
        }
        
    function insert_stock_del($type, $sortir_id){
        $ci =& get_instance();
        $userdata = $ci->ion_auth->user()->row();
        
        if($type == 'sm_id'){
            
                $table = 'stock_material';
                $desc = 'Raw Material Selection Stock';
                $wh  = 'wh_id';
            }else{
                $table = 'production';
                $desc = 'Production Selection Stock';
                $wh  = 'warehouse_id';
                }
        
             $sql = " 
                DELETE FROM stock 
                    where stock_ref_id  = $sortir_id
                and stock_ref_code = 'SORTIR'
                and sc_id = 5 
                and stock_description = '".$desc."' ";
                            
            $query = $this->db->query($sql);
        
        }
    function insert_stock2($type, $sortir_id){
        $ci =& get_instance();
        $userdata = $ci->ion_auth->user()->row();
        
        if($type == 'sm_id'){
            
                $table = 'stock_material';
                $desc = 'Raw Material Selection Stock';
                $wh  = 'wh_id';
            }else{
                $table = 'production';
                $desc = 'Production Selection Stock';
                $wh  = 'warehouse_id';
                }
        
             $sql = " 
                DELETE FROM stock 
                    where stock_ref_id in (select distinct sortir_detail_id from sortir_detail where sortir_id = $sortir_id) 
                and stock_ref_code = 'SORTIR'
                and sc_id = 5 
                and stock_description = '".$desc."' ";
                            
            $query = $this->db->query($sql);
        
        
         $sql = " 
         
                insert into stock (   stock_id,
                                      wh_id,
                                      product_id,
                                      sc_id,
                                      stock_tgl_masuk,
                                      stock_kg,
                                      stock_ref_id,
                                      stock_ref_code,
                                      stock_description,
                                      created_date,
                                      created_by)
                                     SELECT nextval('stock_stock_id_seq'), 
                                            c.$wh,  
                                            a.product_id,
                                            5,
                                            current_date, 
                                            a.sortir_detail_qty,
                                            a.sortir_detail_id,
                                            'SORTIR',
                                            '".$desc."',
                                            current_date, 
                                            '".$userdata->username."'
                                            from sortir_detail a 
                                                 join sortir b on a.sortir_id = b.sortir_id
                                                 join $table c on b.$type = c.$type
                                            where a.sortir_id in (select distinct sortir_detail_id from sortir where sortir_id = $sortir_id) 
                                            ";
                            
        $query = $this->db->query($sql);
        
        
        }
    function get_sm_id($sortir_id){
    
        $sql = " SELECT distinct sm_id from sortir where sortir_id = $sortir_id ";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        $query->free_result();
        
        return $row['sm_id'];
    }
    
    function insertStock($sortir_detail) {
        $ci = & get_instance();

        $ci->load->model('agripro/stock');
        $tStock = $ci->stock;
        $tStock->actionType = 'CREATE';

        $ci->load->model('agripro/stock_category');
        $tStockCategory = $ci->stock_category;

        $ci->load->model('agripro/packing_detail');
        $tPackingDetail = $ci->packing_detail;
        
        $ci->load->model('agripro/sortir');
        $srt = $ci->sortir;
        
        $ci->load->model('agripro/stock_material');
        $tsm = $ci->stock_material;
        /**
         * Steps :
         * 1. Insert master to Stock as PACKING_STOCK category (IN STOCK - PACKING)
         * 2. Insert detail to Stock as SORTIR_STOCK category (OUT STOCK - SORTIR)
         * 3. Decrease Sortir Weight by Detail packing weight
        
         *  Steps sortir :
         * 1. Insert master to Stock as SORTIR_STOCK category (IN STOCK SORTIR)
         * 2. Insert detail to Stock as SORTIR_STOCK category (OUT STOCK - SORTIR)
         * 3. Decrease Sortir Weight by Detail packing weight
         */
         
         /**
         * Step 1 - Insert master to stock as SORTIR_STOCK (IN STOCK - stock_tgl_masuk)
         * Step 2 - Insert master to stock 
         */
         
        $sm_id = $this->get_sm_id($sortir_detail['sortir_id']);
        
        $srt->setCriteria('sortir_id = '.$sortir_detail['sortir_id']);
        $datasrt = $srt->getAll();
        
        $tsm->setCriteria('sm.sm_id = '.$sm_id);
        $datatsm = $tsm->getAll();
        foreach($datatsm as $datatsms) {
            $whid = $datatsms['wh_id'];
            }
        foreach($datasrt as $datasrts) {
            $sdate = $datasrts['sortir_tgl'];
            }
        $record_stock = array();
        $stock_date = $sdate; //$datasrt['sortir_tgl'];
        $record_stock['stock_tgl_masuk'] = $stock_date; //base on sorting_date
        $record_stock['stock_kg'] = $sortir_detail['sortir_detail_qty'];
        $record_stock['stock_ref_id'] = $sortir_detail['sortir_detail_id'];
        $record_stock['stock_ref_code'] = 'SORTIR_STOCK';
        $record_stock['sc_id'] = $tStockCategory->getIDByCode('SORTIR_STOCK');
        $record_stock['wh_id'] = $whid;
        $record_stock['product_id'] = $sortir_detail['product_id'];
        $tStock->setRecord($record_stock);
        $tStock->create();

         /**  
        $sm_id = $this->get_sm_id($sortir_detail['sortir_id']);
        
        $srt->setCriteria('sortir_id = '.$sortir_detail['sortir_id']);
        $datasrt = $srt->getAll();
        
        $tsm->setCriteria('sm.sm_id = '.$sm_id);
        $details = $tsm->getAll();
      
        foreach($details as $datatsm) {
            $record_stock = array();
            $record_stock['stock_tgl_masuk'] = $srt['sortir_date']; //base on packing_tgl
            $record_stock['stock_kg'] = $sortir_detail['sortir_detail_qty'];
            $record_stock['stock_ref_id'] = $sortir_detail['sortir_detail_id']; //sortir_detail id become reference on stock
            $record_stock['stock_ref_code'] = 'SORTIR_PACKING';
            $record_stock['sc_id'] = $tStockCategory->getIDByCode('SORTIR_STOCK');
            $record_stock['wh_id'] = $datatsm['wh_id'];
            $record_stock['product_id'] = $sortir_detail['product_id'];
            $record_stock['stock_description'] = 'Selection Stock';
            $tStock->setRecord($record_stock);
            $tStock->create();
        }


        
         * Step 1 - Insert master to stock as PACKING_STOCK (IN STOCK - stock_tgl_masuk)
         
        $record_stock = array();
        $stock_date = $packing_master['packing_tgl'];
        $record_stock['stock_tgl_masuk'] = $stock_date; //base on packing_tgl
        $record_stock['stock_kg'] = $packing_master['packing_kg'];
        $record_stock['stock_ref_id'] = $packing_master['packing_id'];
        $record_stock['stock_ref_code'] = 'PACKING';
        $record_stock['sc_id'] = $tStockCategory->getIDByCode('PACKING_STOCK');
        $record_stock['wh_id'] = $packing_master['warehouse_id'];
        $record_stock['product_id'] = $packing_master['product_id'];
        $tStock->setRecord($record_stock);
        $tStock->create();*/

       
    }


    public function removePacking($packing_id) {

        $ci = & get_instance();
        /*if ($this->isRefferenced($packing_id)){
            //if packing_id is used in shipping_detail then delete data shipping also
            $ci->load->model('agripro/shipping_detail');
            $tShippingDetail = $ci->shipping_detail;

            $tShippingDetail->removeByPackingID($packing_id);
        }*/

        $ci->load->model('agripro/stock');
        $tStock = $ci->stock;

        $ci->load->model('agripro/packing_detail');
        $tPackingDetail = $ci->packing_detail;

        $ci->load->model('agripro/sortir_detail');
        $tSortirDetail = $ci->sortir_detail;

        /**
         * Steps to Delete Packing
         *
         * 1. Remove all stock_detail first
         * 2. When loop for delete stock_detail, save data sortir in array
         * 3. Delete data packing in stock
         * 4. Loop data sortir for delete data sortir in stock and restore qty to sortir
         * 5. Delete data master packing
         */

        $data_sortir = array();
        $tPackingDetail->setCriteria('pd.packing_id = '.$packing_id);
        $details = $tPackingDetail->getAll();
        $loop = 0;
        foreach($details as $packing_detail) {
            $data_sortir[$loop]['sortir_detail_id'] = $packing_detail['sortir_detail_id'];
            $data_sortir[$loop]['restore_store_qty'] = $packing_detail['pd_kg'];
            $loop++;

            $tPackingDetail->remove($packing_detail['pd_id']);
        }

        /**
         * Delete data stock by packing_id
         */
        $tStock->deleteByReference($packing_id, 'PACKING');

        /**
         * loop for delete data stock by sortir_detail_id and restore store_qty in table sortir
         */
        foreach($data_sortir as $sortir) {
            //delete data stock by sortir_detail_id
            $tStock->deleteByReference($sortir['sortir_detail_id'], 'SORTIR_PACKING');

            //restore store qty
            $increase_kg = (float) $sortir['restore_store_qty'];
            $sql = "UPDATE sortir_detail SET sortir_detail_qty = sortir_detail_qty + ".$increase_kg."
                        WHERE sortir_detail_id = ".$sortir['sortir_detail_id'];

            $tSortirDetail->db->query($sql);

        }

        /**
         * Delete data master packing
         */
        $this->remove($packing_id);
    }
}

/* End of file Groups.php */