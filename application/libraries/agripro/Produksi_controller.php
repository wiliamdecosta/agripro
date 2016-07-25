<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Produksi_controller
* @version 07/05/2015 12:18:00
*/
class Produksi_controller {

    function read() {

        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('sidx','str','repacking_id');
        $sord = getVarClean('sord','str','asc');

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        try {

            $data['page'] = 1;
            $data['total'] = 1;
            $data['records'] = 1;

            $data['rows'] = array(
                ['repacking_id' => 1, 'repacking_jenis_barang' => 'STICK', 'repacking_jml_batch' => 2, 'repacking_berat_total' => 50,'repacking_tgl' => date('Y-m-d'), 'repacking_serial_number' => 'RM/20160720/FM001/0001', 'created_date' => date('Y-m-d'), 'created_by' => 'admin', 'updated_date' => date('Y-m-d'), 'updated_by' => 'admin']
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