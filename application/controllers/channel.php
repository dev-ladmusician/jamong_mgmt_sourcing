<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Channel extends CORE_Controller
{
    function __construct()
    {
        parent::__construct();
        //$this->__require_admin_login();
        $this->load->model('channel_model');
    }

    function index() {
        $this->__get_views('_CHANNEL/index.php');
    }

    function detail() {
        $channel_num = $this->input->get('channelId');
        $channel = $this->channel_model->get_by_id($channel_num);
        $this->__get_views('_CHANNEL/detail.php', array('channel' => $channel[0]));
    }
}
