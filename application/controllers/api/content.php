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
}
