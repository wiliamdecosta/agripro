<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class incoming_goods_controller
* @version 07/05/2015 12:18:00
*/
class Incoming_goods_controller {

    function read() {
	
        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('sidx','str','in_biz_id');
        $sord = getVarClean('sord','str','asc');

        $is_report = getVarClean('report','int',0);

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        try {

            $ci = & get_instance();
            $ci->load->model('agripro/incoming_goods');
            $table = $ci->incoming_goods;
			
            
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
            if($is_report == 1){

               /// $req_param['where'] = array("incd.used_by <> ''");
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

            $data['rows'] = $table->getAllItems();
            $data['success'] = true;

        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }

        return $data;
    }

	function readLov_shipping() {
        permission_check('view-tracking');

        $start = getVarClean('current','int',0);
        $limit = getVarClean('rowCount','int',5);

        $sort = getVarClean('sort','str','shipping_id');
        $dir  = getVarClean('dir','str','asc');

        $searchPhrase = getVarClean('searchPhrase', 'str', '');

        $data = array('rows' => array(), 'success' => false, 'message' => '', 'current' => $start, 'rowCount' => $limit, 'total' => 0);

        try {

            $ci = & get_instance();
            $ci->load->model('agripro/shipping');
            $table = $ci->shipping;
            
            $table->setCriteria(" ship.shipping_id not in (select distinct in_shipping_id from incoming_bizhub ) ");
            if(!empty($searchPhrase)) {
                $table->setCriteria(" (shipping_date ilike '%".$searchPhrase."%' or shipping_driver_name ilike '%".$searchPhrase."%')");
            }

            $start = ($start-1) * $limit;
            $items = $table->getAll($start, $limit, $sort, $dir);
            $totalcount = $table->countAll();

            $data['rows'] = $items;
            $data['success'] = true;
            $data['total'] = $totalcount;

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
        $ci->load->model('agripro/incoming_goods');
        $table = $ci->incoming_goods;

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
        $ci->load->model('agripro/incoming_goods');
        $table = $ci->incoming_goods;

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
        $ci->load->model('agripro/incoming_goods');
        $table = $ci->incoming_goods;

		$ci->load->model('agripro/incoming_goods_detail');
        $tableDet = $ci->incoming_goods_detail;
		
        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $jsonItems = getVarClean('items', 'str', '');
        $items = jsonDecode($jsonItems);

        try{
           
            $table->db->trans_begin(); //Begin Trans
            $tableDet->db->trans_begin(); //Begin Trans

            $total = 0;
            if (is_array($items)){
                foreach ($items as $key => $value){
                    if (empty($value)) throw new Exception('Empty parameter');

                    $checkUsed = $tableDet->checkIsUsed($value);
                    if ($checkUsed > 0){
                        throw new Exception('Sorry You Cant Remove This Data, It Has Been Used In Production Or Selection');
                    };

                    $tableDet->delete_by_biz_id($value);
					$tableDet->db->trans_commit(); //Commit Trans
                    $table->remove($value);
                    $data['rows'][] = array($table->pkey => $value.'aaaa');
                    $total++;
                }
            }else{
                $items = (int) $items;
                if (empty($items)){
                    throw new Exception('Empty parameter');
                };

                 $checkUsed = $tableDet->checkIsUsed($items);
                    if ($checkUsed > 0){
                        throw new Exception('Sorry You Cant Remove This Data, It Has Been Used In Production Or Selection');
                    };

                $tableDet->delete_by_biz_id($items);
				$tableDet->db->trans_commit(); //Commit Trans
				$table->remove($items);
                $data['rows'][] = array($table->pkey => $items.'aaaa');
                $data['total'] = $total = 1;
            }

            $data['success'] = true;
            $data['message'] = $total.' Data deleted successfully';

            $table->db->trans_commit(); //Commit Trans

        }catch (Exception $e) {
            $tableDet->db->trans_rollback(); //Rollback Trans
            $table->db->trans_rollback(); //Rollback Trans
            $data['message'] = $e->getMessage();
            $data['rows'] = array();
            $data['total'] = 0;
        }
        return $data;
    }


    function createForm() {

        $ci = & get_instance();
        $ci->load->model('agripro/incoming_goods');
        $table = $ci->incoming_goods;

        $data = array('success' => false, 'message' => '');
        $table->actionType = 'CREATE';

        /**
         * Data master
         */
        $incoming_goods_date = getVarClean('incoming_date','str','');
        $incoming_goods_shipping_id = getVarClean('shipping_id','str','');
        //$incoming_goods_whid = $this->session->userdata('wh_id');
        $incoming_goods_whid = 999;


        /**
         * Data details
         */
        //$packing_ids = (array)$ci->input->post('packing_id');

        try{

            $table->db->trans_begin(); //Begin Trans

                $items = array(
                    'in_biz_date' => $incoming_goods_date,
                    'in_shipping_id' => $incoming_goods_shipping_id,
                    'warehouse_id' => $incoming_goods_whid
                );

                $table->setRecord($items);
                $table->record[$table->pkey] = $table->generate_id($table->table,$table->pkey);
				$table->create();
				$table->db->trans_commit();
				$table->create_details($table->record[$table->pkey]);
                
				/* $record_detail = array();
                $ci->load->model('agripro/incoming_goods_detail');
                $tableDetail = $ci->incoming_goods_detail;
                $tableDetail->actionType = 'CREATE';


                for($i = 0; $i < count($packing_ids); $i++) {
                    $record_detail[] = array(
                        'in_biz_id' => $table->record[$table->pkey],
                        'packing_id' => $packing_ids[$i]
                    );
                }

                $table->create();
                foreach($record_detail as $item_detail) {
                    $tableDetail->setRecord($item_detail);
                    $tableDetail->record[$tableDetail->pkey] = $tableDetail->generate_id($tableDetail->table,$tableDetail->pkey);
                    $tableDetail->create();

                    $tableDetail->insertStock($tableDetail->record, $table->record);
                }  */

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

	
	function getwhname() {

        $ci = & get_instance();
        $ci->load->model('agripro/incoming_goods_detail');
        $table = $ci->incoming_goods_detail;
        $data = array('success' => false, 'message' => '');

        $pkg_id = getVarClean('pkg_id','str','');
       
		
        try{

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
						'qty_bruto' => 0
						);
					}else{
						$items = array(
						'in_biz_det_id' => $in_biz_det_id,
						'in_biz_id' => $in_biz_id,
						'in_package_id' => $pkg_id,
						'in_biz_det_status' => $status
						);
					}
					
					
				}else{
					
					$qty = getVarClean('val','str','');
					
					$items = array(
                    'in_biz_det_id' => $in_biz_det_id,
                    'in_biz_id' => $in_biz_id,
                    'in_package_id' => $pkg_id,
                    'qty_rescale' => $qty,
                    'qty_bruto' => $qty
					);
					// stock 
				}
                
                $table->setRecord($items);
				$table->update();

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
	
	function get_pkg_info_by_id($packing_id){
		
		$ci = & get_instance();
		$ci->load->model('agripro/packing');
		$tPacking = $ci->packing;
		$tPacking->setCriteria('packing_id = '.$packing_id);
		$d_pd = $tPacking->getAll();
		
		return $d_pd;
	}
	
	function get_detail_incoming(){
		
		$ci = & get_instance();
		$shipping_id  = getVarClean('shipping_id','int','0');
		$in_biz_id  = getVarClean('in_biz_id','int','0');
        
		$ci->load->model('agripro/incoming_goods_detail');
        $incoming_detail = $ci->incoming_goods_detail;
		
		$ci->load->model('agripro/incoming_goods');
        $tIncoming_goods = $ci->incoming_goods;
		
		$data_shipping_detail = array();
		$data_packing_detail = array();
		
        $incoming_detail->setCriteria('inc.in_shipping_id = '.$shipping_id);
        $d_sd = $incoming_detail->getAll();
		
        $loop = 0;
		$html = '';
        foreach($d_sd as $d => $sd) {
			
			/* $d_pd = $tIncoming_goods->get_pkg_info_by_id($sd['in_packing_id']);
			$batch_number = $d_pd['packing_batch_number'];
			$prod_code = $d_pd['product_code'];
			$pkg_kg = $d_pd['packing_kg']; */
			
			$batch_number = $sd['packing_batch_number'];
			$prod_code = $sd['product_code'];
			$pkg_kg = $sd['qty_source'];
			$status = $sd['in_biz_det_status'];
			$newqty = $sd['qty_rescale'];
			$depreciation = @($sd['qty_source'] - $sd['qty_rescale']);
			
			
			$no = $loop + 1;
			$html.= '<tr>';
			$html.= '<td>'. $no .'</td>';
			$html.= '<td>'.$batch_number.'</td>';
			$html.= '<td>'.$prod_code.'</td>';
			
			
			if($status == 'L' ){
				$html.= '<td>
						<a href="javascript:;" onclick="set_status_goods(\''.$sd['in_biz_det_id'].'\',\''.$sd['in_biz_id'].'\',\''.$sd['in_packing_id'].'\', \''.'L'.'\')" class="btn green green-meadow btn-xs" id="OKstatus'.$sd['in_packing_id'].'" style="display:none;" >ok</a>
						<a href="javascript:;" onclick="set_status_goods(\''.$sd['in_biz_det_id'].'\',\''.$sd['in_biz_id'].'\',\''.$sd['in_packing_id'].'\', \''.'E'.'\')" class="btn red  btn-xs"  id="LOSTstatus'.$sd['in_packing_id'].'" >Lost</a>
			
			</td>';
			}else{
				$html.= '<td>
						<a href="javascript:;" onclick="set_status_goods(\''.$sd['in_biz_det_id'].'\',\''.$sd['in_biz_id'].'\',\''.$sd['in_packing_id'].'\', \''.'L'.'\')" class="btn green green-meadow btn-xs" id="OKstatus'.$sd['in_packing_id'].'" >ok</a>
						<a href="javascript:;" onclick="set_status_goods(\''.$sd['in_biz_det_id'].'\',\''.$sd['in_biz_id'].'\',\''.$sd['in_packing_id'].'\', \''.'E'.'\')" class="btn red  btn-xs" style="display:none;" id="LOSTstatus'.$sd['in_packing_id'].'" >Lost</a>
			</td>';
			}
			
			$html.= '<td>'.$pkg_kg.'</td>';
			
			if($pkg_kg > 0 ){
				if($status == 'L' ){
					$html.= '<td>
						<span id="formQty'.$sd['in_packing_id'].'" style="display:none;" >
						<input type="number" placeholder="" id="newqty'.$sd['in_packing_id'].'" onkeyup="set_depresiation(\'newqty'.$sd['in_packing_id'].'\',\'spanDepre'.$sd['in_packing_id'].'\', \''.$pkg_kg.'\')" value="'.$newqty.'">
						<a href="javascript:;" onclick="save_new_qty(\''.$sd['in_biz_det_id'].'\',\''.$sd['in_biz_id'].'\', \''.$sd['in_packing_id'].'\')" class="btn btn-primary btn-xs">Save</a></span>
						<span id="spanQty'.$sd['in_packing_id'].'" ><span  id="spanNQty'.$sd['in_packing_id'].'">'.$newqty.' </span> <span id="spanEditQty'.$sd['in_packing_id'].'" style="visibility:hidden;">| <a href="javascript:;" class="btn btn-primary btn-xs" onclick="show_form(\''.$sd['in_packing_id'].'\')">Edit</a></span></td>';
				}else{
					$html.= '<td>
						<span id="formQty'.$sd['in_packing_id'].'" style="display:none;" >
						<input type="number" placeholder="" id="newqty'.$sd['in_packing_id'].'" onkeyup="set_depresiation(\'newqty'.$sd['in_packing_id'].'\',\'spanDepre'.$sd['in_packing_id'].'\', \''.$pkg_kg.'\')" value="'.$newqty.'">
						<a href="javascript:;" onclick="save_new_qty(\''.$sd['in_biz_det_id'].'\',\''.$sd['in_biz_id'].'\', \''.$sd['in_packing_id'].'\')" class="btn btn-primary btn-xs">Save</a></span>
						<span id="spanQty'.$sd['in_packing_id'].'" ><span  id="spanNQty'.$sd['in_packing_id'].'">'.$newqty.' </span> <span id="spanEditQty'.$sd['in_packing_id'].'">| <a href="javascript:;" class="btn btn-primary btn-xs" onclick="show_form(\''.$sd['in_packing_id'].'\')">Edit</a></span></td>';
				}
				
			}else{
				$html.= '<td><span id="formQty'.$sd['in_packing_id'].'"  >
						 <input type="number" placeholder="" id="newqty'.$sd['in_packing_id'].'" onkeyup="set_depresiation(\'newqty'.$sd['in_packing_id'].'\',\'spanDepre'.$sd['in_packing_id'].'\', \''.$pkg_kg.'\')" value="'.$newqty.'">
						<a href="javascript:;" onclick="save_new_qty(\''.$sd['in_biz_det_id'].'\',\''.$sd['in_biz_id'].'\', \''.$sd['in_packing_id'].'\')" class="btn btn-primary btn-xs">Save</a></span>
						<span id="spanQty'.$sd['in_packing_id'].'" style="display:none;"><span  id="spanNQty'.$sd['in_packing_id'].'">'.$newqty.' </span> <span id="spanEditQty'.$sd['in_packing_id'].'">|<a href="javascript:;" onclick="show_form(\''.$sd['in_packing_id'].'\')" class="btn btn-primary btn-xs" >Edit</a></span></span></td>';
			}
			
			$html.= '<td><span id="spanDepre'.$sd['in_packing_id'].'" >'.$depreciation.'</span></td>';
            $html.= '</tr>';
			
			$loop++;
        }
		echo $html;
		exit;
	}
	
	function get_detail_shipping(){
		
		$ci = & get_instance();
		$shipping_id  = getVarClean('shipping_id','int','0');
        
		$ci->load->model('agripro/shipping_detail');
        $tShippingDetail = $ci->shipping_detail;
		
		$ci->load->model('agripro/incoming_goods');
        $tIncoming_goods = $ci->incoming_goods;
		
		$data_shipping_detail = array();
		$data_packing_detail = array();
		
        $tShippingDetail->setCriteria('shipdet.shipping_id = '.$shipping_id);
        $d_sd = $tShippingDetail->getAll();
		
        $loop = 0;
		$html = '';
        foreach($d_sd as $d => $sd) {
			
			$batch_number = $sd['packing_batch_number'];
			$prod_code = $sd['product_code'];
			$pkg_kg = $sd['qty_source'];
				
				
			$no = $loop + 1;
			$html.= '<tr>';
			$html.= '<td>'. $no .'</td>';
			$html.= '<td>'.$batch_number.'</td>';
			$html.= '<td>'.$prod_code.'</td>';
			$html.= '<td><a href="javascript:;" onclick="set_status_goods(\''.$sd['packing_id'].'\', \''.'L'.'\')" class="btn green green-meadow btn-xs">ok</a></td>';
			$html.= '<td>'.$pkg_kg.'</td>';
			$html.= '<td><input type="number" placeholder="" id="newqty'.$sd['packing_id'].'" onkeyup="set_depresiation(\'newqty'.$sd['packing_id'].'\',\'spanDepre'.$sd['packing_id'].'\', \''.$sd['packing_kg'].'\')" >
					<a href="javascript:;" onclick="save_new_qty(\''.$sd['packing_id'].'\')" class="btn btn-primary btn-xs">Save</a></td>';
			$html.= '<td><span id="spanDepre'.$sd['packing_id'].'"></span></td>';
			$html.= '<td></td>';
            $html.= '</tr>';
			
			$loop++;
        }
		echo $html;
		exit;
	}
	
	function update_col(){
		
		$ci = & get_instance();
		$shipping_id  = getVarClean('shipping_id','int','0');
        
		$ci->load->model('agripro/incoming_goods');
        $incoming_goods = $ci->incoming_goods;
		
		$incoming_goods->update_col($table, $col, $val);
		exit;
	}

}

/* End of file incoming_goods_controller.php */