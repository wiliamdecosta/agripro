<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class incoming_goods_detail_controller
* @version 07/05/2015 12:18:00
*/
class Incoming_goods_detail_controller {

    function read() {

        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('sidx','str','in_biz_det_id');
        $sord = getVarClean('sord','str','asc');

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');
        $in_biz_id = getVarClean('in_biz_id','int',0);

        try {

            $ci = & get_instance();
            $ci->load->model('agripro/incoming_goods_detail');
            $table = $ci->incoming_goods_detail;

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
            $is_report = getVarClean('report','int',0);
            if($is_report == 1){
                $req_param['where'] = array("incd.in_biz_id = $in_biz_id and incd.used_by <> '' ");
            }else{
                $req_param['where'] = array("incd.in_biz_id = $in_biz_id and incd.used_by = '' ");
            }

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

        $shipping_id = getVarClean('shipping_id','int',0);

        try {

            $ci = & get_instance();
            $ci->load->model('agripro/incoming_goods_detail');
            $table = $ci->incoming_goods_detail;

            $table->setCriteria('shipdet.shipping_id = '.$shipping_id);
            $items = $table->getAll(0,-1);

            $output = '';
            $no = 1;
            foreach($items as $item) {
                $output .= '
                    <tr>
                        <td>'.$no++.'</td>
                        <td><input type="hidden" name="shipdet_id[]" value="'.$item['shipdet_id'].'"> <input type="hidden" name="packing_id[]" value="'.$item['packing_id'].'">'.$item['packing_batch_number'].'</td>
                        <td>'.$item['product_code'].'</td>
                        <td><button type="button" onclick="deleteDataRow(this,'.$item['shipdet_id'].');"><i class="fa fa-trash"></i> Delete </button></td>
                    </tr>
                ';
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
        $ci->load->model('agripro/incoming_goods_detail');
        $table = $ci->incoming_goods_detail;

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
        $ci->load->model('agripro/incoming_goods_detail');
        $table = $ci->incoming_goods_detail;

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
        $ci->load->model('agripro/incoming_goods_detail');
        $table = $ci->incoming_goods_detail;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $jsonItems = getVarClean('items', 'str', '');
        $items = jsonDecode($jsonItems);

        try{
            $table->db->trans_begin(); //Begin Trans

            $total = 0;
            if (is_array($items)){
                foreach ($items as $key => $value){
                    if (empty($value)) throw new Exception('Empty parameter');

                    $table->removeItems($value);
                    $data['rows'][] = array($table->pkey => $value);
                    $total++;
                }
            }else{
                $items = (int) $items;
                if (empty($items)){
                    throw new Exception('Empty parameter');
                };

                $table->removeItems($items);
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


    function update_detail() {

        $ci = & get_instance();
        $ci->load->model('agripro/incoming_goods_detail');
        $table = $ci->incoming_goods_detail;
        $table->actionType = 'UPDATE';
        $data = array('success' => false, 'message' => '');

        $val = getVarClean('val','str','');
        $mode = getVarClean('col','str','');
        $in_biz_det_id = getVarClean('in_biz_det_id','str',''); 
        $in_biz_id = getVarClean('in_biz_id','str',''); 
        $pkg_id = getVarClean('pkg_id','str','');
       
        
        try{
            
            $checkUsed = $table->checkIsUsedDet($in_biz_det_id);
            if ($checkUsed > 0){
                throw new Exception('Sorry You Cant Edit This Data, It Has Been Used In Production Or Selection');
            };
            
            $table->db->trans_begin(); //Begin Trans
                
                if($mode == 'in_biz_det_status'){
                    
                    $status = getVarClean('val','str','');
                    if($status == 'L'){
                        $items = array(
                        'in_biz_det_id' => $in_biz_det_id,
                        'in_biz_id' => $in_biz_id,
                        'in_package_id' => $pkg_id,
                        'in_biz_det_status' => $status,
                        'qty_rescale' => 0,
                        'qty_netto' => 0,
                        'qty_bruto' => 0
                        );
                    }else{
                        $items = array(
                        'in_biz_det_id' => $in_biz_det_id,
                        'in_biz_id' => $in_biz_id,
                        'in_package_id' => $pkg_id,
                        'in_biz_det_status' => $status,
                        'qty_netto' => 0
                        );
                    }
                    
                    
                }else{
                    
                    $qty = getVarClean('val','str','');
                    
                    $items = array(
                    'in_biz_det_id' => $in_biz_det_id,
                    'in_biz_id' => $in_biz_id,
                    'in_package_id' => $pkg_id,
                    'qty_rescale' => $qty,
                    'qty_bruto' => $qty,
                    'qty_netto' => $qty
                    );
                }
                
                $table->setRecord($items);
                $table->update();
                $table ->insertStock($in_biz_det_id, $val);
            $table->db->trans_commit(); //Commit Trans

            $data['success'] = true;
            $data['message'] = 'Data updated successfully !';

        }catch (Exception $e) {
            $table->db->trans_rollback(); //Rollback Trans

            $data['message'] = $e->getMessage();
        }


        echo json_encode($data);
        exit;

    }

}

/* End of file incoming_goods_detail_controller.php */