<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Json library
 * @class Stock_material_controller
 * @version 07/05/2015 12:18:00
 */
class Stock_material_controller
{

    function read()
    {

        $page = getVarClean('page', 'int', 1);
        $limit = getVarClean('rows', 'int', 5);
        $sidx = getVarClean('sidx', 'str', 'sm_id');
        $sord = getVarClean('sord', 'str', 'desc');

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $is_sortir = getVarClean('is_sortir', 'str', 0);
        $purchasing = getVarClean('purchasing', 'int', 0);

        try {

            $ci = &get_instance();
            $ci->load->model('agripro/stock_material');
            $table = $ci->stock_material;

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

            // 1 = RM Purchasing
            if ($purchasing == 1) {
                $req_param['where'] = array("sm.sm_qty_bersih is null");
            }
            if ($is_sortir == '1') {
                $req_param['where'] = array("sm.sm_qty_bersih *1 > 0 ");
            }

            $start = getVarClean('inStart','date','');
            $end = getVarClean('inEnd','date','');

            if($start && !$end){
                $req_param['where'] = array("sm.sm_tgl_masuk = '".$start."'::date");
            }
            if($start && $end){
                $req_param['where'] = array("sm.sm_tgl_masuk >= '".$start."'::date and sm.sm_tgl_masuk <= '".$end."'::date");
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

    function readLov()
    {
        permission_check('view-tracking');

        $start = getVarClean('current', 'int', 0);
        $limit = getVarClean('rowCount', 'int', 5);

        $sort = getVarClean('sort', 'str', 'sm_id');
        $dir = getVarClean('dir', 'str', 'asc');

        $searchPhrase = getVarClean('searchPhrase', 'str', '');

        $data = array('rows' => array(), 'success' => false, 'message' => '', 'current' => $start, 'rowCount' => $limit, 'total' => 0);

        try {

            $ci = &get_instance();
            $ci->load->model('agripro/stock_material');
            $table = $ci->stock_material;

            if (!empty($searchPhrase)) {
                $table->setCriteria("(sm_id ilike '%" . $searchPhrase . "%' or sm_no_trans ilike '%" . $searchPhrase . "%')
                                     ");
            }

            $start = ($start - 1) * $limit;
            $items = $table->getAll($start, $limit, $sort, $dir);
            $totalcount = $table->countAll();

            $data['rows'] = $items;
            $data['success'] = true;
            $data['total'] = $totalcount;

        } catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }

        return $data;
    }

    function readLov_sortir()
    {
        permission_check('view-tracking');

        $start = getVarClean('current', 'int', 0);
        $limit = getVarClean('rowCount', 'int', 5);

        $sort = getVarClean('sort', 'str', 'sm_id');
        $dir = getVarClean('dir', 'str', 'asc');

        $searchPhrase = getVarClean('searchPhrase', 'str', '');

        $data = array('rows' => array(), 'success' => false, 'message' => '', 'current' => $start, 'rowCount' => $limit, 'total' => 0);

        try {

            $ci = &get_instance();
            $ci->load->model('agripro/stock_material');
            $table = $ci->stock_material;

            $table->setCriteria(" sm_qty_bersih > 0 AND sm_id not in (select distinct sm_id from sortir where sm_id is not null) ");
            if (!empty($searchPhrase)) {
                $table->setCriteria(" (sm_id ilike '%" . $searchPhrase . "%' or sm_no_trans ilike '%" . $searchPhrase . "%')");
            }

            $start = ($start - 1) * $limit;
            $items = $table->getAll($start, $limit, $sort, $dir);
            $totalcount = $table->countAll();

            $data['rows'] = $items;
            $data['success'] = true;
            $data['total'] = $totalcount;

        } catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }

        return $data;
    }

    function crud()
    {

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
        $ci->load->model('agripro/stock_material');
        $table = $ci->stock_material;

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


                ##############################
                ## Insert Stock
                ##############################
                $table->insertStock($table->record);

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
        $ci->load->model('agripro/stock_material');
        $table = $ci->stock_material;

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

                ##############################
                ## Update Stock
                ##############################
                $table->updateStock($table->record);

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
        $ci->load->model('agripro/stock_material');
        $table = $ci->stock_material;

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
                ##############################
                ## Update Stock
                ##############################
                $table->deleteStock($items);

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


    function summary_stock()
    {

        $ci = &get_instance();
        $ci->load->model('agripro/stock_material');
        $table = $ci->stock_material;

        $sql = "select prod.product_code, prod.product_name, wh.wh_code, sum(sm.sm_qty_kotor) as qty
                from stock_material as sm
                left join product as prod on sm.product_id = prod.product_id
                left join warehouse as wh on sm.wh_id = wh.wh_id
                group by prod.product_code, prod.product_name, wh.wh_code
                order by prod.product_code";

        $query = $table->db->query($sql);
        $items = $query->result_array();

        $no = 1;
        $output = "";
        foreach ($items as $item) {
            $output .= '
                <tr>
                    <td>' . $no++ . '</td>
                    <td>' . $item['product_code'] . '</td>
                    <td>' . $item['product_name'] . '</td>
                    <td>' . $item['wh_code'] . '</td>
                    <td align="right">' . $item['qty'] . '</td>
                </tr>
            ';
        }
        echo $output;
        exit;
    }
}

/* End of file Warehouse_controller.php */