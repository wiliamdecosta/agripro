<?php

/**
 * Shipping Model
 *
 */
class Shipping_bizhub extends Abstract_model {

    public $table           = "shipping_bizhub";
    public $pkey            = "shipping_bizhub_id";
    public $alias           = "ship";

    public $fields          = array(
                                'shipping_bizhub_id'           => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ID Packaging'),
                                'shipping_bizhub_date'         => array('nullable' => false, 'type' => 'date', 'unique' => false, 'display' => 'Shipping Date'),
                                'shipping_bizhub_no'  => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Shipping Number'),
                                'shipping_bizhub_notes'        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Notes'),

                                'created_date'          => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updated_date'          => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'updated_by'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),
                            );


    public $selectClause    = "ship.shipping_bizhub_id, to_char(ship.shipping_bizhub_date,'yyyy-mm-dd') as shipping_bizhub_date, ship.shipping_bizhub_no, ship.shipping_bizhub_notes";
    public $fromClause      = "shipping_bizhub as ship";

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

    function removeShipping($shipping_bizhub_id) {

        $ci = & get_instance();

        $ci->load->model('agripro/stock');
        $tStock = $ci->stock;

        $ci->load->model('agripro/shipping_bizhub_detail');
        $tShippingDetail = $ci->shipping_bizhub_detail;

        $tShippingDetail->setCriteria('shipdet.shipping_bizhub_id = '.$shipping_bizhub_id);
        $details = $tShippingDetail->getAll();

        foreach($details as $shipping_detail) {
            $tShippingDetail->removeItems($shipping_detail['shipdet_bizhub_id']);
        }

        $this->remove($shipping_bizhub_id);
    }

    function getAllItems() {
        $items = $this->getAll();
        return $items;
    }

}
/* End of file Shipping.php */