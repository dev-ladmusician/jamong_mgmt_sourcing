<?php
class Type_model extends CI_Model
{
    private $table;

    function __construct()
    {
        parent::__construct();
        $this->table = 'jumper__type';
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
        if (isset($sort['ai'])) $this->db->order_by("ai", $sort['ai']);
        if (isset($sort['type'])) $this->db->order_by("type", $sort['type']);
        if (isset($sort['name_kr'])) $this->db->order_by("name_kr", $sort['name_kr']);

        // filter
        if ($filter != null && isset($filter['ai'])) $this->db->like('ai', $filter['ai']);
        if ($filter != null && isset($filter['type'])) $this->db->like('type', urldecode($filter['type']));
        if ($filter != null && isset($filter['name_kr'])) $this->db->like('name_kr', urldecode($filter['name_kr']));

        return $this->db->get()->result();
    }

    function get_total_count()
    {
        return $this->db->count_all($this->table);
    }

    function get_by_id($table_id)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('ai', $table_id);
        return $this->db->get()->result();
    }

    function change_type_info($table_id, $type_id, $name_kr)
    {
        $data = array(
            'name_kr' => $name_kr,
            'type' => $type_id
        );

        $this->db->where('ai', $table_id);
        $this->db->update($this->table, $data);

        return $this->db->affected_rows();
    }

    function change_isdeprecated($table_id, $isdeprecated)
    {
        try {
            $data = array(
                'isDeprecated' => $isdeprecated
            );

            $this->db->where('ai', $table_id);
            $this->db->update($this->table, $data);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}