<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Raw_material_controller extends CI_Controller
{

    function __construct() {
        parent::__construct();

    }

    public function listRawMaterial()
    {
        $this->load->model('agripro/raw_material','raw_material');
        $result = $this->raw_material->getListRawMaterial();
        echo "<select>";
        foreach ($result as $value) {
            echo "<option value=" . $value['product_id'] . ">" . strtoupper($value['product_code']) . "</option>";
        }
        echo "</select>";
    }


}