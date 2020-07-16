<?php

/**
 * Created by PhpStorm.
 * User: jmillerfun
 * Date: 2018/10/27
 * Time: 23:24
 */
class DatafaceYearbook extends  CI_Model{

    function __construct(){
        parent::__construct();
        $this->db = $this->load->database('data_dataface',TRUE);
    }

    //更新信息
    function update($update_set,$wheres,$table){
        foreach($update_set as $k=>$v){
            $this->db->set($k, '\''.$v.'\'', FALSE);
        }
        foreach($wheres as $k=>$v){
            $this->db->where($k, '\''.$v.'\'', FALSE);
        }
        $this->db->update($table);
    }

    //------------------------------------
    //查询GDP列表
    function get_gdp_list($city_id,$date_type,$page,$pagesize){
        $query = 'select * from dataface_yearbook_gdp where city_id= '.$city_id.' and gdp_quarter > 0 order by gdp_year desc  limit '.$page.','.$pagesize.'';
        if($date_type == 'Y')
            $query = 'select * from dataface_yearbook_gdp where city_id= '.$city_id.' and gdp_quarter=0 order by gdp_year desc limit '.$page.','.$pagesize.'';
        $result = $this->db->query($query)->result();
        return $result;
    }
    //查询GDP列表
    function get_gdp_list_count($city_id,$date_type)
    {
        $query = 'select count(1) cnt from dataface_yearbook_gdp where city_id= '.$city_id.' and gdp_quarter > 0  ';
        if($date_type == 'Y')
            $query = 'select count(1) cnt from dataface_yearbook_gdp where city_id= '.$city_id.' and gdp_quarter=0 ';
        $result = $this->db->query($query)->row();
        return $result->cnt;
    }
    //查询GDP详情
    function get_gdp_info($id)
    {
        $query = 'select * from dataface_yearbook_gdp where id= '.$id.'';
        $result = $this->db->query($query)->row();
        return $result;
    }
    //添加GDP信息
    function add_gdp($city_id,$gdp_year,$gdp_quarter,$gdp_value_quarter,$gdp_value_total,$first_value,$second_value,$third_value,$per_gdp,$total_value)
    {
        $id = 0;
        $this->db->where('city_id',$city_id);
        $this->db->where('gdp_year',$gdp_year);
        $this->db->where('gdp_quarter',$gdp_quarter);
        $this->query = $this->db->get('dataface_yearbook_gdp');
        if($this->query->num_rows() <= 0)
        {
            $this->db->set('city_id',$city_id);
            $this->db->set('gdp_year',$gdp_year);
            $this->db->set('gdp_quarter', $gdp_quarter);
            $this->db->set('gdp_value_quarter', $gdp_value_quarter);
            $this->db->set('gdp_value_total', $gdp_value_total);
            $this->db->set('first_value', $first_value);
            $this->db->set('second_value', $second_value);
            $this->db->set('third_value', $third_value);
            $this->db->set('per_gdp', $per_gdp);
            $this->db->set('total_value', $total_value);

            $this->db->insert('dataface_yearbook_gdp');
            $id = $this->db->insert_id();
        }
        return $id;
    }
    //----------------------------------------
    //查询人口列表
    function get_pop_list($city_id,$page,$pagesize){
        $query = 'select * from dataface_yearbook_population where city_id= '.$city_id.' order by pop_year desc limit '.$page.','.$pagesize.'';
        $result = $this->db->query($query)->result();
        return $result;
    }
    //查询人口列表总数
    function get_pop_list_count($city_id)
    {
        $query = 'select count(1) cnt from dataface_yearbook_population where city_id= '.$city_id.' ';
        $result = $this->db->query($query)->row();
        return $result->cnt;
    }
    //人口详细
    function get_pop_info($id){
        $query = 'select * from dataface_yearbook_population where id= '.$id.'';
        $result = $this->db->query($query)->row();
        return $result;
    }
    //添加人口
    function add_pop($city_id,$pop_year,$pop_regist,$pop_live,$total_house,$pop_total,$pop_urban,$urbanization,$pop_density)
    {
        $id = 0;
        $this->db->where('city_id',$city_id);
        $this->db->where('pop_year',$pop_year);
        $this->query = $this->db->get('dataface_yearbook_population');
        if($this->query->num_rows() <= 0)
        {
            $this->db->set('city_id',$city_id);
            $this->db->set('pop_year',$pop_year);
            $this->db->set('pop_regist', $pop_regist);
            $this->db->set('pop_live', $pop_live);
            $this->db->set('total_house', $total_house);
            $this->db->set('pop_total', $pop_total);
            $this->db->set('pop_urban', $pop_urban);
            $this->db->set('urbanization', $urbanization);
            $this->db->set('pop_density',$pop_density);
            $this->db->insert('dataface_yearbook_population');
            $id = $this->db->insert_id();
        }
        return $id;
    }
    //--------------------------------------
    //查询POL列表
    function get_qol_list($city_id,$page,$pagesize){
        $query = 'select * from dataface_yearbook_qol where city_id= '.$city_id.' order by qol_year desc limit '.$page.','.$pagesize.'';
        $result = $this->db->query($query)->result();
        return $result;
    }
    //查询POL列表
    function get_qol_list_count($city_id)
    {
        $query = 'select count(1) cnt from dataface_yearbook_qol where city_id= '.$city_id.' ';
        $result = $this->db->query($query)->row();
        return $result->cnt;
    }
    //人口详细
    function get_qol_info($id){
        $query = 'select * from dataface_yearbook_qol where id= '.$id.'';
        $result = $this->db->query($query)->row();
        return $result;
    }
    //添加人口
    function add_qol($city_id,$qol_year,$build_q_area,$live_use_area,$city_area,$per_use_area,$per_build_area,$per_disposable_income,$per_consumer_spending,
                     $savings_surplus,$pcs_food,$pcs_clothes,$pcs_home_kits,$pcs_medical_care,$pcs_traffic_tel,$pcs_education,$pcs_live,$pcs_other)
    {
        $id = 0;
        $this->db->where('city_id',$city_id);
        $this->db->where('qol_year',$qol_year);
        $this->query = $this->db->get('dataface_yearbook_qol');
        if($this->query->num_rows() <= 0)
        {
            $this->db->set('city_id',$city_id);
            $this->db->set('qol_year',$qol_year);
            $this->db->set('build_q_area',$build_q_area);
            $this->db->set('live_use_area', $live_use_area);
            $this->db->set('city_area', $city_area);
            $this->db->set('per_use_area', $per_use_area);
            $this->db->set('per_build_area', $per_build_area);
            $this->db->set('per_disposable_income', $per_disposable_income);
            $this->db->set('per_consumer_spending', $per_consumer_spending);
            $this->db->set('savings_surplus',$savings_surplus);

            $this->db->set('pcs_food', $pcs_food);
            $this->db->set('pcs_clothes', $pcs_clothes);
            $this->db->set('pcs_home_kits', $pcs_home_kits);
            $this->db->set('pcs_medical_care', $pcs_medical_care);
            $this->db->set('pcs_traffic_tel', $pcs_traffic_tel);
            $this->db->set('pcs_education',$pcs_education);
            $this->db->set('pcs_live',$pcs_live);
            $this->db->set('pcs_other',$pcs_other);

            $this->db->insert('dataface_yearbook_qol');
            $id = $this->db->insert_id();
        }
        return $id;
    }

