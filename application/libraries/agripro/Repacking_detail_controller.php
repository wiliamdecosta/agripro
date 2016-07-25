<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Repacking_detail_controller
* @version 07/05/2015 12:18:00
*/
class Repacking_detail_controller {

    function read() {

        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('sidx','str','rd');
        $sord = getVarClean('sord','str','asc');

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        try {

            $data['page'] = 1;
            $data['total'] = 1;
            $data['records'] = 3;

            $data['rows'] = array(
                ['rd' => 1, 'rd_batch_number' => 1, 'rd_berat' => 25, 'rd_serial_number' => 'RP/WH-001/FM001/20160724/0001','created_date' => date('Y-m-d'), 'created_by' => 'admin', 'updated_date' => date('Y-m-d'), 'updated_by' => 'admin'],
                ['rd' => 2, 'rd_batch_number' => 2, 'rd_berat' => 25, 'rd_serial_number' => 'RP/WH-001/FM001/20160724/0002','created_date' => date('Y-m-d'), 'created_by' => 'admin', 'updated_date' => date('Y-m-d'), 'updated_by' => 'admin'],
            );
            $data['success'] = true;

        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }

        return $data;
    }

    function crud() {

        $data = array();
        $oper = getVarClean('oper', 'str', '');
        switch ($oper) {
            case 'add' :
                permission_check('add-repacking');
                $data = $this->create();
            break;

            case 'edit' :
                permission_check('edit-repacking');
                $data = $this->update();
            break;

            case 'del' :
                permission_check('delete-repacking');
                $data = $this->destroy();
            break;

            default :
                permission_check('view-repacking');
                $data = $this->read();
            break;
        }

        return $data;
    }

}

/* End of file Warehouse_controller.php */