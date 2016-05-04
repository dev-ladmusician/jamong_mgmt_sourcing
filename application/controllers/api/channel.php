<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require('/var/www/html/MGMT/static/aws/aws-autoloader.php');

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

class Channel extends CORE_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('channel_model');
        $this->load->model('user_model');
        $this->load->model('channel_profile_model');
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

    function get_managers()
    {
        $page = $this->input->get('page');
        $per_page = $this->input->get('count');
        $sort = $this->input->get('sorting');
        $filter = $this->input->get('filter');

        if ($page === false || $per_page === false) {
            $page = 1;
            $per_page = 10;
        }

        $users = $this->user_model->gets_manager_pagination($page, $per_page, $sort, $filter);
        $rtv = array(
            'row_count' => $per_page,
            'items' => $users,
            'sorting' => $sort
        );
        echo json_encode($rtv, JSON_PRETTY_PRINT);
    }

    function add_manager()
    {
        $channel_id = $this->input->get('channelId');
        $user_id = $this->input->get('userId');

        $rtv = $this->channel_model->add_manager($channel_id, $user_id);

        if ($rtv) {
            $this->session->set_flashdata('message', '매니저를 성공적으로 추가하였습니다.');
        } else {
            $this->session->set_flashdata('message', '매니저를 추가하는데 오류가 발생했습니다.');
        }
        redirect('channel/detail?channelId='.$channel_id);
    }

    function delete_manager()
    {
        $channel_id = $this->input->get('channelId');
        $user_id = $this->input->get('userId');


        $rtv = $this->channel_model->delete_manager($channel_id, $user_id);

        if ($rtv) {
            $this->session->set_flashdata('message', '매니저를 삭제하는데 성공하였습니다.');
        } else {
            $this->session->set_flashdata('message', '매니저를 삭제하는데 오류가 발생했습니다.');
        }
        redirect('channel/detail?channelId='.$channel_id);
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

    function upload_channel_picture()
    {
        error_reporting(E_ALL);
        ini_set('display_errors','On');

        $channel_id = $this->input->get('channelId');

        $uploaddir = '/tmp/';
        $uploadfile = $uploaddir . basename($_FILES['jamong-channel-image']['name']);

        if (move_uploaded_file($_FILES['jamong-channel-image']['tmp_name'], $uploadfile)) {
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

                $fileType = explode (".", $_FILES['jamong-channel-image']['name']);
                $fileName = 'ch_' . $channel_id. date( ' Y-m-d H:i:s.') .$fileType[1];
                // Upload a publicly accessible file. File size, file type, and md5 hash are automatically calculated by the SDK
                $result = $s3->putObject(array(
                    'Bucket' => 'dongshin.channel',
                    'Key'    => $fileName,
                    'Body'   => fopen($uploadfile, 'r'),
                    'ACL'    => 'public-read',
                    'ContentType'=>mime_content_type($uploadfile)
                ));

                $rtv = $this->channel_profile_model->get_id_by_channel($channel_id);

                //user_picture table에 user가 존재하지 않을 경우 추가
                if($rtv == null){
                    $this->channel_profile_model->add_ch_picture($channel_id,$result["ObjectURL"]);
                    $this->session->set_flashdata('message', '채널 대표 사진을 성공적으로 변경 했습니다.');
                    redirect('channel/detail?channelId=' . $channel_id);
                }else{
                    //user_picture table에 user가 이미 존재할 경우 업데이트
                    $this->channel_profile_model->update_ch_picture($channel_id,$result["ObjectURL"]);
                    $this->session->set_flashdata('message', '채널 대표 사진을 성공적으로 변경 했습니다.');
                    redirect('channel/detail?channelId=' . $channel_id);
                }

            } catch(S3Exception $e){
                print_r($e);
            }
        } else {
            $this->session->set_flashdata('message', '임시 저장에 실패 햇습니다..');
            redirect('channel/detail?channelId=' . $channel_id);
        }
    }

    function upload_channel_background()
    {
        $channel_id = $this->input->get('channelId');

        $uploaddir = '/tmp/';
        $uploadfile = $uploaddir . basename($_FILES['jamong-channel-background']['name']);

        if (move_uploaded_file($_FILES['jamong-channel-background']['tmp_name'], $uploadfile)) {
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

                $fileType = explode (".", $_FILES['jamong-channel-background']['name']);
                $fileName = 'bg_' . $channel_id. date( ' Y-m-d H:i:s.') .$fileType[1];
                // Upload a publicly accessible file. File size, file type, and md5 hash are automatically calculated by the SDK
                $result = $s3->putObject(array(
                    'Bucket' => 'dongshin.channel',
                    'Key'    => $fileName,
                    'Body'   => fopen($uploadfile, 'r'),
                    'ACL'    => 'public-read',
                    'ContentType'=>mime_content_type($uploadfile),
                    'KeyPrefix' =>'channel_bg_picture'
                ));

                $rtv = $this->channel_profile_model->get_id_by_channel($channel_id);

                //user_picture table에 user가 존재하지 않을 경우 추가
                if($rtv == null){
                    $this->channel_profile_model->add_bg_picture($channel_id,$result["ObjectURL"]);
                    $this->session->set_flashdata('message', '채널 배경 사진을 성공적으로 변경 했습니다.');
                    redirect('channel/detail?channelId=' . $channel_id);
                }else{
                    //user_picture table에 user가 이미 존재할 경우 업데이트
                    $this->channel_profile_model->update_bg_picture($channel_id,$result["ObjectURL"]);
                    $this->session->set_flashdata('message', '채널 배경 사진을 성공적으로 변경 했습니다.');
                    redirect('channel/detail?channelId=' . $channel_id);
                }

            } catch(S3Exception $e){
                print_r($e);
            }
        } else {
            $this->session->set_flashdata('message', '임시 저장에 실패 햇습니다..');
            redirect('channel/detail?channelId=' . $channel_id);
        }


