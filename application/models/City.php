<?php

/**
 * Created by PhpStorm.
 * User: jmillerfun
 * Date: 2018/8/8
 * Time: 14:23
 */
/*城市列表*/
class City extends  CI_Model{

    function __construct(){
        parent::__construct();
        $this->db = $this->load->database('data_dataface',TRUE);
    }
    // 查询城市列表
    function get_list(){
        $query = 'select city_id,city_name,city_code,is_first,is_second from dataface_city ';
        $result = $this->db->query($query)->result();
        return $result;
    }
    // 查询城市信息
    function get($city_id){
        $query = 'select city_id,city_name,city_code,is_first,is_second from dataface_city where city_id='.$city_id;
        $result = $this->db->query($query)->row();
        return $result;
    }
}