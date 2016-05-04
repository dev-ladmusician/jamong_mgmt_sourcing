<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Category extends CORE_Controller
{
    function __construct()
    {
        parent::__construct();
        //$this->__require_admin_login();
        $this->load->model('category_model');
    }

    function index() {
        $this->__get_views('_CATEGORY/index.php');
    }

    function detail() {
        $category_id= $this->input->get('categoryId');
        $category = $this->category_model->get_by_id($category_id);
        $this->__get_views('_CATEGORY/detail.php', array('category' => $category[0]));
    }
}