//        if ($file["error"] == UPLOAD_ERR_OK) {
//                  $this->session->set_flashdata('message', '파일이 성공적으로 업로드 되었습니다.');
//                redirect('user/detail?userId=' . $user_id);
//        } else {
//            if ($file["error"] == UPLOAD_ERR_INI_SIZE) {
//                $this->session->set_flashdata('message', '업로드한 파일이 php.ini upload_max_filesize 지시어보다 큽니다.');
//                redirect('user/detail?userId=' . $user_id);
//            } elseif ($file["error"] == UPLOAD_ERR_FORM_SIZE) {
//                $this->session->set_flashdata('message', '업로드한 파일이 HTML 폼에서 지정한 MAX_FILE_SIZE 지시어보다 큽니다.');
//                redirect('user/detail?userId=' . $user_id);
//            } elseif ($file["error"] == UPLOAD_ERR_PARTIAL) {
//                $this->session->set_flashdata('message', '파일이 일부분만 전송되었습니다.');
//                redirect('user/detail?userId=' . $user_id);
//            } elseif ($file["error"] == UPLOAD_ERR_NO_FILE) {
//                $this->session->set_flashdata('message', '파일이 전송되지 않았습니다.');
//                redirect('user/detail?userId=' . $user_id);
//            } elseif ($file["error"] == UPLOAD_ERR_NO_TMP_DIR) {
//                $this->session->set_flashdata('message', '임시 폴더가 없습니다.');
//                redirect('user/detail?userId=' . $user_id);
//            } elseif ($file["error"] == UPLOAD_ERR_CANT_WRITE) {
//                $this->session->set_flashdata('message', '디스크에 파일 쓰기를 실패했습니다.');
//                redirect('user/detail?userId=' . $user_id);
//            } elseif ($file["error"] == UPLOAD_ERR_EXTENSION) {
//                $this->session->set_flashdata('message', '확장에 의해 파일 업로드가 중지되었습니다.');
//                redirect('user/detail?userId=' . $user_id);
//            }
//        }
    }
}
