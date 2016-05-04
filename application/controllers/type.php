<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Type extends CORE_Controller
{
    function __construct()
    {
        parent::__construct();
        //$this->__require_admin_login();
        $this->load->model('type_model');
    }

    function index() {
        $this->__get_views('_TYPE/index.php');
    }

    function detail() {
        $table_id= $this->input->get('tableId');
        $type = $this->type_model->get_by_id($table_id);
        $this->__get_views('_TYPE/detail.php', array('type' => $type[0]));
    }
}
