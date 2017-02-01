<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Json library
 * @class Stock_material_controller
 * @version 07/05/2015 12:18:00
 */
class Production_planning_controller
{

    function read()
    {

        $page = getVarClean('page', 'int', 1);
        $limit = getVarClean('rows', 'int', 5);
        $sidx = getVarClean('sidx', 'str', 'planning_id');
        $sord = getVarClean('sord', 'str', 'desc');

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $is_sortir = getVarClean('is_sortir', 'str', 0);
        $purchasing = getVarClean('purchasing', 'int', 0);

        try {

            $ci = &get_instance();
            $ci->load->model('agripro/production_planning');
            $table = $ci->production_planning;

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

        } catch (Exception $e) {
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


    function create()
    {

        $ci = &get_instance();
        $ci->load->model('agripro/production_planning');
        $table = $ci->production_planning;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $jsonItems = getVarClean('items', 'str', '');
        $items = jsonDecode($jsonItems);

        if (!is_array($items)) {
            $data['message'] = 'Invalid items parameter';
            return $data;
        }

        $table->actionType = 'CREATE';
        $errors = array();
        if (isset($items[0])) {
            $numItems = count($items);
            for ($i = 0; $i < $numItems; $i++) {
                try {

                    $table->db->trans_begin(); //Begin Trans

                    $table->setRecord($items[$i]);
                    $table->create();

                    $table->db->trans_commit(); //Commit Trans

                } catch (Exception $e) {

                    $table->db->trans_rollback(); //Rollback Trans
                    $errors[] = $e->getMessage();
                }
            }

            $numErrors = count($errors);
            if ($numErrors > 0) {
                $data['message'] = $numErrors . " from " . $numItems . " record(s) failed to be saved.<br/><br/><b>System Response:</b><br/>- " . implode("<br/>- ", $errors) . "";
            } else {
                $data['success'] = true;
                $data['message'] = 'Data added successfully';
            }
            $data['rows'] = $items;
        } else {

            try {
                $table->db->trans_begin(); //Begin Trans

                $table->setRecord($items);
                $table->record[$table->pkey] = $table->generate_id($table->table, $table->pkey);
                $table->create();

                $table->db->trans_commit(); //Commit Trans

                $data['success'] = true;
                $data['message'] = 'Data added successfully';

            } catch (Exception $e) {
                $table->db->trans_rollback(); //Rollback Trans

                $data['message'] = $e->getMessage();
                $data['rows'] = $items;
            }

        }
        return $data;

    }

    function update()
    {

        $ci = &get_instance();
        $ci->load->model('agripro/production_planning');
        $table = $ci->production_planning;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $jsonItems = getVarClean('items', 'str', '');
        $items = jsonDecode($jsonItems);

        if (!is_array($items)) {
            $data['message'] = 'Invalid items parameter';
            return $data;
        }

        $table->actionType = 'UPDATE';

        if (isset($items[0])) {
            $errors = array();
            $numItems = count($items);
            for ($i = 0; $i < $numItems; $i++) {
                try {
                    $table->db->trans_begin(); //Begin Trans

                    $table->setRecord($items[$i]);
                    $table->update();

                    $table->db->trans_commit(); //Commit Trans

                    $items[$i] = $table->get($items[$i][$table->pkey]);
                } catch (Exception $e) {
                    $table->db->trans_rollback(); //Rollback Trans

                    $errors[] = $e->getMessage();
                }
            }

            $numErrors = count($errors);
            if ($numErrors > 0) {
                $data['message'] = $numErrors . " from " . $numItems . " record(s) failed to be saved.<br/><br/><b>System Response:</b><br/>- " . implode("<br/>- ", $errors) . "";
            } else {
                $data['success'] = true;
                $data['message'] = 'Data update successfully';
            }
            $data['rows'] = $items;
        } else {

            try {
                $table->db->trans_begin(); //Begin Trans


                $table->setRecord($items);
                $table->update();

                $table->db->trans_commit(); //Commit Trans

                $data['success'] = true;
                $data['message'] = 'Data update successfully';

                $data['rows'] = $table->get($items[$table->pkey]);
            } catch (Exception $e) {
                $table->db->trans_rollback(); //Rollback Trans

                $data['message'] = $e->getMessage();
                $data['rows'] = $items;
            }

        }
        return $data;

    }

    function destroy()
    {
        $ci = &get_instance();
        $ci->load->model('agripro/production_planning');
        $table = $ci->production_planning;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $jsonItems = getVarClean('items', 'str', '');
        $items = jsonDecode($jsonItems);

        try {
            $table->db->trans_begin(); //Begin Trans

            $total = 0;
            if (is_array($items)) {
                foreach ($items as $key => $value) {
                    if (empty($value)) throw new Exception('Empty parameter');

                    $table->remove($value);
                    $data['rows'][] = array($table->pkey => $value);
                    $total++;
                }
            } else {
                $items = (int)$items;
                if (empty($items)) {
                    throw new Exception('Empty parameter');
                };

                $table->remove($items);

                $data['rows'][] = array($table->pkey => $items);
                $data['total'] = $total = 1;
            }

            $data['success'] = true;
            $data['message'] = $total . ' Data deleted successfully';

            $table->db->trans_commit(); //Commit Trans

        } catch (Exception $e) {
            $table->db->trans_rollback(); //Rollback Trans
            $data['message'] = $e->getMessage();
            $data['rows'] = array();
            $data['total'] = 0;
        }
        return $data;
    }

    public function createForm(){
        $ci = & get_instance();
        $ci->load->model('agripro/production_planning');
        $table = $ci->production_planning;

        $data = array('success' => false, 'message' => '');
        $table->actionType = 'CREATE';

        $po_number = getVarClean('inPONumber','str');
        $client_name = getVarClean('inClientName','str');
        $planning_start_date = ($ci->input->post('inStartDate'))? $ci->input->post('inStartDate') : null;
        $planning_end_date = ($ci->input->post('inEndDate'))? $ci->input->post('inEndDate') : null;
        //$planning_qty_init = getVarClean('inPONumber','str');
        //$planning_qty = getVarClean('inPONumber','str');
        $sending_type = getVarClean('slSendingType','str');
        $planning_status = getVarClean('rbStatus','str');
        //$basis_prepare_date = getVarClean('rbStatus','int');
        //$basis_prepare_qty_init = getVarClean('inPONumber','str');
        //$basis_prepare_qty = getVarClean('inPONumber','str');
        $basis_real_qty = getVarClean('inBasisRealQTY','float');
        $basis_real_arrived = ($ci->input->post('inBasisRealDate'))? $ci->input->post('inBasisRealDate') : null;
        $prod_prepare_date = ($ci->input->post('inProdPrepDate'))? $ci->input->post('inProdPrepDate') : null;
        $prod_prepare_qty = getVarClean('inProdPrepQTY','float');
        $prep_performa_inv = getVarClean('inPrepPerformaInv','str');
        $shipping_start_date = ($ci->input->post('inShippingStartDate')) ? $ci->input->post('inShippingStartDate') : null;
        $shipping_end_date = ($ci->input->post('inPlannedShippingTo')) ? $ci->input->post('inPlannedShippingTo') : null;
        $vessel_feeder_name = getVarClean('inVesselName','str');
        $stuffing_date = ($ci->input->post('inStuffingDate')) ? $ci->input->post('inStuffingDate') : null;
        $loading_date = ($ci->input->post('inLoadingDate'))? $ci->input->post('inLoadingDate') : null;


        $array_product = (array)$ci->input->post('row_product_id');
        $array_weight= (array)$ci->input->post('weight');

        $userdata = $ci->ion_auth->user()->row();

        try{

            if(count($array_product) == 0) {
                throw new Exception('Data Product must be filled');
            }

            $table->db->trans_begin(); //Begin Trans
            $items = array(
                'po_number' => strtoupper($po_number),
                'client_name' => ucfirst($client_name),
                'planning_start_date' => $planning_start_date,
                'planning_end_date' => $planning_end_date,
                'sending_type' => $sending_type,
                'planning_status' => $planning_status,
                'prep_performa_inv' => $prep_performa_inv,
                'basis_real_qty' => $basis_real_qty,
                'basis_real_arrived' => $basis_real_arrived,
                'prod_prepare_date' => $prod_prepare_date,
                'prod_prepare_qty' => $prod_prepare_qty,
                'shipping_start_date' => $shipping_start_date,
                'shipping_end_date' => $shipping_end_date,
                'vessel_feeder_name' => ucfirst($vessel_feeder_name),
                'stuffing_date' => $stuffing_date,
                'loading_date' => $loading_date,
            );



            $table->setRecord($items);

            $product_planning = array();
            $table->record[$table->pkey] = $table->generate_id($table->table,$table->pkey);

            for($i = 0; $i < count($array_product); $i++) {
                $product_planning[] = array(
                    'planning_id' => $table->record[$table->pkey],
                    'product_id' => $array_product[$i],
                    'weight' => floatval($array_weight[$i])
                );

            }

            ####################################
            ### Step 1. Insert Master Planning
            ####################################

            $table->create();

            ####################################
            ### Step 2. Insert Product Planning
            ####################################
            $table->insertProductPlanning($product_planning);

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

    function showProductList(){

        $page = getVarClean('page', 'int', 1);
        $limit = getVarClean('rows', 'int', 5);
        $sidx = getVarClean('sidx', 'str', 'product_planning_id');
        $sord = getVarClean('sord', 'str', 'desc');

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');




        try {

            $ci = &get_instance();
            $ci->load->model('agripro/product_planning');
            $table = $ci->product_planning;

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

            $planning_id = $ci->input->post('planning_id');
            if($planning_id){
                $req_param['where'] = array("pp.planning_id =". $planning_id);
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

        } catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }

        return $data;
    }

}

/* End of file Warehouse_controller.php */