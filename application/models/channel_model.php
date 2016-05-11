<?php

class Channel_model extends CI_Model
{
    private $table;

    function __construct()
    {
        parent::__construct();
        $this->table = 'jumper__channellist';
    }

    function get_items()
    {
        $this->db->select('channelnum, channelname');
        $this->db->where('isdeprecated', false);
        $this->db->from($this->table);
        return $this->db->get()->result();
    }

    function gets_pagination($page, $per_page, $sort, $filter, $user_id) {
        if ($page === 1) {
            $this->db->limit($per_page);

        } else {
            $this->db->limit($per_page, ($page - 1) * $per_page);
        }
        $this->db->select($this->table.'.*, count(jumper__channels.inum) as contentCount');
        $this->db->from($this->table);
        $this->db->join('jumper__channels', 'jumper__channels.channelnum = '.$this->table.'.channelnum', 'left');
        //$this->db->join('jumper__mychannels', 'jumper__mychannels.channelnum = '.$this->table.'.channelnum', 'left');
        $this->db->group_by($this->table.'.channelnum');

        if ($user_id) {
            $this->db->where('userNumber', $user_id);
        }

        // sorting
        if (isset($sort['channelnum'])) $this->db->order_by("channelnum", $sort['channelnum']);
        if (isset($sort['channelname'])) $this->db->order_by("channelname", $sort['channelname']);
        if (isset($sort['nickname'])) $this->db->order_by("nickName", $sort['nickname']);
        if (isset($sort['follow'])) $this->db->order_by("follow", $sort['follow']);
        if (isset($sort['contents'])) $this->db->order_by("contentCount", $sort['contents']);
        if (isset($sort['created'])) $this->db->order_by("datetime", $sort['created']);

        // filter
        if ($filter != null && isset($filter['channelnum'])) $this->db->like('channelnum', $filter['channelnum']);
        if ($filter != null && isset($filter['channelname'])) $this->db->like('channelname', urldecode($filter['channelname']));
        if ($filter != null && isset($filter['nickname'])) $this->db->like('nickName', urldecode($filter['nickname']));
        //if ($filter != null && isset($filter['follow'])) $this->db->like('follow', $filter['follow']);
        //if ($filter != null && isset($filter['contents'])) $this->db->like('contentCount', $filter['contents']);
        if ($filter != null && isset($filter['created'])) $this->db->like('datetime', $filter['created']);

        return $this->db->get()->result();
    }

    function get_my_channels($page, $per_page, $sort, $filter, $user_id) {
        if ($page === 1) {
            $this->db->limit($per_page);

        } else {
            $this->db->limit($per_page, ($page - 1) * $per_page);
        }
        $this->db->select('*');
        $this->db->from('jumper__managers');
        $this->db->join($this->table, $this->table.'.channelnum = jumper__managers.channelnum', 'left');
        $this->db->where('jumper__managers.userNumber', $user_id);

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

    function get_total_count() {
        return $this->db->count_all($this->table);
    }

    function get_my_channel_total_count($user_id) {
        $this->db->select('*');
        $this->db->from('jumper__managers');
        $this->db->where('userNumber', $user_id);
        return count($this->db->get()->result());
    }

    function check_manager($user_id, $channel_num) {
        $this->db->select('mnum');
        $this->db->from('jumper__managers');
        $this->db->where(array(
            'userNumber' => $user_id,
            'channelnum' => $channel_num
        ));
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

            // change isadmin in user table
            $this->load->model('user_model');
            $this->user_model->change_admin($user_id, true);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    function add_manager_bulk($data) {
        try {
            foreach($data as $each) {
                if ($this->check_exist_manager($each) == 0) {
                    $this->db->insert('jumper__managers', $each);
                }
            }
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    function check_exist_manager($data) {
        $this->db->select('*');
        $this->db->from('jumper__managers');
        $this->db->where('channelnum', $data['channelnum']);
        $this->db->where('userNumber', $data['userNumber']);
        return count($this->db->get()->result());
    }

    function delete_manager($channel_id, $user_id)
    {
        try {
            $this->db->delete('jumper__managers', array(
                'channelnum' => $channel_id,
                'userNumber' => $user_id
            ));

            // change isadmin in user table
            $this->load->model('user_model');
            if(count($this->check_any_manager($user_id)) == 0) {
                $this->user_model->change_admin($user_id, false);
            }

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    function check_any_manager($user_id) {
        $this->db->select('*');
        $this->db->from('jumper__managers');
        $this->db->where('userNumber', $user_id);
        return $this->db->get()->result();
    }

    function add($title, $content) {
        $input_data = array(
            'channelname' => $title,
            'chdesc' => $content,
            'userNumber' => $this->session->userdata('userid'),
            'nickname' => $this->session->userdata('nickname'),
            'datetime' => date("y-m-d+H:i:s"),
        );

        $this->db->insert($this->table, $input_data);
        $result = $this->db->insert_id();

        return $result;
    }
}