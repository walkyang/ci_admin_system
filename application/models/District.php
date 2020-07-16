<?php

/**
 * Created by PhpStorm.
 * User: jmillerfun
 * Date: 2018/8/8
 * Time: 14:30
 */
class District extends  CI_Model{

    function __construct(){
        parent::__construct();
    }

    // 查询城市列表
    function get_list($city_code){
        $this->db = $this->load->database('data_'.$city_code,TRUE);
        $query = 'select district_id,district_name from district';
        $result = $this->db->query($query)->result();
        return $result;
    }

    //查询区域
    function get_district_name($city_code,$district_id){
        $this->db = $this->load->database('data_'.$city_code,TRUE);
        $query = 'select district_name from district where district_id='.$district_id;
        $result = $this->db->query($query)->row();
        if($result){
            return $result->district_name;
        }
        return '';
    }

}