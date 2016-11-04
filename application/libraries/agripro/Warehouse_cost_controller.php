<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Warehouse_cost_controller
* @version 07/05/2015 12:18:00
*/
class Warehouse_cost_controller {

    function read() {

        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('sidx','str','whcost_id');
        $sord = getVarClean('sord','str','asc');

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        try {

            $ci = & get_instance();
            $ci->load->model('agripro/warehouse_cost');
            $table = $ci->warehouse_cost;

            $req_param = array(
                "sort_by" => $sidx,
                "sord" => $sord,
                "limit" => null,
                "field" => null,
                "where" => null,
                "where_in" => null,
                "where_not_in" => null,
                "search" => $_REQUEST['_search'],
                "search_field" => isset($_REQUEST['searchField']) ? $_REQUEST['searchField'] : null,
                "search_operator" => isset($_REQUEST['searchOper']) ? $_REQUEST['searchOper'] : null,
                "search_str" => isset($_REQUEST['searchString']) ? $_REQUEST['searchString'] : null
            );

            // Filter Table
            $req_param['where'] = array();

            $table->setJQGridParam($req_param);
            $count = $table->countAll();

            if ($count > 0) $total_pages = ceil($count / $limit);
            else $total_pages = 1;

            if ($page > $total_pages) $page = $total_pages;
            $start = $limit * $page - ($limit); // do not put $limit*($page - 1)

            $req_param['limit'] = array(
                'start' => $start,
                'end' => $limit
            );

            $table->setJQGridParam($req_param);

            if ($page == 0) $data['page'] = 1;
            else $data['page'] = $page;

            $data['total'] = $total_pages;
            $data['records'] = $count;

            $data['rows'] = $table->getAll($start, $limit, $sidx, $sord);
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
                permission_check('add-tracking');
                $data = $this->create();
            break;

            case 'edit' :
                permission_check('edit-tracking');
                $data = $this->update();
            break;

            case 'del' :
                permission_check('delete-tracking');
                $data = $this->destroy();
            break;

            default :
                permission_check('view-tracking');
                $data = $this->read();
            break;
        }

        return $data;
    }


    function create() {

        $ci = & get_instance();
        $ci->load->model('agripro/warehouse_cost');
        $table = $ci->warehouse_cost;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $jsonItems = getVarClean('items', 'str', '');
        $items = jsonDecode($jsonItems);

        if (!is_array($items)){
            $data['message'] = 'Invalid items parameter';
            return $data;
        }

        $table->actionType = 'CREATE';
        $errors = array();

        if (isset($items[0])){
            $numItems = count($items);
            for($i=0; $i < $numItems; $i++){
                try{

                    $table->db->trans_begin(); //Begin Trans

                        $table->setRecord($items[$i]);
                        $table->create();

                    $table->db->trans_commit(); //Commit Trans

                }catch(Exception $e){

                    $table->db->trans_rollback(); //Rollback Trans
                    $errors[] = $e->getMessage();
                }
            }

            $numErrors = count($errors);
            if ($numErrors > 0){
                $data['message'] = $numErrors." from ".$numItems." record(s) failed to be saved.<br/><br/><b>System Response:</b><br/>- ".implode("<br/>- ", $errors)."";
            }else{
                $data['success'] = true;
                $data['message'] = 'Data added successfully';
            }
            $data['rows'] =$items;
        }else {

            try{
                $table->db->trans_begin(); //Begin Trans

                    $table->setRecord($items);
                    $table->create();

                $table->db->trans_commit(); //Commit Trans

                $data['success'] = true;
                $data['message'] = 'Data added successfully';

            }catch (Exception $e) {
                $table->db->trans_rollback(); //Rollback Trans

                $data['message'] = $e->getMessage();
                $data['rows'] = $items;
            }

        }
        return $data;

    }

