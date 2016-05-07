<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Content extends CORE_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->__require_admin_login();
        $this->load->model('content_model');
        $this->load->model('category_model');
        $this->load->model('type_model');
        $this->load->model('channel_model');
    }

    function index() {
        $this->__get_views('_CONTENT/index.php');
    }

    function detail() {
        $content_id = $this->input->get('contentId');
        $content = $this->content_model->get_by_id($content_id);
        
        $channels = $this->channel_model->get_items();
        $types = $this->type_model->get_items();
        $categories = $this->category_model->get_items();

        $this->__get_views('_CONTENT/detail.php', array('content' => $content[0], 'types' => $types, 'categories' => $categories , 'channels' =>$channels));
    }

    function create() {
        $this->__get_views('_CONTENT/create.php');
    }

    function create_info(){
        $channels = $this->channel_model->get_items();
        $types = $this->type_model->get_items();
        $categories = $this->category_model->get_items();

        $this->__get_views('_CONTENT/create_info.php', array( 'types' => $types, 'categories' => $categories , 'channels' =>$channels));
    }

    function upload_movie(){
        $contentId = $this->input->get('contentId');

//        $this->__get_views('_CONTENT/upload_movie.php', array('contentId' => $contentId));
        $this->__get_views('_CONTENT/upload_movie.php');
    }
}
