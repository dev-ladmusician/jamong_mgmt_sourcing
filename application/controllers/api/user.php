<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//require(realpath($_SERVER["DOCUMENT_ROOT"]) . '/MGMT/static/aws/aws-autoloader.php') ;

require('/var/www/html/MGMT/static/aws/aws-autoloader.php');

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

class User extends CORE_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('user_picture_model');
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
        $total_count = $this->user_model->get_total_count();

        $rtv = array(
            'row_count' => $total_count,
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

    function change_is_superadmin()
    {
        $user_id = $this->input->get('userId');
        $is_admin = $this->input->get('isadmin') == 'true' ? true : false;

        $rtv = $this->user_model->change_is_superadmin($user_id, $is_admin);
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

        if (strlen($password) == 0) {
            $this->session->set_flashdata('message', '비밀 번호 길이가 짧습니다.');
            redirect('user/detail?userId=' . $user_id);
        } else {
            $rtv = $this->user_model->change_password($user_id, $this->keyEncrypt($password));

            if ($rtv) {
                $this->session->set_flashdata('message', '비밀 번호를 변경하는데 성공 했습니다.');
                redirect('user/detail?userId=' . $user_id);
            } else {
                $this->session->set_flashdata('message', '비밀 번호를 변경하는데 오류가 발생했습니다.');
                redirect('user/detail?userId=' . $user_id);
            }
        }
    }

    function block_user()
    {
        $user_id = $this->input->get('userId');
        $state = $this->input->get('state');

        //state가 active 이면 block 가능
        if (strcmp($state, 'active') == 0) {

            $rtv = $this->user_model->change_state_block($user_id);

            if ($rtv) {
                $this->session->set_flashdata('message', '계정이 이용정지 되었습니다.');

                redirect('user/detail?userId=' . $user_id);
            } else {
                $this->session->set_flashdata('message', '오류가 발생했습니다.');

                redirect('user/detail?userId=' . $user_id);
            }
        } else {

            if (strcmp($state, 'block') == 0) {

                $this->session->set_flashdata('message', '이미 이용정지 된 계정 입니다.');
                redirect('user/detail?userId=' . $user_id);

            } else if (strcmp($state, 'out') == 0) {

                $this->session->set_flashdata('message', '이미 탈퇴한 계정 입니다.');
                redirect('user/detail?userId=' . $user_id);

            }

        }
    }

    function upload_profile_image()
    {
        $user_id = $this->input->get('userId');

        $uploaddir = '/tmp/';
        $uploadfile = $uploaddir . basename($_FILES['jamong-profile-image']['name']);

        if (move_uploaded_file($_FILES['jamong-profile-image']['tmp_name'], $uploadfile)) {
            try{
                // Instantiate an S3 client
                $s3 = S3Client::factory([
                    'version'     => 'latest',
                    'region'      => 'ap-northeast-1',
                    'credentials' => [
                        'key'    => 'AKIAJWWW3TRCBB2ACYBA',
                        'secret' => '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'
                    ]
                ]);

                $fileType = explode (".", $_FILES['jamong-profile-image']['name']);
                $fileName = $user_id . date( ' Y-m-d H:i:s.') .$fileType[1];
                // Upload a publicly accessible file. File size, file type, and md5 hash are automatically calculated by the SDK
                $result = $s3->putObject(array(
                    'Bucket' => 'dongshin.user',
                    'Key'    => $fileName. '/' .  $fileName,
                    'Body'   => fopen($uploadfile, 'r'),
                    'ACL'    => 'public-read',
                    'ContentType'=>mime_content_type($uploadfile)
                ));

                $rtv = $this->user_picture_model->get_id_by_user($user_id);

                //user_picture table에 user가 존재하지 않을 경우 추가
                if($rtv == null){
                    $this->user_picture_model->add($user_id,$result["ObjectURL"]);
                    $this->session->set_flashdata('message', '프로필 사진을 성공적으로 변경 했습니다.');
                    redirect('user/detail?userId=' . $user_id);
                }else{
                    //user_picture table에 user가 이미 존재할 경우 업데이트
                    $this->user_picture_model->update($user_id,$result["ObjectURL"]);
                    $this->session->set_flashdata('message', '프로필 사진을 성공적으로 변경 했습니다.');
                    redirect('user/detail?userId=' . $user_id);
                }

            } catch(S3Exception $e){
                print_r($e);
            }
        } else {
            $this->session->set_flashdata('message', '임시 저장에 실패 햇습니다..');
            redirect('user/detail?userId=' . $user_id);
        }
    }
}


