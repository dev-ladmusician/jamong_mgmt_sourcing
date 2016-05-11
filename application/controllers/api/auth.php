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

    function test() {
        $longURL = "https://s3-ap-northeast-1.amazonaws.com/dongshin.movie/original/37_2016-05-11_14:49:11_test_video.mp4";
        $api_key = "AIzaSyDwWcpxM-X9fmtbspybET9QaAUwwC2XNJ0";
        $curlopt_url = "https://www.googleapis.com/urlshortener/v1/url?key=".$api_key;

        $ch = curl_init();
        //$timeout = 10;
        curl_setopt($ch, CURLOPT_URL, $curlopt_url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $jsonArray = array('longUrl' => $longURL);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($jsonArray));
        $shortURL = curl_exec($ch);    curl_close($ch);
        $result_array = json_decode($shortURL, true);


        //return $result_array['id']; // goo.gl

        $shortURL = curl_exec($ch);
        curl_close($ch);
        var_dump($shortURL);
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
