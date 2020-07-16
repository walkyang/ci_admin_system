<?php

/**
 * Created by PhpStorm.
 * User: jmillerfun
 * Date: 2018/8/7
 * Time: 14:47
 */
/*用户信息*/
class UserInfo extends  CI_Model{

    function __construct(){
        parent::__construct();
        $this->db = $this->load->database('data_dataface',TRUE);
    }

    // 用户列表
    function get_list($user_source,$key,$page,$pagesize){
        $where = 'where 1=1 ';
        if($user_source){
            $where .= ' and user_source = '.$user_source;
        }
        if($key){
            $where .= ' and (user_mobile like "%'.$key.'%" or user_name like "%'.$key.'%" or user_company like "%'.$key.'%") ';
        }
        $query = 'select * from dataface_user_info '.$where.' order by user_id desc limit '.$page.','.$pagesize.'';
        $result = $this->db->query($query)->result();
        return $result;
    }
    //
    function get_list_count($user_source,$key){
        $where = 'where 1=1 ';
        if($user_source){
            $where .= ' and user_source = '.$user_source;
        }
        if($key){
            $where .= ' and (user_mobile like "%'.$key.'%" or user_name like "%'.$key.'%" or user_company like "%'.$key.'%") ';
        }
        $query = 'select count(1) cnt from dataface_user_info '.$where;
        $result = $this->db->query($query)->row();
        return $result->cnt;
    }

    //用户权限
    function get_power($user_id,$city_id){
        $query = 'select * from dataface_user_power where user_id='.$user_id.' and city_id='.$city_id;
        $result = $this->db->query($query)->result();
        return $result;
    }
    //添加用户权限
    function add_power($user_id,$city_id,$model_id,$valid_date){
        //先判断是否存在，如果存在则修改日期
        $result = 0;
        $exist_query = 'select id,valid_date from dataface_user_power where user_id='.$user_id.' and city_id='.$city_id.' and model_id='.$model_id.' ';
        $exist_result = $this->db->query($exist_query)->row();
        if($exist_result){
            if($valid_date <= $exist_result->valid_date){
                $result = -1;
            }else{
                $update_query = 'update dataface_user_power set valid_date = "'.$valid_date.'" where id= '.$exist_result->id;
                $this->db->query($update_query);
                $result = 1;
                $this->add_power_info($user_id,$city_id,$model_id,$valid_date);
            }
        }else{
            $this->db->set('user_id', $user_id);
            $this->db->set('city_id', $city_id);
            $this->db->set('model_id', $model_id);
            $this->db->set('valid_date',$valid_date);
            $this->db->set('add_time',date('Y-m-d H;i:s'));
            $this->db->set('edit_time',date('Y-m-d H;i:s'));
            $this->db->insert('dataface_user_power');
            $this->db->insert_id();
            $this->add_power_info($user_id,$city_id,$model_id,$valid_date);
            $result = 1;
        }
        return $result;
    }

    //添加购买记录
    function add_power_info($user_id,$city_id,$model_id,$valid_date){
        $this->db->set('user_id', $user_id);
        $this->db->set('city_id', $city_id);
        $this->db->set('model_id', $model_id);
        $this->db->set('valid_date',$valid_date);
        $this->db->set('add_time',date('Y-m-d H;i:s'));
        $this->db->insert('dataface_user_powerinfo');
        $this->db->insert_id();
    }

    //禁用用户
    function delete_user($user_id,$is_del){
        $query = 'update dataface_user_info set is_del='.$is_del.' where user_id='.$user_id;
        $this->db->query($query);
        return 1;
    }

    //获得用户信息
    function get_user($user_id){
        $query = 'select * from dataface_user_info where user_id = '.$user_id.'';
        return $this->db->query($query)->row();
    }

    //获得用户权限城市
    function get_user_city($user_id){
        $query = 'select dp.city_id,city_name,max(valid_date) max_date,count(1) from dataface_user_power dp inner join dataface_city dc on dp.city_id=dc.city_id where user_id = '.$user_id.' group by dp.city_id,city_name
';
        return $this->db->query($query)->result();
    }

    //获取最后登陆城市权限
    function get_last_city($user_id,$city_id){
        $query = 'select dp.city_id,city_name,max(valid_date) max_date from dataface_user_power dp inner join dataface_city dc on dp.city_id=dc.city_id where user_id = '.$user_id.' and dp.city_id = '.$city_id.'
';
        return $this->db->query($query)->row();
    }

    //获取最后登陆城市权限-微信中介
    function get_last_city_wxmedium($user_id,$city_id){
        $query = 'select dus.city_id,city_name,max(valid_date) max_date from dataface_user_sales dus inner join dataface_city dc on dus.city_id=dc.city_id
where dus.`status`=1 and user_id = '.$user_id.' and dus.city_id = '.$city_id;
        return $this->db->query($query)->row();
    }

    //更新信息
    function update($update_set,$wheres){
        foreach($update_set as $k=>$v){
            $this->db->set($k, '\''.$v.'\'', FALSE);
        }
        foreach($wheres as $k=>$v){
            $this->db->where($k, '\''.$v.'\'', FALSE);
        }
        $this->db->update('dataface_user_info');
    }

