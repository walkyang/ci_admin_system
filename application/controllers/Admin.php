<?php

/**
 * Created by PhpStorm.
 * User: jmillerfun
 * Date: 2018/11/28
 * Time: 11:04
 */
class Admin extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->helper('cookie');
        $this->load->model('DatafaceAdmin','admininfo');
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

    //用户列表
    function admin_list($page=1){
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        $_surl = '';
        $_surl = $_surl ? '?'.ltrim($_surl,'&') : '';
        //分页配置
        $start = ($page - 1) * $this->pagesize;
        $userlist = $this->admininfo->get_list($start,$this->pagesize);
        $total =  $this->admininfo->get_list_count();
        $data['userlist'] = $userlist;
        $data['pagestr'] = $this->utility->multi($total, $this->pagesize, $page, '/admin/admin_list/', $_surl);
        $this->load->view('admin_list',$data);
    }

    //用户列表
    function admin_add(){
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        $data['id'] = 0;
        $this->load->view('admin_info',$data);
    }
    function admin_info(){
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        $id = $this->input->get('id');
        $admin_info = $this->admininfo->get($id);
        $data['id'] = $id;
        $data['admin_info'] = $admin_info;
        $this->load->view('admin_info',$data);
    }
    //新增管理信息
    function add_jbxx(){
        $user_name = $this->input->post('user_name');
        $user_mobile = $this->input->post('user_mobile');
        $user_pwd = $this->input->post('user_pwd');

        $id = $this->admininfo->add($user_name,$user_mobile,$user_pwd);
        if($id)
            $this->utility->tsgGoHref('添加成功','/admin/admin_info/?id='.$id.'');
        else
            $this->utility->tsgGoHref('添加失败','/admin/admin_info');
    }
    //更新管理信息
    function update_jbxx(){
        $id = $this->input->post('id');
        $user_name = $this->input->post('user_name');
        $user_mobile = $this->input->post('user_mobile');
        $user_pwd = $this->input->post('user_pwd');

        $update_set['user_name'] = $user_name;
        $update_set['user_mobile'] = $user_mobile;
        $update_set['user_pwd'] = $user_pwd;
        $update_where['id'] = $id;
        $this->admininfo->update($update_set,$update_where);
        $this->utility->tsgGoHref('修改成功','/admin/admin_info/?id='.$id);
    }
}