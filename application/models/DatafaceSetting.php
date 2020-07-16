<?php

/**
 * Created by PhpStorm.
 * User: jmillerfun
 * Date: 2018/10/29
 * Time: 16:51
 */
class DatafaceSetting extends  CI_Model{

    function __construct(){
        parent::__construct();
        $this->db = $this->load->database('data_dataface',TRUE);
    }

    //查询设置列表
    function get_list($city_id,$page,$pagesize){
        $query = 'select * from dataface_setting where city_id= '.$city_id.' order by id limit '.$page.','.$pagesize.'  ';
        $result = $this->db->query($query)->result();
        return $result;
    }
    //查询设置列表
    function get_list_count($city_id){
        $query = 'select count(1) cnt from dataface_setting where city_id= '.$city_id.' ';
        $result = $this->db->query($query)->row();
        return $result->cnt;
    }
    //修改设置列表
    function update_value($id,$setting_value){
        $this->db->set('setting_value',$setting_value);
        $this->db->set('edit_time',date('Y-m-d H:i:s'));
        $this->db->where('id',$id, FALSE);
        $this->db->update('dataface_setting');
        //echo $this->db->last_query();
    }

}