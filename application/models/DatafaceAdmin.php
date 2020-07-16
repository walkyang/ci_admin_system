<?php

/**
 * Created by PhpStorm.
 * User: jmillerfun
 * Date: 2018/11/28
 * Time: 10:55
 */
class DatafaceAdmin  extends  CI_Model{
    function __construct(){
        parent::__construct();
        $this->db = $this->load->database('data_dataface',TRUE);
    }

    // 管理列表
    function get_list($page,$pagesize){
        $query = 'select * from dataface_admin_info order by id desc limit '.$page.','.$pagesize.'';
        $result = $this->db->query($query)->result();
        return $result;
    }
    //
    function get_list_count(){
        $query = 'select count(1) cnt from dataface_admin_info ';
        $result = $this->db->query($query)->row();
        return $result->cnt;
    }

    //
    function get($id){
        $query = 'select * from dataface_admin_info where id='.$id;
        $result = $this->db->query($query)->row();
        return $result;
    }

    //
    function login($user_mobile,$user_pwd){
        $query = 'select * from dataface_admin_info where user_mobile= "'.$user_mobile.'" and user_pwd= "'.$user_pwd.'"';
        $result = $this->db->query($query)->row();
        return $result;
    }

    function add($user_name,$user_mobile,$user_pwd){
        $id = 0;
        $this->db->where('user_mobile',$user_mobile);
        $this->query = $this->db->get('dataface_admin_info');
        if($this->query->num_rows() <= 0)
        {
            $this->db->set('user_name',$user_name);
            $this->db->set('user_mobile',$user_mobile);
            $this->db->set('user_pwd', $user_pwd);
            $this->db->set('registration_time', date('Y-m-d H:i:s'));
            $this->db->set('last_login_time', date('Y-m-d H:i:s'));

            $this->db->insert('dataface_admin_info');
            $id = $this->db->insert_id();
        }
        return $id;
    }

    //更新信息
    function update($update_set,$wheres){
        foreach($update_set as $k=>$v){
            $this->db->set($k, '\''.$v.'\'', FALSE);
        }
        foreach($wheres as $k=>$v){
            $this->db->where($k, '\''.$v.'\'', FALSE);
        }
        $this->db->update('dataface_admin_info');
    }
}