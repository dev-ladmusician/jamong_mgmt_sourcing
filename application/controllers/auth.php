<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CORE_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->library('form_validation');
    }

    function index()
    {
        redirect('/auth/login');
    }

    /* 로그인 */
    function login()
    {
        $this->__is_logined();

        $this->form_validation->set_rules('email', '이메일', 'required|valid_email');
        $this->form_validation->set_rules('password', '비밀번호', 'required');

        $isValidate = $this->form_validation->run();

        $email = $this->input->post('email');
        $password = $this->input->post('password');

        if ($isValidate) {
            $input_data = array('email' => $email);

            $rtv = $this->user_model->get_user_by_email($input_data);

            // db 정보와 확인
            if ($rtv != null && count($rtv) > 0) {
                $user = $rtv[0];
                if ($user->email == $input_data['email'] && $this->keyEncrypt($password) == $user->password) {
                    if ($user->is_admin || $user->is_superadmin) {
                        $this->handle_login($user);
                    } else {
                        $this->session->set_flashdata('message', '관리자만 접근할 수 있습니다.');
                        redirect('auth/login');
                    }
                } else {
                    $this->session->set_flashdata('message', '로그인에 실패하였습니다.');
                    redirect('auth/login');
                }
            } else {
                $this->session->set_flashdata('message', '로그인에 실패하였습니다.');
                if ($this->input->get('returnURL') === "") {
                    $this->__get_views('_AUTH/login');
                }
            }
        }else {
            $this->__get_views('_AUTH/login', array('returnURL' => $this->input->get('returnURL')));
        }
    }

    /* 회원가입 */
    function join()
    {
        $this->__get_views('_AUTH/join');
    }

    /* submit 회원가입 */
    function submit_join()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $input_data = array(
            'email' => $email,
            'password' => $this->keyEncrypt($password)
        );

        $rtv = $this->user_model->add($input_data);

        if ($rtv != null && $rtv > 0) {
            $this->session->set_flashdata('message', '회원을 성공적으로 저장하였습니다.');
            redirect('auth/login');
        } else {
            $this->session->set_flashdata('message', '회원 추가하는데 오류가 발생했습니다. 개발자에게 문의하세요.');
            $this->__get_views('_AUTH/join.php');
        }
    }

    /* 로그아웃 */
    function logout()
    {
        $this->session->sess_destroy();
        redirect('/auth/login');
    }

    function handle_login($user)
    {
        $this->session->set_flashdata('message', '로그인에 성공하였습니다.');
        $this->session->set_userdata('userid', $user->userNumber);
        $this->session->set_userdata('is_login', true);
        $this->session->set_userdata('email', $user->email);
        $this->session->set_userdata('nickname', $user->nickName);
        $this->session->set_userdata('isadmin', $user->is_admin);
        $this->session->set_userdata('issuperadmin', $user->is_superadmin);

        $returnURL = $this->input->get('returnURL');

        if ($returnURL === false || $returnURL === "") {
            redirect('home/index');
        }

        redirect($returnURL);
    }
}
