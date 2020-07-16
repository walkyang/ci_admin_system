<?php

/**
 * Created by PhpStorm.
 * User: jmillerfun
 * Date: 2018/9/3
 * Time: 15:26
 */
class HouseInfo extends  CI_Model{

    function __construct(){
        parent::__construct();
    }

    function info($city_code,$house_id){
        $this->db = $this->load->database('data_'.$city_code,TRUE);
        $query = 'select house_id,house_name,nick_name,show_address,district_id,plate_id,is_first,sales_office,sales_tel,open_date_detail,
 deliver_date_detail,jg_time,house_type,arch_type,developer_id,land_area,build_area,green_rate,volume_rate,total_house,wy_price,parking_space_detail,lng,lat from house_info where house_id ='.$house_id;
        $result = $this->db->query($query)->row();
        return $result;
    }

    function search_key($city_code,$is_first,$key){
        $this->db = $this->load->database('data_'.$city_code,TRUE);
        $where = 'where is_first = 2';
        if($is_first == 1){
            $where = 'where is_first in (1,4)';
        }
        $query = 'select house_id,house_name,nick_name,is_first from house_info '.$where.' and match_key like "%'.$key.'%" limit 5';
        $result = $this->db->query($query)->result();
        return $result;
    }

}