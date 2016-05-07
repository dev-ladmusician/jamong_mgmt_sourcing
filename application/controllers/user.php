<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User extends CORE_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->__require_admin_login();
        $this->load->model('user_model');
    }

    function index()
    {
        //$users = $this->user_model->gets();
        $this->__get_views('_USER/index.php', array());
    }

    function create()
    {
        $this->load->model('blog_category_model');
        $this->load->model('user_model');
        $users = $this->user_model->gets();
        $categories = $this->blog_category_model->gets();
        $this->__get_views('_BLOG/create.php', array('data' => null, 'categories' => $categories, 'users' => $users));
    }

    function detail()
    {
        $userid = $this->input->get('userId');
        $user = $this->user_model->get_user_by_id($userid);
        if ($user != null && count($user) > 0) {
            $this->__get_views('_USER/detail.php', array('item' => $user[0]));

        } else {
            $this->session->set_flashdata('message', '해당 유저가 없습니다.');
            redirect('user/index');
        }
    }

    function update()
    {
        $userid = $this->input->get('userid');
        $user = $this->user_model->get_user_by_id($userid);
        if ($user != null) {
            $this->__get_views('_USER/update.php', array('item' => $user));

        } else {
            $this->session->set_flashdata('message', '해당 유저가 없습니다.');
            redirect('user/index');
        }
    }

    function submit()
    {
        $input_data = array(
            'title' => $this->input->post('title'),
            'summary' => $this->input->post('summary'),
            'content' => $this->input->post('content'),
            'main_img_uri' => $this->handle_main_img($this->input->post('content')),
            'for_categoryid' => $this->input->post('category')
        );
        $rtv = $this->user_model->add($input_data);

        if ($rtv != null && $rtv > 0) {
            $this->session->set_flashdata('message', '���ۼ��� ���������� �����Ͽ����ϴ�.');
            redirect('blog/index');
        } else {
            $this->session->set_flashdata('message', '���ۼ��ϴµ� ���� �߻��߽��ϴ�. �����ڿ��� �����ϼ���');
            $this->__get_views('_BLOG/create.php', array('data' => $input_data));
        }
    }

    function submit_update()
    {
        $input_data = array(
            'title' => $this->input->post('title'),
            'summary' => $this->input->post('summary'),
            'content' => $this->input->post('content'),
            'main_img_uri' => $this->handle_main_img($this->input->post('content')),
            'for_categoryid' => $this->input->post('category')
        );
        $rtv = $this->user_model->add($input_data);

        if ($rtv != null && $rtv > 0) {
            $this->session->set_flashdata('message', '���ۼ��� ���������� �����Ͽ����ϴ�.');
            redirect('blog/index');
        } else {
            $this->session->set_flashdata('message', '���ۼ��ϴµ� ���� �߻��߽��ϴ�. �����ڿ��� �����ϼ���');
            $this->__get_views('_BLOG/create.php', array('data' => $input_data));
        }
    }

    function change_admin()
    {
        $userid = $this->input->get('userid');
        $isadmin = $this->input->get('isadmin') == 'true' ? true : false;

        if (!$userid) {
            $this->session->set_flashdata('message', '페이지를 로드하는데 오류가 발생했습니다.');
        } else {
            $rtv = $this->user_model->change_admin($userid, $isadmin);

            if ($rtv == 1) {
                $this->session->set_flashdata('message', '관리가 권한 변경이 성공했습니다.');
            } else {
                $this->session->set_flashdata('message', '관리가 권한 변경에 오류가 발생했습니다.');
            }
        }
        redirect('/user/detail?userid='.$userid);
    }

    function change_isdeprecated()
    {
        $userid = $this->input->get('userid');
        $isdeprecated = $this->input->get('isdeprecated') == 'true' ? true : false;

        $rtv = $this->user_model->change_isdeprecated($userid, $isdeprecated);
        if ($rtv) {
            if ($isdeprecated) {
                $this->session->set_flashdata('message', '사용자를 성공적으로 삭제하였습니다.');
            } else {
                $this->session->set_flashdata('message', '사용자를 성공적으로 부활하였습니다.');
            }

            redirect('user/index');
        } else {
            if ($isdeprecated) {
                $this->session->set_flashdata('message', '사용자를 삭제하는데 오류가 발생했습니다. 개발자에게 문의하세요.');
            } else {
                $this->session->set_flashdata('message', '사용자를 부활하는데 오류가 발생했습니다. 개발자에게 문의하세요.');
            }

            redirect('user/detail?userid='.$userid);
        }
    }
}