    //------------------------------------
    //查询fixedassets列表
    function get_fixedassets_list($city_id,$date_type,$page,$pagesize){
        $query = 'select * from dataface_yearbook_fixedassets where city_id= '.$city_id.' and fa_quarter > 0 order by fa_year desc,fa_quarter desc  limit '.$page.','.$pagesize.'';
        if($date_type == 'Y')
            $query = 'select * from dataface_yearbook_fixedassets where city_id= '.$city_id.' and fa_quarter=0 and fa_month=0 order by fa_year desc limit '.$page.','.$pagesize.'';
        if($date_type == 'M')
            $query = 'select * from dataface_yearbook_fixedassets where city_id= '.$city_id.' and fa_month > 0 order by fa_year desc,fa_month desc limit '.$page.','.$pagesize.'';

        $result = $this->db->query($query)->result();
        return $result;
    }
    //查询fixedassets列表
    function get_fixedassets_list_count($city_id,$date_type)
    {
        $query = 'select count(1) cnt from dataface_yearbook_gdp where city_id= '.$city_id.' and gdp_quarter > 0  ';
        if($date_type == 'Y')
            $query = 'select count(1) cnt from dataface_yearbook_gdp where city_id= '.$city_id.' and gdp_quarter=0 ';
        $result = $this->db->query($query)->row();
        return $result->cnt;
    }
    //查询fixedassets详情
    function get_fixedassets_info($id)
    {
        $query = 'select * from dataface_yearbook_fixedassets where id= '.$id.'';
        $result = $this->db->query($query)->row();
        return $result;
    }
    //添加fixedassets信息
    function add_fixedassets($city_id,$fa_year,$fa_quarter,$fa_month,$fa_value_quarter,$fa_value_month,$fa_value_total,$fixe_assets_value,$infrastructure_value,$fixe_assets_house)
    {
        $id = 0;
        $this->db->where('city_id',$city_id);
        $this->db->where('fa_year',$fa_year);
        $this->db->where('fa_quarter',$fa_quarter);
        $this->db->where('fa_month',$fa_month);
        $this->query = $this->db->get('dataface_yearbook_fixedassets');
        if($this->query->num_rows() <= 0)
        {
            $this->db->set('city_id',$city_id);
            $this->db->set('fa_year',$fa_year);
            $this->db->set('fa_quarter', $fa_quarter);
            $this->db->set('fa_month', $fa_month);
            $this->db->set('fa_value_quarter', $fa_value_quarter);
            $this->db->set('fa_value_month', $fa_value_month);
            $this->db->set('fa_value_total', $fa_value_total);
            $this->db->set('fixe_assets_value', $fixe_assets_value);
            $this->db->set('infrastructure_value', $infrastructure_value);
            $this->db->set('fixe_assets_house', $fixe_assets_house);
            $this->db->insert('dataface_yearbook_fixedassets');
            $id = $this->db->insert_id();
        }
        return $id;
    }

