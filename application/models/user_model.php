<?php

class User_model extends CI_Model
{

    private $table;

    function __construct()
    {
        parent::__construct();
        $this->table = 'jamong__tb_users';
    }

    function test($user_num) {
        $quest_str = "Select a.*".
                     ", (select  nickName from jumper_user where userNumber=".$user_num.") as nickName".
                     ", (select  count(*) from jumper__channellist where userNumber=".$user_num.") as Ch_Cnt".
                     ", (select  count(*) from jumper__favorites where userNumber=".$user_num.") as Favor_Cnt".
                     ", (select count(*) from jumper__mychannels where userNumber=".$user_num.") as S_Cnt".
                     ", (select follow from jumper__channellist where userNumber=".$user_num.") as Follow_Cnt".
                     " from jamong__tb_users a Where userNumber =".$user_num;
        $query = $this->db->query($quest_str);

        return $query->result();
    }

    function gets()
    {
//        $query_str = "SELECT jamong__tb_users.userNumber, picture, count(channelnum) as channelNum FROM jamong__tb_users ".
//                     "LEFT JOIN jamong__tb_users_picture ".
//                     "ON jamong__tb_users.userNumber = jamong__tb_users_picture.userNumber ".
//                     "LEFT JOIN jumper__channellist ".
//                     "ON jamong__tb_users.userNumber = jumper__channellist.userNumber ".
//                     "GROUP BY userNumber";
//        $query = $this->db->query($query_str);
//        return $query->result();

//        $this->db->select('jamong__tb_users.userNumber, jamong__tb_users_picture.picture');
//        $this->db->from($this->table);
//        $this->db->join('jamong__tb_users_picture', 'jamong__tb_users_picture.userNumber = jamong__tb_users.userNumber', 'left');
//        $this->db->join('jumper__channellist', 'jumper__channellist.userNumber = jamong__tb_users.userNumber', 'left');
//        $this->db->group_by('jamong__tb_users.userNumber');
//        return $this->db->get()->result();

        $this->db->select('*');
        $this->db->from('jamong__tb_users_picture');
        return $this->db->get()->result();
    }

    function gets_pagination($page, $per_page, $sort, $filter) {
        if ($page === 1) {
            $this->db->limit($per_page);

        } else {
            $this->db->limit($per_page, ($page - 1) * $per_page);
        }
        $this->db->select('jamong__tb_users.userNumber, jamong__tb_users.email, jamong__tb_users.joinday, 
                           jamong__tb_users.accounttype, jamong__tb_users.vrcoin, jamong__tb_users.adultdate, jamong__tb_users.adult,
                           jamong__tb_users.state, jamong__tb_users.statedate,   
                           count(ainum) as purchaseNum, 
                           jumper_user.nickname');
        $this->db->from($this->table);
        $this->db->join('jumper_user', 'jumper_user.userNumber = jamong__tb_users.userNumber', 'left');
        $this->db->join('jamong__tb_purchasehistory', 'jamong__tb_purchasehistory.userNumber = jamong__tb_users.userNumber', 'left');
        $this->db->group_by('jamong__tb_users.userNumber');

        // sorting
        if (isset($sort['userNumber'])) $this->db->order_by("jamong__tb_users.userNumber", $sort['userNumber']);
        if (isset($sort['email'])) $this->db->order_by("email", $sort['email']);
        if (isset($sort['accounttype'])) $this->db->order_by("accounttype", $sort['accounttype']);
        if (isset($sort['nickname'])) $this->db->order_by("nickname", $sort['nickname']);
        if (isset($sort['purchaseNum'])) $this->db->order_by("purchaseNum", $sort['purchaseNum']);
        if (isset($sort['vrcoin'])) $this->db->order_by("vrcoin", $sort['vrcoin']);
        if (isset($sort['adult'])) $this->db->order_by("adult", $sort['adult']);
        if (isset($sort['state'])) $this->db->order_by("state", $sort['state']);
        if (isset($sort['statedate'])) $this->db->order_by("statedate", $sort['statedate']);

        // filter
        if ($filter != null && isset($filter['userNumber'])) $this->db->like('jamong__tb_users.userNumber', $filter['userNumber']);
        if ($filter != null && isset($filter['email'])) $this->db->like('jamong__tb_users.email', $filter['email']);
        if ($filter != null && isset($filter['accounttype'])) $this->db->like('jamong__tb_users.accounttype', $filter['accounttype']);
        if ($filter != null && isset($filter['nickname'])) $this->db->like('jumper_user.nickname', urldecode($filter['nickname']));

        return $this->db->get()->result();
    }

    function get_total_count()
    {
        return $this->db->count_all($this->table);
    }

    function gets_manager_pagination($page, $per_page, $sort, $filter) {
        if ($page === 1) {
            $this->db->limit($per_page);

        } else {
            $this->db->limit($per_page, ($page - 1) * $per_page);
        }
        $this->db->select('jamong__tb_users.userNumber, jamong__tb_users.email, jamong__tb_users.joinday, 
                           jamong__tb_users.accounttype, jamong__tb_users.vrcoin, jamong__tb_users.adultdate, jamong__tb_users.adult,
                           jamong__tb_users.state, jamong__tb_users.statedate, 
                           jumper_user.nickname,
                           jumper__managers.channelnum');
        $this->db->from($this->table);
        $this->db->join('jumper_user', 'jumper_user.userNumber = jamong__tb_users.userNumber', 'left');
        $this->db->join('jumper__managers', 'jumper__managers.userNumber = jamong__tb_users.userNumber', 'left');
        $this->db->group_by('jamong__tb_users.userNumber');

        // sorting
        if (isset($sort['userNumber'])) $this->db->order_by("jamong__tb_users.userNumber", $sort['userNumber']);
        if (isset($sort['email'])) $this->db->order_by("email", $sort['email']);
        if (isset($sort['nickname'])) $this->db->order_by("nickname", $sort['nickname']);
        if (isset($sort['adult'])) $this->db->order_by("adult", $sort['adult']);
        if (isset($sort['manager'])) $this->db->order_by("jumper__managers.channelnum", $sort['manager']);

        // filter
        if ($filter != null && isset($filter['userNumber'])) $this->db->like('jamong__tb_users.userNumber', $filter['userNumber']);
        if ($filter != null && isset($filter['email'])) $this->db->like('jamong__tb_users.email', $filter['email']);
        if ($filter != null && isset($filter['accounttype'])) $this->db->like('jamong__tb_users.accounttype', $filter['accounttype']);
        if ($filter != null && isset($filter['nickname'])) $this->db->like('jumper_user.nickname', urldecode($filter['nickname']));
        if ($filter != null && isset($filter['manager'])) $this->db->like('jumper__managers.channelnum', urldecode($filter['manager']));

        return $this->db->get()->result();
    }

    function gets_admin()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where(array('is_admin' => true));
        return $this->db->get()->result();
    }

    function gets_non_isdeprecated()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where(array('isdeprecated' => false));
        return $this->db->get()->result();
    }

