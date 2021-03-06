<?php

class Content_model extends CI_Model
{
    private $table;

    function __construct()
    {
        parent::__construct();
        $this->table = 'jumper_talk';
    }

    function gets_pagination($page, $per_page, $sort, $filter, $user_id) {
        if ($page === 1) {
            $this->db->limit($per_page);

        } else {
            $this->db->limit($per_page, ($page - 1) * $per_page);
        }
        $this->db->select('jumper_talk.inum, jumper_talk.title, jumper_talk.nickName, jumper_talk.userNumber, jumper_talk.talk, jumper_talk.price,
                           jumper_talk.view, jumper_talk.likes, jumper_talk.datetime, jumper_talk.isdeprecated, jumper_talk.filename, 
                           jumper_talk.type as type_id, jumper_talk.cate as category_id,
                           jumper__type.name_kr as type,
                           jumper__category.name_kr as category,
                           jumper__channellist.channelnum, jumper__channellist.channelname');
        $this->db->from($this->table);
        $this->db->join('jumper__type', 'jumper__type.type = jumper_talk.type', 'left');
        $this->db->join('jumper__category', 'jumper__category.catenum = jumper_talk.cate', 'left');
        $this->db->join('jumper__channels', 'jumper__channels.inum = jumper_talk.inum', 'left');
        $this->db->join('jumper__channellist', 'jumper__channellist.channelnum = jumper__channels.channelnum', 'left');

        if ($user_id) {
            $this->db->where('jumper_talk.userNumber', $user_id);
        }

        // sorting
        if (isset($sort['id'])) $this->db->order_by("inum", $sort['id']);
        if (isset($sort['title'])) $this->db->order_by("title", $sort['title']);
        if (isset($sort['nickname'])) $this->db->order_by("nickName", $sort['nickname']);
        if (isset($sort['content'])) $this->db->order_by("talk", $sort['content']);
        if (isset($sort['price'])) $this->db->order_by("price", $sort['price']);
        if (isset($sort['view'])) $this->db->order_by("view", $sort['view']);
        if (isset($sort['like'])) $this->db->order_by("likes", $sort['like']);
        if (isset($sort['type'])) $this->db->order_by("jumper__type.name_kr", $sort['type']);
        if (isset($sort['category'])) $this->db->order_by("jumper__category.name_kr", $sort['category']);
        if (isset($sort['datetime'])) $this->db->order_by("datetime", $sort['datetime']);
        if (isset($sort['isdeprecated'])) $this->db->order_by("isdeprecated", $sort['isdeprecated']);

        // filter
        if ($filter != null && isset($filter['id'])) $this->db->like('inum', urldecode($filter['id']));
        if ($filter != null && isset($filter['title'])) $this->db->like('title', urldecode($filter['title']));
        if ($filter != null && isset($filter['nickname'])) $this->db->like('nickName', urldecode($filter['nickname']));
        if ($filter != null && isset($filter['content'])) $this->db->like('talk', urldecode($filter['content']));
        if ($filter != null && isset($filter['price'])) $this->db->like('price', urldecode($filter['price']));
        if ($filter != null && isset($filter['view'])) $this->db->like('view', $filter['view']);
        if ($filter != null && isset($filter['like'])) $this->db->like('likes', $filter['like']);
        if ($filter != null && isset($filter['type'])) $this->db->like('jumper__type.name_kr', urldecode($filter['type']));
        if ($filter != null && isset($filter['category'])) $this->db->like('jumper__category.name_kr', urldecode($filter['category']));
        if ($filter != null && isset($filter['datetime'])) $this->db->like('datetime', urldecode($filter['datetime']));

        return $this->db->get()->result();
    }

    function get_items_in_channel($page, $per_page, $sort, $filter, $channelnum) {
        if ($page === 1) {
            $this->db->limit($per_page);

        } else {
            $this->db->limit($per_page, ($page - 1) * $per_page);
        }
        $this->db->select('jumper_talk.inum, jumper_talk.title, jumper_talk.nickName, jumper_talk.userNumber, jumper_talk.talk, jumper_talk.price,
                           jumper_talk.view, jumper_talk.likes, jumper_talk.datetime, jumper_talk.isdeprecated, jumper_talk.filename, 
                           jumper_talk.type as type_id, jumper_talk.cate as category_id,
                           jumper__type.name_kr as type,
                           jumper__category.name_kr as category,
                           jumper__channellist.channelnum, jumper__channellist.channelname');
        $this->db->from($this->table);
        $this->db->join('jumper__type', 'jumper__type.type = jumper_talk.type', 'left');
        $this->db->join('jumper__category', 'jumper__category.catenum = jumper_talk.cate', 'left');
        $this->db->join('jumper__channels', 'jumper__channels.inum = jumper_talk.inum', 'left');
        $this->db->join('jumper__channellist', 'jumper__channellist.channelnum = jumper__channels.channelnum', 'left');
        $this->db->where('jumper_talk.ch', $channelnum);

        // sorting
        if (isset($sort['id'])) $this->db->order_by("inum", $sort['id']);
        if (isset($sort['title'])) $this->db->order_by("title", $sort['title']);
        if (isset($sort['nickname'])) $this->db->order_by("nickName", $sort['nickname']);
        if (isset($sort['content'])) $this->db->order_by("talk", $sort['content']);
        if (isset($sort['price'])) $this->db->order_by("price", $sort['price']);
        if (isset($sort['view'])) $this->db->order_by("view", $sort['view']);
        if (isset($sort['like'])) $this->db->order_by("likes", $sort['like']);
        if (isset($sort['type'])) $this->db->order_by("jumper__type.name_kr", $sort['type']);
        if (isset($sort['category'])) $this->db->order_by("jumper__category.name_kr", $sort['category']);
        if (isset($sort['datetime'])) $this->db->order_by("datetime", $sort['datetime']);
        if (isset($sort['isdeprecated'])) $this->db->order_by("isdeprecated", $sort['isdeprecated']);

        // filter
        if ($filter != null && isset($filter['id'])) $this->db->like('inum', urldecode($filter['id']));
        if ($filter != null && isset($filter['title'])) $this->db->like('title', urldecode($filter['title']));
        if ($filter != null && isset($filter['nickname'])) $this->db->like('nickName', urldecode($filter['nickname']));
        if ($filter != null && isset($filter['content'])) $this->db->like('talk', urldecode($filter['content']));
        if ($filter != null && isset($filter['price'])) $this->db->like('price', urldecode($filter['price']));
        if ($filter != null && isset($filter['view'])) $this->db->like('view', $filter['view']);
        if ($filter != null && isset($filter['like'])) $this->db->like('likes', $filter['like']);
        if ($filter != null && isset($filter['type'])) $this->db->like('jumper__type.name_kr', urldecode($filter['type']));
        if ($filter != null && isset($filter['category'])) $this->db->like('jumper__category.name_kr', urldecode($filter['category']));
        if ($filter != null && isset($filter['datetime'])) $this->db->like('datetime', urldecode($filter['datetime']));

        return $this->db->get()->result();
    }

    function get_by_id($content_id)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('inum', $content_id);
        return $this->db->get()->result();
    }

    function get_total_count()
    {
        return $this->db->count_all($this->table);
    }

    function get_total_items_in_channel($channelnum)
    {
        $this->db->select('inum');
        $this->db->from($this->table);
        $this->db->where('ch', $channelnum);
        return count($this->db->get()->result());
    }

    function change_isdeprecated($content_id, $isdeprecated)
    {
        try {
            $data = array(
                'isdeprecated' => $isdeprecated
            );

            $this->db->where('inum', $content_id);
            $this->db->update($this->table, $data);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    function update($content_id,$file_name)
    {
        try {
            $input_data = array(
                'picture' => $file_name
            );

            $this->db->where('inum', $content_id);
            $this->db->update($this->table, $input_data);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    function update_thumbnail($content_id, $file_name) {
        try {
            $input_data = array(
                'picture' => $file_name
            );

            $this->db->where('inum', $content_id);
            $this->db->update($this->table, $input_data);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    function update_filename($content_id, $file_name, $file_format)
    {
        $input_data = array(
            'filename' => $file_name,
            'format' => $file_format
        );

        $this->db->where('inum', $content_id);
        $this->db->update($this->table, $input_data);

        return $this->db->affected_rows();
    }
    function update_xml($content_id, $file_name)
    {
        try {
            $input_data = array(
                'xml' => $file_name,
            );

            $this->db->where('inum', $content_id);
            $this->db->update($this->table, $input_data);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    function add_item($input_data){
        try {
            $this->db->insert($this->table, $input_data);
            $result = $this->db->insert_id();

            $insert_data_to_relation_table = array (
                'channelnum' => $input_data['ch'],
                'inum' => $result
            );
            $this->db->insert('jumper__channels', $insert_data_to_relation_table);

            return $result;
        } catch (Exception $e) {
            return false;
        }
    }

    function change_content_info($input_data){
        $data = array(
            'title' => $input_data['title'],
            'talk' => $input_data['content'],
            'price' => $input_data['price'],
            'type' => $input_data['typeId'],
            'cate' => $input_data['categoryId'],
            'ch' => $input_data['channelId']
        );

        $this->db->where('inum', $input_data['contentId']);
        $this->db->update($this->table, $data);

        $this->db->where('inum', $input_data['contentId']);
        $this->db->update('jumper__channels', array(
            'channelnum' => $input_data['ch']
        ));

        return $this->db->affected_rows();
    }
}