    function update() {

        $ci = & get_instance();
        $ci->load->model('agripro/warehouse_cost');
        $table = $ci->warehouse_cost;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $jsonItems = getVarClean('items', 'str', '');
        $items = jsonDecode($jsonItems);

        if (!is_array($items)){
            $data['message'] = 'Invalid items parameter';
            return $data;
        }

        $table->actionType = 'UPDATE';

        if (isset($items[0])){
            $errors = array();
            $numItems = count($items);
            for($i=0; $i < $numItems; $i++){
                try{
                    $table->db->trans_begin(); //Begin Trans

                        $table->setRecord($items[$i]);
                        $table->update();

                    $table->db->trans_commit(); //Commit Trans

                    $items[$i] = $table->get($items[$i][$table->pkey]);
                }catch(Exception $e){
                    $table->db->trans_rollback(); //Rollback Trans

                    $errors[] = $e->getMessage();
                }
            }

            $numErrors = count($errors);
            if ($numErrors > 0){
                $data['message'] = $numErrors." from ".$numItems." record(s) failed to be saved.<br/><br/><b>System Response:</b><br/>- ".implode("<br/>- ", $errors)."";
            }else{
                $data['success'] = true;
                $data['message'] = 'Data update successfully';
            }
            $data['rows'] =$items;
        }else {

            try{
                $table->db->trans_begin(); //Begin Trans

                    $table->setRecord($items);
                    $table->update();

                $table->db->trans_commit(); //Commit Trans

                $data['success'] = true;
                $data['message'] = 'Data update successfully';

                $data['rows'] = $table->get($items[$table->pkey]);
            }catch (Exception $e) {
                $table->db->trans_rollback(); //Rollback Trans

                $data['message'] = $e->getMessage();
                $data['rows'] = $items;
            }

        }
        return $data;

    }

    function destroy() {
        $ci = & get_instance();
        $ci->load->model('agripro/warehouse_cost');
        $table = $ci->warehouse_cost;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $jsonItems = getVarClean('items', 'str', '');
        $items = jsonDecode($jsonItems);

        try{
            $table->db->trans_begin(); //Begin Trans

            $total = 0;
            if (is_array($items)){
                foreach ($items as $key => $value){
                    if (empty($value)) throw new Exception('Empty parameter');

                    $table->removeWarehouseCost($value);
                    $data['rows'][] = array($table->pkey => $value);
                    $total++;
                }
            }else{
                $items = (int) $items;
                if (empty($items)){
                    throw new Exception('Empty parameter');
                };

                $table->removeWarehouseCost($items);
                $data['rows'][] = array($table->pkey => $items);
                $data['total'] = $total = 1;
            }

            $data['success'] = true;
            $data['message'] = $total.' Data deleted successfully';

            $table->db->trans_commit(); //Commit Trans

        }catch (Exception $e) {
            $table->db->trans_rollback(); //Rollback Trans
            $data['message'] = $e->getMessage();
            $data['rows'] = array();
            $data['total'] = 0;
        }
        return $data;
    }


    function createForm() {

        $ci = & get_instance();
        $ci->load->model('agripro/warehouse_cost');
        $userdata = $ci->ion_auth->user()->row();

        $table = $ci->warehouse_cost;

        $data = array('success' => false, 'message' => '');
        $table->actionType = 'CREATE';

        /**
         * Data master
         */
        $whcost_start_date = getVarClean('whcost_start_date','str','');
        $whcost_end_date = getVarClean('whcost_end_date','str','');
        $whcost_description = getVarClean('whcost_description','str','');


        /**
         * Data details
         */
        $parameter_cost_ids = (array)$ci->input->post('parameter_cost_id');
        $whcost_det_values = (array)$ci->input->post('whcost_det_values');
        $parameter_cost_codes = (array)$ci->input->post('parameter_cost_code');

        try{

            $table->db->trans_begin(); //Begin Trans

                if(compareDate($whcost_start_date, $whcost_end_date) == 2) {
                    throw new Exception("Start Date must be lesser that End Date");
                }

                $items = array(
                    'whcost_start_date' => $whcost_start_date,
                    'whcost_end_date' => $whcost_end_date,
                    'whcost_description' => $whcost_description,
                    'warehouse_id' => $userdata->wh_id
                );

                $table->setRecord($items);
                $table->record[$table->pkey] = $table->generate_id($table->table,$table->pkey);


                $record_detail = array();
                $ci->load->model('agripro/warehouse_cost_detail');
                $tableDetail = $ci->warehouse_cost_detail;
                $tableDetail->actionType = 'CREATE';


                for($i = 0; $i < count($parameter_cost_ids); $i++) {
                    if($parameter_cost_codes[$i] != 'STOCK MATERIAL') {
                        $record_detail[] = array(
                            'whcost_id' => $table->record[$table->pkey],
                            'parameter_cost_id' => $parameter_cost_ids[$i],
                            'whcost_det_value' => $whcost_det_values[$i]
                        );
                    }else {
                        $record_detail[] = array(
                            'whcost_id' => $table->record[$table->pkey],
                            'parameter_cost_id' => $parameter_cost_ids[$i],
                            'whcost_det_value' => $table->getStockMaterialValue($whcost_start_date, $whcost_end_date)
                        );
                    }
                }

                $table->create();
                foreach($record_detail as $item_detail) {
                    $tableDetail->setRecord($item_detail);
                    $tableDetail->record[$tableDetail->pkey] = $tableDetail->generate_id($tableDetail->table,$tableDetail->pkey);
                    $tableDetail->create();
                }

            $table->db->trans_commit(); //Commit Trans

            $data['success'] = true;
            $data['message'] = 'Data added successfully';

        }catch (Exception $e) {
            $table->db->trans_rollback(); //Rollback Trans

            $data['message'] = $e->getMessage();
        }


        echo json_encode($data);
        exit;

    }

