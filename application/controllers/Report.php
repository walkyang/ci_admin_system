<?php

/**
 * Created by PhpStorm.
 * User: jmillerfun
 * Date: 2019/2/22
 * Time: 11:45
 */
//报表
class Report extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->helper('cookie');
        $this->load->library('Utility');
        if(!$this->input->cookie('admin_id')){
            $this->utility->tsgHref('/login');
        }else{
            $this->admin_name = $this->input->cookie('admin_name');
            $this->admin_id = $this->input->cookie('admin_id');
        }
        $this->load->model('City','city');
        $this->load->model('DatafaceAdmin','admininfo');
        $this->load->model('ReportInfo','reportinfo');
        header("Content-Type:text/html;charset=utf-8");
        $this->pagesize = 20;
    }

    // 整体行情
    function month_tj()
    {
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        //获取城市
        $citylist = $this->city->get_list();
        //print_r($citylist);
        $data['citylist'] = $citylist;
        $_surl = '';
        $is_first = 2;
        $house_type_id = 100;
        $city_id = 0;
        if (!empty($_GET['city_id'])) {
            $city_id=$_GET['city_id'];
            $_surl .= '&city_id='.$city_id;
        }
        // 城市
        $city_info = $this->city->get($city_id);
        $city_code = $city_info->city_code;
        $year = 0;
        if (!empty($_GET['year'])) {
            $year=$_GET['year'];
        }
        $month = 0;
        if (!empty($_GET['month'])) {
            $month=$_GET['month'];
        }
        $is_sjprice = 0;
        if (!empty($_GET['is_sjprice'])) {
            $is_sjprice=$_GET['is_sjprice'];
        }

        $data['city_id'] = $city_id;
        $data['year'] = $year;
        $data['month'] = $month;
        $data['is_sjprice'] = $is_sjprice;
        $info = array();
        $house_list = array();
        if($year > 0 && $month > 0){
            $info = $this->reportinfo->tj($city_code,$year,$month,$is_first,$house_type_id,$is_sjprice);
            //查询前一个月数据，用来环比
            $pre_month = $month-1;
            $pre_year = $year;
            if($month == 1) {
                $pre_month = 12;
                $pre_year = $pre_year-1;
            }
            $data['pre_info'] = $this->reportinfo->tj($city_code,$pre_year,$pre_month,$is_first,$house_type_id,$is_sjprice);

            $house_list = $this->reportinfo->house_top($city_code,$year,$month,$is_first,$house_type_id,3,'',$is_sjprice);
        }
        $data['info'] = $info;
        $data['max_year'] = date('Y');
        $data['house_list'] = $house_list;
        $this->load->view('report_month_tj',$data);
    }

    //量价分析
    function month_lj(){
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        //获取城市
        $citylist = $this->city->get_list();
        //print_r($citylist);
        $data['citylist'] = $citylist;
        $_surl = '';
        $is_first = 2;
        $house_type_id = 100;
        $city_id = 0;
        if (!empty($_GET['city_id'])) {
            $city_id=$_GET['city_id'];
            $_surl .= '&city_id='.$city_id;
        }
        // 城市
        $city_info = $this->city->get($city_id);
        $city_code = $city_info->city_code;
        $year = 0;
        if (!empty($_GET['year'])) {
            $year=$_GET['year'];
        }
        $month = 0;
        if (!empty($_GET['month'])) {
            $month=$_GET['month'];
        }
        $is_sjprice = 0;
        if (!empty($_GET['is_sjprice'])) {
            $is_sjprice=$_GET['is_sjprice'];
        }

        $data['city_id'] = $city_id;
        $data['year'] = $year;
        $data['month'] = $month;
        $data['is_sjprice'] = $is_sjprice;
        $deal_tj = array();
        if($year > 0 && $month > 0){
            $min_year = $year;
            if($month <= 6){
                $min_year = $year -1;
                $min_month = ($month+7)-1;
            }else {
                $min_month = $month-7;
            }
            $deal_tj = $this->reportinfo->deal_month_top($city_code, $year, $month, $is_first, $house_type_id, 7,$min_year,$min_month,$is_sjprice);
        }
        $data['deal_tj'] = $deal_tj;
        $data['max_year'] = date('Y');

        $this->load->view('report_month_lj',$data);
    }

    //环线分析
    function month_loop(){
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        //获取城市
        $citylist = $this->city->get_list();
        //print_r($citylist);
        $data['citylist'] = $citylist;
        $_surl = '';
        $is_first = 2;
        $house_type_id = 100;
        $city_id = 0;
        if (!empty($_GET['city_id'])) {
            $city_id=$_GET['city_id'];
            $_surl .= '&city_id='.$city_id;
        }
        // 城市
        $city_info = $this->city->get($city_id);
        $city_code = $city_info->city_code;
        $year = 0;
        if (!empty($_GET['year'])) {
            $year=$_GET['year'];
        }
        $month = 0;
        if (!empty($_GET['month'])) {
            $month=$_GET['month'];
        }
        $is_sjprice = 0;
        if (!empty($_GET['is_sjprice'])) {
            $is_sjprice=$_GET['is_sjprice'];
        }

        $data['city_id'] = $city_id;
        $data['year'] = $year;
        $data['month'] = $month;
        $data['is_sjprice'] = $is_sjprice;
        $loop_list = array();
        $house_list = array();
        if($year > 0 && $month > 0){
            $loop_list = $this->reportinfo->loop_top($city_code,$year,$month,$is_first,$house_type_id,$is_sjprice);
            //查询前一个月数据，用来环比
            $pre_month = $month-1;
            $pre_year = $year;
            if($month == 1) {
                $pre_month = 12;
                $pre_year = $pre_year-1;
            }
            $pre_loop_list = $this->reportinfo->loop_top($city_code,$pre_year,$pre_month,$is_first,$house_type_id,$is_sjprice);

        }
        $data['pre_loop_list'] = $pre_loop_list;
        $data['loop_list'] = $loop_list;
        $data['max_year'] = date('Y');
        $this->load->view('report_month_loop',$data);
    }

    //区域分析
    function month_district(){
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        //获取城市
        $citylist = $this->city->get_list();
        //print_r($citylist);
        $data['citylist'] = $citylist;
        $_surl = '';
        $is_first = 2;
        $house_type_id = 100;
        $city_id = 0;
        if (!empty($_GET['city_id'])) {
            $city_id=$_GET['city_id'];
            $_surl .= '&city_id='.$city_id;
        }
        // 城市
        $city_info = $this->city->get($city_id);
        $city_code = $city_info->city_code;
        $year = 0;
        if (!empty($_GET['year'])) {
            $year=$_GET['year'];
        }
        $month = 0;
        if (!empty($_GET['month'])) {
            $month=$_GET['month'];
        }
        $is_sjprice = 0;
        if (!empty($_GET['is_sjprice'])) {
            $is_sjprice=$_GET['is_sjprice'];
        }

        $data['city_id'] = $city_id;
        $data['year'] = $year;
        $data['month'] = $month;
        $data['is_sjprice'] = $is_sjprice;
        $district_list = array();
        $house_list = array();
        if($year > 0 && $month > 0){
            $district_list = $this->reportinfo->district_top($city_code,$year,$month,$is_first,$house_type_id,$is_sjprice);
            //查询前一个月数据，用来环比
            $pre_month = $month-1;
            $pre_year = $year;
            if($month == 1) {
                $pre_month = 12;
                $pre_year = $pre_year-1;
            }
            $pre_district_list = $this->reportinfo->district_top($city_code,$pre_year,$pre_month,$is_first,$house_type_id,$is_sjprice);

        }
        $data['pre_district_list'] = $pre_district_list;
        $data['district_list'] = $district_list;
        $data['max_year'] = date('Y');
        $this->load->view('report_month_district',$data);
    }

    //总价段分析
    function month_tprice(){
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        //获取城市
        $citylist = $this->city->get_list();
        //print_r($citylist);
        $data['citylist'] = $citylist;
        $_surl = '';
        $is_first = 2;
        $house_type_id = 100;
        $city_id = 0;
        if (!empty($_GET['city_id'])) {
            $city_id=$_GET['city_id'];
            $_surl .= '&city_id='.$city_id;
        }
        // 城市
        $city_info = $this->city->get($city_id);
        $city_code = $city_info->city_code;
        $year = 0;
        if (!empty($_GET['year'])) {
            $year=$_GET['year'];
        }
        $month = 0;
        if (!empty($_GET['month'])) {
            $month=$_GET['month'];
        }
        $is_sjprice = 0;
        if (!empty($_GET['is_sjprice'])) {
            $is_sjprice=$_GET['is_sjprice'];
        }

        $data['city_id'] = $city_id;
        $data['year'] = $year;
        $data['month'] = $month;
        $data['is_sjprice'] = $is_sjprice;
        $tprice_block = '0-100,100-300,300-500,500-800,800-1000,1000-1500,1500-2000,2000-3000,3000-5000,5000-999999';
        $tprice_list = array();
        if($year > 0 && $month > 0){
            $tprice_arr = explode(',',$tprice_block);
            $tprice_list = $this->reportinfo->deal_month_tprice($city_code,$year,$month,$is_first,$house_type_id,$tprice_arr,$is_sjprice);
            //查询前一个月数据，用来环比
            $pre_month = $month-1;
            $pre_year = $year;
            if($month == 1) {
                $pre_month = 12;
                $pre_year = $pre_year-1;
            }
            $pre_tprice_list = $this->reportinfo->deal_month_tprice($city_code,$pre_year,$pre_month,$is_first,$house_type_id,$tprice_arr,$is_sjprice);
            //300一下
            $house_list_0 = $this->reportinfo->house_top($city_code,$year,$month,$is_first,$house_type_id,1,' and totalprice < 100*10000',$is_sjprice);
            $house_list_1 = $this->reportinfo->house_top($city_code,$year,$month,$is_first,$house_type_id,1,' and (totalprice >= 100*10000 and totalprice < 300*10000)',$is_sjprice);
            $house_list_2 = $this->reportinfo->house_top($city_code,$year,$month,$is_first,$house_type_id,1,' and (totalprice >= 300*10000 and totalprice < 500*10000)',$is_sjprice);
            $house_list_3 = $this->reportinfo->house_top($city_code,$year,$month,$is_first,$house_type_id,1,' and (totalprice >= 500*10000 and totalprice < 800*10000)',$is_sjprice);
            $house_list_4 = $this->reportinfo->house_top($city_code,$year,$month,$is_first,$house_type_id,1,' and (totalprice >= 800*10000 and totalprice < 1000*10000)',$is_sjprice);
            $house_list_5 = $this->reportinfo->house_top($city_code,$year,$month,$is_first,$house_type_id,1,' and (totalprice >= 1000*10000 and totalprice < 1500*10000)',$is_sjprice);
            $house_list_6 = $this->reportinfo->house_top($city_code,$year,$month,$is_first,$house_type_id,1,' and (totalprice >= 1500*10000 and totalprice < 2000*10000)',$is_sjprice);
            $house_list_7 = $this->reportinfo->house_top($city_code,$year,$month,$is_first,$house_type_id,1,' and (totalprice >= 2000*10000 and totalprice < 3000*10000)',$is_sjprice);
            $house_list_8 = $this->reportinfo->house_top($city_code,$year,$month,$is_first,$house_type_id,1,' and (totalprice >= 3000*10000 and totalprice < 5000*10000)',$is_sjprice);
            $house_list_9 = $this->reportinfo->house_top($city_code,$year,$month,$is_first,$house_type_id,1,' and totalprice >= 5000*10000',$is_sjprice);
        }
        $data['tprice_arr'] = $tprice_arr;
        $data['pre_tprice_list'] = $pre_tprice_list;
        $data['tprice_list'] = $tprice_list;
        $data['max_year'] = date('Y');
        $data['house_list_0'] = $house_list_0;
        $data['house_list_1'] = $house_list_1;
        $data['house_list_2'] = $house_list_2;
        $data['house_list_3'] = $house_list_3;
        $data['house_list_4'] = $house_list_4;
        $data['house_list_5'] = $house_list_5;
        $data['house_list_6'] = $house_list_6;
        $data['house_list_7'] = $house_list_7;
        $data['house_list_8'] = $house_list_8;
        $data['house_list_9'] = $house_list_9;

        $this->load->view('report_month_tprice',$data);
    }

    //面积段分析
    function month_area(){
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        //获取城市
        $citylist = $this->city->get_list();
        //print_r($citylist);
        $data['citylist'] = $citylist;
        $_surl = '';
        $is_first = 2;
        $house_type_id = 100;
        $city_id = 0;
        if (!empty($_GET['city_id'])) {
            $city_id=$_GET['city_id'];
            $_surl .= '&city_id='.$city_id;
        }
        // 城市
        $city_info = $this->city->get($city_id);
        $city_code = $city_info->city_code;
        $year = 0;
        if (!empty($_GET['year'])) {
            $year=$_GET['year'];
        }
        $month = 0;
        if (!empty($_GET['month'])) {
            $month=$_GET['month'];
        }
        $is_sjprice = 0;
        if (!empty($_GET['is_sjprice'])) {
            $is_sjprice=$_GET['is_sjprice'];
        }

        $data['city_id'] = $city_id;
        $data['year'] = $year;
        $data['month'] = $month;
        $data['is_sjprice'] = $is_sjprice;
        $area_block = '0-65,65-80,80-100,100-125,125-150,150-180,180-220,220-300,300-999999';
        $area_list = array();
        $house_list = array();
        if($year > 0 && $month > 0){
            $area_arr = explode(',',$area_block);
            $area_list = $this->reportinfo->deal_month_area($city_code,$year,$month,$is_first,$house_type_id,$area_arr,$is_sjprice);
            //print_r($area_list);
            //查询前一个月数据，用来环比
            $pre_month = $month-1;
            $pre_year = $year;
            if($month == 1) {
                $pre_month = 12;
                $pre_year = $pre_year-1;
            }
            $pre_area_list = $this->reportinfo->deal_month_area($city_code,$pre_year,$pre_month,$is_first,$house_type_id,$area_arr,$is_sjprice);


            //300一下
            $house_list_0 = $this->reportinfo->house_top($city_code,$year,$month,$is_first,$house_type_id,1,' and area < 65',$is_sjprice);
            $house_list_1 = $this->reportinfo->house_top($city_code,$year,$month,$is_first,$house_type_id,1,' and (area >= 65 and area < 80)',$is_sjprice);
            $house_list_2 = $this->reportinfo->house_top($city_code,$year,$month,$is_first,$house_type_id,1,' and (area >= 80 and area < 100)',$is_sjprice);
            $house_list_3 = $this->reportinfo->house_top($city_code,$year,$month,$is_first,$house_type_id,1,' and (area >= 100 and area < 125)',$is_sjprice);
            $house_list_4 = $this->reportinfo->house_top($city_code,$year,$month,$is_first,$house_type_id,1,' and (area >= 125 and area < 150)',$is_sjprice);
            $house_list_5 = $this->reportinfo->house_top($city_code,$year,$month,$is_first,$house_type_id,1,' and (area >= 150 and area < 180)',$is_sjprice);
            $house_list_6 = $this->reportinfo->house_top($city_code,$year,$month,$is_first,$house_type_id,1,' and (area >= 180 and area < 220)',$is_sjprice);
            $house_list_7 = $this->reportinfo->house_top($city_code,$year,$month,$is_first,$house_type_id,1,' and (area >= 220 and area < 300)',$is_sjprice);
            $house_list_8 = $this->reportinfo->house_top($city_code,$year,$month,$is_first,$house_type_id,1,' and area >= 300',$is_sjprice);
        }
        $data['area_arr'] = $area_arr;
        $data['pre_area_list'] = $pre_area_list;
        $data['area_list'] = $area_list;
        $data['house_list_0'] = $house_list_0;
        $data['house_list_1'] = $house_list_1;
        $data['house_list_2'] = $house_list_2;
        $data['house_list_3'] = $house_list_3;
        $data['house_list_4'] = $house_list_4;
        $data['house_list_5'] = $house_list_5;
        $data['house_list_6'] = $house_list_6;
        $data['house_list_7'] = $house_list_7;
        $data['house_list_8'] = $house_list_8;

        $data['max_year'] = date('Y');
        $this->load->view('report_month_area',$data);
    }

    //中介分析
    function month_medium(){
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        //获取城市
        $citylist = $this->city->get_list();
        //print_r($citylist);
        $data['citylist'] = $citylist;
        $_surl = '';
        $is_first = 2;
        $house_type_id = 100;
        $city_id = 0;
        if (!empty($_GET['city_id'])) {
            $city_id=$_GET['city_id'];
            $_surl .= '&city_id='.$city_id;
        }
        // 城市
        $city_info = $this->city->get($city_id);
        $city_code = $city_info->city_code;
        $year = 0;
        if (!empty($_GET['year'])) {
            $year=$_GET['year'];
        }
        $month = 0;
        if (!empty($_GET['month'])) {
            $month=$_GET['month'];
        }
        $is_sjprice = 0;
        if (!empty($_GET['is_sjprice'])) {
            $is_sjprice=$_GET['is_sjprice'];
        }

        $data['city_id'] = $city_id;
        $data['year'] = $year;
        $data['month'] = $month;
        $data['is_sjprice'] = $is_sjprice;
        $medium_list = array();
        if($year > 0 && $month > 0){
            $medium_list = $this->reportinfo->deal_month_medium($city_code,$year,$month,$is_first,$house_type_id,10,$is_sjprice);
            //查询前一个月数据，用来环比
            $pre_month = $month-1;
            $pre_year = $year;
            if($month == 1) {
                $pre_month = 12;
                $pre_year = $pre_year-1;
            }
            $pre_medium_list = $this->reportinfo->deal_month_medium($city_code,$pre_year,$pre_month,$is_first,$house_type_id,0,$is_sjprice);
        }
        $data['pre_medium_list'] = $pre_medium_list;
        $data['medium_list'] = $medium_list;
        $data['max_year'] = date('Y');
        $this->load->view('report_month_medium',$data);
    }
}