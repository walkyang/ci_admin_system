<?php

/**
 * Created by PhpStorm.
 * User: jmillerfun
 * Date: 2018/9/12
 * Time: 10:58
 */
class User  extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->helper('cookie');
        $this->load->model('UserInfo','userinfo');
        $this->load->model('City','city');
        $this->load->model('District','district');
        $this->load->model('Plate','plate');
        $this->load->library('Utility');
        $this->load->library('Yuwu_dict');
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
    function user_list($page=1){
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        $key = '';
        $_surl = '';
        $user_source = 10;
        if (!empty($_GET['user_source'])) {
            $user_source=$_GET['user_source'];
            $_surl .= '&user_source='.$user_source;
        }
        if (!empty($_GET['key'])) {
            $key=$_GET['key'];
            $_surl .= '&key='.$key;
        }


        $_surl = $_surl ? '?'.ltrim($_surl,'&') : '';
        //分页配置
        $start = ($page - 1) * $this->pagesize;
        $userlist = $this->userinfo->get_list($user_source,$key,$start,$this->pagesize);
        $total =  $this->userinfo->get_list_count($user_source,$key);
        $list = array();

        foreach($userlist as $k=>$v){
            if($user_source == 30){
                $user_city = $this->userinfo->get_last_city_wxmedium($v->user_id,$v->city_id);
                $city_power = $user_city->city_name.'('.$user_city->max_date.')';
                if($user_city->max_date < date('Y-m-d'))
                    $city_power = '<span style="color: red">'.$user_city->city_name.'(过期)</span>';
            }
            else{
                $user_city = $this->userinfo->get_last_city($v->user_id,$v->city_id);
                $city_power = $user_city->city_name.'('.$user_city->max_date.')';
                if($user_city->max_date < date('Y-m-d'))
                    $city_power = '<span style="color: red">'.$user_city->city_name.'(过期)</span>';
            }

            $list[$k] = array('user_id'=>$v->user_id,'user_mobile'=>$v->user_mobile,'user_name'=>$v->user_name,'real_name'=>$v->real_name,
                'user_company'=>$v->user_company,'user_position'=>$v->user_position,'last_login_time'=>date('Y-m-d',strtotime($v->last_login_time)),
            'city_id'=>$v->city_id,'is_del'=>$v->is_del,'city_power'=>$city_power,'user_source'=>$v->user_source);
        }
        $data['user_source'] = $user_source;
        $data['userlist'] = $list;
        $data['pagestr'] = $this->utility->multi($total, $this->pagesize, $page, '/user/user_list/', $_surl);
        $this->load->view('user_list',$data);
    }

    //用户权限
    function user_power(){
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        $citylist = $this->city->get_list();
        //print_r($citylist);
        $data['citylist'] = $citylist;

        $user_id = $this->input->get('id');
        $city_id = $this->input->get('city_id');
        $result = $this->userinfo->get_power($user_id,$city_id);
        $user_power_list = array();
        foreach($result as $k=>$v){
            $city_name = $this->city->get($v->city_id)->city_name;
            $mk_name = '';
            switch($v->model_id){
                case 1: $mk_name = '新房';break;
                case 2: $mk_name = '2手';break;
                case 3: $mk_name = '土地';break;
                case 4: $mk_name = '新房排行';break;
                case 5: $mk_name = '二手排行';break;
                case 6: $mk_name = '土地排行';break;
                case 7: $mk_name = '挂牌';break;
            }
            $user_power_list[] = array('city_name'=>$city_name,'model_id'=>$v->model_id,'mk_name'=>$mk_name,'valid_date'=>$v->valid_date,'edit_time'=>$v->edit_time);
        }
        $data['user_power_list'] = $user_power_list;
        $data['user_id'] = $user_id;
        $data['city_id'] = $city_id;
        $user_city_power = $this->userinfo->get_user_city($user_id);
        $data['user_city_power'] = $user_city_power;
        $this->load->view('user_power',$data);
    }

    //微信用户权限
    function user_power_wx(){
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        $citylist = $this->city->get_list();
        //print_r($citylist);
        $data['citylist'] = $citylist;

        $user_id = $this->input->get('id');
        $city_id = $this->input->get('city_id');
        $result = $this->userinfo->get_power($user_id,$city_id);
        $user_power_list = array();
        foreach($result as $k=>$v){
            $city_name = $this->city->get($v->city_id)->city_name;
            $mk_name = '';
            switch($v->model_id){
                case 10: $mk_name = '新房';break;
                case 20: $mk_name = '2手';break;
            }
            $user_power_list[] = array('city_name'=>$city_name,'model_id'=>$v->model_id,'mk_name'=>$mk_name,'valid_date'=>$v->valid_date,'edit_time'=>$v->edit_time);
        }
        $data['user_power_list'] = $user_power_list;
        $data['user_id'] = $user_id;
        $data['city_id'] = $city_id;
        $user_city_power = $this->userinfo->get_user_city($user_id);
        $data['user_city_power'] = $user_city_power;
        $this->load->view('user_power_wx',$data);
    }

    //微信中介用户权限
    function user_power_wxmedium($page=1){
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;

        $_surl = '';
        $_surl = $_surl ? '?'.ltrim($_surl,'&') : '';

        $citylist = $this->city->get_list();
        $data['citylist'] = $citylist;
        $user_id = $this->input->get('id');
        $city_id = $this->input->get('city_id');

        $city_code = $this->city->get($city_id)->city_code;
        $district_list = $this->district->get_list($city_code);

        //分页配置
        $start = ($page - 1) * $this->pagesize;
        $user_sales_list = $this->userinfo->get_user_sales($user_id,$city_id,$start,$this->pagesize);
        $total =  $this->userinfo->get_user_sales_count($user_id,$city_id);
        $data['user_sales_list'] = $user_sales_list;
        $data['pagestr'] = $this->utility->multi($total, $this->pagesize, $page, '/user/user_power_wxmedium/', $_surl);

        $data['district_list'] = $district_list;
        $data['user_id'] = $user_id;
        $data['city_id'] = $city_id;
        $data['city_code'] = $city_code;
        $this->load->view('user_power_wxmedium',$data);
    }

    //用户信息
    function user_info(){
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        $user_id = $this->input->get('id');
        $result = $this->userinfo->get_user($user_id);
        $data['user_id'] = $user_id;
        $data['user_info'] = $result;
        $this->load->view('user_info',$data);
    }


    //微信中介用户权限
    function sales_list($page=1){
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;

        $_surl = '';
        $where = ' where dui.is_dataface = 0';
        $city_id = 0;
        if (!empty($_GET['city_id'])) {
            $city_id=$_GET['city_id'];
            $where .= ' and dus.city_id='.$city_id;
            $_surl .= '&city_id='.$city_id;
        }
        $sales_type = 0;
        if (!empty($_GET['sales_type'])) {
            $sales_type=$_GET['sales_type'];
            $where .= ' and dus.sales_type='.$sales_type;
            $_surl .= '&sales_type='.$sales_type;
        }
        $sales_no = '';
        if (!empty($_GET['sales_no'])) {
            $sales_no=$_GET['sales_no'];
            $where .= ' and dus.sales_no like "%'.$sales_no.'%" ';
            $_surl .= '&sales_no='.$sales_no;
        }
        $s_date = '';
        if (!empty($_GET['s_date'])) {
            $s_date=$_GET['s_date'];
            $where .= ' and dus.add_time >= "'.$s_date.'" ';
            $_surl .= '&s_date='.$s_date;
        }
        $e_date = '';
        if (!empty($_GET['e_date'])) {
            $e_date=$_GET['e_date'];
            $where .= ' and dus.add_time <= "'.$e_date.' 23:59:59"';;
            $_surl .= '&e_date='.$e_date;
        }
        $user_key = '';
        if (!empty($_GET['user_key'])) {
            $user_key=$_GET['user_key'];
            $where .= ' and (dui.user_name like "%'.$user_key.'%" or  dui.user_mobile like "%'.$user_key.'%") ';
            $_surl .= '&user_key='.$user_key;
        }
        $citylist = $this->city->get_list();
        $data['citylist'] = $citylist;
        $_surl = $_surl ? '?'.ltrim($_surl,'&') : '';
        //分页配置
        $start = ($page - 1) * $this->pagesize;
        $user_sales_list = $this->userinfo->get_user_order_list($where,$start,$this->pagesize);
        $total =  $this->userinfo->get_user_order_count($where)->cnt;
        $data['city_id'] = $city_id;
        $data['sales_type'] = $sales_type;
        $data['user_key'] = $user_key;
        $data['sales_no'] = $sales_no;
        $data['s_date'] = $s_date;
        $data['e_date'] = $e_date;

        $data['total_cnt'] = $total;//总条数
        //$data['total_cnt'] = $total;//总金额
        $pay_where = $where .' and `status`=1 ';
        $pay_result = $this->userinfo->get_user_order_count($pay_where);
        $data['pay_cnt'] = $pay_result->cnt;//支付条数
        $data['pay_cost'] = $pay_result->sales_cost;//支付金额
        $nopay_where = $where .' and `status`=0 ';
        $nopay_result = $this->userinfo->get_user_order_count($nopay_where);
        $data['nopay_cnt'] = $nopay_result->cnt;//未支付条数
        $data['nopay_cost'] = $nopay_result->sales_cost;//未支付金额


        $data['user_sales_list'] = $user_sales_list;
        $data['pagestr'] = $this->utility->multi($total, $this->pagesize, $page, '/user/sales_list/', $_surl);
        $this->load->view('user_sales_list',$data);
    }

    //用户信息
    function update_info(){
        $user_id = $this->input->post('id');

        $user_name = $this->input->post('user_name');
        $user_mobile = $this->input->post('user_mobile');
        $user_company = $this->input->post('user_company');
        $user_position = $this->input->post('user_position');
        $user_pass = $this->input->post('user_pass');

        $update_set['user_name'] = $user_name;
        $update_set['user_mobile'] = $user_mobile;
        $update_set['user_company'] = $user_company;
        $update_set['user_position'] = $user_position;
        $update_set['user_pass'] = $user_pass;
        $update_where['user_id'] = $user_id;
        $this->userinfo->update($update_set,$update_where);
        $this->utility->tsgGoHref('修改成功','/user/user_info/?id='.$user_id.'');
    }

    //添加权限
    function add_power(){
        $result = 0;
        $user_id = $this->input->post('user_id');
        $city_id = $this->input->post('city_id');
        $model_id = $this->input->post('model_id');
        $valid_date = $this->input->post('valid_date');
        foreach($model_id as $k=>$v){
            $result = $this->userinfo->add_power($user_id,$city_id,$v,$valid_date);
        }
        echo $result;
    }

    //添加中介版购买信息
    function add_sales(){
        $user_id = $this->input->post('user_id');
        $city_id = $this->input->post('city_id');
        $is_first = $this->input->post('is_first');
        $sales_type = $this->input->post('sales_type');
        $district_id = $this->input->post('district');
        $plate_id = $this->input->post('plate');
        $city_code = $this->input->post('city_code');
        $house_name_arr = $this->input->post('txt_house_name');
        $house_id = 0;$house_name= '';
        if(strstr($house_name_arr, '-')){
            $house_name_arr = explode('-',$house_name_arr);
            $house_id = $house_name_arr[0];
            $house_name =  $house_name_arr[1];
        }
        $valid_date = $this->input->post('valid_date');
        $sales_no = str_replace('-', '', date('Y-m-d')) . $this->yuwu_dict->createNonceStr(4);
        $first_name = '';
        switch($is_first){
            case 1: $first_name = '(新房明细)';break;
            case 2: $first_name = '(二手明细)';break;
        }
        $name = '系统赠送';
        switch($sales_type){
            case 1:$name = $house_name.$first_name.'['.$valid_date.'到期]'; break;
            case 2:
                $district_name =  $this->district->get_district_name($city_code,$district_id);
                $name = $district_name.$first_name.'['.$valid_date.'到期]';break;
            case 3:
                $plate_name =  $this->plate->get_plate_name($city_code,$plate_id);
                $name = $plate_name.$first_name.'['.$valid_date.'到期]';break;
            case 4:
                $city_name = $this->city->get($city_id)->city_name;
                $name = $city_name.$first_name.'['.$valid_date.'到期]';break;
            case 5:
                switch($is_first){
                    case 1: $first_name = '新房';break;
                    case 2: $first_name = '二手';break;
                }
                $name = $first_name.'VIP['.$valid_date.'到期]';break;
        }
        $open_id = 0; $sales_cost = 0; $transaction_id = 0; $erro_msg='系统';$sales_source = 30;$status= 1;

        //添加订单
        $result = $this->userinfo->add_user_sales($sales_no,$city_id,$is_first,$user_id,$open_id,$house_id,$district_id,$plate_id,$sales_cost,$transaction_id,$erro_msg,$sales_type,$name,$sales_source,$status,$valid_date);
        //添加到权限明细
        $result_info = $this->userinfo->add_user_salesinfo($sales_no,$city_id,$is_first,$user_id,$open_id,$house_id,$district_id,$plate_id,$sales_type,$name,$sales_source,$status,$valid_date);
        if($result && $result_info){
            $this->utility->tsgGoHref('权限添加成功','/user/user_power_wxmedium/?id='.$user_id.'&city_id='.$city_id);
        }
    }

    function user_delete(){
        $user_id = $this->input->post('id');
        $is_del = $this->input->post('is_del');
        $result = $this->userinfo->delete_user($user_id,$is_del);
        echo $result;
    }

    //重置用户可以网页登陆
    function user_browser(){
        $user_id = $this->input->post('id');
        $browser_token = $this->yuwu_dict->createNonceStr(8);
        $update_set['browser_token'] = $browser_token;
        $update_set['is_bandbrowser'] = 1;
        $wheres['user_id'] = $user_id;
        $this->userinfo->update($update_set,$wheres);
        echo 1;
    }
}