    //--------------------------------------
    //查询realtyprice列表
    function get_realtyprice_list($city_id,$page,$pagesize){
        $query = 'select * from dataface_yearbook_realtyprice where city_id= '.$city_id.' order by realty_year desc,realty_month desc limit '.$page.','.$pagesize.'';
        $result = $this->db->query($query)->result();
        return $result;
    }
    //查询realtyprice列表
    function get_realtyprice_list_count($city_id)
    {
        $query = 'select count(1) cnt from dataface_yearbook_realtyprice where city_id= '.$city_id.' ';
        $result = $this->db->query($query)->row();
        return $result->cnt;
    }
    //realtyprice详细
    function get_realtyprice_info($id){
        $query = 'select * from dataface_yearbook_realtyprice where id= '.$id.'';
        $result = $this->db->query($query)->row();
        return $result;
    }
    //添加realtyprice
    function add_realtyprice($city_id,$realty_year,$realty_month,$realty_spf_total_price,$realty_spf_month_price,$realty_zz_total_price,$realty_zz_month_price
        ,$realty_jsf_total_price,$realty_jsf_month_price,$realty_bs_total_price,$realty_bs_month_price,$realty_bg_total_price,$realty_bg_month_price,$realty_sy_total_price,$realty_sy_month_price)
    {
        $id = 0;
        $this->db->where('city_id',$city_id);
        $this->db->where('realty_year',$realty_year);
        $this->db->where('realty_month',$realty_month);
        $this->query = $this->db->get('dataface_yearbook_realtyprice');
        if($this->query->num_rows() <= 0)
        {
            $this->db->set('city_id',$city_id);
            $this->db->set('realty_year',$realty_year);
            $this->db->set('realty_month',$realty_month);
            $this->db->set('realty_spf_total_price',$realty_spf_total_price);
            $this->db->set('realty_spf_month_price', $realty_spf_month_price);
            $this->db->set('realty_zz_total_price',$realty_zz_total_price);
            $this->db->set('realty_zz_month_price', $realty_zz_month_price);
            $this->db->set('realty_jsf_total_price',$realty_jsf_total_price);
            $this->db->set('realty_jsf_month_price', $realty_jsf_month_price);
            $this->db->set('realty_bs_total_price',$realty_bs_total_price);
            $this->db->set('realty_bs_month_price', $realty_bs_month_price);
            $this->db->set('realty_bg_total_price',$realty_bg_total_price);
            $this->db->set('realty_bg_month_price', $realty_bg_month_price);
            $this->db->set('realty_sy_total_price',$realty_sy_total_price);
            $this->db->set('realty_sy_month_price', $realty_sy_month_price);

            $this->db->insert('dataface_yearbook_realtyprice');
            $id = $this->db->insert_id();
        }
        return $id;
    }

