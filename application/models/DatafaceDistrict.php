<?php

/**
 * Created by PhpStorm.
 * User: jmillerfun
 * Date: 2018/10/13
 * Time: 23:19
 */
class DatafaceDistrict extends  CI_Model{

    function __construct(){
        parent::__construct();
        $this->db = $this->load->database('data_dataface',TRUE);
    }

    //根据城市查询列表
    function get_list_bycity($city_id){
        $query = 'select * from dataface_yearbook_district where city_id= '.$city_id;
        $result = $this->db->query($query)->result();
        return $result;
    }

    // 查询区域信息
    function get($city_id,$district_id){
        $query = 'select * from dataface_yearbook_district where city_id= '.$city_id.' and district_id= '.$district_id;
        $result = $this->db->query($query)->row();
        return $result;
    }

    //查询如果存在 ，则取出修改，否则插入
    function insert_district($city_id,$district_id,$district_area,$resident_population,$external_population,$population_density,$district_des)
    {
        $query = 'select id from dataface_yearbook_district where city_id= '.$city_id.' and district_id= '.$district_id;
        $result = $this->db->query($query)->row();
        if($result){
            $this->db->set('district_area', $district_area);
            $this->db->set('resident_population',$resident_population);
            $this->db->set('external_population',$external_population);
            $this->db->set('population_density',$population_density);
            $this->db->set('district_des',$district_des);
            $this->db->set('edit_time',date('Y-m-d H;i:s'));
            $this->db->where('id',$result->id);
            $this->db->update('dataface_yearbook_district');
        }else{
            $this->db->set('city_id', $city_id);
            $this->db->set('district_id', $district_id);
            $this->db->set('district_area', $district_area);
            $this->db->set('resident_population',$resident_population);
            $this->db->set('external_population',$external_population);
            $this->db->set('population_density',$population_density);
            $this->db->set('district_des',$district_des);
            $this->db->set('edit_time',date('Y-m-d H;i:s'));
            $this->db->insert('dataface_yearbook_district');
            $this->db->insert_id();
        }
    }

}