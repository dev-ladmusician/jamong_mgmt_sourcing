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

    /**
     * 영상 정보 업로드
     */
    function create_info(){
        $price = $this->input->post('jamong-content-price');
        $title = $this->input->post('jamong-content-title');
        $content = $this->input->post('jamong-content-content');
        $channelId = $this->input->post('jamong-content-channel');
        $typeId = $this->input->post('jamong-content-type');
        $categoryId = $this->input->post('jamong-content-category');

        if(strlen($title)){
            if(strlen($content)){
                $rtv = $this->content_model->add_item(array('price' => $price,
                                                                'title' => $title,
                                                                'talk' => $content,
                                                                'ch' =>$channelId,
                                                                'type' => $typeId,
                                                                'cate' => $categoryId,
                                                                'userNumber' => $this->session->userdata('userid'),
                                                                'nickname' => $this->session->userdata('nickname')));
                if($rtv){
                    $this->session->set_flashdata('message', '영상 정보를 성공적으로 등록하였습니다.');
                    redirect('/content/detail?contentId=' .$rtv);
                }else{
                    $this->session->set_flashdata('message', '영상 정보를 등록하는데 실패하였습니다.');
                    redirect('/content/create_info');
                }
            }else{
                $this->session->set_flashdata('message', '내용을 입력해주세요.');
                redirect('/content/create_info');
            }
        }else{
            $this->session->set_flashdata('message', '제목을 입력해주세요.');
            redirect('/content/create_info');
        }
    }

    function get_items()
    {
        $page = $this->input->get('page');
        $per_page = $this->input->get('count');
        $sort = $this->input->get('sorting');
        $filter = $this->input->get('filter');

        $user_id = $this->input->get('userId');

        if ($page === false || $per_page === false) {
            $page = 1;
            $per_page = 10;
        }

        $users = $this->content_model->gets_pagination($page, $per_page, $sort, $filter, $user_id);
        $total_count = $this->content_model->get_total_count();

        $rtv = array(
            'row_count' => $total_count,
            'items' => $users,
            'sort' => $sort,
            'filter' => $filter,
            'userId' => $user_id
        );
        echo json_encode($rtv, JSON_PRETTY_PRINT);
    }

    function get_items_in_channel()
    {
        $page = $this->input->get('page');
        $per_page = $this->input->get('count');
        $sort = $this->input->get('sorting');
        $filter = $this->input->get('filter');
        $channelnum = $this->input->get('channelId');

        if ($page === false || $per_page === false) {
            $page = 1;
            $per_page = 10;
        }

        $users = $this->content_model->get_items_in_channel($page, $per_page, $sort, $filter, $channelnum);
        $total_count = $this->content_model->get_total_items_in_channel($channelnum);

        $rtv = array(
            'row_count' => $total_count,
            'items' => $users
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

    function change_content_info() {

        $input_data = array("contentId" => $this->input->get('contentId'),
                            "channelId" => $this->input->post('jamong-content-channel'),
                            "categoryId" => $this->input->post('jamong-content-category'),
                            "typeId" => $this->input->post('jamong-content-type'),
                            "price" => $this->input->post('jamong-content-price'),
                            "title" => $this->input->post('jamong-content-title'),
                            "content" => $this->input->post('jamong-content-content') );

        $rtv = $this->content_model->change_content_info($input_data);

        if ($rtv > 0) {
            $this->session->set_flashdata('message', '컨텐츠를 성공적으로 수정하였습니다.');
        } else {
            $this->session->set_flashdata('message', '변경된 정보가 없거나 컨텐츠를 수정하는데 오류가 발생했습니다.');
        }
        redirect('/content/detail?contentId='.$input_data['contentId']);
    }

    function upload_movie()
    {
        $content_id = $this->input->get('contentId');
        $content = $this->content_model->get_by_id($content_id)[0];

        $uploaddir = '/tmp/';
        $uploadfile = $uploaddir.basename($_FILES['jamong-content-movie']['name']);

        if (move_uploaded_file($_FILES['jamong-content-movie']['tmp_name'], $uploadfile)) {
            // Instantiate an S3 client
            $s3 = S3Client::factory([
                'version' => 'latest',
                'region' => 'ap-northeast-1',
                'credentials' => [
                    'key' => $this->config->item('S3_CREDENTIAL_KEY'),
                    'secret' => $this->config->item('S3_CREDENTIAL_SECRET')
                ]
            ]);

            $file_type = explode(".", $_FILES['jamong-content-movie']['name']);
            $file_original_name = $file_type[0];
            $file_original_format = $file_type[1];
            $file_new_filename = $content_id."_".date('Y-m-d_H:i:s')."_".$file_original_name;

//            if (strlen($content->filename) > 0) {
//                $file_new_filename = $content->filename;
//            } else {
//                $file_new_filename = $content_id."_".date('Y-m-d_H:i:s')."_".$file_original_name;
//            }

            $result = $s3->putObject(array(
                'Bucket' => 'dongshin.movie',
                'Key' => 'original/' . $file_new_filename.".".$file_original_format,
                'Body' => fopen($uploadfile, 'r'),
                'ACL' => 'public-read',
                'ContentType' => mime_content_type($uploadfile)
            ));

            if ($result['@metadata']['statusCode'] == 200) {
                // removce temp file
                unlink($uploadfile);
                // upload db record
                $rtv = $this->content_model->update_filename($content_id, $file_new_filename, $file_original_format);
                if ($rtv > 0) {
                    $this->session->set_flashdata('message', '영상을 성공적으로 업데이트 하였습니다.');
                } else {
                    $this->session->set_flashdata('message', '데이터베이스에 영상정보를 업데이트 하는데 오류가 발생했습니다.');
                }
            } else {
                $this->session->set_flashdata('message', '영상을 파일서버에 업로드하는데 오류가 발생했습니다.');
            }

        } else {
            $this->session->set_flashdata('message', '영상을 임시 저장소에 업로드하는데 오류가 발생했습니다.');
        }
        redirect('content/detail?contentId=' . $content_id);
    }

    function upload_content_image()
    {
        $content_id = $this->input->get('contentId');
        $content_filename = $this->input->get('contentFileName');

        $uploaddir = '/tmp/';
        $uploadfile = $uploaddir.basename($_FILES['jamong-content-image']['name']);

        if (move_uploaded_file($_FILES['jamong-content-image']['tmp_name'], $uploadfile)) {
            try {
                // Instantiate an S3 client
                $s3 = S3Client::factory([
                    'version' => 'latest',
                    'region' => 'ap-northeast-1',
                    'credentials' => [
                        'key' => $this->config->item('S3_CREDENTIAL_KEY'),
                        'secret' => $this->config->item('S3_CREDENTIAL_SECRET')
                    ]
                ]);

                $file_type = explode(".", $_FILES['jamong-content-image']['name']);
                $file_original_format = $file_type[1];

                $result = $s3->putObject(array(
                    'Bucket' => 'dongshin.images',
                    'Key' => 'playlist/'.$content_filename.'/high_thumb.'.$file_original_format,
                    'Body' => fopen($uploadfile, 'r'),
                    'ACL' => 'public-read',
                    'ContentType' => mime_content_type($uploadfile)
                ));

                if ($result['@metadata']['statusCode'] == 200) {
                    // remove temp image
                    unlink($uploadfile);

                    // update database info
                    $rtv = $this->content_model->update_thumbnail($content_id, $result["ObjectURL"]);
                    if($rtv > 0){
                        $this->session->set_flashdata('message', '썸네일을 성공적으로 변경 했습니다.');
                    } else {
                        $this->session->set_flashdata('message', '썸네일 정보를 데이터베이스에서 업로드 하는데 오류가 발생했습니다.');
                    }
                } else {
                    $this->session->set_flashdata('message', '썸네일을 파일서버에 업로드하는데 오류가 발생했습니다.');
                }
            } catch (S3Exception $e) {
                print_r($e);
            }
        } else {
            $this->session->set_flashdata('message', '썸네일을 임시 저장소에 업로드하는데 오류가 발생했습니다.');
        }
        redirect('content/detail?contentId=' . $content_id);
    }

    function delet_movie() {

    }
}