    //获得近期登陆用户数量,注册数量
    function get_user_cnt($where){
        $query = 'select count(1) cnt from dataface_user_info where '.$where;
        $result = $this->db->query($query)->row();
        return $result->cnt;
    }

    //获取用户一段时间的访问量
    function get_user_pv($s_date,$e_date){
        //$query = 'select count(1) pv_cnt,user_source,FROM_UNIXTIME(UNIX_TIMESTAMP(last_login_time),\'%Y-%m-%d\') d from dataface_user_info where last_login_time>= "'.$s_date.'" and last_login_time <= "'.$e_date.' 23:59:59"
//group by user_source,d';
        $query = 'select count(1) pv_cnt,page_source,d from (select DISTINCT user_id,page_source,FROM_UNIXTIME(UNIX_TIMESTAMP(add_time),\'%Y-%m-%d\') d from dataface_api_visit_info
 where add_time>= "'.$s_date.'" and add_time <= "'.$e_date.' 23:59:59") t group by page_source,d';
        $result = $this->db->query($query)->result();
        return $result;
    }

    //***//
    //添加购买记录
    function add_user_sales($sales_no,$city_id,$is_first,$user_id,$open_id,$house_id,$district_id,$plate_id,$sales_cost,$transaction_id,$erro_msg,$sales_type,$name,$sales_source,$status,$valid_date){
        $this->db->set('sales_no', $sales_no);
        $this->db->set('user_id', $user_id);
        $this->db->set('city_id', $city_id);
        $this->db->set('is_first', $is_first);
        $this->db->set('open_id', $open_id);
        $this->db->set('house_id', $house_id);
        $this->db->set('district_id', $district_id);
        $this->db->set('plate_id', $plate_id);
        $this->db->set('sales_cost', $sales_cost);
        $this->db->set('transaction_id', $transaction_id);
        $this->db->set('erro_msg', $erro_msg);
        $this->db->set('body',$name);
        $this->db->set('sales_type',$sales_type);
        $this->db->set('sales_source',$sales_source);
        $this->db->set('status',$status,true);
        $this->db->set('valid_date',$valid_date);
        $this->db->set('is_web',1);//标记来自后台加入
        $this->db->set('add_time',date('Y-m-d H;i:s'));
        $this->db->insert('dataface_user_sales');
        $id = $this->db->insert_id();
        return $id;
    }

    //添加购买明细
    function add_user_salesinfo($sales_no,$city_id,$is_first,$user_id,$open_id,$house_id,$district_id,$plate_id,$sales_type,$name,$sales_source,$status,$valid_date){
        $this->db->set('sales_no', $sales_no);
        $this->db->set('user_id', $user_id);
        $this->db->set('city_id', $city_id);
        $this->db->set('is_first', $is_first);
        $this->db->set('open_id', $open_id);
        $this->db->set('house_id', $house_id);
        $this->db->set('district_id', $district_id);
        $this->db->set('plate_id', $plate_id);
        $this->db->set('sales_type',$sales_type);
        $this->db->set('body',$name);
        $this->db->set('sales_source',$sales_source);
        $this->db->set('status',$status,true);
        $this->db->set('valid_date',$valid_date);
        $this->db->set('add_time',date('Y-m-d H;i:s'));
        $this->db->insert('dataface_user_salesinfo');
        $id = $this->db->insert_id();
        return $id;
    }


    //查询用户购买记录
    function get_user_sales($user_id,$city_id,$start,$topnum){
        $query = 'select sales_type,sales_no,body,sales_cost,is_first,valid_date,add_time,`status` from dataface_user_sales where user_id = '.$user_id.' and city_id='.$city_id.'  order by add_time desc limit '.$start.','.$topnum.'' ;
        $result = $this->db->query($query)->result();
        return $result;
    }

    //查询用户购买记录
    function get_user_sales_count($user_id,$city_id){
        $query = 'select count(1) cnt from dataface_user_sales where user_id = '.$user_id.' and `status`=1 and city_id='.$city_id.'' ;
        $result = $this->db->query($query)->row();
        return $result->cnt;
    }

    //**用户购买记录订单**///
    function get_user_order_list($where,$start,$topnum){
        $query = 'select sales_type,sales_no,body,sales_cost,dus.is_first,valid_date,add_time,`status`,user_name,user_mobile,city_name from dataface_user_sales dus
inner join dataface_user_info dui on dus.user_id = dui.user_id inner join dataface_city dc on dc.city_id = dus.city_id  '.$where.' order by dus.add_time desc limit '.$start.','.$topnum.' ';
        $result = $this->db->query($query)->result();
        return $result;
    }

    function get_user_order_count($where){
        $query = 'select count(1) cnt,sum(sales_cost) sales_cost from dataface_user_sales dus
inner join dataface_user_info dui on dus.user_id = dui.user_id '.$where.' ';
        $result = $this->db->query($query)->row();
        return $result;
    }

}