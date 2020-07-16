<?php

/**
 * Created by PhpStorm.
 * User: jmillerfun
 * Date: 2018/10/27
 * Time: 23:04
 */
class Yearbook extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->helper('cookie');
        $this->load->model('City','city');
        $this->load->model('District','district');
        $this->load->model('DatafaceYearbook','dataface_yearbook');
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
    //--------------------------------------
    //GDP List
    function gdp_list($page=1)
    {
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        //获取城市
        $citylist = $this->city->get_list();
        $data['citylist'] = $citylist;
        $city_id = 0;
        $date_type = 'Q';
        $_surl = '';
        if (!empty($_GET['city_id'])) {
            $city_id=$_GET['city_id'];
            $_surl .= '&city_id='.$city_id;
        };
        if (!empty($_GET['date_type'])) {
            $date_type=$_GET['date_type'];
            $_surl .= '&date_type='.$date_type;
        };
        $_surl = $_surl ? '?'.ltrim($_surl,'&') : '';
        //分页配置
        $start = ($page - 1) * $this->pagesize;
        //分页配置
        //根据城市获取当前区域，板块，环线
        $city_info = $this->city->get($city_id);
        $gdp_list = $this->dataface_yearbook->get_gdp_list($city_id,$date_type,$start,$this->pagesize);
        $total =  $this->dataface_yearbook->get_gdp_list_count($city_id,$date_type);
        $data['gdp_list'] = $gdp_list;
        $data['date_type'] =$date_type;
        $data['city_id'] = $city_id;
        $data['pagestr'] = $this->utility->multi($total, $this->pagesize, $page, '/yearbook/gdp_list/', $_surl);
        $this->load->view('gdp_list',$data);
    }
    //GDP info
    function gdp_info(){
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        $id = $this->input->get('id');
        $city_id = $this->input->get('city_id');
        $date_type = $this->input->get('date_type');
        $gdp_info = $this->dataface_yearbook->get_gdp_info($id);
        $data['city_id'] = $city_id;
        $data['date_type'] = $date_type;
        $data['gdp_info'] = $gdp_info;
        $name = $gdp_info->gdp_year.'年';
        if($date_type == 'Q')
            $name .= '第'.$gdp_info->gdp_quarter.'季度';
        $data['id'] = $id;
        $data['name'] = $name;
        $this->load->view('gdp_info',$data);
    }
    function gdp_add(){
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        $city_id = $this->input->get('city_id');
        $date_type = $this->input->get('date_type');
        $data['city_id'] = $city_id;
        $data['id'] = 0;
        $data['date_type'] = $date_type;
        $this->load->view('gdp_add',$data);
    }
    //GDP update
    function update_gdpjbxx_Q(){
        $id = $this->input->post('id');
        $city_id = $this->input->post('city_id');
        //gdp 信息
        $gdp_year = $this->input->post('gdp_year');
        $gdp_quarter = $this->input->post('gdp_quarter');
        $gdp_value_quarter = $this->input->post('gdp_value_quarter');
        $gdp_value_total = $this->input->post('gdp_value_total');

        $update_set['gdp_year'] = $gdp_year;
        $update_set['gdp_quarter'] = $gdp_quarter;
        $update_set['gdp_value_quarter'] = $gdp_value_quarter;
        $update_set['gdp_value_total'] = $gdp_value_total;

        $update_where['id'] = $id;
        $this->dataface_yearbook->update($update_set,$update_where,'dataface_yearbook_gdp');
        $this->utility->tsgGoHref('修改成功','/yearbook/gdp_info/?id='.$id.'&city_id='.$city_id.'&date_type=Q');
    }
    function update_gdpjbxx_Y(){
        $id = $this->input->post('id');
        $city_id = $this->input->post('city_id');
        //gdp 信息
        $gdp_year = $this->input->post('gdp_year');
        $first_value = $this->input->post('first_value');
        $second_value = $this->input->post('second_value');
        $third_value = $this->input->post('third_value');
        $per_gdp = $this->input->post('per_gdp');
        $total_value = $this->input->post('total_value');

        $update_set['gdp_year'] = $gdp_year;
        $update_set['first_value'] = $first_value;
        $update_set['second_value'] = $second_value;
        $update_set['third_value'] = $third_value;
        $update_set['per_gdp'] = $per_gdp;
        $update_set['total_value'] = $total_value;
        $update_where['id'] = $id;
        $this->dataface_yearbook->update($update_set,$update_where,'dataface_yearbook_gdp');
        $this->utility->tsgGoHref('修改成功','/yearbook/gdp_info/?id='.$id.'&city_id='.$city_id.'&date_type=Y');
    }
    //GDP add
    function add_gdpjbxx_Q(){
        $city_id = $this->input->post('city_id');
        //gdp信息
        $gdp_year = $this->input->post('gdp_year');
        $gdp_quarter = $this->input->post('gdp_quarter');
        $gdp_value_quarter = $this->input->post('gdp_value_quarter');
        $gdp_value_total = $this->input->post('gdp_value_total');

        $id = $this->dataface_yearbook->add_gdp($city_id,$gdp_year,$gdp_quarter,$gdp_value_quarter,$gdp_value_total,0,0,0);
        if($id)
            $this->utility->tsgGoHref('添加成功','/yearbook/gdp_info/?id='.$id.'&city_id='.$city_id.'&date_type=Q');
        else
            $this->utility->tsgGoHref('添加失败','/yearbook/gdp_info/?city_id='.$city_id.'&date_type=Q');
    }
    function add_gdpjbxx_Y(){
        $city_id = $this->input->post('city_id');
        //gdp信息
        $gdp_year = $this->input->post('gdp_year');
        $first_value = $this->input->post('first_value');
        $second_value = $this->input->post('second_value');
        $third_value = $this->input->post('third_value');
        $per_gdp = $this->input->post('per_gdp');
        $total_value = $this->input->post('total_value');
        $id = $this->dataface_yearbook->add_gdp($city_id,$gdp_year,0,0,0,$first_value,$second_value,$third_value,$per_gdp,$total_value);
        if($id)
            $this->utility->tsgGoHref('添加成功','/yearbook/gdp_info/?id='.$id.'&city_id='.$city_id.'&date_type=Y');
        else
            $this->utility->tsgGoHref('添加失败','/yearbook/gdp_info/?city_id='.$city_id.'&date_type=Y');
    }
    //----------------------------------------
    //POP List
    function pop_list($page=1)
    {
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        //获取城市
        $citylist = $this->city->get_list();
        $data['citylist'] = $citylist;
        $city_id = 0;
        $date_type = 'Q';
        $_surl = '';
        if (!empty($_GET['city_id'])) {
            $city_id=$_GET['city_id'];
            $_surl .= '&city_id='.$city_id;
        };
        $_surl = $_surl ? '?'.ltrim($_surl,'&') : '';
        //分页配置
        $start = ($page - 1) * $this->pagesize;
        //分页配置
        //根据城市获取当前区域，板块，环线
        $pop_list = $this->dataface_yearbook->get_pop_list($city_id,$start,$this->pagesize);
        $total =  $this->dataface_yearbook->get_pop_list_count($city_id);
        $data['pop_list'] = $pop_list;
        $data['city_id'] = $city_id;
        $data['pagestr'] = $this->utility->multi($total, $this->pagesize, $page, '/yearbook/pop_list/', $_surl);
        $this->load->view('pop_list',$data);
    }
    //POP info
    function pop_info(){
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        $id = $this->input->get('id');
        $city_id = $this->input->get('city_id');
        $pop_info = $this->dataface_yearbook->get_pop_info($id);
        $data['city_id'] = $city_id;
        $data['pop_info'] = $pop_info;
        $data['id'] = $id;
        $this->load->view('pop_info',$data);
    }
    //POP info
    function pop_add(){
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        $city_id = $this->input->get('city_id');
        $data['city_id'] = $city_id;
        $data['id'] = 0;
        $this->load->view('pop_info',$data);
    }
    //POP update
    function update_popjbxx(){
        $id = $this->input->post('id');
        $city_id = $this->input->post('city_id');
        //pop信息
        $pop_regist = $this->input->post('pop_regist');
        $pop_live = $this->input->post('pop_live');
        $total_house = $this->input->post('total_house');

        $pop_density = $this->input->post('pop_density');

        $update_set['pop_regist'] = $pop_regist;
        $update_set['pop_live'] = $pop_live;
        $update_set['total_house'] = $total_house;

        $update_set['pop_density'] = $pop_density;
        $update_where['id'] = $id;
        $this->dataface_yearbook->update($update_set,$update_where,'dataface_yearbook_population');
        $this->utility->tsgGoHref('修改成功','/yearbook/pop_info/?id='.$id.'&city_id='.$city_id);
    }
    //POP add
    function add_popjbxx(){
        $city_id = $this->input->post('city_id');
        //pop信息
        $pop_year = $this->input->post('pop_year');
        $pop_regist = $this->input->post('pop_regist');
        $pop_live = $this->input->post('pop_live');
        $total_house = $this->input->post('total_house');
        $pop_density = $this->input->post('pop_density');
        $id = $this->dataface_yearbook->add_pop($city_id,$pop_year,$pop_regist,$pop_live,$total_house,0,0,0,$pop_density);
        if($id)
            $this->utility->tsgGoHref('添加成功','/yearbook/pop_info/?id='.$id.'&city_id='.$city_id);
        else
            $this->utility->tsgGoHref('添加失败','/yearbook/pop_info/?city_id='.$city_id);
    }
    //-----------------------------------------
    //QOL List
    function qol_list($page=1)
    {
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        //获取城市
        $citylist = $this->city->get_list();
        $data['citylist'] = $citylist;
        $city_id = 0;
        $date_type = 'Q';
        $_surl = '';
        if (!empty($_GET['city_id'])) {
            $city_id=$_GET['city_id'];
            $_surl .= '&city_id='.$city_id;
        };
        $_surl = $_surl ? '?'.ltrim($_surl,'&') : '';
        //分页配置
        $start = ($page - 1) * $this->pagesize;
        //分页配置
        //根据城市获取当前区域，板块，环线
        $pop_list = $this->dataface_yearbook->get_qol_list($city_id,$start,$this->pagesize);
        $total =  $this->dataface_yearbook->get_qol_list_count($city_id);
        $data['pop_list'] = $pop_list;
        $data['city_id'] = $city_id;
        $data['pagestr'] = $this->utility->multi($total, $this->pagesize, $page, '/yearbook/qol_list/', $_surl);
        $this->load->view('qol_list',$data);
    }
    //QOL info
    function qol_info(){
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        $id = $this->input->get('id');
        $city_id = $this->input->get('city_id');
        $qol_info = $this->dataface_yearbook->get_qol_info($id);
        $data['city_id'] = $city_id;
        $data['qol_info'] = $qol_info;
        $data['id'] = $id;
        $this->load->view('qol_info',$data);
    }
    //QOL add
    function qol_add(){
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        $city_id = $this->input->get('city_id');
        $data['city_id'] = $city_id;
        $data['id'] = 0;
        $this->load->view('qol_info',$data);
    }
    //QOL update
    function update_qoljbxx(){
        $id = $this->input->post('id');
        $city_id = $this->input->post('city_id');
        //qol信息
        $build_q_area = $this->input->post('build_q_area');
        $live_use_area = $this->input->post('live_use_area');
        $city_area = $this->input->post('city_area');
        $per_use_area = $this->input->post('per_use_area');
        $per_build_area = $this->input->post('per_build_area');

        $per_disposable_income = $this->input->post('per_disposable_income');
        $per_consumer_spending = $this->input->post('per_consumer_spending');
        $savings_surplus = $this->input->post('savings_surplus');

        $pcs_food = $this->input->post('pcs_food');
        $pcs_clothes = $this->input->post('pcs_clothes');
        $pcs_home_kits = $this->input->post('pcs_home_kits');
        $pcs_medical_care = $this->input->post('pcs_medical_care');
        $pcs_traffic_tel = $this->input->post('pcs_traffic_tel');
        $pcs_education = $this->input->post('pcs_education');
        $pcs_live = $this->input->post('pcs_live');
        $pcs_other = $this->input->post('pcs_other');

        $update_set['build_q_area'] = $build_q_area;
        $update_set['live_use_area'] = $live_use_area;
        $update_set['city_area'] = $city_area;
        $update_set['per_use_area'] = $per_use_area;
        $update_set['per_build_area'] = $per_build_area;
        $update_set['per_disposable_income'] = $per_disposable_income;
        $update_set['per_consumer_spending'] = $per_consumer_spending;
        $update_set['savings_surplus'] = $savings_surplus;

        $update_set['pcs_food'] = $pcs_food;
        $update_set['pcs_clothes'] = $pcs_clothes;
        $update_set['pcs_home_kits'] = $pcs_home_kits;
        $update_set['pcs_medical_care'] = $pcs_medical_care;
        $update_set['pcs_traffic_tel'] = $pcs_traffic_tel;
        $update_set['pcs_education'] = $pcs_education;
        $update_set['pcs_live'] = $pcs_live;
        $update_set['pcs_other'] = $pcs_other;

        $update_where['id'] = $id;
        $this->dataface_yearbook->update($update_set,$update_where,'dataface_yearbook_qol');
        $this->utility->tsgGoHref('修改成功','/yearbook/qol_info/?id='.$id.'&city_id='.$city_id);
    }
    //QOL add
    function add_qoljbxx(){
        $city_id = $this->input->post('city_id');
        //qol信息
        $qol_year = $this->input->post('qol_year');
        $build_q_area = $this->input->post('build_q_area');
        $live_use_area = $this->input->post('live_use_area');
        $city_area = $this->input->post('city_area');
        $per_use_area = $this->input->post('per_use_area');
        $per_build_area = $this->input->post('per_build_area');

        $per_disposable_income = $this->input->post('per_disposable_income');
        $per_consumer_spending = $this->input->post('per_consumer_spending');
        $savings_surplus = $this->input->post('savings_surplus');

        $pcs_food = $this->input->post('pcs_food');
        $pcs_clothes = $this->input->post('pcs_clothes');
        $pcs_home_kits = $this->input->post('pcs_home_kits');
        $pcs_medical_care = $this->input->post('pcs_medical_care');
        $pcs_traffic_tel = $this->input->post('pcs_traffic_tel');
        $pcs_education = $this->input->post('pcs_education');
        $pcs_live = $this->input->post('pcs_live');
        $pcs_other = $this->input->post('pcs_other');

        $id = $this->dataface_yearbook->add_qol($city_id,$qol_year,$build_q_area,$live_use_area,$city_area,$per_use_area,$per_build_area,$per_disposable_income,$per_consumer_spending,
            $savings_surplus,$pcs_food,$pcs_clothes,$pcs_home_kits,$pcs_medical_care,$pcs_traffic_tel,$pcs_education,$pcs_live,$pcs_other);
        if($id)
            $this->utility->tsgGoHref('添加成功','/yearbook/qol_info/?id='.$id.'&city_id='.$city_id);
        else
            $this->utility->tsgGoHref('添加失败','/yearbook/qol_info/?city_id='.$city_id);
    }
    //--------------------------------------
    //fixedassets List
    function fixedassets_list($page=1)
    {
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        //获取城市
        $citylist = $this->city->get_list();
        $data['citylist'] = $citylist;
        $city_id = 0;
        $date_type = 'Y';
        $_surl = '';
        if (!empty($_GET['city_id'])) {
            $city_id=$_GET['city_id'];
            $_surl .= '&city_id='.$city_id;
        };
        if (!empty($_GET['date_type'])) {
            $date_type=$_GET['date_type'];
            $_surl .= '&date_type='.$date_type;
        };
        $_surl = $_surl ? '?'.ltrim($_surl,'&') : '';
        //分页配置
        $start = ($page - 1) * $this->pagesize;
        //分页配置
        $fixedassets_list = $this->dataface_yearbook->get_fixedassets_list($city_id,$date_type,$start,$this->pagesize);
        $total =  $this->dataface_yearbook->get_fixedassets_list_count($city_id,$date_type);
        $data['fixedassets_list'] = $fixedassets_list;
        $data['date_type'] =$date_type;
        $data['city_id'] = $city_id;
        $data['pagestr'] = $this->utility->multi($total, $this->pagesize, $page, '/yearbook/fixedassets_list/', $_surl);
        $this->load->view('fixedassets_list',$data);
    }
    //fixedassets info
    function fixedassets_info(){
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        $id = $this->input->get('id');
        $city_id = $this->input->get('city_id');
        $date_type = $this->input->get('date_type');
        $fixedassets_info = $this->dataface_yearbook->get_fixedassets_info($id);
        $data['city_id'] = $city_id;
        $data['date_type'] = $date_type;
        $data['fixedassets_info'] = $fixedassets_info;
        $name = $fixedassets_info->fa_year.'年';
        if($date_type == 'Q')
            $name .= '第'.$fixedassets_info->fa_quarter.'季度';
        if($date_type == 'M')
            $name .=  $fixedassets_info->fa_month.'月';
        $data['id'] = $id;
        $data['name'] = $name;
        $this->load->view('fixedassets_info',$data);
    }
    function fixedassets_add(){
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        $city_id = $this->input->get('city_id');
        $date_type = $this->input->get('date_type');
        $data['city_id'] = $city_id;
        $data['id'] = 0;
        $data['date_type'] = $date_type;
        $this->load->view('fixedassets_add',$data);
    }
    //fixedassets update
    function update_fixedassetsjbxx_Y(){
        $id = $this->input->post('id');
        $city_id = $this->input->post('city_id');
        //gdp 信息
        $fa_year = $this->input->post('fa_year');
        $fixe_assets_value = $this->input->post('fixe_assets_value');
        $infrastructure_value = $this->input->post('infrastructure_value');
        $fixe_assets_house = $this->input->post('fixe_assets_house');
        $update_set['fa_year'] = $fa_year;
        $update_set['fixe_assets_value'] = $fixe_assets_value;
        $update_set['infrastructure_value'] = $infrastructure_value;
        $update_set['fixe_assets_house'] = $fixe_assets_house;
        $update_where['id'] = $id;
        $this->dataface_yearbook->update($update_set,$update_where,'dataface_yearbook_fixedassets');
        $this->utility->tsgGoHref('修改成功','/yearbook/fixedassets_info/?id='.$id.'&city_id='.$city_id.'&date_type=Y');
    }
    function update_fixedassetsjbxx_Q(){
        $id = $this->input->post('id');
        $city_id = $this->input->post('city_id');
        //gdp 信息
        $fa_year = $this->input->post('fa_year');
        $fa_quarter = $this->input->post('fa_quarter');
        $fa_value_quarter = $this->input->post('fa_value_quarter');
        $fa_value_total = $this->input->post('fa_value_total');

        $update_set['fa_year'] = $fa_year;
        $update_set['fa_quarter'] = $fa_quarter;
        $update_set['fa_value_quarter'] = $fa_value_quarter;
        $update_set['fa_value_total'] = $fa_value_total;

        $update_where['id'] = $id;
        $this->dataface_yearbook->update($update_set,$update_where,'dataface_yearbook_fixedassets');
        $this->utility->tsgGoHref('修改成功','/yearbook/fixedassets_info/?id='.$id.'&city_id='.$city_id.'&date_type=Q');
    }
    function update_fixedassetsjbxx_M(){
        $id = $this->input->post('id');
        $city_id = $this->input->post('city_id');
        //gdp 信息
        $fa_year = $this->input->post('fa_year');
        $fa_month = $this->input->post('fa_month');
        $fa_value_month = $this->input->post('fa_value_month');
        $fa_value_total = $this->input->post('fa_value_total');

        $update_set['fa_year'] = $fa_year;
        $update_set['fa_month'] = $fa_month;
        $update_set['fa_value_month'] = $fa_value_month;
        $update_set['fa_value_total'] = $fa_value_total;

        $update_where['id'] = $id;
        $this->dataface_yearbook->update($update_set,$update_where,'dataface_yearbook_fixedassets');
        $this->utility->tsgGoHref('修改成功','/yearbook/fixedassets_info/?id='.$id.'&city_id='.$city_id.'&date_type=M');
    }
    //fixedassets add
    function add_fixedassetsjbxx_Y(){
        $city_id = $this->input->post('city_id');
        //gdp信息
        $fa_year = $this->input->post('fa_year');
        $fixe_assets_value = $this->input->post('fixe_assets_value');
        $infrastructure_value = $this->input->post('infrastructure_value');
        $fixe_assets_house = $this->input->post('fixe_assets_house');

        $id = $this->dataface_yearbook->add_fixedassets($city_id,$fa_year,0,0,0,0,0,$fixe_assets_value,$infrastructure_value,$fixe_assets_house);
        if($id)
            $this->utility->tsgGoHref('添加成功','/yearbook/fixedassets_info/?id='.$id.'&city_id='.$city_id.'&date_type=Y');
        else
            $this->utility->tsgGoHref('添加失败','/yearbook/fixedassets_info/?city_id='.$city_id.'&date_type=Y');
    }
    function add_fixedassetsjbxx_Q(){
        $city_id = $this->input->post('city_id');
        //gdp信息
        $fa_year = $this->input->post('fa_year');
        $fa_quarter = $this->input->post('fa_quarter');
        $fa_value_quarter = $this->input->post('fa_value_quarter');
        $fa_value_total = $this->input->post('fa_value_total');
        $id = $this->dataface_yearbook->add_fixedassets($city_id,$fa_year,$fa_quarter,0,$fa_value_quarter,0,$fa_value_total,0,0,0);
        if($id)
            $this->utility->tsgGoHref('添加成功','/yearbook/fixedassets_info/?id='.$id.'&city_id='.$city_id.'&date_type=Q');
        else
            $this->utility->tsgGoHref('添加失败','/yearbook/fixedassets_info/?city_id='.$city_id.'&date_type=Q');
    }
    function add_fixedassetsjbxx_M(){
        $city_id = $this->input->post('city_id');
        //gdp信息
        $fa_year = $this->input->post('fa_year');
        $fa_month = $this->input->post('fa_month');
        $fa_value_month = $this->input->post('fa_value_month');
        $fa_value_total = $this->input->post('fa_value_total');

        $id = $this->dataface_yearbook->add_fixedassets($city_id,$fa_year,0,$fa_month,0,$fa_value_month,$fa_value_total,0,0,0);
        if($id)
            $this->utility->tsgGoHref('添加成功','/yearbook/fixedassets_info/?id='.$id.'&city_id='.$city_id.'&date_type=M');
        else
            $this->utility->tsgGoHref('添加失败','/yearbook/fixedassets_info/?city_id='.$city_id.'&date_type=M');
    }
    //-----------------------------------------
    //realtyprice List
    function realtyprice_list($page=1)
    {
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        //获取城市
        $citylist = $this->city->get_list();
        $data['citylist'] = $citylist;
        $city_id = 0;
        $_surl = '';
        if (!empty($_GET['city_id'])) {
            $city_id=$_GET['city_id'];
            $_surl .= '&city_id='.$city_id;
        };
        $_surl = $_surl ? '?'.ltrim($_surl,'&') : '';
        //分页配置
        $start = ($page - 1) * $this->pagesize;
        //分页配置
        //根据城市获取当前区域，板块，环线
        $pop_list = $this->dataface_yearbook->get_realtyprice_list($city_id,$start,$this->pagesize);
        $total =  $this->dataface_yearbook->get_realtyprice_list_count($city_id);
        $data['pop_list'] = $pop_list;
        $data['city_id'] = $city_id;
        $data['pagestr'] = $this->utility->multi($total, $this->pagesize, $page, '/yearbook/realtyprice_list/', $_surl);
        $this->load->view('realtyprice_list',$data);
    }
    //realtyprice info
    function realtyprice_info(){
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        $id = $this->input->get('id');
        $city_id = $this->input->get('city_id');
        $realtyprice_info = $this->dataface_yearbook->get_realtyprice_info($id);
        $data['city_id'] = $city_id;
        $data['realtyprice_info'] = $realtyprice_info;
        $data['id'] = $id;
        $this->load->view('realtyprice_info',$data);
    }
    //realtyprice add
    function realtyprice_add(){
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        $city_id = $this->input->get('city_id');
        $data['city_id'] = $city_id;
        $data['id'] = 0;
        $this->load->view('realtyprice_info',$data);
    }
    //realtyprice update
    function update_realtypricejbxx(){
        $id = $this->input->post('id');
        $city_id = $this->input->post('city_id');
        //realtyprice信息
        $realty_year = $this->input->post('realty_year');
        $realty_month = $this->input->post('realty_month');
        $realty_spf_total_price = $this->input->post('realty_spf_total_price');
        $realty_spf_month_price = $this->input->post('realty_spf_month_price');
        $realty_zz_total_price = $this->input->post('realty_zz_total_price');
        $realty_zz_month_price = $this->input->post('realty_zz_month_price');
        $realty_jsf_total_price = $this->input->post('realty_jsf_total_price');
        $realty_jsf_month_price = $this->input->post('realty_jsf_month_price');
        $realty_bs_total_price = $this->input->post('realty_bs_total_price');
        $realty_bs_month_price = $this->input->post('realty_bs_month_price');
        $realty_bg_total_price = $this->input->post('realty_bg_total_price');
        $realty_bg_month_price = $this->input->post('realty_bg_month_price');
        $realty_sy_total_price = $this->input->post('realty_sy_total_price');
        $realty_sy_month_price = $this->input->post('realty_sy_month_price');

        $update_set['realty_year'] = $realty_year;
        $update_set['realty_month'] = $realty_month;
        $update_set['realty_spf_total_price'] = $realty_spf_total_price;
        $update_set['realty_spf_month_price'] = $realty_spf_month_price;
        $update_set['realty_zz_total_price'] = $realty_zz_total_price;
        $update_set['realty_zz_month_price'] = $realty_zz_month_price;
        $update_set['realty_jsf_total_price'] = $realty_jsf_total_price;
        $update_set['realty_jsf_month_price'] = $realty_jsf_month_price;

        $update_set['realty_bs_total_price'] = $realty_bs_total_price;
        $update_set['realty_bs_month_price'] = $realty_bs_month_price;
        $update_set['realty_bg_total_price'] = $realty_bg_total_price;
        $update_set['realty_bg_month_price'] = $realty_bg_month_price;
        $update_set['realty_sy_total_price'] = $realty_sy_total_price;
        $update_set['realty_sy_month_price'] = $realty_sy_month_price;

        $update_where['id'] = $id;
        $this->dataface_yearbook->update($update_set,$update_where,'dataface_yearbook_realtyprice');
        $this->utility->tsgGoHref('修改成功','/yearbook/realtyprice_info/?id='.$id.'&city_id='.$city_id);
    }
    //realtyprice add
    function add_realtypricejbxx(){
        $city_id = $this->input->post('city_id');
        //realtyprice信息
        $realty_year = $this->input->post('realty_year');
        $realty_month = $this->input->post('realty_month');
        $realty_spf_total_price = $this->input->post('realty_spf_total_price');
        $realty_spf_month_price = $this->input->post('realty_spf_month_price');
        $realty_zz_total_price = $this->input->post('realty_zz_total_price');
        $realty_zz_month_price = $this->input->post('realty_zz_month_price');
        $realty_jsf_total_price = $this->input->post('realty_jsf_total_price');
        $realty_jsf_month_price = $this->input->post('realty_jsf_month_price');
        $realty_bs_total_price = $this->input->post('realty_bs_total_price');
        $realty_bs_month_price = $this->input->post('realty_bs_month_price');
        $realty_bg_total_price = $this->input->post('realty_bg_total_price');
        $realty_bg_month_price = $this->input->post('realty_bg_month_price');
        $realty_sy_total_price = $this->input->post('realty_sy_total_price');
        $realty_sy_month_price = $this->input->post('realty_sy_month_price');

        $id = $this->dataface_yearbook->add_realtyprice($city_id,$realty_year,$realty_month,$realty_spf_total_price,$realty_spf_month_price,$realty_zz_total_price,$realty_zz_month_price
            ,$realty_jsf_total_price,$realty_jsf_month_price,$realty_bs_total_price,$realty_bs_month_price,$realty_bg_total_price,$realty_bg_month_price,$realty_sy_total_price,$realty_sy_month_price);
        if($id)
            $this->utility->tsgGoHref('添加成功','/yearbook/realtyprice_info/?id='.$id.'&city_id='.$city_id);
        else
            $this->utility->tsgGoHref('添加失败','/yearbook/realtyprice_info/?city_id='.$city_id);
    }
    //-----------------------------------------
    //realtycompletedarea List
    function realtycompletedarea_list($page=1)
    {
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        //获取城市
        $citylist = $this->city->get_list();
        $data['citylist'] = $citylist;
        $city_id = 0;
        $_surl = '';
        if (!empty($_GET['city_id'])) {
            $city_id=$_GET['city_id'];
            $_surl .= '&city_id='.$city_id;
        };
        $_surl = $_surl ? '?'.ltrim($_surl,'&') : '';
        //分页配置
        $start = ($page - 1) * $this->pagesize;
        //分页配置
        //根据城市获取当前区域，板块，环线
        $pop_list = $this->dataface_yearbook->get_realtycompletedarea_list($city_id,$start,$this->pagesize);
        $total =  $this->dataface_yearbook->get_realtycompletedarea_list_count($city_id);
        $data['pop_list'] = $pop_list;
        $data['city_id'] = $city_id;
        $data['pagestr'] = $this->utility->multi($total, $this->pagesize, $page, '/yearbook/realtycompletedarea_list/', $_surl);
        $this->load->view('realtycompletedarea_list',$data);
    }
    //realtycompletedarea info
    function realtycompletedarea_info(){
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        $id = $this->input->get('id');
        $city_id = $this->input->get('city_id');
        $realtycompletedarea_info = $this->dataface_yearbook->get_realtycompletedarea_info($id);
        $data['city_id'] = $city_id;
        $data['realtycompletedarea_info'] = $realtycompletedarea_info;
        $data['id'] = $id;
        $this->load->view('realtycompletedarea_info',$data);
    }
    //realtycompletedarea add
    function realtycompletedarea_add(){
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        $city_id = $this->input->get('city_id');
        $data['city_id'] = $city_id;
        $data['id'] = 0;
        $this->load->view('realtycompletedarea_info',$data);
    }
    //realtycompletedarea update
    function update_realtycompletedareajbxx(){
        $id = $this->input->post('id');
        $city_id = $this->input->post('city_id');
        //realtycompletedarea信息
        $realty_year = $this->input->post('realty_year');
        $realty_month = 12;//$this->input->post('realty_month');
        $realty_spf_total_completedarea = $this->input->post('realty_spf_total_completedarea');
        $realty_spf_month_completedarea = $this->input->post('realty_spf_month_completedarea');
        $realty_zz_total_completedarea = $this->input->post('realty_zz_total_completedarea');
        $realty_zz_month_completedarea = $this->input->post('realty_zz_month_completedarea');
        $realty_jsf_total_completedarea = $this->input->post('realty_jsf_total_completedarea');
        $realty_jsf_month_completedarea = $this->input->post('realty_jsf_month_completedarea');
        $realty_bs_total_completedarea = $this->input->post('realty_bs_total_completedarea');
        $realty_bs_month_completedarea = $this->input->post('realty_bs_month_completedarea');
        $realty_bg_total_completedarea = $this->input->post('realty_bg_total_completedarea');
        $realty_bg_month_completedarea = $this->input->post('realty_bg_month_completedarea');
        $realty_sy_total_completedarea = $this->input->post('realty_sy_total_completedarea');
        $realty_sy_month_completedarea = $this->input->post('realty_sy_month_completedarea');

        $update_set['realty_year'] = $realty_year;
        $update_set['realty_month'] = $realty_month;
        $update_set['realty_spf_total_completedarea'] = $realty_spf_total_completedarea;
        $update_set['realty_spf_month_completedarea'] = $realty_spf_month_completedarea;
        $update_set['realty_zz_total_completedarea'] = $realty_zz_total_completedarea;
        $update_set['realty_zz_month_completedarea'] = $realty_zz_month_completedarea;
        $update_set['realty_jsf_total_completedarea'] = $realty_jsf_total_completedarea;
        $update_set['realty_jsf_month_completedarea'] = $realty_jsf_month_completedarea;

        $update_set['realty_bs_total_completedarea'] = $realty_bs_total_completedarea;
        $update_set['realty_bs_month_completedarea'] = $realty_bs_month_completedarea;
        $update_set['realty_bg_total_completedarea'] = $realty_bg_total_completedarea;
        $update_set['realty_bg_month_completedarea'] = $realty_bg_month_completedarea;
        $update_set['realty_sy_total_completedarea'] = $realty_sy_total_completedarea;
        $update_set['realty_sy_month_completedarea'] = $realty_sy_month_completedarea;

        $update_where['id'] = $id;
        $this->dataface_yearbook->update($update_set,$update_where,'dataface_yearbook_realtycompletedarea');
        $this->utility->tsgGoHref('修改成功','/yearbook/realtycompletedarea_info/?id='.$id.'&city_id='.$city_id);
    }
    //realtycompletedarea add
    function add_realtycompletedareajbxx(){
        $city_id = $this->input->post('city_id');
        //realtycompletedarea信息
        $realty_year = $this->input->post('realty_year');
        $realty_month = 12;//$this->input->post('realty_month');
        $realty_spf_total_completedarea = $this->input->post('realty_spf_total_completedarea');
        $realty_spf_month_completedarea = $this->input->post('realty_spf_month_completedarea');
        $realty_zz_total_completedarea = $this->input->post('realty_zz_total_completedarea');
        $realty_zz_month_completedarea = $this->input->post('realty_zz_month_completedarea');
        $realty_jsf_total_completedarea = $this->input->post('realty_jsf_total_completedarea');
        $realty_jsf_month_completedarea = $this->input->post('realty_jsf_month_completedarea');
        $realty_bs_total_completedarea = $this->input->post('realty_bs_total_completedarea');
        $realty_bs_month_completedarea = $this->input->post('realty_bs_month_completedarea');
        $realty_bg_total_completedarea = $this->input->post('realty_bg_total_completedarea');
        $realty_bg_month_completedarea = $this->input->post('realty_bg_month_completedarea');
        $realty_sy_total_completedarea = $this->input->post('realty_sy_total_completedarea');
        $realty_sy_month_completedarea = $this->input->post('realty_sy_month_completedarea');

        $id = $this->dataface_yearbook->add_realtycompletedarea($city_id,$realty_year,$realty_month,$realty_spf_total_completedarea,$realty_spf_month_completedarea,$realty_zz_total_completedarea,$realty_zz_month_completedarea
            ,$realty_jsf_total_completedarea,$realty_jsf_month_completedarea,$realty_bs_total_completedarea,$realty_bs_month_completedarea,$realty_bg_total_completedarea,$realty_bg_month_completedarea,$realty_sy_total_completedarea,$realty_sy_month_completedarea);
        if($id)
            $this->utility->tsgGoHref('添加成功','/yearbook/realtycompletedarea_info/?id='.$id.'&city_id='.$city_id);
        else
            $this->utility->tsgGoHref('添加失败','/yearbook/realtycompletedarea_info/?city_id='.$city_id);
    }
    //-----------------------------------------
    //realtybuildarea List
    function realtybuildarea_list($page=1)
    {
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        //获取城市
        $citylist = $this->city->get_list();
        $data['citylist'] = $citylist;
        $city_id = 0;
        $_surl = '';
        if (!empty($_GET['city_id'])) {
            $city_id=$_GET['city_id'];
            $_surl .= '&city_id='.$city_id;
        };
        $_surl = $_surl ? '?'.ltrim($_surl,'&') : '';
        //分页配置
        $start = ($page - 1) * $this->pagesize;
        //分页配置
        //根据城市获取当前区域，板块，环线
        $pop_list = $this->dataface_yearbook->get_realtybuildarea_list($city_id,$start,$this->pagesize);
        $total =  $this->dataface_yearbook->get_realtybuildarea_list_count($city_id);
        $data['pop_list'] = $pop_list;
        $data['city_id'] = $city_id;
        $data['pagestr'] = $this->utility->multi($total, $this->pagesize, $page, '/yearbook/realtybuildarea_list/', $_surl);
        $this->load->view('realtybuildarea_list',$data);
    }
    //realtybuildarea info
    function realtybuildarea_info(){
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        $id = $this->input->get('id');
        $city_id = $this->input->get('city_id');
        $realtybuildarea_info = $this->dataface_yearbook->get_realtybuildarea_info($id);
        $data['city_id'] = $city_id;
        $data['realtybuildarea_info'] = $realtybuildarea_info;
        $data['id'] = $id;
        $this->load->view('realtybuildarea_info',$data);
    }
    //realtybuildarea add
    function realtybuildarea_add(){
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        $city_id = $this->input->get('city_id');
        $data['city_id'] = $city_id;
        $data['id'] = 0;
        $this->load->view('realtybuildarea_info',$data);
    }
    //realtybuildarea update
    function update_realtybuildareajbxx(){
        $id = $this->input->post('id');
        $city_id = $this->input->post('city_id');
        //realtybuildarea信息
        $realty_year = $this->input->post('realty_year');
        $realty_month = 12;//$this->input->post('realty_month');
        $realty_spf_total_buildarea = $this->input->post('realty_spf_total_buildarea');
        $realty_spf_month_buildarea = $this->input->post('realty_spf_month_buildarea');
        $realty_zz_total_buildarea = $this->input->post('realty_zz_total_buildarea');
        $realty_zz_month_buildarea = $this->input->post('realty_zz_month_buildarea');
        $realty_jsf_total_buildarea = $this->input->post('realty_jsf_total_buildarea');
        $realty_jsf_month_buildarea = $this->input->post('realty_jsf_month_buildarea');
        $realty_bs_total_buildarea = $this->input->post('realty_bs_total_buildarea');
        $realty_bs_month_buildarea = $this->input->post('realty_bs_month_buildarea');
        $realty_bg_total_buildarea = $this->input->post('realty_bg_total_buildarea');
        $realty_bg_month_buildarea = $this->input->post('realty_bg_month_buildarea');
        $realty_sy_total_buildarea = $this->input->post('realty_sy_total_buildarea');
        $realty_sy_month_buildarea = $this->input->post('realty_sy_month_buildarea');

        $update_set['realty_year'] = $realty_year;
        $update_set['realty_month'] = $realty_month;
        $update_set['realty_spf_total_buildarea'] = $realty_spf_total_buildarea;
        $update_set['realty_spf_month_buildarea'] = $realty_spf_month_buildarea;
        $update_set['realty_zz_total_buildarea'] = $realty_zz_total_buildarea;
        $update_set['realty_zz_month_buildarea'] = $realty_zz_month_buildarea;
        $update_set['realty_jsf_total_buildarea'] = $realty_jsf_total_buildarea;
        $update_set['realty_jsf_month_buildarea'] = $realty_jsf_month_buildarea;

        $update_set['realty_bs_total_buildarea'] = $realty_bs_total_buildarea;
        $update_set['realty_bs_month_buildarea'] = $realty_bs_month_buildarea;
        $update_set['realty_bg_total_buildarea'] = $realty_bg_total_buildarea;
        $update_set['realty_bg_month_buildarea'] = $realty_bg_month_buildarea;
        $update_set['realty_sy_total_buildarea'] = $realty_sy_total_buildarea;
        $update_set['realty_sy_month_buildarea'] = $realty_sy_month_buildarea;

        $update_where['id'] = $id;
        $this->dataface_yearbook->update($update_set,$update_where,'dataface_yearbook_realtybuildarea');
        $this->utility->tsgGoHref('修改成功','/yearbook/realtybuildarea_info/?id='.$id.'&city_id='.$city_id);
    }
    //realtybuildarea add
    function add_realtybuildareajbxx(){
        $city_id = $this->input->post('city_id');
        //realtybuildarea信息
        $realty_year = $this->input->post('realty_year');
        $realty_month = 12;//$this->input->post('realty_month');
        $realty_spf_total_buildarea = $this->input->post('realty_spf_total_buildarea');
        $realty_spf_month_buildarea = $this->input->post('realty_spf_month_buildarea');
        $realty_zz_total_buildarea = $this->input->post('realty_zz_total_buildarea');
        $realty_zz_month_buildarea = $this->input->post('realty_zz_month_buildarea');
        $realty_jsf_total_buildarea = $this->input->post('realty_jsf_total_buildarea');
        $realty_jsf_month_buildarea = $this->input->post('realty_jsf_month_buildarea');
        $realty_bs_total_buildarea = $this->input->post('realty_bs_total_buildarea');
        $realty_bs_month_buildarea = $this->input->post('realty_bs_month_buildarea');
        $realty_bg_total_buildarea = $this->input->post('realty_bg_total_buildarea');
        $realty_bg_month_buildarea = $this->input->post('realty_bg_month_buildarea');
        $realty_sy_total_buildarea = $this->input->post('realty_sy_total_buildarea');
        $realty_sy_month_buildarea = $this->input->post('realty_sy_month_buildarea');

        $id = $this->dataface_yearbook->add_realtybuildarea($city_id,$realty_year,$realty_month,$realty_spf_total_buildarea,$realty_spf_month_buildarea,$realty_zz_total_buildarea,$realty_zz_month_buildarea
            ,$realty_jsf_total_buildarea,$realty_jsf_month_buildarea,$realty_bs_total_buildarea,$realty_bs_month_buildarea,$realty_bg_total_buildarea,$realty_bg_month_buildarea,$realty_sy_total_buildarea,$realty_sy_month_buildarea);
        if($id)
            $this->utility->tsgGoHref('添加成功','/yearbook/realtybuildarea_info/?id='.$id.'&city_id='.$city_id);
        else
            $this->utility->tsgGoHref('添加失败','/yearbook/realtybuildarea_info/?city_id='.$city_id);
    }
    //-----------------------------------------
    //realtynewstartarea List
    function realtynewstartarea_list($page=1)
    {
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        //获取城市
        $citylist = $this->city->get_list();
        $data['citylist'] = $citylist;
        $city_id = 0;
        $_surl = '';
        if (!empty($_GET['city_id'])) {
            $city_id=$_GET['city_id'];
            $_surl .= '&city_id='.$city_id;
        };
        $_surl = $_surl ? '?'.ltrim($_surl,'&') : '';
        //分页配置
        $start = ($page - 1) * $this->pagesize;
        //分页配置
        //根据城市获取当前区域，板块，环线
        $pop_list = $this->dataface_yearbook->get_realtynewstartarea_list($city_id,$start,$this->pagesize);
        $total =  $this->dataface_yearbook->get_realtynewstartarea_list_count($city_id);
        $data['pop_list'] = $pop_list;
        $data['city_id'] = $city_id;
        $data['pagestr'] = $this->utility->multi($total, $this->pagesize, $page, '/yearbook/realtynewstartarea_list/', $_surl);
        $this->load->view('realtynewstartarea_list',$data);
    }
    //realtynewstartarea info
    function realtynewstartarea_info(){
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        $id = $this->input->get('id');
        $city_id = $this->input->get('city_id');
        $realtynewstartarea_info = $this->dataface_yearbook->get_realtynewstartarea_info($id);
        $data['city_id'] = $city_id;
        $data['realtynewstartarea_info'] = $realtynewstartarea_info;
        $data['id'] = $id;
        $this->load->view('realtynewstartarea_info',$data);
    }
    //realtynewstartarea add
    function realtynewstartarea_add(){
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        $city_id = $this->input->get('city_id');
        $data['city_id'] = $city_id;
        $data['id'] = 0;
        $this->load->view('realtynewstartarea_info',$data);
    }
    //realtynewstartarea update
    function update_realtynewstartareajbxx(){
        $id = $this->input->post('id');
        $city_id = $this->input->post('city_id');
        //realtynewstartarea信息
        $realty_year = $this->input->post('realty_year');
        $realty_month = 12;//$this->input->post('realty_month');
        $realty_spf_total_newstartarea = $this->input->post('realty_spf_total_newstartarea');
        $realty_spf_month_newstartarea = $this->input->post('realty_spf_month_newstartarea');
        $realty_zz_total_newstartarea = $this->input->post('realty_zz_total_newstartarea');
        $realty_zz_month_newstartarea = $this->input->post('realty_zz_month_newstartarea');
        $realty_jsf_total_newstartarea = $this->input->post('realty_jsf_total_newstartarea');
        $realty_jsf_month_newstartarea = $this->input->post('realty_jsf_month_newstartarea');
        $realty_bs_total_newstartarea = $this->input->post('realty_bs_total_newstartarea');
        $realty_bs_month_newstartarea = $this->input->post('realty_bs_month_newstartarea');
        $realty_bg_total_newstartarea = $this->input->post('realty_bg_total_newstartarea');
        $realty_bg_month_newstartarea = $this->input->post('realty_bg_month_newstartarea');
        $realty_sy_total_newstartarea = $this->input->post('realty_sy_total_newstartarea');
        $realty_sy_month_newstartarea = $this->input->post('realty_sy_month_newstartarea');

        $update_set['realty_year'] = $realty_year;
        $update_set['realty_month'] = $realty_month;
        $update_set['realty_spf_total_newstartarea'] = $realty_spf_total_newstartarea;
        $update_set['realty_spf_month_newstartarea'] = $realty_spf_month_newstartarea;
        $update_set['realty_zz_total_newstartarea'] = $realty_zz_total_newstartarea;
        $update_set['realty_zz_month_newstartarea'] = $realty_zz_month_newstartarea;
        $update_set['realty_jsf_total_newstartarea'] = $realty_jsf_total_newstartarea;
        $update_set['realty_jsf_month_newstartarea'] = $realty_jsf_month_newstartarea;

        $update_set['realty_bs_total_newstartarea'] = $realty_bs_total_newstartarea;
        $update_set['realty_bs_month_newstartarea'] = $realty_bs_month_newstartarea;
        $update_set['realty_bg_total_newstartarea'] = $realty_bg_total_newstartarea;
        $update_set['realty_bg_month_newstartarea'] = $realty_bg_month_newstartarea;
        $update_set['realty_sy_total_newstartarea'] = $realty_sy_total_newstartarea;
        $update_set['realty_sy_month_newstartarea'] = $realty_sy_month_newstartarea;

        $update_where['id'] = $id;
        $this->dataface_yearbook->update($update_set,$update_where,'dataface_yearbook_realtynewstartarea');
        $this->utility->tsgGoHref('修改成功','/yearbook/realtynewstartarea_info/?id='.$id.'&city_id='.$city_id);
    }
    //realtynewstartarea add
    function add_realtynewstartareajbxx(){
        $city_id = $this->input->post('city_id');
        //realtynewstartarea信息
        $realty_year = $this->input->post('realty_year');
        $realty_month = 12;//$this->input->post('realty_month');
        $realty_spf_total_newstartarea = $this->input->post('realty_spf_total_newstartarea');
        $realty_spf_month_newstartarea = $this->input->post('realty_spf_month_newstartarea');
        $realty_zz_total_newstartarea = $this->input->post('realty_zz_total_newstartarea');
        $realty_zz_month_newstartarea = $this->input->post('realty_zz_month_newstartarea');
        $realty_jsf_total_newstartarea = $this->input->post('realty_jsf_total_newstartarea');
        $realty_jsf_month_newstartarea = $this->input->post('realty_jsf_month_newstartarea');
        $realty_bs_total_newstartarea = $this->input->post('realty_bs_total_newstartarea');
        $realty_bs_month_newstartarea = $this->input->post('realty_bs_month_newstartarea');
        $realty_bg_total_newstartarea = $this->input->post('realty_bg_total_newstartarea');
        $realty_bg_month_newstartarea = $this->input->post('realty_bg_month_newstartarea');
        $realty_sy_total_newstartarea = $this->input->post('realty_sy_total_newstartarea');
        $realty_sy_month_newstartarea = $this->input->post('realty_sy_month_newstartarea');

        $id = $this->dataface_yearbook->add_realtynewstartarea($city_id,$realty_year,$realty_month,$realty_spf_total_newstartarea,$realty_spf_month_newstartarea,$realty_zz_total_newstartarea,$realty_zz_month_newstartarea
            ,$realty_jsf_total_newstartarea,$realty_jsf_month_newstartarea,$realty_bs_total_newstartarea,$realty_bs_month_newstartarea,$realty_bg_total_newstartarea,$realty_bg_month_newstartarea,$realty_sy_total_newstartarea,$realty_sy_month_newstartarea);
        if($id)
            $this->utility->tsgGoHref('添加成功','/yearbook/realtynewstartarea_info/?id='.$id.'&city_id='.$city_id);
        else
            $this->utility->tsgGoHref('添加失败','/yearbook/realtynewstartarea_info/?city_id='.$city_id);
    }
}