    function logined($user)
    {
        $user->logined = date("Y-m-d H:i:sa");
        $this->db->update($this->table, $user, array('_userid' => $user->_userid));
    }

    function get_user_by_email($option)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->join('jumper_user', 'jumper_user.userNumber = jamong__tb_users.userNumber', 'left');
        $this->db->where('email', $option['email']);

        return $this->db->get()->result();
    }

    function get_user_by_id($user_id)
    {
        $query_str = "Select a.*".
                     ", (select  picture from jamong__tb_users_picture where userNumber=".$user_id.") as picture".
                     ", (select  nickName from jumper_user where userNumber=".$user_id.") as nickName".
                     ", (select  count(*) from jumper__channellist where userNumber=".$user_id.") as Ch_Cnt".
                     ", (select  count(*) from jumper__favorites where userNumber=".$user_id.") as Favor_Cnt".
                     ", (select count(*) from jumper__mychannels where userNumber=".$user_id.") as S_Cnt".
                     ", (select follow from jumper__channellist where userNumber=".$user_id.") as Follow_Cnt".
                     ", (select count(ainum) from jamong__tb_purchasehistory where userNumber=".$user_id.") as Purchase_Cnt".
                     " from jamong__tb_users a Where userNumber = ".$user_id;
        $query = $this->db->query($query_str);
        return $query->result();
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

    function change_password($user_id, $password)
    {
        try {
            $data = array(
                'password' => $password
            );

            $this->db->where('userNumber', $user_id);
            $this->db->update($this->table, $data);

            return $this->db->affected_rows();
        } catch (Exception $e) {
            return false;
        }
    }

    function change_state_block($user_id)
    {
        date_default_timezone_set('UTC');
        try {
            $data = array(
                'blockdate' => date('Y-m-d H:i:s'),
                'state' => 'block'
            );

            $this->db->where('userNumber', $user_id);
            $this->db->update($this->table, $data);

            return $this->db->affected_rows();
        } catch (Exception $e) {
            return false;
        }
    }

    function change_isdeprecated($user_id, $isdeprecated)
    {
        try {
            $data = array(
                'isdeprecated' => $isdeprecated
            );

            $this->db->where('userNumber', $user_id);
            $this->db->update($this->table, $data);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    function change_isadmin($user_id, $is_admin)
    {
        try {
            $data = array(
                'isadmin' => $is_admin
            );

            $this->db->where('userNumber', $user_id);
            $this->db->update($this->table, $data);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    function add($data)
    {
        $input_data = array(
            'email' => $data['email'],
            'password' => $data['password'],
            'joinday' => date("y-m-d+H:i:s"),
            'accounttype' => 'email',
            'state' => 'active',
            'is_admin' => FALSE,
            'is_superadmin' => FALSE,
        );

        $this->db->insert($this->table, $input_data);
        $result = $this->db->insert_id();

        return $result;
    }

    function update($data)
    {
        try {
            $input_data = array(
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => $data['password'],
                'profile_uri' => $data['profile_uri'],
                'is_admin'=>$data['is_admin'],
                'isdeprecated'=>$data['isdeprecated']
            );

            $this->db->where('userNumber', $data['userid']);
            $this->db->update($this->table, $input_data);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}