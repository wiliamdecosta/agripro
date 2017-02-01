<?php

/**
 * Product Model
 *
 */
class Product_planning extends Abstract_model
{

    public $table = "product_planning";
    public $pkey = "product_planning_id";
    public $alias = "pp";

    public $fields = array(
        'product_planning_id' => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'Product Planning Id'),
        'product_id' => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Product ID'),
        'product_code' => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Product Code'),
        'product_name' => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Name'),
        'product_description' => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Description'),
        'weight' => array('nullable' => true, 'type' => 'float', 'unique' => false, 'display' => 'Weight')

    );

    public $selectClause = "pp.product_planning_id, pp.planning_id, pp.weight, prod.product_id, prod.parent_id,prod.product_name,prod.product_description,prod.product_category_id,
                               prod.product_code ";
    public $fromClause = "product_planning pp 
                          INNER JOIN product prod ON pp.product_id = prod.product_id ";

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
            //do something
            // example :
            /* $this->record['created_date'] = date('Y-m-d');
             $this->record['created_by'] = $userdata->username;
             $this->record['updated_date'] = date('Y-m-d');
             $this->record['updated_by'] = $userdata->username;*/
            if ($this->record['parent_id'] == '')
                $this->record['parent_id'] = null;
        } else {
            //do something
            //example:
            /* $this->record['updated_date'] = date('Y-m-d');
             $this->record['updated_by'] = $userdata->username;*/
            //if false please throw new Exception
        }
        return true;
    }

}

/* End of file Groups.php */