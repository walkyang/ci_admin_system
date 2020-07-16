<?php

/**
 * Created by PhpStorm.
 * User: jmillerfun
 * Date: 2018/8/28
 * Time: 10:37
 */
class Login extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library('Utility');
        $this->load->helper('cookie');
        //$this->load->library('Redis_cache');
        $this->load->model('DatafaceAdmin','admininfo');
        header("Content-Type:text/html;charset=utf-8");
        $this->pagesize = 20;
    }
    function index()
    {
        $this->load->view('login');
    }

    function do_login()
    {
        $mobile = $this->input->post('mobile');
        $password = $this->input->post('password');

        $admin_row = $this->admininfo->login($mobile,$password);
        if($admin_row){
            $savatime = time()+3600000*5;
            setcookie("admin_name", $admin_row->user_name, $savatime, '/','admin.dataface.vip');
            setcookie("admin_mobile", $admin_row->user_mobile, $savatime, '/','admin.dataface.vip');
            setcookie("admin_id", $admin_row->id, $savatime, '/','admin.dataface.vip');
            $update_set['last_login_time'] = date('Y-m-d H:i:s');
            $update_where['id'] = $admin_row->id;
            $this->admininfo->update($update_set,$update_where);
            $this->utility->tsgGoHref('登陆成功','/index');
        }
    }

    function do_logout(){
        setcookie("admin_name", false, 0, '/','admin.dataface.vip');
        setcookie("admin_mobile", false, 0, '/','admin.dataface.vip');
        setcookie("admin_id", false, 0, '/','admin.dataface.vip');
        $this->utility->tsgGoHref('注销成功','/login');
    }
}