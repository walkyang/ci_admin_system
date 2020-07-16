<?php

/**
 * Created by PhpStorm.
 * User: jmillerfun
 * Date: 2018/10/29
 * Time: 16:51
 */
class Setting  extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->helper('cookie');
        $this->load->model('City','city');
        $this->load->model('DatafaceSetting','dataface_setting');
        $this->load->library('Utility');
        $this->load->library('Redis_cache');
        if(!$this->input->cookie('admin_id')){
            $this->utility->tsgHref('/login');
        }else{
            $this->admin_name = $this->input->cookie('admin_name');
            $this->admin_id = $this->input->cookie('admin_id');
        }
        header("Content-Type:text/html;charset=utf-8");
        $this->pagesize = 20;
    }

    function index(){
        $s = 'sh.Index.FHouse.Date';
        echo substr($s,0,strpos($s, '.'));
    }

    function setting_list($page=1){
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
        $setting_list = $this->dataface_setting->get_list($city_id,$start,$this->pagesize);
        $total =  $this->dataface_setting->get_list_count($city_id);
        $data['setting_list'] = $setting_list;
        $data['city_id'] = $city_id;
        $data['pagestr'] = $this->utility->multi($total, $this->pagesize, $page, '/setting/setting_list/', $_surl);
        $this->load->view('setting_list',$data);
    }

    //更改数据
    function update_value(){
        $html = 1;
        $id = $this->input->post('id');
        $value = $this->input->post('value');
        $name = $this->input->post('name');
        $result = $this->dataface_setting->update_value($id,$value);
        //这里要进行一些缓存的更新，如果做了修改
        if (strstr($name,'Index.Yearbook')){
            $key = substr($name,0,strripos($name, '.'));
            $this->redis_cache->del($key);
        }elseif (strstr($name,'Index.Land')) {
            $key = substr($name, 0, strripos($name, '.'));
            $this->redis_cache->del($key);
        }elseif (strstr($name,'Index.FHouse')) {
            $key = substr($name, 0, strripos($name, '.'));
            $code = substr($name,0,strpos($name, '.'));
            $key1 = $code.'.Index.FRanking';
            $this->redis_cache->del($key);
            $this->redis_cache->del($key1);
        }elseif (strstr($name,'Index.SHouse')) {
            $key = substr($name, 0, strripos($name, '.'));
            $code = substr($name,0,strpos($name, '.'));
            $key1 = $code.'.Index.SRanking';
            $this->redis_cache->del($key);
            $this->redis_cache->del($key1);
        }else{
            $this->redis_cache->del($name);
        }
        echo $html;
    }

}