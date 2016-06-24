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
        $row = $this->Portal->getTracking();
        if($row->num_rows() > 0){
            $data['packaging'] = $row->row();
            $data['detail_packing'] = $this->Portal->getDetailPackaging($row->row()->pkg_id);
            $this->load->view('portal/detail_tracking',$data);
        }else{
            echo json_encode('Data tidak ditemukan');
        }
    }




}