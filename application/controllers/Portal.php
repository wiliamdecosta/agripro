<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Portal extends CI_Controller
{

    function __construct() {
        parent::__construct();
        $this->load->helper(array('url', 'language'));
        $this->load->model('agripro/MPortal','Portal');
    }

    function index() {
        $this->load->view('portal/template/header');
        $this->load->view('portal/tracking');
        $this->load->view('portal/template/footer');
    }

    public function submitTracking(){
       // $packing = $this->Portal->getTracking();


        #################################
        ### 1. Get Packing Informasi
        ###
        ###
        ###
        ###
        #################################
        $serial = trim(strtoupper($this->input->post('input_txt')));

        $sql = " select 
                    pk.packing_batch_number,pk.packing_kg,pk.packing_serial,pk.packing_tgl,
                    pr.product_code,
                    wh.wh_name,wh.wh_location
                    from packing pk
                    INNER JOIN product pr ON pk.product_id = pr.product_id
                    INNER JOIN warehouse wh ON pk.warehouse_id = wh.wh_id
                    WHERE
                    pk.packing_batch_number = '".$serial. "'
        ";
        $result = $this->db->query($sql)->row();

        if($result != NULL){
            $data['packing_inf'] = $result;

            $sm_ids = $this->getSortirID($serial);
            // Get Detail
            $detail = array();
            for($i=0; $i < count($sm_ids); $i++){
                $detail[$i] = $this->getDetailTracebility($sm_ids[$i]);
            }
            $data['details'] = $detail;

            $this->load->view('portal/detail_tracking',$data);
        }else{
            echo json_encode('Data not found');
        }
    }

    function getSortirID($serial){
        $sql = " select 
                   -- pk.packing_batch_number,pk.packing_kg,pk.packing_tgl,
                   -- pr.product_code,
                   -- pd.sortir_detail_id,
                   -- sd.sortir_id,
                    st.sm_id,st.production_id
                    from packing pk
                    INNER JOIN product pr ON pk.product_id = pr.product_id
                    INNER JOIN packing_detail pd ON pk.packing_id = pd.packing_id
                    INNER JOIN sortir_detail sd ON pd.sortir_detail_id = sd.sortir_detail_id
                    INNER JOIN sortir st ON sd.sortir_id = st.sortir_id
                    where 
                    pk.packing_batch_number = '".$serial. "'
        ";
        $return = $this->db->query($sql)->result_array();

        $sm_id = array();
        foreach($return as $sm){
            if($sm['sm_id'] == NULL){
                // Production Item
                $smid_prod = $this->getSmIDProduction($sm['production_id']);
                foreach($smid_prod as $result_smid){
                    $sm_id[] = $result_smid['sm_id'];
                }
            }else{
                $sm_id[] = $sm['sm_id'];
            }
        }

        return $sm_id;

    }

    public function getSmIDProduction($production_id){
        $q = " select sm_id from production_detail where production_id = ".$production_id;
        $result = $this->db->query($q);
        return $result->result_array();
    }

    function getDetailTracebility($sm_id){
        $q = "select
                sm.sm_tgl_masuk,sm.sm_no_trans,
                fm.fm_name,fm.fm_code,fm.fm_address,
                plt.plt_alamat,
                pr.product_code
                from stock_material sm
                inner join farmer fm ON sm.fm_id = fm.fm_id
                inner join plantation plt ON sm.plt_id = plt.plt_id
                inner join product pr ON sm.product_id = pr.product_id
                where sm.sm_id = $sm_id
        ";
        $result = $this->db->query($q);
        return $result->row();
    }




}