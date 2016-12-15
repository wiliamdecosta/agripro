<?php

/**
 * Shipping Model
 *
 */
class Shipping extends Abstract_model {

    public $table           = "shipping";
    public $pkey            = "shipping_id";
    public $alias           = "ship";

    public $fields          = array(
                                'shipping_id'           => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ID Packaging'),
                                'shipping_date'         => array('nullable' => false, 'type' => 'date', 'unique' => false, 'display' => 'Shipping Date'),
                                'shipping_driver_name'  => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Driver Name'),
                                'shipping_notes'        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Notes'),
                                'shipping_police_no'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'No Police'),
                                'shipping_license'      => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'License File'),

                                'created_date'          => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updated_date'          => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'updated_by'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );


    public $selectClause    = "ship.shipping_id, to_char(ship.shipping_date,'yyyy-mm-dd') as shipping_date,
                                ship.shipping_driver_name, ship.shipping_notes,
                                ship.shipping_police_no, ship.shipping_license, ship.shipping_license as shipping_license_view,
                                (select wh_name from warehouse 
                                    where wh_id = (select distinct warehouse_id from packing
                                                        where packing_id in (select packing_id 
                                                                                from shipping_detail 
                                                                                    where shipping_id = ship.shipping_id) 
                                )) wh_name ";
    public $fromClause      = "shipping as ship";

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

    function removeShipping($shipping_id) {

        $ci = & get_instance();

        $ci->load->model('agripro/stock');
        $tStock = $ci->stock;

        $ci->load->model('agripro/shipping_detail');
        $tShippingDetail = $ci->shipping_detail;

        $tShippingDetail->setCriteria('shipdet.shipping_id = '.$shipping_id);
        $details = $tShippingDetail->getAll();

        foreach($details as $shipping_detail) {
            $tShippingDetail->removeItems($shipping_detail['shipdet_id']);
        }

        $this->removeShippingCost($shipping_id);
        $this->remove($shipping_id);
    }

    function removeShippingCost($shipping_id) {
        $sql = "delete from shipping_cost where shipping_id = ?";
        $this->db->query($sql, array($shipping_id));
        return true;
    }

    function getTotalCost($shipping_id) {
        $sql = "select sum(shipping_cost_value) as total
                    from shipping_cost
                    where shipping_id = ?";

        $query = $this->db->query($sql, array($shipping_id));
        $row = $query->row_array();

        return $row['total'];
    }

    function getAllItems() {
        $items = $this->getAll();

        for($record = 0; $record < count($items); $record++) {
            $items[$record]['shipping_cost'] = $this->getTotalCost($items[$record][$this->pkey]);
        }
        return $items;
    }

}
/* End of file Shipping.php */