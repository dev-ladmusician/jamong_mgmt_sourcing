<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Channel extends CORE_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('channel_model');
        $this->load->model('channel_profile_model');
    }

    function index() {
        $this->__require_admin_login();
        $this->__get_views('_CHANNEL/index.php');
    }

    function detail() {
        $user_id = $this->session->userdata('userid');
        $channel_num = $this->input->get('channelId');

        $check = $this->channel_model->check_manager($user_id, $channel_num);

        if (count($check) > 0) {
            $channel = $this->channel_model->get_by_id($channel_num);
            $profiles = $this->channel_profile_model->get_by_id($channel_num);
            $profile = null;
            if (count($profiles) > 0)
                $profile = $profiles[0];
            else
                $profile = null;
            $managers = $this->channel_model->get_managers($channel_num);
            $this->__get_views('_CHANNEL/detail.php', array('channel' => $channel[0], 'managers' => $managers ,
                'profile' => $profile));
        } else {
            $this->session->set_flashdata('message', '채널관리자가 아닙니다. 관리자에게 문의하세요.');
            redirect('home/index');
        }
    }

    function create() {
        $this->__get_views('_CHANNEL/create.php');
    }
}
