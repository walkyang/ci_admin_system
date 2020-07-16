<?php

/**
 * Created by PhpStorm.
 * User: jmillerfun
 * Date: 2018/12/21
 * Time: 13:48
 */
class Developer extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->helper('cookie');
        $this->load->model('DatafaceDeveloper','developer');
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

    //企业系列表
    function developer_list($page=1){
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        $_surl = '';
        $_surl = $_surl ? '?'.ltrim($_surl,'&') : '';
        //分页配置
        $start = ($page - 1) * $this->pagesize;
        $developerlist = $this->developer->get_list($start,$this->pagesize);
        $total =  $this->developer->get_list_count();
        $data['developerlist'] = $developerlist;
        $data['pagestr'] = $this->utility->multi($total, $this->pagesize, $page, '/developer/developer_list/', $_surl);
        $this->load->view('developer_list',$data);
    }

    //添加企业
    function developer_add(){
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        $data['id'] = 0;
        $this->load->view('developer_info',$data);
    }
    function developer_info(){
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        $id = $this->input->get('id');
        $developer_info = $this->developer->get($id);
        $data['id'] = $id;
        $data['developer_info'] = $developer_info;
        $this->load->view('developer_info',$data);
    }

    //新增管理信息
    function add_jbxx(){
        $short_name = $this->input->post('short_name');
        $full_name = $this->input->post('full_name');
        $first_py = $this->input->post('first_py');

        $id = $this->developer->add($short_name,$full_name,$first_py);
        if($id)
            $this->utility->tsgGoHref('添加成功','/developer/developer_info/?id='.$id.'');
        else
            $this->utility->tsgGoHref('添加失败','/developer/developer_info');
    }
    //更新管理信息
    function update_jbxx(){
        $id = $this->input->post('id');
        $short_name = $this->input->post('short_name');
        $full_name = $this->input->post('full_name');
        $first_py = $this->input->post('first_py');

        $update_set['short_name'] = $short_name;
        $update_set['full_name'] = $full_name;
        $update_set['first_py'] = $first_py;
        $update_where['company_id'] = $id;
        $this->developer->update($update_set,$update_where);
        $this->utility->tsgGoHref('修改成功','/developer/developer_info/?id='.$id);
    }


}