<?php

class User_picture_model extends CI_Model
{

    private $table;

    function __construct()
    {
        parent::__construct();
        $this->table = 'jamong__tb_users_picture';
    }

    function gets()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        return $this->db->get()->result();
    }

    function get_id_by_user($user_id){
        try {
            $this->db->select('_pictureid');
            $this->db->where('userNumber', $user_id);
            $this->db->from($this->table);
            return $this->db->get()->result();
        } catch (Exception $e) {
            return false;
        }
    }
    function change_admin($user_id, $is_admin)
    {
        try {
            $data = array(
                'is_admin' => $is_admin
            );

            $this->db->where('userNumber', $user_id);
            $this->db->update($this->table, $data);

            return $this->db->affected_rows();
        } catch (Exception $e) {
            return false;
        }
    }

    function add($user_id,$file_name)
    {
        $input_data = array(
            'userNumber' => $user_id,
            'picture' => $file_name
        );

        $this->db->insert($this->table, $input_data);
        $result = $this->db->insert_id();

        return $result;
    }

    function update($user_id,$file_name)
    {
        try {
            $input_data = array(
                'picture' => $file_name
            );

            $this->db->where('userNumber', $user_id);
            $this->db->update($this->table, $input_data);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}