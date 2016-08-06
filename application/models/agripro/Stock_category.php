<?php

/**
 * Stock_category Model
 *
 */
class Stock_category extends Abstract_model {

    public $table           = "stock_category";
    public $pkey            = "sc_id";
    public $alias           = "";

    public $fields          = array(
                                'sc_id'             => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ID Stock Category'),
                                'sc_code'           => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'Code'),
                                'sc_description'    => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Description'),
                            );

    public $selectClause    = "sc.*";
    public $fromClause      = "stock_category as sc";

    public $refs            = array('stock' => 'sc_id');

    function __construct() {
        parent::__construct();
    }

    function validate() {
        $ci =& get_instance();
        $userdata = $ci->ion_auth->user()->row();

        if($this->actionType == 'CREATE') {
            //do something
            // example :

        }else {
            //do something
            //example:
            //if false please throw new Exception
        }
        return true;
    }

}

/* End of file Groups.php */