<?php

/**
 * Raw Material Model
 *
 */
class Production_planning extends Abstract_model
{

    public $table = "production_planning";
    public $pkey = "planning_id";
    public $alias = "a";

    public $fields = array(
        'planning_id' => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'Planning ID'),
        'po_number' => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'PO Number'),
        'client_name' => array('nullable' => true, 'type' => 'str', 'unique' => true, 'display' => 'Client'),
        'planning_start_date' => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Due Date'),
        'planning_end_date' => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'End Date'),
        'planning_qty_init' => array('nullable' => true, 'type' => 'float', 'unique' => false, 'display' => 'QTY Init'),
        'planning_qty' => array('nullable' => true, 'type' => 'float', 'unique' => false, 'display' => 'QTY'),
        'sending_type' => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Send Type'),
        'planning_status' => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Status'),
        'basis_prepare_date' => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Basis Prepare Date'),
        'basis_prepare_qty_init' => array('nullable' => true, 'type' => 'float', 'unique' => false, 'display' => 'Basis Prepare QTY Init'),
        'basis_prepare_qty' => array('nullable' => true, 'type' => 'float', 'unique' => false, 'display' => 'Basis Prepare QTY'),
        'basis_real_qty' => array('nullable' => true, 'type' => 'float', 'unique' => false, 'display' => 'Basis Real QTY'),
        'basis_real_arrived' => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Basis Real Arrived'),
        'prod_prepare_date' => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Production Prepare Date'),
        'prod_prepare_qty' => array('nullable' => true, 'type' => 'float', 'unique' => false, 'display' => 'Production Prepare QTY'),
        'prep_performa_inv' => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Performa Inv'),
        'planning_shipping_start_date' => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Shipping Date Period From'),
        'planning_shipping_end_date' => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Shipping Date Period to'),
        'vessel_feeder_name' => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Vessel Feeder Name'),
        'stuffing_date' => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Stuffing Date'),
        'loading_date' => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Loading Date'),

        'created_date' => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
        'created_by' => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
        'updated_date' => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
        'updated_by' => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By')
    );


    public $selectClause = "a.* ";
    public $fromClause = "production_planning a";

    public $refs = array();

    function __construct()
    {
        parent::__construct();
    }

    function validate()
    {
        $ci =& get_instance();
        $userdata = $ci->ion_auth->user()->row();

        if ($this->actionType == 'CREATE') {

            $this->record['created_date'] = date('Y-m-d');
            $this->record['created_by'] = $userdata->username;
            $this->record['updated_date'] = date('Y-m-d');
            $this->record['updated_by'] = $userdata->username;

            /*if(empty($this->record['planning_start_date'])) {
                unset($this->record['planning_start_date']);
            }

            if(empty($this->record['planning_end_date'])) {
                unset($this->record['planning_end_date']);
            }

            if(empty($this->record['basis_prepare_date'])) {
                unset($this->record['basis_prepare_date']);
            }

            if(empty($this->record['basis_real_arrived'])) {
                unset($this->record['basis_real_arrived']);
            }

            if(empty($this->record['prod_prepare_date'])) {
                unset($this->record['prod_prepare_date']);
            }

            if(empty($this->record['shipping_start_date'])) {
                unset($this->record['shipping_start_date']);
            }

            if(empty($this->record['shipping_end_date'])) {
                unset($this->record['shipping_end_date']);
            }

            if(empty($this->record['stuffing_date'])) {
                unset($this->record['stuffing_date']);
            }

            if(empty($this->record['loading_date'])) {
                unset($this->record['loading_date']);
            }*/


        } else {
            //do something
            //example:
            $this->record['updated_date'] = date('Y-m-d');
            $this->record['updated_by'] = $userdata->username;
            //if false please throw new Exception
        }
        return true;
    }


    function insertProductPlanning($prod)
    {

        foreach ($prod as $production_detail) {
            $this->db->insert('product_planning',
                array('planning_id' => $production_detail['planning_id'],
                    'product_id' => $production_detail['product_id'],
                    'weight' => $production_detail['weight']
                )
            );
        }
    }


}
/* End of file Groups.php */