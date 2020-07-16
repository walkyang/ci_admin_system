<?php

/**
 * Created by PhpStorm.
 * User: jmillerfun
 * Date: 2018/10/13
 * Time: 22:44
 */
class Dist extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->helper('cookie');
        $this->load->model('City','city');
        $this->load->model('District','district');
        $this->load->model('DatafaceDistrict','dataface_district');
        $this->load->library('Utility');
        if(!$this->input->cookie('admin_id')){
            $this->utility->tsgHref('/login');
        }else{
            $this->admin_name = $this->input->cookie('admin_name');
            $this->admin_id = $this->input->cookie('admin_id');
        }
        header("Content-Type:text/html;charset=utf-8");
        $this->pagesize = 20;
    }

    //区域列表
    function district_list(){
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        //获取城市
        $citylist = $this->city->get_list();
        $data['citylist'] = $citylist;
        $city_id = 0;
        if (!empty($_GET['city_id'])) {
            $city_id=$_GET['city_id'];
        };
        //分页配置
        //根据城市获取当前区域，板块，环线
        $city_info = $this->city->get($city_id);
        $district_list = array();
        $city_code = '';

        $city_code = $city_info->city_code;
        $district_list = $this->district->get_list($city_code);
        $result = array();
        foreach($district_list as $k=>$v){
            $district_area = 0;$resident_population = 0;$edit_time = '';
            $dataface_district_list = $this->dataface_district->get_list_bycity($city_id);
            foreach($dataface_district_list as $k1=>$v1){
                if($v1->district_id == $v->district_id){
                    $district_area = $v1->district_area;$resident_population = $v1->resident_population;$edit_time = $v1->edit_time;
                    break;
                }
            }
            $result[] = array('district_id'=>$v->district_id,'district_name'=>$v->district_name,'district_area'=>$district_area,'resident_population'=>$resident_population,'edit_time'=>$edit_time);
        }


        $data['district_list'] = $result;
        $data['city_id'] = $city_id;
        $this->load->view('district_list',$data);
    }

    //区域信息
    function district_info(){
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        $district_id = $this->input->get('id');
        $city_id = $this->input->get('city_id');
        $district_name = $this->input->get('district_name');
        $district_info = $this->dataface_district->get($city_id,$district_id);
        $data['district'] = $district_info;
        $data['city_id'] = $city_id;
        $data['district_id'] = $district_id;
        $data['district_name'] = $district_name;
        $this->load->view('district_info',$data);
    }

    //添加或者编辑区域信息
    function update_distjbxx(){
        $city_id = $this->input->post('city_id');
        $district_id = $this->input->post('district_id');
        $district_name = $this->input->post('district_name');

        //土地信息
        $district_area = $this->input->post('district_area');
        $resident_population = $this->input->post('resident_population');
        $external_population = $this->input->post('external_population');
        $population_density = $this->input->post('population_density');
        $district_des = $this->input->post('district_des');

        $this->dataface_district->insert_district($city_id,$district_id,$district_area,$resident_population,$external_population,$population_density,$district_des);
        $this->utility->tsgGoHref('修改成功','/dist/district_info/?id='.$district_id.'&city_id='.$city_id.'&district_name='.$district_name);
    }
}