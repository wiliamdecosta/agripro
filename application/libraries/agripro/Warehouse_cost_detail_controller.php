<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Warehouse_cost_detail_controller
* @version 07/05/2015 12:18:00
*/
class Warehouse_cost_detail_controller {

    function read() {

        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('sidx','str','whcost_det_id');
        $sord = getVarClean('sord','str','asc');

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');
        $whcost_id = getVarClean('whcost_id','int',0);

        try {

            $ci = & get_instance();
            $ci->load->model('agripro/warehouse_cost_detail');
            $table = $ci->warehouse_cost_detail;

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
            $req_param['where'] = array('whcost_det.whcost_id = '.$whcost_id);

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

            $data['rows'] = $table->getAll();
            $data['success'] = true;

        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }

        return $data;
    }


    function getDetail() {

        $whcost_id = getVarClean('whcost_id','int',0);

        try {

            $ci = & get_instance();
            $ci->load->model('agripro/warehouse_cost_detail');
            $table = $ci->warehouse_cost_detail;

            $table->setCriteria('whcost_det.whcost_id = '.$whcost_id);
            $items = $table->getAll(0,-1);

            $output = '';
            $no = 1;
            foreach($items as $item) {

                if(!empty($item['whcost_det_evidence'])) {
                    $output .= '
                        <tr>
                            <td>'.$no++.'</td>
                            <td><input type="hidden" name="whcost_det_id[]" value="'.$item['whcost_det_id'].'"> <input type="hidden" name="parameter_cost_id[]" value="'.$item['parameter_cost_id'].'"><input type="hidden" name="parameter_cost_code[]" value="'.$item['parameter_cost_code'].'">'.$item['parameter_cost_code'].'</td>
                            <td align="right"><input type="hidden" name="whcost_det_values[]" value="'.$item['whcost_det_value'].'">'.numberFormat($item['whcost_det_value'],2).'</td>
                            <td><a href="'.base_url("file_evidence/".$item['whcost_det_evidence']).'">'.$item['whcost_det_evidence'].'</a></td>
                            <td><button type="button" onclick="deleteDataRow(this,'.$item['whcost_det_id'].');"><i class="fa fa-trash"></i> Delete </button></td>
                        </tr>
                        ';
                }else {
                    $output .= '
                        <tr>
                            <td>'.$no++.'</td>
                            <td><input type="hidden" name="whcost_det_id[]" value="'.$item['whcost_det_id'].'"> <input type="hidden" name="parameter_cost_id[]" value="'.$item['parameter_cost_id'].'"><input type="hidden" name="parameter_cost_code[]" value="'.$item['parameter_cost_code'].'">'.$item['parameter_cost_code'].'</td>
                            <td align="right"><input type="hidden" name="whcost_det_values[]" value="'.$item['whcost_det_value'].'">'.numberFormat($item['whcost_det_value'],2).'</td>
                            <td><input type="hidden" name="exist_evidences[]" value="'.$item['whcost_det_id'].'"><input type="file" name="whcost_det_evidences[]"></td>
                            <td><button type="button" onclick="deleteDataRow(this,'.$item['whcost_det_id'].');"><i class="fa fa-trash"></i> Delete </button></td>
                        </tr>
                        ';
                }

            }

        }catch (Exception $e) {
            echo $e->getMessage();
        }

        echo $output;
        exit;

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
        $ci->load->model('agripro/warehouse_cost_detail');
        $table = $ci->warehouse_cost_detail;

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
        $ci->load->model('agripro/warehouse_cost_detail');
        $table = $ci->warehouse_cost_detail;

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
        $ci->load->model('agripro/warehouse_cost_detail');
        $table = $ci->warehouse_cost_detail;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $jsonItems = getVarClean('items', 'str', '');
        $items = jsonDecode($jsonItems);

        try{
            $table->db->trans_begin(); //Begin Trans

            $total = 0;
            if (is_array($items)){
                foreach ($items as $key => $value){
                    if (empty($value)) throw new Exception('Empty parameter');

                    $table->remove($value);
                    $data['rows'][] = array($table->pkey => $value);
                    $total++;
                }
            }else{
                $items = (int) $items;
                if (empty($items)){
                    throw new Exception('Empty parameter');
                };

                $table->remove($items);
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

}

/* End of file warehouse_cost_detail_controller.php */