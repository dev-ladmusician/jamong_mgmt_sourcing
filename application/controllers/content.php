<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Content extends CORE_Controller
{
    function __construct()
    {
        parent::__construct();
        //$this->__require_admin_login();
        $this->load->model('content_model');
        $this->load->model('category_model');
        $this->load->model('content_model');
    }

    function index() {
        $this->__get_views('_CONTENT/index.php');
    }

    function detail() {
        $content_id = $this->input->get('contentId');
        $content = $this->content_model->get_by_id($content_id);
        $this->__get_views('_CONTENT/detail.php', array('content' => $content[0]));
    }
}
