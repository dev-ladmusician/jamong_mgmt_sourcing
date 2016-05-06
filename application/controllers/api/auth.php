<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require('/var/www/html/MGMT/static/aws/aws-autoloader.php');

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

class Auth extends CORE_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }

    /**
     * 로그인
     * email, password
     * 로그인 성공시 userNumber return
     * 로그인 실패시 -1 return
     */
    function login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->user_model->get_user_by_email(array('email' => $email));

        if ($user != null && $user->email == $email &&
            $this->keyEncrypt($password) == $user->password) {
            echo json_encode($user->userNumber, JSON_PRETTY_PRINT);
        } else {
            echo json_encode(-1, JSON_PRETTY_PRINT);
        }
    }

    function join() {
        $email = $this->input->post('email');
        $nickname = $this->input->post('nickname');
        $password = $this->input->post('password');

        $user = $this->user_model->add(
            array (
                'email' => $email,
                'password' => $this->keyEncrypt($password),
                'nickname' => $nickname
            )
        );
    }

}
