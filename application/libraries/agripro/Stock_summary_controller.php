<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Product_controller
* @version 07/05/2015 12:18:00
*/
class Stock_summary_controller {

    function getSummary() {

        $sc_code = getVarClean('sc_code','str','');

        try {

            $ci = & get_instance();
            $ci->load->model('agripro/stock_summary');
            $table = $ci->stock_summary;

            $items = $table->getSummary($sc_code);

            $output = '';
            $no = 1;
            foreach($items as $item) {
                $output .= '
                    <tr>
                        <td>'.$no++.'</td>
                        <td>'.$item['product_code'].'</td>
                        <td align="right">'.$item['total_stock'].'</td>
                    </tr>
                ';
            }

        }catch (Exception $e) {
            echo $e->getMessage();
        }

        echo $output;
        exit;
    }

}

/* End of file Warehouse_controller.php */