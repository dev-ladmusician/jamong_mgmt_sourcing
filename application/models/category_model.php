<?php
class Category_model extends CI_Model
{
    private $table;

    function __construct()
    {
        parent::__construct();
        $this->table = 'jumper__category';
    }

    function gets_pagination($page, $per_page, $sort, $filter) {
        if ($page === 1) {
            $this->db->limit($per_page);

        } else {
            $this->db->limit($per_page, ($page - 1) * $per_page);
        }
        $this->db->select('*');
        $this->db->from($this->table);

        // sorting
        if (isset($sort['catenum'])) $this->db->order_by("catenum", $sort['catenum']);
        if (isset($sort['name_kr'])) $this->db->order_by("name_kr", $sort['name_kr']);
        if (isset($sort['name_en'])) $this->db->order_by("name_en", $sort['name_en']);

        // filter
        if ($filter != null && isset($filter['catenum'])) $this->db->like('catenum', $filter['catenum']);
        if ($filter != null && isset($filter['name_kr'])) $this->db->like('name_kr', urldecode($filter['name_kr']));
        if ($filter != null && isset($filter['name_en'])) $this->db->like('name_en', urldecode($filter['name_en']));

        return $this->db->get()->result();
    }
    
    function get_total_count()
    {
        return $this->db->count_all($this->table);
    }

    function get_by_id($category_id)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('catenum', $category_id);
        return $this->db->get()->result();
    }

    function change_category_info($category_id, $name_kr, $name_en)
    {
        $data = array(
            'name_kr' => $name_kr,
            'name_en' => $name_en
        );

        $this->db->where('catenum', $category_id);
        $this->db->update($this->table, $data);

        return $this->db->affected_rows();
    }

    function change_isdeprecated($category_id, $isdeprecated)
    {
        try {
            $data = array(
                'isDeprecated' => $isdeprecated
            );

            $this->db->where('catenum', $category_id);
            $this->db->update($this->table, $data);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    function create($name_kr, $name_en){
        try {
            $input_data = array(
                'name_kr' => $name_kr,
                'name_en' => $name_en
            );

            $this->db->insert($this->table, $input_data);
            $result = $this->db->insert_id();

            return $result;
        } catch (Exception $e) {
            return false;
        }
    }
}