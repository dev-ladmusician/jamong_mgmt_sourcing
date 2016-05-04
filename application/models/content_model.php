<?php

class Content_model extends CI_Model
{
    private $table;

    function __construct()
    {
        parent::__construct();
        $this->table = 'jumper_talk';
    }

    function gets_pagination($page, $per_page, $sort, $filter) {
        if ($page === 1) {
            $this->db->limit($per_page);

        } else {
            $this->db->limit($per_page, ($page - 1) * $per_page);
        }
        $this->db->select('jumper_talk.inum, jumper_talk.title, jumper_talk.nickName, jumper_talk.talk, jumper_talk.price,
                           jumper_talk.view, jumper_talk.likes, jumper_talk.datetime,
                           jumper__type.name_kr as type,
                           jumper__category.name_kr as category');
        $this->db->from($this->table);
        $this->db->join('jumper__type', 'jumper__type.ai = jumper_talk.type', 'left');
        $this->db->join('jumper__category', 'jumper__category.catenum = jumper_talk.cate', 'left');

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

    function get_by_id($channel_id)
    {
        $query_str = "SELECT l.*, p.ch_picture, p.bg_picture FROM jumper__channellist l ".
                     "LEFT OUTER JOIN jumper__channel_profile p ON l.channelnum = p.channelnum ".
                     "AND l.userNumber = p.userNumber ".
                     "WHERE l.channelnum=". $channel_id;
        $query = $this->db->query($query_str);
        return $query->result();
    }

    function get_managers($channel_id)
    {
        $this->db->select('*');
        $this->db->from("jumper__managers");
        $this->db->join('jamong__tb_users', 'jamong__tb_users.userNumber = jumper__managers.userNumber', 'left');
        $this->db->join('jumper_user', 'jumper_user.userNumber = jumper__managers.userNumber', 'left');
        $this->db->where('channelnum', $channel_id);
        return $this->db->get()->result();
    }

    function change_channel_info($channel_id, $name, $nickname, $content)
    {
        $data = array(
            'channelname' => $name,
            'nickName' => $nickname,
            'chdesc' => $content
        );

        $this->db->where('channelnum', $channel_id);
        return $this->db->affected_rows();
    }

    function change_isdeprecated($channel_id, $isdeprecated)
    {
        try {
            $data = array(
                'isdeprecated' => $isdeprecated
            );

            $this->db->where('channelnum', $channel_id);
            $this->db->update($this->table, $data);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    function add_manager($channel_id, $user_id)
    {
        try {
            $this->db->insert('jumper__managers', array(
                'channelnum' => $channel_id,
                'userNumber' => $user_id
            ));
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    function delete_manager($channel_id, $user_id)
    {
        try {
            $this->db->delete('jumper__managers', array(
                'channelnum' => $channel_id,
                'userNumber' => $user_id
            ));
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}