<?php

/**
 * Created by PhpStorm.
 * User: jmillerfun
 * Date: 2018/8/8
 * Time: 14:40
 */
class Loop extends  CI_Model{

    function __construct(){
        parent::__construct();
    }

    // 查询环线列表
    function get_list($city_code){
        $this->db = $this->load->database('data_'.$city_code,TRUE);
        $query = 'select loop_id,loop_name from `loop`';
        $result = $this->db->query($query)->result();
        return $result;
    }

    //查询环线
    function get_loop_name($city_code,$loop_id){
        $this->db = $this->load->database('data_'.$city_code,TRUE);
        $query = 'select loop_name from `loop` where loop_id='.$loop_id;
        $result = $this->db->query($query)->row();
        if($result){
            return $result->loop_name;
        }
        return '';
    }
}