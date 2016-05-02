<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User extends CORE_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }

    function test()
    {
        var_dump($_POST);
        $test = json_decode($_POST['test']);
        echo json_encode($test, JSON_PRETTY_PRINT);
    }

    function get_users()
    {
        $page = $this->input->get('page');
        $per_page = $this->input->get('count');
        $sort = $this->input->get('sorting');
        $filter = $this->input->get('filter');

        if ($page === false || $per_page === false) {
            $page = 1;
            $per_page = 10;
        }

        $users = $this->user_model->gets_pagination($page, $per_page, $sort, $filter);
        $rtv = array(
            'row_count' => $per_page,
            'items' => $users,
        );
        echo json_encode($rtv, JSON_PRETTY_PRINT);
    }

    function detail()
    {
        $user_id = $this->input->get('userId');
        $user = $this->user_model->get_user_by_id($user_id);
        if ($user != null && count($user) > 0) {
            echo json_encode($user[0], JSON_PRETTY_PRINT);
        }
    }

    function change_isadmin()
    {
        $user_id = $this->input->get('userId');
        $is_admin = $this->input->get('isadmin') == 'true' ? true : false;

        $rtv = $this->user_model->change_isadmin($user_id, $is_admin);
        if ($rtv) {
            if ($is_admin) {
                $this->session->set_flashdata('message', '관리자 권한을 부여하였습니다.');
            } else {
                $this->session->set_flashdata('message', '관리자 권한을 박탈하였습니다.');
            }

            redirect('user/detail?userId=' . $user_id);
        } else {
            if ($is_admin) {
                $this->session->set_flashdata('message', '관리자 권한을 부여하는데 오류가 발생했습니다.');
            } else {
                $this->session->set_flashdata('message', '관리자 권한을 박탈하는데 오류가 발생했습니다.');
            }

            redirect('user/detail?userId=' . $user_id);
        }
    }

    function change_password()
    {
        $user_id = $this->input->post('userId');
        $password = $this->input->post('password');

        if(strlen($password) == 0){
            $this->session->set_flashdata('message', '비밀 번호 길이가 짧습니다.');
            redirect('user/detail?userId=' . $user_id);
        }else{
            $rtv = $this->user_model->change_password($user_id, $password);

            if ($rtv) {
                $this->session->set_flashdata('message', '비밀 번호를 변경하는데 성공 했습니다.');
                redirect('user/detail?userId=' . $user_id);
            } else {
                $this->session->set_flashdata('message', '비밀 번호를 변경하는데 오류가 발생했습니다.');
                redirect('user/detail?userId=' . $user_id);
            }
        }
    }
}
