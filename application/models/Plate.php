<?php

/**
 * Created by PhpStorm.
 * User: jmillerfun
 * Date: 2018/8/8
 * Time: 14:35
 */
class Plate extends  CI_Model{

    function __construct(){
        parent::__construct();
    }

    // 查询板块列表
    function get_list($city_code,$district_ids){
        $this->db = $this->load->database('data_'.$city_code,TRUE);
        $query = 'select plate_id,plate_name from plate';
        if(strstr($district_ids,','))
            $query .= ' where district_id in ('.$district_ids.')';
        elseif($district_ids)
            $query .= ' where district_id='.$district_ids;
        $result = $this->db->query($query)->result();
        return $result;
    }

    //查询板块
    function get_plate_name($city_code,$plate_id){
        $this->db = $this->load->database('data_'.$city_code,TRUE);
        $query = 'select plate_name from plate where plate_id='.$plate_id;
        $result = $this->db->query($query)->row();
        if($result){
            return $result->plate_name;
        }
        return '';
    }

}