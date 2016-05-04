<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require('/var/www/html/MGMT/static/aws/aws-autoloader.php');

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

class Content extends CORE_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('content_model');
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

        $users = $this->content_model->gets_pagination($page, $per_page, $sort, $filter);
        $total_count = $this->content_model->get_total_count();

        $rtv = array(
            'row_count' => $total_count,
            'items' => $users,
            'sort' => $sort,
            'filter' => $filter
        );
        echo json_encode($rtv, JSON_PRETTY_PRINT);
    }

    function change_isdeprecated()
    {
        $content_id = $this->input->get('contentId');
        $isdeprecated = $this->input->get('isdeprecated') == 'true' ? true : false;

        $rtv = $this->content_model->change_isdeprecated($content_id, $isdeprecated);
        if ($rtv) {
            if ($isdeprecated) {
                $this->session->set_flashdata('message', '영상을 성공적으로 삭제하였습니다.');
            } else {
                $this->session->set_flashdata('message', '영상을 성공적으로 부활하였습니다.');
            }
        } else {
            if ($isdeprecated) {
                $this->session->set_flashdata('message', '영상을 삭제하는데 오류가 발생했습니다. 개발자에게 문의하세요.');
            } else {
                $this->session->set_flashdata('message', '영상을 부활하는데 오류가 발생했습니다. 개발자에게 문의하세요.');
            }
        }
        redirect('content/index');
    }

    function upload_content_image()
    {
        error_reporting(E_ALL);
        ini_set('display_errors','On');
        $content_id = $this->input->get('contentId');

        $uploaddir = '/tmp/';
        $uploadfile = $uploaddir . basename($_FILES['jamong-content-image']['name']);

        if (move_uploaded_file($_FILES['jamong-content-image']['tmp_name'], $uploadfile)) {
            try {
                // Instantiate an S3 client
                $s3 = S3Client::factory([
                    'version' => 'latest',
                    'region' => 'ap-northeast-1',
                    'credentials' => [
                        'key' => 'AKIAJWWW3TRCBB2ACYBA',
                        'secret' => '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'
                    ]
                ]);

                $fileType = explode(".", $_FILES['jamong-content-image']['name']);
                $fileName = $content_id . date(' Y-m-d H:i:s.') . $fileType[1];
                // Upload a publicly accessible file. File size, file type, and md5 hash are automatically calculated by the SDK
                $result = $s3->putObject(array(
                    'Bucket' => 'dongshin.movie.thumbnail',
                    'Key' => $fileName,
                    'Body' => fopen($uploadfile, 'r'),
                    'ACL' => 'public-read',
                    'ContentType' => mime_content_type($uploadfile)
                ));

                $rtv = $this->content_model->update($content_id, $result["ObjectURL"]);
                if($rtv){
                    $this->session->set_flashdata('message', '썸네일을 성공적으로 변경 했습니다.');
                    redirect('content/detail?contentId=' . $content_id);
                }

            } catch (S3Exception $e) {
                print_r($e);
            }
        } else {
            $this->session->set_flashdata('message', '임시 저장에 실패 햇습니다..');
            redirect('content/detail?contentId=' . $content_id);
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
