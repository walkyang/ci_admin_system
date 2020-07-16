<?php

/**
 * Created by PhpStorm.
 * User: jmillerfun
 * Date: 2018/8/8
 * Time: 11:17
 */
/*房源类型*/
class HouseType extends  CI_Model{
    function __construct(){
        parent::__construct();
    }

    // 获取房屋类型
    function get_list($city_code){
        $this->db = $this->load->database('data_'.$city_code,TRUE);
        $query = 'select house_type_id,house_type_name from house_type_info';
        $result = $this->db->query($query)->result();
        return $result;
    }

    //查询房屋类型
    function get_housetype_name($city_code,$house_type_id){
        $this->db = $this->load->database('data_'.$city_code,TRUE);
        $query = 'select house_type_name from house_type_info where house_type_id='.$house_type_id;
        $result = $this->db->query($query)->row();
        if($result){
            return $result->house_type_name;
        }
        return '';
    }
}