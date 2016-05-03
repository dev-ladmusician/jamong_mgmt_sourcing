<?php

class Channel_profile_model extends CI_Model
{
    private $table;

    function __construct()
    {
        parent::__construct();
        $this->table = 'jumper__channel_profile';
    }

    function gets()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        return $this->db->get()->result();
    }

    function get_by_id($channel_id){
        $this->db->select('*');
        $this->db->where('channelnum', $channel_id);
        $this->db->from($this->table);
        return $this->db->get()->result();
    }

    function get_id_by_channel($channel_id){
        try {
            $this->db->select('profile_id');
            $this->db->where('channelnum', $channel_id);
            $this->db->from($this->table);
            return $this->db->get()->result();
        } catch (Exception $e) {
            return false;
        }
    }

    function add_ch_picture($channel_id , $file_name)
    {
        $input_data = array(
            'channelnum' => $channel_id,
            'ch_picture' => $file_name
        );

        $this->db->insert($this->table, $input_data);
        $result = $this->db->insert_id();

        return $result;
    }

    function update_ch_picture($channel_id, $file_name)
    {
        try {
            $input_data = array(
                'ch_picture' => $file_name
            );

            $this->db->where('channelnum', $channel_id);
            $this->db->update($this->table, $input_data);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    function add_bg_picture($channel_id , $file_name)
    {
        $input_data = array(
            'channelnum' => $channel_id,
            'bg_picture' => $file_name
        );

        $this->db->insert($this->table, $input_data);
        $result = $this->db->insert_id();

        return $result;
    }

    function update_bg_picture($channel_id, $file_name)
    {
        try {
            $input_data = array(
                'bg_picture' => $file_name
            );

            $this->db->where('channelnum', $channel_id);
            $this->db->update($this->table, $input_data);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }


}