<?php

/**
 * Created by PhpStorm.
 * User: jmillerfun
 * Date: 2018/8/28
 * Time: 13:15
 */
class Land extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->helper('cookie');
        $this->load->model('City','city');
        $this->load->model('District','district');
        $this->load->model('Plate','plate');
        $this->load->model('Loop','loop');
        $this->load->model('LandInfo','landinfo');
        $this->load->model('HouseInfo','houseinfo');
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

    //地块列表
    function land_list($page=1){
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        //获取城市
        $citylist = $this->city->get_list();
        //print_r($citylist);
        $data['citylist'] = $citylist;
        $key = '';
        $_surl = '';
        $city_id = 0;
        if (!empty($_GET['city_id'])) {
            $city_id=$_GET['city_id'];
            $_surl .= '&city_id='.$city_id;
        }
        if (!empty($_GET['key'])) {
            $key=$_GET['key'];
            $_surl .= '&key='.$key;
        }
        $_surl = $_surl ? '?'.ltrim($_surl,'&') : '';
        //分页配置
        $start = ($page - 1) * $this->pagesize;
        $landlist = $this->landinfo->get_list($city_id,$key,$start,$this->pagesize);
        $total =  $this->landinfo->get_list_count($city_id,$key);
        $data['landlist'] = $landlist;
        $data['city_id'] = $city_id;
        $data['pagestr'] = $this->utility->multi($total, $this->pagesize, $page, '/land/land_list/', $_surl);
        $this->load->view('land_list',$data);
    }

    //地块信息
    function land_info(){
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        $land_id = $this->input->get('id');
        $tab = 1;
        if($this->input->get('tab')){
            $tab = $this->input->get('tab');
        }
        $land_info = $this->landinfo->get_by_id($land_id);
        //根据城市获取当前区域，板块，环线
        $city_info = $this->city->get($land_info->city_id);
        $district_list = array();
        $plate_list = array();
        $loop_list = array();
        $city_code = '';
        if($city_info){
            $city_code = $city_info->city_code;
            $district_list = $this->district->get_list($city_code);
            $plate_list = array();
            $loop_list =  $this->loop->get_list($city_code);
        }
        $data['city_code'] = $city_code;
        $data['city_id'] = $land_info->city_id;
        $data['land_info'] = $land_info;
        $data['district_list'] = $district_list;
        $data['plate_list'] = $plate_list;
        $data['loop_list'] = $loop_list;
        $data['land_id'] = $land_id;
        $house_land_list = $this->landinfo->get_land_house_list($land_id);
        $data['house_land_list'] = $house_land_list;
        $data['tab'] = $tab;
        $this->load->view('land_info',$data);
    }

    //更改基本信息
    function update_jbxx(){
        $land_id = $this->input->post('land_id');

        //土地信息
        $land_no = $this->input->post('land_no');
        $dkmc = $this->input->post('dkmc');
        $district_id = $this->input->post('district');
        $plate_id = $this->input->post('plate');
        $loop_id = $this->input->post('loop');
        $szfw = $this->input->post('szfw');
        $crmj = $this->input->post('crmj');
        $build_area = $this->input->post('build_area');
        $land_status = $this->input->post('land_status');
        $tdtype = $this->input->post('tdtype');
        $crnx = $this->input->post('crnx');
        $rjl = $this->input->post('rjl');
        $green_ratio = $this->input->post('green_ratio');
        $build_density = $this->input->post('build_density');
        $build_height = $this->input->post('build_height');
        $land_zhoubian = $this->input->post('land_zhoubian');
        //上市信息
        $fbsj = $this->input->post('fbsj');//发布时间，公告时间，要拆分年月
        $crr = $this->input->post('crr');
        $crfs_state = $this->input->post('crfs_state');
        $jsjmkssj = $this->input->post('jsjmkssj');
        $jsjmjssj = $this->input->post('jsjmjssj');
        $gpbjkssj = $this->input->post('gpbjkssj');
        $gpbjjssj = $this->input->post('gpbjjssj');
        $ffwjkssj = $this->input->post('ffwjkssj');
        $ffwjjzsj = $this->input->post('ffwjjzsj');
        $bzjsj = $this->input->post('bzjsj');
        $qsj = $this->input->post('qsj');
        $lbj = $this->input->post('lbj');
        $mmdj = $this->input->post('mmdj');
        $zxzf = $this->input->post('zxzf');
        $jmbzj = $this->input->post('jmbzj');
        $tzqd = $this->input->post('tzqd');
        $contact_tel = $this->input->post('contact_tel');
        $contact_address = $this->input->post('contact_address');
        $jy_address = $this->input->post('jy_address');
        //成交信息
        $block_state = $this->input->post('block_state');
        $jdrq = $this->input->post('jdrq');
        $jdj = $this->input->post('jdj');
        $jdlbj = $this->input->post('jdlbj');
        $jdmmdj = $this->input->post('jdmmdj');
        $yjl = $this->input->post('yjl');
        $jdr = $this->input->post('jdr');
        //标书及文件
        $crxz = $this->input->post('crxz');
        $ysht = $this->input->post('ysht');
        $crwj = $this->input->post('crwj');

        $fbsjyear = date('Y',strtotime($fbsj));
        $fbsjmonth = date('m',strtotime($fbsj));
        $jdrqyear = 0;
        $jdrqmonth = 0;
        if($jdrq){
            $jdrqyear = date('Y',strtotime($jdrq));
            $jdrqmonth = date('m',strtotime($jdrq));
        }
        $land_type_id = $this->input->post('land_type_id');
        $house_type_rjl = $this->input->post('house_type_rjl');
        $house_type_id = $this->input->post('house_type_id');
        $house_name_arr = $this->input->post('txt_house_name');
        $house_name = '';$house_id = 0;
        if(strstr($house_name_arr, '-')){
            $house_name_arr = explode('-',$house_name_arr);
            $house_id = $house_name_arr[0];
            $house_name = $house_name_arr[1];
        }


        $update_set['land_no'] = $land_no;
        $update_set['dkmc'] = $dkmc;
        $update_set['district_id'] = $district_id;
        $update_set['plate_id'] = $plate_id;
        $update_set['loop_id'] = $loop_id;
        $update_set['szfw'] = $szfw;
        $update_set['crmj'] = $crmj;
        $update_set['build_area'] = $build_area;
        $update_set['tdtype'] = $tdtype;
        $update_set['crnx'] = $crnx;
        $update_set['rjl'] = $rjl;
        $update_set['green_ratio'] = $green_ratio;
        $update_set['build_density'] = $build_density;
        $update_set['build_height'] = $build_height;
        $update_set['land_status'] = $land_status;
        $update_set['land_zhoubian'] = $land_zhoubian;
        $update_set['contact_tel'] = $contact_tel;
        $update_set['contact_address'] = $contact_address;
        $update_set['jy_address'] = $jy_address;
        $update_set['lbj'] = $lbj;
        $update_set['mmdj'] = $mmdj;
        $update_set['zxzf'] = $zxzf;
        $update_set['jmbzj'] = $jmbzj;
        $update_set['tzqd'] = $tzqd;

        $update_set['fbsj'] = $fbsj;
        $update_set['crr'] = $crr;
        $update_set['crfs_state'] = $crfs_state;
        $update_set['jsjmkssj'] = $jsjmkssj;
        $update_set['jsjmjssj'] = $jsjmjssj;
        $update_set['gpbjkssj'] = $gpbjkssj;
        $update_set['gpbjjssj'] = $gpbjjssj;
        $update_set['ffwjkssj'] = $ffwjkssj;
        $update_set['ffwjjzsj'] = $ffwjjzsj;
        $update_set['bzjsj'] = $bzjsj;
        $update_set['qsj'] = $qsj;

        $update_set['block_state'] = $block_state;
        if($jdrq)
            $update_set['jdrq'] = $jdrq;
        $update_set['jdj'] = $jdj;
        $update_set['jdlbj'] = $jdlbj;
        $update_set['jdmmdj'] = $jdmmdj;
        $update_set['yjl'] = $yjl;
        $update_set['jdr'] = $jdr;
        $update_set['crxz'] = $crxz;
        $update_set['ysht'] = $ysht;
        $update_set['crwj'] = $crwj;

        $update_set['fbsjyear'] = $fbsjyear;
        $update_set['fbsjmonth'] = $fbsjmonth;
        $update_set['jdrqyear'] = $jdrqyear;
        $update_set['jdrqmonth'] = $jdrqmonth;

        $update_set['land_type_id'] = $land_type_id;
        $update_set['house_type_rjl'] = $house_type_rjl;
        $update_set['house_type_id'] = $house_type_id;
        $update_set['house_id'] = $house_id;
        $update_set['house_name'] = $house_name;
        $update_set['is_state'] = 0;

        $update_where['land_id'] = $land_id;
        $this->landinfo->update($update_set,$update_where);
        $this->utility->tsgGoHref('修改成功','/land/land_info/?id='.$land_id);
    }

    //显示添加页面
    function land_add(){
        $data['admin_name'] = $this->admin_name;
        $data['admin_id'] = $this->admin_id;
        if($this->input->get('city_id')){
            $city_id = $this->input->get('city_id');

            //根据城市获取当前区域，板块，环线
            $city_info = $this->city->get($city_id);
            $district_list = array();
            $plate_list = array();
            $loop_list = array();
            $city_code = '';
            if($city_info){
                $city_code = $city_info->city_code;
                $district_list = $this->district->get_list($city_code);
                $plate_list = array();
                $loop_list =  $this->loop->get_list($city_code);
            }
            $data['city_code'] = $city_code;
            $data['city_id'] = $city_id;
            $data['district_list'] = $district_list;
            $data['plate_list'] = $plate_list;
            $data['loop_list'] = $loop_list;
            $data['tab'] = 1;
            $this->load->view('land_add',$data);
        }else{
            $this->utility->tsgGo('出错了');
        }
    }

    //添加地块信息
    function add(){
        $city_id = $this->input->post('city_id');
        //土地信息
        $land_no = $this->input->post('land_no');
        $dkmc = $this->input->post('dkmc');
        $district_id = $this->input->post('district');
        $plate_id = $this->input->post('plate');
        $loop_id = $this->input->post('loop');
        $szfw = $this->input->post('szfw');
        $crmj = $this->input->post('crmj');
        $build_area = $this->input->post('build_area');
        $land_status = $this->input->post('land_status');
        $tdtype = $this->input->post('tdtype');
        $crnx = $this->input->post('crnx');
        $rjl = $this->input->post('rjl');
        $green_ratio = $this->input->post('green_ratio');
        $build_density = $this->input->post('build_density');
        $build_height = $this->input->post('build_height');
        $land_zhoubian = $this->input->post('land_zhoubian');
        //上市信息
        $fbsj = $this->input->post('fbsj');//发布时间，公告时间，要拆分年月

        $crr = $this->input->post('crr');
        $crfs_state = $this->input->post('crfs_state');
        $jsjmkssj = $this->input->post('jsjmkssj');
        $jsjmjssj = $this->input->post('jsjmjssj');
        $gpbjkssj = $this->input->post('gpbjkssj');
        $gpbjjssj = $this->input->post('gpbjjssj');
        $ffwjkssj = $this->input->post('ffwjkssj');
        $ffwjjzsj = $this->input->post('ffwjjzsj');
        $bzjsj = $this->input->post('bzjsj');
        $qsj = $this->input->post('qsj');
        $lbj = $this->input->post('lbj');
        $mmdj = $this->input->post('mmdj');
        $zxzf = $this->input->post('zxzf');
        $jmbzj = $this->input->post('jmbzj');
        $tzqd = $this->input->post('tzqd');
        $contact_tel = $this->input->post('contact_tel');
        $contact_address = $this->input->post('contact_address');
        $jy_address = $this->input->post('jy_address');
        //成交信息
        $block_state = $this->input->post('block_state');
        $jdrq = $this->input->post('jdrq');
        $jdj = $this->input->post('jdj');
        $jdlbj = $this->input->post('jdlbj');
        $jdmmdj = $this->input->post('jdmmdj');
        $yjl = $this->input->post('yjl');
        $jdr = $this->input->post('jdr');
        //标书及文件
        $crxz = $this->input->post('crxz');
        $ysht = $this->input->post('ysht');
        $crwj = $this->input->post('crwj');

        $fbsjyear = date('Y',strtotime($fbsj));
        $fbsjmonth = date('m',strtotime($fbsj));
        $jdrqyear = 0;
        $jdrqmonth = 0;
        if($jdrq){
            $jdrqyear = date('Y',strtotime($jdrq));
            $jdrqmonth = date('m',strtotime($jdrq));
        }
        $land_type_id = $this->input->post('land_type_id');
        $house_type_rjl = $this->input->post('house_type_rjl');
        $house_type_id = $this->input->post('house_type_id');
        $house_name_arr = $this->input->post('txt_house_name');
        $house_name = '';$house_id = 0;
        if(strstr($house_name_arr, '-')){
            $house_name_arr = explode('-',$house_name_arr);
            $house_id = $house_name_arr[0];
            $house_name = $house_name_arr[1];
        }

        $land_id = $this->landinfo->add($city_id,$land_no,$dkmc,$district_id,$plate_id,$loop_id,$szfw,$crmj,$build_area,$land_status,
            $tdtype,$crnx,$rjl,$green_ratio,$build_density,$build_height,$land_zhoubian,$fbsj,$crr,$crfs_state,$jsjmkssj,$jsjmjssj,$gpbjkssj,$gpbjjssj,$ffwjkssj,
            $ffwjjzsj,$bzjsj,$qsj,$lbj,$mmdj,$zxzf,$jmbzj,$tzqd,$contact_tel,$contact_address,$jy_address,$block_state,$jdrq,$jdj,$jdlbj,
            $jdmmdj,$yjl,$jdr,$crxz,$ysht,$crwj,$fbsjyear,$fbsjmonth,$land_type_id,$house_type_rjl,$house_type_id,$house_name,$house_id,$jdrqyear,$jdrqmonth);
        if($land_id){
            $this->utility->tsgGoHref('修改成功','/land/land_info/?id='.$land_id);
        }else{
            $this->utility->tsgGo('已经存在');
        }

    }


    //获得板块
    function get_plate(){
        $city_code = $this->input->post('city_code');
        $district_id = $this->input->post('district_id');
        $result = $this->plate->get_list($city_code,$district_id);
        echo json_encode($result);
    }
    //获得楼盘
    function get_house(){
        $city_code = $this->input->post('city_code');
        $key = $this->input->post('key');
        $is_first = $this->input->post('is_first');
        $result = $this->houseinfo->search_key($city_code,$is_first,$key);
        echo json_encode($result);
    }
}