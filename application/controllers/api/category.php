<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Category extends CORE_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('category_model');
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

        $categories = $this->category_model->gets_pagination($page, $per_page, $sort, $filter);
        $total_count = $this->category_model->get_total_count();

        $rtv = array(
            'row_count' => $total_count,
            'items' => $categories,
            'sort' => $sort,
            'filter' => $filter
        );
        echo json_encode($rtv, JSON_PRETTY_PRINT);
    }



    function change_isdeprecated()
    {
        $category_id = $this->input->get('categoryId');
        $isdeprecated = $this->input->get('isdeprecated') == 'true' ? true : false;

        $rtv = $this->category_model->change_isdeprecated($category_id, $isdeprecated);
        if ($rtv) {
            if ($isdeprecated) {
                $this->session->set_flashdata('message', '카테고리를 성공적으로 삭제하였습니다.');
            } else {
                $this->session->set_flashdata('message', '카테고리를 성공적으로 부활하였습니다.');
            }

            redirect('category/index');
        } else {
            if ($isdeprecated) {
                $this->session->set_flashdata('message', '카테고리를 삭제하는데 오류가 발생했습니다. 개발자에게 문의하세요.');
            } else {
                $this->session->set_flashdata('message', '카테고리를 부활하는데 오류가 발생했습니다. 개발자에게 문의하세요.');
            }

            redirect('category/index');
        }
    }

    function change_category_info() {
        $category_id = $this->input->post('categoryId');
        $name_kr = $this->input->post('name_kr');
        $name_en = $this->input->post('name_en');

        $rtv = array(
            'name_en' => $name_en,
            'name_kr' => $name_kr,
            'id' => $category_id,
            'rtv' => $this->category_model->change_category_info($category_id, $name_kr, $name_en)
        );
        echo json_encode(
            $rtv, JSON_PRETTY_PRINT);
    }

    function create(){
        $name_kr = $this->input->post('name_kr');
        $name_en = $this->input->post('name_en');

        if( !strlen($name_kr) || !strlen($name_en)){
            $this->session->set_flashdata('message', '카테고리 이름을 모두 입력해주세요');
            redirect('/category/create');
        }else{
            $rtv = $this->category_model->create($name_kr,$name_en);
            if($rtv){
                $this->session->set_flashdata('message', '카테고리를 추가하는데 성공했습니다.');
                redirect('/category/detail?categoryId=' . $rtv);
            }else{
                $this->session->set_flashdata('message', '카테고리를 추가하는데 오류가 발생했습니다.');
                redirect('/category/create');
            }
        }
    }
}
