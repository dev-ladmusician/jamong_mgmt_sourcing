<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Type extends CORE_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('type_model');
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

        $types = $this->type_model->gets_pagination($page, $per_page, $sort, $filter);
        $total_count = $this->type_model->get_total_count();

        $rtv = array(
            'row_count' => $total_count,
            'items' => $types,
            'sort' => $sort,
            'filter' => $filter
        );
        echo json_encode($rtv, JSON_PRETTY_PRINT);
    }



    function change_isdeprecated()
    {
        $table_id = $this->input->get('tableId');
        $isdeprecated = $this->input->get('isdeprecated') == 'true' ? true : false;

        $rtv = $this->type_model->change_isdeprecated($table_id, $isdeprecated);
        if ($rtv) {
            if ($isdeprecated) {
                $this->session->set_flashdata('message', '타입을 성공적으로 삭제하였습니다.');
            } else {
                $this->session->set_flashdata('message', '타입을 성공적으로 부활하였습니다.');
            }

            redirect('type/index');
        } else {
            if ($isdeprecated) {
                $this->session->set_flashdata('message', '타입을 삭제하는데 오류가 발생했습니다. 개발자에게 문의하세요.');
            } else {
                $this->session->set_flashdata('message', '타입을 부활하는데 오류가 발생했습니다. 개발자에게 문의하세요.');
            }

            redirect('type/index');
        }
    }

    function change_type_info() {
        $table_id = $this->input->post('tableId');
        $type = $this->input->post('type');
        $name_kr = $this->input->post('name_kr');

        $rtv = array(
            'name_kr' => $name_kr,
            'type' => $type,
            'rtv' => $this->type_model->change_type_info($table_id, $type, $name_kr)
        );
        echo json_encode(
            $rtv, JSON_PRETTY_PRINT);
    }
}
