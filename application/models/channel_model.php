<?php

class Channel_model extends CI_Model
{
    private $table;

    function __construct()
    {
        parent::__construct();
        $this->table = 'jumper__channellist';
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
        if (isset($sort['channelnum'])) $this->db->order_by("channelnum", $sort['channelnum']);
        if (isset($sort['channelname'])) $this->db->order_by("channelname", $sort['channelname']);
        if (isset($sort['nickname'])) $this->db->order_by("nickName", $sort['nickname']);
        if (isset($sort['follow'])) $this->db->order_by("follow", $sort['follow']);
        if (isset($sort['contents'])) $this->db->order_by("contents", $sort['contents']);
        if (isset($sort['created'])) $this->db->order_by("datetime", $sort['created']);

        // filter
        if ($filter != null && isset($filter['channelnum'])) $this->db->like('channelnum', $filter['channelnum']);
        if ($filter != null && isset($filter['channelname'])) $this->db->like('channelname', urldecode($filter['channelname']));
        if ($filter != null && isset($filter['nickname'])) $this->db->like('nickName', urldecode($filter['nickname']));
        if ($filter != null && isset($filter['follow'])) $this->db->like('follow', $filter['follow']);
        if ($filter != null && isset($filter['contents'])) $this->db->like('contents', $filter['contents']);
        if ($filter != null && isset($filter['created'])) $this->db->like('datetime', $filter['created']);

        return $this->db->get()->result();
    }

    function get_total_count()
    {
        return $this->db->count_all($this->table);
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
        $this->db->update($this->table, $data);

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