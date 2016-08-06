<?php

/**
 * Product Model
 *
 */
class Category extends Abstract_model {

    public $table           = "category";
    public $pkey            = "category_id";
    public $alias           = "cat";

    public $fields          = array(
                            'category_id'   => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'Category Id'),'category_name' => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Category'),
                            'category_name' => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Name'),
                            'category_description' => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Description')
                            );

    public $selectClause    = "cat.category_id, cat.category_name, cat.category_description ";
    public $fromClause      = "category cat ";


    function __construct() {
        parent::__construct();
    }

    function validate() {
        $ci =& get_instance();
        $userdata = $ci->ion_auth->user()->row();

        if($this->actionType == 'CREATE') {
            //do something
            // example :
           /* $this->record['created_date'] = date('Y-m-d');
            $this->record['created_by'] = $userdata->username;
            $this->record['updated_date'] = date('Y-m-d');
            $this->record['updated_by'] = $userdata->username;*/

        }else {
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