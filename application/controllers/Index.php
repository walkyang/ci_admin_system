<?php

/**
 * Created by PhpStorm.
 * User: jmillerfun
 * Date: 2018/11/2
 * Time: 21:11
 */
class Index extends CI_Controller {
    function __construct()
    {
        parent::__construct();
       // $this->load->helper('cookie');
        $this->load->library('yuwu_dict');
        header("Content-Type:text/html;charset=utf-8");
        if(!$this->input->cookie('admin_id')){
            $this->utility->tsgHref('/login');
        }else{
            $this->admin_name = $this->input->cookie('admin_name');
            $this->admin_id = $this->input->cookie('admin_id');
        }
        $this->load->model('LandInfo','landinfo');
        $this->load->model('UserInfo','userinfo');
        $this->pagesize = 20;
    }

    function index(){
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        //日期
        $s_date = date("Y-m-d",strtotime(date('Y-m-d')."-6 day"));
        $e_date = date("Y-m-d");
        //先获得一个日期数组
        $date_arr = $this->yuwu_dict->getDateArr('D',$s_date,$e_date);

        //设置三个变量数组
        $dataface_pv_arr = array();
        $dataface_wx_pv_arr = array();
        $shulian_pv_arr = array();

        //获取用户一段时间的访问量
        $result = $this->userinfo->get_user_pv($s_date,$e_date);
        foreach($date_arr as $d){
            $dataface_pv_cnt = 0;$dataface_wx_pv_cnt = 0;$shulian_pv_cnt = 0;
            foreach($result as $k=>$v){
                switch($v->page_source){
                    case 10:
                        if($d == $v->d){
                            $dataface_pv_cnt = $v->pv_cnt;
                            break;
                        }
                        break;
                    case 20:
                        if($d == $v->d){
                            $dataface_wx_pv_cnt = $v->pv_cnt;
                            break;
                        }
                        break;
                    case 30:
                        if($d == $v->d){
                            $shulian_pv_cnt = $v->pv_cnt;
                            break;
                        }
                        break;
                }
            }
            $dataface_pv_arr[] = $dataface_pv_cnt;
            $dataface_wx_pv_arr[] = $dataface_wx_pv_cnt;
            $shulian_pv_arr[] = $shulian_pv_cnt;
        }
        $data['date_arr'] = $date_arr;
        $data['dataface_pv_arr'] = $dataface_pv_arr;
        $data['dataface_wx_pv_arr'] = $dataface_wx_pv_arr;
        $data['shulian_pv_arr'] = $shulian_pv_arr;
        //查询土地信息
        $data['land_list'] = $this->landinfo->get_city_land_cnt();
        $this->load->view('index',$data);
    }

}