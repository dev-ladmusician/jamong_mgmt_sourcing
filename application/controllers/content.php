<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Content extends CORE_Controller
{
    function __construct()
    {
        parent::__construct();
        //$this->__require_admin_login();
        $this->load->model('content_model');
    }

    function index() {
        $this->__get_views('_CONTENT/index.php');
    }
}
