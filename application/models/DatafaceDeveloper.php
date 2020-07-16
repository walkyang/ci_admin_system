<?php

/**
 * Created by PhpStorm.
 * User: jmillerfun
 * Date: 2018/12/21
 * Time: 13:38
 */
//企业系 因为一致就放在一个表里
class DatafaceDeveloper extends  CI_Model{
    function __construct(){
        parent::__construct();
        $this->db = $this->load->database('data_dataface',TRUE);
    }

    // 企业系列表
    function get_list($page,$pagesize){
        $query = 'select * from dataface_developer_company order by company_id desc limit '.$page.','.$pagesize.'';
        $result = $this->db->query($query)->result();
        return $result;
    }
    //
    function get_list_count(){
        $query = 'select count(1) cnt from dataface_developer_company ';
        $result = $this->db->query($query)->row();
        return $result->cnt;
    }

    //
    function get($id){
        $query = 'select * from dataface_developer_company where company_id='.$id;
        $result = $this->db->query($query)->row();
        return $result;
    }

    //添加信息
    function add($short_name,$full_name,$first_py){
        $id = 0;
        $this->db->where('full_name',$full_name);
        $this->query = $this->db->get('dataface_developer_company');
        if($this->query->num_rows() <= 0)
        {
            $this->db->set('short_name',$short_name);
            $this->db->set('full_name',$full_name);
            $this->db->set('first_py', $first_py);
            $this->db->insert('dataface_developer_company');
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
        $this->db->update('dataface_developer_company');
    }

}