    function updateForm() {

        $ci = & get_instance();
        $ci->load->model('agripro/warehouse_cost');
        $table = $ci->warehouse_cost;

        $data = array('success' => false, 'message' => '');
        $table->actionType = 'UDATE';

        /**
         * Data master
         */
        $whcost_id = getVarClean('whcost_id','int',0);
        $whcost_start_date = getVarClean('whcost_start_date','str','');
        $whcost_end_date = getVarClean('whcost_end_date','str','');
        $whcost_description = getVarClean('whcost_description','str','');


        /**
         * Data details
         */
        $whcost_det_ids = (array)$ci->input->post('whcost_det_id');
        $parameter_cost_ids = (array)$ci->input->post('parameter_cost_id');
        $whcost_det_values = (array)$ci->input->post('whcost_det_values');
        $parameter_cost_codes = (array)$ci->input->post('parameter_cost_code');

        try{

            $table->db->trans_begin(); //Begin Trans

                if(compareDate($whcost_start_date, $whcost_end_date) == 2) {
                    throw new Exception("Start Date must be lesser that End Date");
                }

                $items = array(
                    'whcost_id' => $whcost_id,
                    'whcost_start_date' => $whcost_start_date,
                    'whcost_end_date' => $whcost_end_date,
                    'whcost_description' => $whcost_description
                );
                $table->setRecord($items);

                $record_detail = array();
                $ci->load->model('agripro/warehouse_cost_detail');
                $tableDetail = $ci->warehouse_cost_detail;
                $tableDetail->actionType = 'CREATE';

                $stockMaterialFoundCreate = false;
                $stockMaterialFoundUpdate = array();

                for($i = 0; $i < count($parameter_cost_ids); $i++) {
                    if($whcost_det_ids[$i] == "") {
                        if($parameter_cost_codes[$i] != 'STOCK MATERIAL') {
                            $record_detail[] = array(
                                'whcost_id' => $whcost_id,
                                'parameter_cost_id' => $parameter_cost_ids[$i],
                                'whcost_det_value' => $whcost_det_values[$i]
                            );
                        }else {
                            $stockMaterialFoundCreate = true;
                            $record_detail[] = array(
                                'whcost_id' => $whcost_id,
                                'parameter_cost_id' => $parameter_cost_ids[$i],
                                'whcost_det_value' => $table->getStockMaterialValue($whcost_start_date, $whcost_end_date)
                            );
                        }
                    }

                    if($whcost_det_ids[$i] != "" and $parameter_cost_codes[$i] == 'STOCK MATERIAL') {
                        $stockMaterialFoundUpdate['whcost_det_id'] = $whcost_det_ids[$i];
                        $stockMaterialFoundUpdate['whcost_id'] = $whcost_id;
                        $stockMaterialFoundUpdate['parameter_cost_id'] = $parameter_cost_ids[$i];
                        $stockMaterialFoundUpdate['whcost_det_value'] = $table->getStockMaterialValue($whcost_start_date, $whcost_end_date);
                    }
                }

                $table->update();

                foreach($record_detail as $item_detail) {
                    $tableDetail->setRecord($item_detail);
                    $tableDetail->record[$tableDetail->pkey] = $tableDetail->generate_id($tableDetail->table,$tableDetail->pkey);
                    $tableDetail->create();
                }

                if( count($stockMaterialFoundUpdate) > 0) { //update cost value for stock material
                    $tableDetail->actionType = 'UPDATE';
                    $tableDetail->setRecord($stockMaterialFoundUpdate);
                    $tableDetail->update();
                }
                //$table->insertStock($table->record);

            $table->db->trans_commit(); //Commit Trans

            $data['success'] = true;
            $data['message'] = 'Data added successfully';

        }catch (Exception $e) {
            $table->db->trans_rollback(); //Rollback Trans

            $data['message'] = $e->getMessage();
        }


        echo json_encode($data);
        exit;

    }

}

/* End of file Shipping_controller.php */