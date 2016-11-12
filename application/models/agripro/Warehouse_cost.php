<?php

/**
 * Warehouse_cost Model
 *
 */
class Warehouse_cost extends Abstract_model {

    public $table           = "warehouse_cost";
    public $pkey            = "whcost_id";
    public $alias           = "whcost";

    public $fields          = array(
                                'whcost_id'             => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ID WHCost'),
                                'warehouse_id'          => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'ID Warehouse'),
                                'whcost_description'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Description'),
                                'whcost_start_date'     => array('nullable' => false, 'type' => 'date', 'unique' => false, 'display' => 'Start Date'),
                                'whcost_end_date'       => array('nullable' => false, 'type' => 'date', 'unique' => false, 'display' => 'End Date'),
                                'created_date'          => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updated_date'          => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'updated_by'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By')
                            );

    public $selectClause    = "whcost.whcost_id, whcost.warehouse_id, whcost.whcost_description,
                             to_char(whcost.whcost_start_date,'yyyy-mm-dd') as whcost_start_date,
                             to_char(whcost.whcost_end_date,'yyyy-mm-dd') as whcost_end_date,
                             warehouse.wh_code, warehouse.wh_name";
    public $fromClause      = "warehouse_cost whcost
                                left join warehouse on whcost.warehouse_id = warehouse.wh_id";

    public $refs            = array('warehouse_cost_detail' => 'whcost_id');

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

        }else {
            //do something
            //example:
            $this->record['updated_date'] = date('Y-m-d');
            $this->record['updated_by'] = $userdata->username;
            //if false please throw new Exception
        }
        return true;
    }

    function removeWarehouseCost($whcost_id) {
        $ci = & get_instance();
        $ci->load->model('agripro/warehouse_cost_detail');
        $tDetail = $ci->warehouse_cost_detail;

        $tDetail->setCriteria('whcost_det.whcost_id = '.$whcost_id);
        $details = $tDetail->getAll(0,-1);
        foreach($details as $detail) {
            $tDetail->remove($detail[$tDetail->pkey]);
        }
        $this->remove($whcost_id);
    }

    function getStockMaterialValue($start_date, $end_date) {
        $sql = "select sum(sm_harga_total) as total from stock_material
                    where sm_tgl_masuk between ? and ?";

        $query = $this->db->query($sql, array($start_date, $end_date));
        $item = $query->row_array();

        return $item['total'];
    }

    function getAllItems($start, $limit, $sidx, $sord) {
        $items = $this->getAll($start, $limit, $sidx, $sord);
        for($rec = 0; $rec < count($items); $rec++) {
            $items[$rec]['total_cost'] = $this->getTotalCost($items[$rec][$this->pkey]);
        }
        return $items;
    }

    function getTotalCost($whcost_id) {
        $sql = "select sum(whcost_det_value) as total_cost from warehouse_cost_detail
                    where whcost_id = ?";

        $query = $this->db->query($sql, array($whcost_id));
        $item = $query->row_array();

        return $item['total_cost'];
    }
}

/* End of file Groups.php */