    //--------------------------------------
    //查询realtycompletedarea列表
    function get_realtycompletedarea_list($city_id,$page,$pagesize){
        $query = 'select * from dataface_yearbook_realtycompletedarea where  realty_month=12 and city_id= '.$city_id.' order by realty_year desc,realty_month desc limit '.$page.','.$pagesize.'';
        $result = $this->db->query($query)->result();
        return $result;
    }
    //查询realtycompletedarea列表
    function get_realtycompletedarea_list_count($city_id)
    {
        $query = 'select count(1) cnt from dataface_yearbook_realtycompletedarea where  realty_month=12 and city_id= '.$city_id.' ';
        $result = $this->db->query($query)->row();
        return $result->cnt;
    }
    //realtycompletedarea详细
    function get_realtycompletedarea_info($id){
        $query = 'select * from dataface_yearbook_realtycompletedarea where id= '.$id.'';
        $result = $this->db->query($query)->row();
        return $result;
    }
    //添加realtycompletedarea
    function add_realtycompletedarea($city_id,$realty_year,$realty_month,$realty_spf_total_completedarea,$realty_spf_month_completedarea,$realty_zz_total_completedarea,$realty_zz_month_completedarea
        ,$realty_jsf_total_completedarea,$realty_jsf_month_completedarea,$realty_bs_total_completedarea,$realty_bs_month_completedarea,$realty_bg_total_completedarea,$realty_bg_month_completedarea,$realty_sy_total_completedarea,$realty_sy_month_completedarea)
    {
        $id = 0;
        $this->db->where('city_id',$city_id);
        $this->db->where('realty_year',$realty_year);
        $this->db->where('realty_month',$realty_month);
        $this->query = $this->db->get('dataface_yearbook_realtycompletedarea');
        if($this->query->num_rows() <= 0)
        {
            $this->db->set('city_id',$city_id);
            $this->db->set('realty_year',$realty_year);
            $this->db->set('realty_month',$realty_month);
            $this->db->set('realty_spf_total_completedarea',$realty_spf_total_completedarea);
            $this->db->set('realty_spf_month_completedarea', $realty_spf_month_completedarea);
            $this->db->set('realty_zz_total_completedarea',$realty_zz_total_completedarea);
            $this->db->set('realty_zz_month_completedarea', $realty_zz_month_completedarea);
            $this->db->set('realty_jsf_total_completedarea',$realty_jsf_total_completedarea);
            $this->db->set('realty_jsf_month_completedarea', $realty_jsf_month_completedarea);
            $this->db->set('realty_bs_total_completedarea',$realty_bs_total_completedarea);
            $this->db->set('realty_bs_month_completedarea', $realty_bs_month_completedarea);
            $this->db->set('realty_bg_total_completedarea',$realty_bg_total_completedarea);
            $this->db->set('realty_bg_month_completedarea', $realty_bg_month_completedarea);
            $this->db->set('realty_sy_total_completedarea',$realty_sy_total_completedarea);
            $this->db->set('realty_sy_month_completedarea', $realty_sy_month_completedarea);

            $this->db->insert('dataface_yearbook_realtycompletedarea');
            $id = $this->db->insert_id();
        }
        return $id;
    }
    //--------------------------------------
    //查询realtybuildarea列表
    function get_realtybuildarea_list($city_id,$page,$pagesize){
        $query = 'select * from dataface_yearbook_realtybuildarea where  realty_month=12 and city_id= '.$city_id.' order by realty_year desc,realty_month desc limit '.$page.','.$pagesize.'';
        $result = $this->db->query($query)->result();
        return $result;
    }
    //查询realtybuildarea列表
    function get_realtybuildarea_list_count($city_id)
    {
        $query = 'select count(1) cnt from dataface_yearbook_realtybuildarea where  realty_month=12 and city_id= '.$city_id.' ';
        $result = $this->db->query($query)->row();
        return $result->cnt;
    }
    //realtybuildarea详细
    function get_realtybuildarea_info($id){
        $query = 'select * from dataface_yearbook_realtybuildarea where id= '.$id.'';
        $result = $this->db->query($query)->row();
        return $result;
    }
    //添加realtybuildarea
    function add_realtybuildarea($city_id,$realty_year,$realty_month,$realty_spf_total_buildarea,$realty_spf_month_buildarea,$realty_zz_total_buildarea,$realty_zz_month_buildarea
        ,$realty_jsf_total_buildarea,$realty_jsf_month_buildarea,$realty_bs_total_buildarea,$realty_bs_month_buildarea,$realty_bg_total_buildarea,$realty_bg_month_buildarea,$realty_sy_total_buildarea,$realty_sy_month_buildarea)
    {
        $id = 0;
        $this->db->where('city_id',$city_id);
        $this->db->where('realty_year',$realty_year);
        $this->db->where('realty_month',$realty_month);
        $this->query = $this->db->get('dataface_yearbook_realtybuildarea');
        if($this->query->num_rows() <= 0)
        {
            $this->db->set('city_id',$city_id);
            $this->db->set('realty_year',$realty_year);
            $this->db->set('realty_month',$realty_month);
            $this->db->set('realty_spf_total_buildarea',$realty_spf_total_buildarea);
            $this->db->set('realty_spf_month_buildarea', $realty_spf_month_buildarea);
            $this->db->set('realty_zz_total_buildarea',$realty_zz_total_buildarea);
            $this->db->set('realty_zz_month_buildarea', $realty_zz_month_buildarea);
            $this->db->set('realty_jsf_total_buildarea',$realty_jsf_total_buildarea);
            $this->db->set('realty_jsf_month_buildarea', $realty_jsf_month_buildarea);
            $this->db->set('realty_bs_total_buildarea',$realty_bs_total_buildarea);
            $this->db->set('realty_bs_month_buildarea', $realty_bs_month_buildarea);
            $this->db->set('realty_bg_total_buildarea',$realty_bg_total_buildarea);
            $this->db->set('realty_bg_month_buildarea', $realty_bg_month_buildarea);
            $this->db->set('realty_sy_total_buildarea',$realty_sy_total_buildarea);
            $this->db->set('realty_sy_month_buildarea', $realty_sy_month_buildarea);

            $this->db->insert('dataface_yearbook_realtybuildarea');
            $id = $this->db->insert_id();
        }
        return $id;
    }
    //--------------------------------------
    //查询realtynewstartarea列表
    function get_realtynewstartarea_list($city_id,$page,$pagesize){
        $query = 'select * from dataface_yearbook_realtynewstartarea where realty_month=12 and  city_id= '.$city_id.' order by realty_year desc,realty_month desc limit '.$page.','.$pagesize.'';
        $result = $this->db->query($query)->result();
        return $result;
    }
    //查询realtynewstartarea列表
    function get_realtynewstartarea_list_count($city_id)
    {
        $query = 'select count(1) cnt from dataface_yearbook_realtynewstartarea where  realty_month=12 and city_id= '.$city_id.' ';
        $result = $this->db->query($query)->row();
        return $result->cnt;
    }
    //realtynewstartarea详细
    function get_realtynewstartarea_info($id){
        $query = 'select * from dataface_yearbook_realtynewstartarea where id= '.$id.'';
        $result = $this->db->query($query)->row();
        return $result;
    }
    //添加realtynewstartarea
    function add_realtynewstartarea($city_id,$realty_year,$realty_month,$realty_spf_total_newstartarea,$realty_spf_month_newstartarea,$realty_zz_total_newstartarea,$realty_zz_month_newstartarea
        ,$realty_jsf_total_newstartarea,$realty_jsf_month_newstartarea,$realty_bs_total_newstartarea,$realty_bs_month_newstartarea,$realty_bg_total_newstartarea,$realty_bg_month_newstartarea,$realty_sy_total_newstartarea,$realty_sy_month_newstartarea)
    {
        $id = 0;
        $this->db->where('city_id',$city_id);
        $this->db->where('realty_year',$realty_year);
        $this->db->where('realty_month',$realty_month);
        $this->query = $this->db->get('dataface_yearbook_realtynewstartarea');
        if($this->query->num_rows() <= 0)
        {
            $this->db->set('city_id',$city_id);
            $this->db->set('realty_year',$realty_year);
            $this->db->set('realty_month',$realty_month);
            $this->db->set('realty_spf_total_newstartarea',$realty_spf_total_newstartarea);
            $this->db->set('realty_spf_month_newstartarea', $realty_spf_month_newstartarea);
            $this->db->set('realty_zz_total_newstartarea',$realty_zz_total_newstartarea);
            $this->db->set('realty_zz_month_newstartarea', $realty_zz_month_newstartarea);
            $this->db->set('realty_jsf_total_newstartarea',$realty_jsf_total_newstartarea);
            $this->db->set('realty_jsf_month_newstartarea', $realty_jsf_month_newstartarea);
            $this->db->set('realty_bs_total_newstartarea',$realty_bs_total_newstartarea);
            $this->db->set('realty_bs_month_newstartarea', $realty_bs_month_newstartarea);
            $this->db->set('realty_bg_total_newstartarea',$realty_bg_total_newstartarea);
            $this->db->set('realty_bg_month_newstartarea', $realty_bg_month_newstartarea);
            $this->db->set('realty_sy_total_newstartarea',$realty_sy_total_newstartarea);
            $this->db->set('realty_sy_month_newstartarea', $realty_sy_month_newstartarea);

            $this->db->insert('dataface_yearbook_realtynewstartarea');
            $id = $this->db->insert_id();
        }
        return $id;
    }

}