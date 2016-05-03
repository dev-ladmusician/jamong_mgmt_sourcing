<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Channel extends CORE_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('channel_model');
    }

    function get_items()
    {
        $page = $this->input->get('page');
        $per_page = $this->input->get('count');
        $sort = $this->input->get('sorting');
        $filter = $this->input->get('filter');

        if ($page === false || $per_page === false) {
            $page = 1;
            $per_page = 10;
        }

        $users = $this->channel_model->gets_pagination($page, $per_page, $sort, $filter);
        $rtv = array(
            'row_count' => $page,
            'items' => $users,
            'sort' => $sort,
            'filter' => $filter
        );
        echo json_encode($rtv, JSON_PRETTY_PRINT);
    }

    function change_isdeprecated()
    {
        $channel_id = $this->input->get('channelId');
        $isdeprecated = $this->input->get('isdeprecated') == 'true' ? true : false;

        $rtv = $this->channel_model->change_isdeprecated($channel_id, $isdeprecated);
        if ($rtv) {
            if ($isdeprecated) {
                $this->session->set_flashdata('message', '채널을 성공적으로 삭제하였습니다.');
            } else {
                $this->session->set_flashdata('message', '채널을 성공적으로 부활하였습니다.');
            }

            redirect('channel/index');
        } else {
            if ($isdeprecated) {
                $this->session->set_flashdata('message', '채널을 삭제하는데 오류가 발생했습니다. 개발자에게 문의하세요.');
            } else {
                $this->session->set_flashdata('message', '채널을 부활하는데 오류가 발생했습니다. 개발자에게 문의하세요.');
            }

            redirect('channel/detail?channelNum='.$channel_id);
        }
    }

    function change_channel_info() {
        $channel_id = $this->input->post('channelId');
        $name = $this->input->post('name');
        $nickname = $this->input->post('nickname');
        $content = $this->input->post('content');

        $rtv = array(
            'name' => $name,
            'nickname' => $nickname,
            'content' => $content,
            'id' => $channel_id,
            'rtv' => $this->channel_model->change_channel_info($channel_id, $name, $nickname, $content)
        );
        echo json_encode(
            $rtv, JSON_PRETTY_PRINT);
    }
}
