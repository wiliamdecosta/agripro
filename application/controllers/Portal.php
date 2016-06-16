<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Portal extends CI_Controller
{

    function __construct() {
        parent::__construct();
        $this->load->helper(array('url', 'language'));
    }

    function index() {
       echo "form tracking";
    }


}