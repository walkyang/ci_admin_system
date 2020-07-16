<?php

/**
 * Created by PhpStorm.
 * User: jmillerfun
 * Date: 2018/8/8
 * Time: 14:23
 */
/*土地列表*/
class LandInfo extends  CI_Model{

    function __construct(){
        parent::__construct();
        $this->db = $this->load->database('data_dataface',TRUE);
    }
    // 查询土地列表
    function get_list($city_id,$key,$page,$pagesize){
        $where = 'where 1=1 ';
        if($city_id){
            $where .= ' and city_id = '.$city_id;
        }
        if($key){
            $where .= ' and land_no like "%'.$key.'%" or dkmc like "%'.$key.'%"';
        }
        $query = 'select * from dataface_land '.$where.' order by is_state desc, fbsj desc limit '.$page.','.$pagesize.'';
        $result = $this->db->query($query)->result();
        return $result;
    }
    // 查询土地列表
    function get_list_count($city_id,$key){
        $where = 'where 1=1 ';
        if($city_id){
            $where .= ' and city_id = '.$city_id;
        }
        if($key){
            $where .= ' and land_no like "%'.$key.'%" or dkmc like "%'.$key.'%"';
        }
        $query = 'select count(1) cnt from dataface_land '.$where;
        $result = $this->db->query($query)->row();
        return $result->cnt;
    }

    // 查询土地信息
    function get_by_id($land_id){
        $query = 'select * from dataface_land where land_id= "'.$land_id.'" ';
        $result = $this->db->query($query)->row();
        return $result;
    }

    // 查询土地信息
    function get_by_no($land_no){
        $query = 'select * from dataface_land where land_no= "'.$land_no.'" ';
        $result = $this->db->query($query)->row();
        return $result;
    }

    //添加土地信息
    function add($city_id,$land_no,$dkmc,$district_id,$plate_id,$loop_id,$szfw,$crmj,$build_area,$land_status,
                 $tdtype,$crnx,$rjl,$green_ratio,$build_density,$build_height,$land_zhoubian,$fbsj,$crr,$crfs_state,$jsjmkssj,$jsjmjssj,$gpbjkssj,$gpbjjssj,$ffwjkssj,
                 $ffwjjzsj,$bzjsj,$qsj,$lbj,$mmdj,$zxzf,$jmbzj,$tzqd,$contact_tel,$contact_address,$jy_address,$block_state,$jdrq,$jdj,$jdlbj,
                 $jdmmdj,$yjl,$jdr,$crxz,$ysht,$crwj,$fbsjyear,$fbsjmonth,$land_type_id,$house_type_rjl,$house_type_id,$house_name,$house_id,$jdrqyear,$jdrqmonth){
        //先判断是否存在
        $exist_query = 'select land_id from dataface_land where land_no='.$land_no.' and city_id='.$city_id.' ';
        $exist_result = $this->db->query($exist_query)->row();
        if(!$exist_result){
            $this->db->set('city_id', $city_id);
            $this->db->set('dkmc', $dkmc);
            $this->db->set('district_id', $district_id);
            $this->db->set('plate_id', $plate_id);
            $this->db->set('loop_id',$loop_id);
            $this->db->set('szfw',$szfw);
            $this->db->set('crmj',$crmj);
            $this->db->set('build_area', $build_area);
            $this->db->set('land_status', $land_status);
            $this->db->set('tdtype', $tdtype);
            $this->db->set('crnx',$crnx);
            $this->db->set('rjl',$rjl);
            $this->db->set('green_ratio',$green_ratio);
            $this->db->set('build_density',$build_density);
            $this->db->set('build_height',$build_height);
            $this->db->set('land_zhoubian', $land_zhoubian);
            $this->db->set('fbsj', $fbsj);
            $this->db->set('crr', $crr);
            $this->db->set('crfs_state', $crfs_state);
            $this->db->set('jsjmkssj',$jsjmkssj);
            $this->db->set('jsjmjssj',$jsjmjssj);
            $this->db->set('gpbjkssj',$gpbjkssj);
            $this->db->set('gpbjjssj',$gpbjjssj);
            $this->db->set('ffwjkssj', $ffwjkssj);
            $this->db->set('ffwjjzsj', $ffwjjzsj);
            $this->db->set('bzjsj', $bzjsj);
            $this->db->set('qsj',$qsj);
            $this->db->set('lbj',$lbj);
            $this->db->set('mmdj',$mmdj);
            $this->db->set('zxzf',$zxzf);
            $this->db->set('jmbzj', $jmbzj);
            $this->db->set('tzqd', $tzqd);
            $this->db->set('contact_tel', $contact_tel);
            $this->db->set('contact_address',$contact_address);
            $this->db->set('jy_address',$jy_address);
            $this->db->set('block_state',$block_state);
            if($jdrq)
                $this->db->set('jdrq',$jdrq);
            $this->db->set('jdj', $jdj);
            $this->db->set('jdlbj', $jdlbj);
            $this->db->set('jdmmdj', $jdmmdj);
            $this->db->set('yjl',$yjl);
            $this->db->set('jy_address',$jy_address);
            $this->db->set('jdr',$jdr);
            $this->db->set('crxz', $crxz);
            $this->db->set('ysht',$ysht);
            $this->db->set('crwj',$crwj);
            $this->db->set('fbsjyear', $fbsjyear);
            $this->db->set('fbsjmonth',$fbsjmonth);
            $this->db->set('land_type_id',$land_type_id);
            $this->db->set('house_type_rjl',$house_type_rjl);
            $this->db->set('house_type_id',$house_type_id);
            $this->db->set('house_name',$house_name);
            $this->db->set('house_id',$house_id);

            $this->db->set('jdrqyear',$jdrqyear);
            $this->db->set('jdrqmonth',$jdrqmonth);
            $this->db->insert('dataface_land');
            $id = $this->db->insert_id();
        }else{
            $id = 0;
        }
        return $id;
    }

    //更新土地信息
    function update($update_set,$wheres){
        foreach($update_set as $k=>$v){
            $this->db->set($k, '\''.$v.'\'', FALSE);
        }
        foreach($wheres as $k=>$v){
            $this->db->where($k, '\''.$v.'\'', FALSE);
        }
        $this->db->update('dataface_land');
    }

    //查询地块对应楼盘
    function get_land_house_list($land_id){
        $query = 'select * from dataface_land_type where land_id='.$land_id;
        $result = $this->db->query($query)->result();
        return $result;
    }

    //查询楼盘新增更新条数
    function get_city_land_cnt(){
        $query = 'select t.city_id,city_name ,max(case is_state when 2 then cnt else 0 end) \'add_cnt\' ,
max(case is_state when 1 then cnt else 0 end) \'update_cnt\' from
 (select count(1) cnt ,city_id,is_state from dataface_land where is_state > 0 group by city_id,is_state) t inner join dataface_city dc on t.city_id = dc.city_id
group by t.city_id,city_name';
        $result = $this->db->query($query)->result();
        return $result;
    }

}