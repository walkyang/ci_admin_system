<?php

/**
 * Created by PhpStorm.
 * User: jmillerfun
 * Date: 2018/8/8
 * Time: 16:16
 */
class HouseSupply extends  CI_Model{

    function __construct(){
        parent::__construct();
    }
    //统计
    function supply_tj($city_code,$is_first,$s_date,$e_date,$house_type_ids,$min_area,$max_area,$room_ids,
                     $developer_company,$house_id,$house_name,$min_volume_rate,$max_volume_rate,$district_ids,$plate_ids,$loop_ids){
        $this->db = $this->load->database('data_'.$city_code,TRUE);
        $where_house = $this->get_where_house($is_first,$developer_company,$house_id,$house_name,$min_volume_rate,$max_volume_rate,$district_ids,$plate_ids,$loop_ids);
        $where_deal = $this->get_where_supply($s_date,$e_date,$house_type_ids,$min_area,$max_area,$room_ids);
        $query_d = 'select house_id,count(1) cnt,sum(area) s_area from house_supply '.$where_deal.' group by house_id ';
        $query_h = 'select house_id from house_info '.$where_house.'';
        $query = 'select count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from ('.$query_d.') t1 inner join ('.$query_h.') t2 on t1.house_id=t2.house_id';
        $result = $this->db->query($query)->result();
        return $result;
    }

    //列表
    function supply_list($city_code,$is_first,$s_date,$e_date,$house_type_ids,$min_area,$max_area,$room_ids,
                       $developer_company,$house_id,$house_name,$min_volume_rate,$max_volume_rate,$district_ids,$plate_ids,$loop_ids,$group,
                       $user_area_arr){
        $this->db = $this->load->database('data_'.$city_code,TRUE);
        $where_house = $this->get_where_house($is_first,$developer_company,$house_id,$house_name,$min_volume_rate,$max_volume_rate,$district_ids,$plate_ids,$loop_ids);
        $where_supply = $this->get_where_supply($s_date,$e_date,$house_type_ids,$min_area,$max_area,$room_ids);
        switch($group){
            case "D":
                $query = 'select D, count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,open_date D,count(1) cnt,sum(area) s_area from house_supply '.$where_supply.'
                group by D,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by D';
                break;//天
            case "W":
                $query = 'select Y,W,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,week(open_date,1) W,count(1) cnt,sum(area) s_area from house_supply '.$where_supply.'
                group by Y,W,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by Y,W';
                break;//周
            case "M":
                $query = 'select Y,M,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,month(open_date) M,count(1) cnt,sum(area) s_area from house_supply '.$where_supply.'
                group by Y,M,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by Y,M ';
                break;//月
            case "Q":
                $query = 'select Y,Q,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,quarter(open_date) Q,count(1) cnt,sum(area) s_area,from house_supply '.$where_supply.'
                group by Y,Q,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by Y,Q ';
                break;//季度
            case "HY":
                $query = 'select Y,case when Q <= 2 then 1 when Q>2 and Q<= 4 then 2 else "other" end  HY,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area
                from (select house_id,year(open_date) Y,quarter(open_date) Q,count(1) cnt,sum(area) s_area from house_supply '.$where_supply.'
                group by Y,Q,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by Y,HY ';
                break;//半年
            case "Y":
                $query = 'select Y,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,count(1) cnt,sum(area) s_area from house_supply '.$where_supply.'
                group by Y,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by Y ';
                break;//年
            case "District":
                $query = 'select d.district_id,district_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,count(1) cnt,sum(area) s_area from house_supply '.$where_supply.'
                group by house_id ) t1 inner join (select house_id,district_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join district d on d.district_id=t2.district_id
                 group by district_id,district_name';
                break;//区域
            case "Plate":
                $query = 'select p.plate_id,plate_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,count(1) cnt,sum(area) s_area from house_supply '.$where_supply.'
                group by house_id ) t1 inner join (select house_id,plate_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join plate p on p.plate_id=t2.plate_id
                group by plate_id,plate_name';
                break;//板块
            case "Loop":
                $query = 'select l.loop_id,loop_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,count(1) cnt,sum(area) s_area from house_supply '.$where_supply.'
                group by house_id ) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join `loop` l on l.loop_id = t2.loop_id group by loop_id,loop_name';
                break;//环线
            case "Area":
                $gr = "case ";//比如传进来的0-50，50-100
                foreach($user_area_arr as $k=>$v){
                    if(strpos($v,'-')){//必须包含-
                        $v_arr = explode("-",$v);//必须拆分为2个值
                        if(count($v_arr) >= 2){
                            if(is_numeric($v_arr[0]) && is_numeric($v_arr[1])){
                                $gr .= " when  area >=".$v_arr[0]." and area < ".$v_arr[1]." then '".$k."' ";
                            }
                        }
                    }
                }
                $gr .= " else 'other' end k";
                $query = 'select k,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,'.$gr.',count(1) cnt,sum(area) s_area from house_supply '.$where_supply.'
                group by house_id,k ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by k';
                break;//面积
            case "HouseType":
                $query = 'select hti.house_type_id,house_type_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,house_type_id,count(1) cnt,sum(area) s_area from house_supply '.$where_supply.'
                group by house_id,house_type_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join house_type_info hti on hti.house_type_id = t1.house_type_id
                 group by house_type_id';
                break;//房屋类型
            case "Room":
                $query = 'select room,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,room,count(1) cnt,sum(area) s_area from house_supply '.$where_supply.'
                group by house_id,room ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by room ';
                break;//房型
        }
        $result = $this->db->query($query)->result_array();
        //echo $query;
        return $result;
    }

    //交叉列表
    function jcsupply_list($city_code,$is_first,$s_date,$e_date,$house_type_ids,$min_area,$max_area,$room_ids,
                         $developer_company,$house_id,$house_name,$min_volume_rate,$max_volume_rate,$district_ids,$plate_ids,$loop_ids,$group1,$group2,
                         $user_area_arr){
        $this->db = $this->load->database('data_'.$city_code,TRUE);
        $where_house = $this->get_where_house($is_first,$developer_company,$house_id,$house_name,$min_volume_rate,$max_volume_rate,$district_ids,$plate_ids,$loop_ids);
        $where_supply = $this->get_where_supply($s_date,$e_date,$house_type_ids,$min_area,$max_area,$room_ids);
        switch($group1){
            case "D":
                switch($group2){
                    case "District":
                        $query = 'select D,d.district_id,district_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,open_date D,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by D,house_id ) t1 inner join (select house_id,district_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join district d on d.district_id = t2.district_id group by D,district_id,district_name';
                        break;
                    case "Plate":
                        $query = 'select D,p.plate_id,plate_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,open_date D,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by D,house_id ) t1 inner join (select house_id,plate_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join plate p on p.plate_id = t2.plate_id group by D,plate_id,plate_name';
                        break;
                    case "Loop":
                        $query = 'select D,l.loop_id,loop_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,open_date D,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by D,house_id ) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join `loop` l on l.loop_id = t2.loop_id group by D,loop_id,loop_name';
                        break;
                    case "Area":
                        $gr = "case ";//比如传进来的0-50，50-100
                        foreach($user_area_arr as $k=>$v){
                            if(strpos($v,'-')){//必须包含-
                                $v_arr = explode("-",$v);//必须拆分为2个值
                                if(count($v_arr) >= 2){
                                    if(is_numeric($v_arr[0]) && is_numeric($v_arr[1])){
                                        $gr .= " when  area >=".$v_arr[0]." and area < ".$v_arr[1]." then '".$k."' ";
                                    }
                                }
                            }
                        }
                        $gr .= " else 'other' end k";
                        $query = 'select D,k,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,open_date D,'.$gr.',count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by D,k,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        group by D,k';
                        break;
                    case "HouseType":
                        $query = 'select D,hti.house_type_id,house_type_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,open_date D,house_type_id,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by D,house_type_id,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join house_type_info hti on hti.house_type_id = t1.house_type_id group by D,house_type_id,house_type_name';
                        break;
                    case "Room":
                        $query = 'select D,room,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,open_date D,room,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by D,room,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        group by D,room';
                        break;
                }
                break;//天
            case "W":
                switch($group2){
                    case "District":
                        $query = 'select Y,W,d.district_id,district_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,week(open_date,1) W,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,W,house_id ) t1 inner join (select house_id,district_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join district d on d.district_id = t2.district_id group by Y,W,district_id,district_name';
                        break;
                    case "Plate":
                        $query = 'select Y,W,p.plate_id,plate_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,week(open_date,1) W,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,W,house_id ) t1 inner join (select house_id,plate_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join plate p on p.plate_id = t2.plate_id group by Y,W,plate_id,plate_name';
                        break;
                    case "Loop":
                        $query = 'select Y,W,l.loop_id,loop_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,week(open_date,1) W,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,W,house_id ) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join `loop` l on l.loop_id = t2.loop_id group by Y,W,loop_id,loop_name';
                        break;
                    case "Area":
                        $gr = "case ";//比如传进来的0-50，50-100
                        foreach($user_area_arr as $k=>$v){
                            if(strpos($v,'-')){//必须包含-
                                $v_arr = explode("-",$v);//必须拆分为2个值
                                if(count($v_arr) >= 2){
                                    if(is_numeric($v_arr[0]) && is_numeric($v_arr[1])){
                                        $gr .= " when  area >=".$v_arr[0]." and area < ".$v_arr[1]." then '".$k."' ";
                                    }
                                }
                            }
                        }
                        $gr .= " else 'other' end k";
                        $query = 'select Y,W,k,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,week(open_date,1) W,'.$gr.',count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,W,k,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        group by Y,W,k';
                        break;
                    case "HouseType":
                        $query = 'select Y,W,hti.house_type_id,house_type_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,week(open_date,1) W,house_type_id,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,W,house_type_id,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join house_type_info hti on hti.house_type_id = t1.house_type_id group by Y,W,house_type_id,house_type_name';
                        break;
                    case "Room":
                        $query = 'select Y,W,room,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,week(open_date,1) W,room,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,W,room,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        group by Y,W,room';
                        break;
                }
                break;//周
            case "M":
                switch($group2){
                    case "District":
                        $query = 'select Y,M,d.district_id,district_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,month(open_date) M,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,M,house_id ) t1 inner join (select house_id,district_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join district d on d.district_id = t2.district_id group by Y,M,district_id,district_name';
                        break;
                    case "Plate":
                        $query = 'select Y,M,p.plate_id,plate_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,month(open_date) M,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,M,house_id ) t1 inner join (select house_id,plate_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join plate p on p.plate_id = t2.plate_id group by Y,M,plate_id,plate_name';
                        break;
                    case "Loop":
                        $query = 'select Y,M,l.loop_id,loop_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,month(open_date) M,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,M,house_id ) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join `loop` l on l.loop_id = t2.loop_id group by Y,M,loop_id,loop_name';
                        break;
                    case "Area":
                        $gr = "case ";//比如传进来的0-50，50-100
                        foreach($user_area_arr as $k=>$v){
                            if(strpos($v,'-')){//必须包含-
                                $v_arr = explode("-",$v);//必须拆分为2个值
                                if(count($v_arr) >= 2){
                                    if(is_numeric($v_arr[0]) && is_numeric($v_arr[1])){
                                        $gr .= " when  area >=".$v_arr[0]." and area < ".$v_arr[1]." then '".$k."' ";
                                    }
                                }
                            }
                        }
                        $gr .= " else 'other' end k";
                        $query = 'select Y,M,k,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,month(open_date) M,'.$gr.',count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,M,k,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        group by Y,M,k';
                        break;
                    case "HouseType":
                        $query = 'select Y,M,hti.house_type_id,house_type_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,month(open_date) M,house_type_id,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,M,house_type_id,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join house_type_info hti on hti.house_type_id = t1.house_type_id group by Y,M,house_type_id,house_type_name';
                        break;
                    case "Room":
                        $query = 'select Y,M,room,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,month(open_date) M,room,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,M,room,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        group by Y,M,room';
                        break;
                }
                break;//月
            case "Q":
                switch($group2){
                    case "District":
                        $query = 'select Y,Q,d.district_id,district_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,quarter(open_date) Q,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,Q,house_id ) t1 inner join (select house_id,district_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join district d on d.district_id = t2.district_id group by Y,Q,district_id,district_name';
                        break;
                    case "Plate":
                        $query = 'select Y,Q,p.plate_id,plate_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,quarter(open_date) Q,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,Q,house_id ) t1 inner join (select house_id,plate_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join plate p on p.plate_id = t2.plate_id group by Y,Q,plate_id,plate_name';
                        break;
                    case "Loop":
                        $query = 'select Y,Q,l.loop_id,loop_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,quarter(open_date) Q,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,Q,house_id ) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join `loop` l on l.loop_id = t2.loop_id group by Y,Q,loop_id,loop_name';
                        break;
                    case "Area":
                        $gr = "case ";//比如传进来的0-50，50-100
                        foreach($user_area_arr as $k=>$v){
                            if(strpos($v,'-')){//必须包含-
                                $v_arr = explode("-",$v);//必须拆分为2个值
                                if(count($v_arr) >= 2){
                                    if(is_numeric($v_arr[0]) && is_numeric($v_arr[1])){
                                        $gr .= " when  area >=".$v_arr[0]." and area < ".$v_arr[1]." then '".$k."' ";
                                    }
                                }
                            }
                        }
                        $gr .= " else 'other' end k";
                        $query = 'select Y,Q,k,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,quarter(open_date) Q,'.$gr.',count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,Q,k,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        group by Y,Q,k';
                        break;
                    case "HouseType":
                        $query = 'select Y,Q,hti.house_type_id,house_type_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,quarter(open_date) Q,house_type_id,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,Q,house_type_id,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join house_type_info hti on hti.house_type_id = t1.house_type_id group by Y,Q,house_type_id,house_type_name';
                        break;
                    case "Room":
                        $query = 'select Y,Q,room,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,quarter(open_date) Q,room,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,Q,room,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        group by Y,Q,room';
                        break;
                }
                break;//季度
            case "HY":
                switch($group2){
                    case "District":
                        $query = 'select Y,case when Q <= 2 then 1 when Q>2 and Q<= 4 then 2 else "other" end  HY,d.district_id,district_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,quarter(open_date) Q,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,Q,house_id ) t1 inner join (select house_id,district_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join district d on d.district_id = t2.district_id group by Y,HY,district_id,district_name';
                        break;
                    case "Plate":
                        $query = 'select Y,case when Q <= 2 then 1 when Q>2 and Q<= 4 then 2 else "other" end  HY,p.plate_id,plate_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,quarter(open_date) Q,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,Q,house_id ) t1 inner join (select house_id,plate_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join plate p on p.plate_id = t2.plate_id group by Y,HY,plate_id,plate_name';
                        break;
                    case "Loop":
                        $query = 'select Y,case when Q <= 2 then 1 when Q>2 and Q<= 4 then 2 else "other" end  HY,l.loop_id,loop_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,quarter(open_date) Q,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,Q,house_id ) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join `loop` l on l.loop_id = t2.loop_id group by Y,HY,loop_id,loop_name';
                        break;
                    case "Area":
                        $gr = "case ";//比如传进来的0-50，50-100
                        foreach($user_area_arr as $k=>$v){
                            if(strpos($v,'-')){//必须包含-
                                $v_arr = explode("-",$v);//必须拆分为2个值
                                if(count($v_arr) >= 2){
                                    if(is_numeric($v_arr[0]) && is_numeric($v_arr[1])){
                                        $gr .= " when  area >=".$v_arr[0]." and area < ".$v_arr[1]." then '".$k."' ";
                                    }
                                }
                            }
                        }
                        $gr .= " else 'other' end k";
                        $query = 'select Y,case when Q <= 2 then 1 when Q>2 and Q<= 4 then 2 else "other" end  HY,k,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,quarter(open_date) Q,'.$gr.',count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,Q,k,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        group by Y,HY,k';
                        break;
                    case "HouseType":
                        $query = 'select Y,case when Q <= 2 then 1 when Q>2 and Q<= 4 then 2 else "other" end  HY,hti.house_type_id,house_type_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,quarter(open_date) Q,house_type_id,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,Q,house_type_id,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join house_type_info hti on hti.house_type_id = t1.house_type_id group by Y,HY,house_type_id,house_type_name';
                        break;
                    case "Room":
                        $query = 'select Y,case when Q <= 2 then 1 when Q>2 and Q<= 4 then 2 else "other" end  HY,room,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,quarter(open_date) Q,room,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,Q,room,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        group by Y,HY,room';
                        break;
                }
                break;//半年
            case "Y":
                switch($group2){
                    case "District":
                        $query = 'select Y,d.district_id,district_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,house_id ) t1 inner join (select house_id,district_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join district d on d.district_id = t2.district_id group by Y,district_id,district_name';
                        break;
                    case "Plate":
                        $query = 'select Y,p.plate_id,plate_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,house_id ) t1 inner join (select house_id,plate_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join plate p on p.plate_id = t2.plate_id group by Y,plate_id,plate_name';
                        break;
                    case "Loop":
                        $query = 'select Y,l.loop_id,loop_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,house_id ) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join `loop` l on l.loop_id = t2.loop_id group by Y,loop_id,loop_name';
                        break;
                    case "Area":
                        $gr = "case ";//比如传进来的0-50，50-100
                        foreach($user_area_arr as $k=>$v){
                            if(strpos($v,'-')){//必须包含-
                                $v_arr = explode("-",$v);//必须拆分为2个值
                                if(count($v_arr) >= 2){
                                    if(is_numeric($v_arr[0]) && is_numeric($v_arr[1])){
                                        $gr .= " when  area >=".$v_arr[0]." and area < ".$v_arr[1]." then '".$k."' ";
                                    }
                                }
                            }
                        }
                        $gr .= " else 'other' end k";
                        $query = 'select Y,k,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,'.$gr.',count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,Q,k,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        group by Y,k';
                        break;
                    case "HouseType":
                        $query = 'select Y,hti.house_type_id,house_type_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,house_type_id,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,house_type_id,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join house_type_info hti on hti.house_type_id = t1.house_type_id group by Y,house_type_id,house_type_name';
                        break;
                    case "Room":
                        $query = 'select Y,room,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,room,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,room,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        group by Y,room';
                        break;
                }
                break;//年
            case "District":
                switch($group2){
                    case "D":
                        $query = 'select D,d.district_id,district_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,open_date D,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by D,house_id ) t1 inner join (select house_id,district_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join district d on d.district_id = t2.district_id group by district_id,district_name,D';
                        break;
                    case "W":
                        $query = 'select Y,W,d.district_id,district_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,week(open_date,1) W,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,W,house_id ) t1 inner join (select house_id,district_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join district d on d.district_id = t2.district_id group by district_id,district_name,Y,W';
                        break;
                    case "M":
                        $query = 'select Y,M,d.district_id,district_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,month(open_date) M,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,M,house_id ) t1 inner join (select house_id,district_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join district d on d.district_id = t2.district_id group by district_id,district_name,Y,M';
                        break;
                    case "Q":
                        $query = 'select Y,Q,d.district_id,district_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,quarter(open_date) Q,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,Q,house_id ) t1 inner join (select house_id,district_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join district d on d.district_id = t2.district_id group by district_id,district_name,Y,Q';
                        break;
                    case "HY":
                        $query = 'select Y,case when Q <= 2 then 1 when Q>2 and Q<= 4 then 2 else "other" end  HY,d.district_id,district_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,quarter(open_date) Q,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,Q,house_id ) t1 inner join (select house_id,district_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join district d on d.district_id = t2.district_id group by district_id,district_name,Y,HY';
                        break;
                    case "Y":
                        $query = 'select Y,d.district_id,district_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,house_id ) t1 inner join (select house_id,district_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join district d on d.district_id = t2.district_id group by district_id,district_name,Y';
                        break;
                    case "Area":
                        $gr = "case ";//比如传进来的0-50，50-100
                        foreach($user_area_arr as $k=>$v){
                            if(strpos($v,'-')){//必须包含-
                                $v_arr = explode("-",$v);//必须拆分为2个值
                                if(count($v_arr) >= 2){
                                    if(is_numeric($v_arr[0]) && is_numeric($v_arr[1])){
                                        $gr .= " when  area >=".$v_arr[0]." and area < ".$v_arr[1]." then '".$k."' ";
                                    }
                                }
                            }
                        }
                        $gr .= " else 'other' end k";
                        $query = 'select d.district_id,district_name,k,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,'.$gr.',count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by k,house_id ) t1 inner join (select house_id,district_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join district d on d.district_id = t2.district_id group by district_id,district_name,k';
                        break;
                    case "HouseType":
                        $query = 'select d.district_id,district_name,hti.house_type_id,house_type_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,house_type_id,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by house_type_id,house_id ) t1 inner join (select house_id,district_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join district d on d.district_id = t2.district_id left join house_type_info hti on hti.house_type_id = t1.house_type_id group by district_id,district_name,house_type_id,house_type_name';
                        break;
                    case "Room":
                        $query = 'select d.district_id,district_name,room,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,room,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by room,house_id ) t1 inner join (select house_id,district_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join district d on d.district_id = t2.district_id group by district_id,district_name,room';
                        break;
                }
                break;//区域
            case "Plate":
               switch($group2){
                    case "D":
                        $query = 'select D,p.plate_id,plate_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,open_date D,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by D,house_id ) t1 inner join (select house_id,plate_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join plate p on p.plate_id = t2.plate_id group by plate_id,plate_name,D';
                        break;
                    case "W":
                        $query = 'select Y,W,p.plate_id,plate_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,week(open_date,1) W,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,W,house_id ) t1 inner join (select house_id,plate_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join plate p on p.plate_id = t2.plate_id group by plate_id,plate_name,Y,W';
                        break;
                    case "M":
                        $query = 'select Y,M,d.district_id,district_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,month(open_date) M,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,M,house_id ) t1 inner join (select house_id,district_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join district d on d.district_id = t2.district_id group by district_id,district_name,Y,M';
                        break;
                    case "Q":
                        $query = 'select Y,Q,p.plate_id,plate_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,quarter(open_date) Q,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,Q,house_id ) t1 inner join (select house_id,plate_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join plate p on p.plate_id = t2.plate_id group by plate_id,plate_name,Y,Q';
                        break;
                    case "HY":
                        $query = 'select Y,case when Q <= 2 then 1 when Q>2 and Q<= 4 then 2 else "other" end  HY,p.plate_id,plate_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,quarter(open_date) Q,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,Q,house_id ) t1 inner join (select house_id,plate_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join plate p on p.plate_id = t2.plate_id group by plate_id,plate_name,Y,HY';
                        break;
                    case "Y":
                        $query = 'select Y,p.plate_id,plate_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,house_id ) t1 inner join (select house_id,plate_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join plate p on p.plate_id = t2.plate_id group by plate_id,plate_name,Y';
                        break;
                    case "Area":
                        $gr = "case ";//比如传进来的0-50，50-100
                        foreach($user_area_arr as $k=>$v){
                            if(strpos($v,'-')){//必须包含-
                                $v_arr = explode("-",$v);//必须拆分为2个值
                                if(count($v_arr) >= 2){
                                    if(is_numeric($v_arr[0]) && is_numeric($v_arr[1])){
                                        $gr .= " when  area >=".$v_arr[0]." and area < ".$v_arr[1]." then '".$k."' ";
                                    }
                                }
                            }
                        }
                        $gr .= " else 'other' end k";
                        $query = 'select p.plate_id,plate_name,k,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,'.$gr.',count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by k,house_id ) t1 inner join (select house_id,plate_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join plate p on p.plate_id = t2.plate_id group by plate_id,plate_name,k';
                        break;
                    case "HouseType":
                        $query = 'select p.plate_id,plate_name,hti.house_type_id,house_type_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,house_type_id,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by house_type_id,house_id ) t1 inner join (select house_id,plate_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join plate p on p.plate_id = t2.plate_id left join house_type_info hti on hti.house_type_id = t1.house_type_id group by plate_id,plate_name,house_type_id,house_type_name';
                        break;
                    case "Room":
                        $query = 'select p.plate_id,plate_name,room,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,room,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by room,house_id ) t1 inner join (select house_id,plate_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join plate p on p.plate_id = t2.plate_id group by plate_id,plate_name,room';
                        break;
                }
                break;//板块
            case "Loop":
                switch($group2){
                    case "D":
                        $query = 'select D,l.loop_id,loop_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,open_date D,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by D,house_id ) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join `loop` l on l.loop_id = t2.loop_id group by loop_id,loop_name,D';
                        break;
                    case "W":
                        $query = 'select Y,W,l.loop_id,loop_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,week(open_date,1) W,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,W,house_id ) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join `loop` l on l.loop_id = t2.loop_id group by loop_id,loop_name,Y,W';
                        break;
                    case "M":
                        $query = 'select Y,M,l.loop_id,loop_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,month(open_date) M,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,M,house_id ) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join `loop` l on l.loop_id = t2.loop_id group by loop_id,loop_name,Y,M';
                        break;
                    case "Q":
                        $query = 'select Y,Q,l.loop_id,loop_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,quarter(open_date) Q,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,Q,house_id ) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join `loop` l on l.loop_id = t2.loop_id group by loop_id,loop_name,Y,Q';
                        break;
                    case "HY":
                        $query = 'select Y,case when Q <= 2 then 1 when Q>2 and Q<= 4 then 2 else "other" end  HY,l.loop_id,loop_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,quarter(open_date) Q,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,Q,house_id ) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join `loop` l on l.loop_id = t2.loop_id group by loop_id,loop_name,Y,HY';
                        break;
                    case "Y":
                        $query = 'select Y,l.loop_id,loop_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,house_id ) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join `loop` l on l.loop_id = t2.loop_id group by loop_id,loop_name,Y';
                        break;
                    case "Area":
                        $gr = "case ";//比如传进来的0-50，50-100
                        foreach($user_area_arr as $k=>$v){
                            if(strpos($v,'-')){//必须包含-
                                $v_arr = explode("-",$v);//必须拆分为2个值
                                if(count($v_arr) >= 2){
                                    if(is_numeric($v_arr[0]) && is_numeric($v_arr[1])){
                                        $gr .= " when  area >=".$v_arr[0]." and area < ".$v_arr[1]." then '".$k."' ";
                                    }
                                }
                            }
                        }
                        $gr .= " else 'other' end k";
                        $query = 'select l.loop_id,loop_name,k,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,'.$gr.',count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by k,house_id ) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join `loop` l on l.loop_id = t2.loop_id group by loop_id,loop_name,k';
                        break;
                    case "HouseType":
                        $query = 'select l.loop_id,loop_name,hti.house_type_id,house_type_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,house_type_id,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by house_type_id,house_id ) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join `loop` l on l.loop_id = t2.loop_id left join house_type_info hti on hti.house_type_id = t1.house_type_id group by loop_id,loop_name,house_type_id,house_type_name';
                        break;
                    case "Room":
                        $query = 'select l.loop_id,loop_name,room,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,room,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by room,house_id ) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join `loop` l on l.loop_id = t2.loop_id group by loop_id,loop_name,room';
                        break;
                }
                break;//环线
            case "Area":
                $gr = "case ";//比如传进来的0-50，50-100
                foreach($user_area_arr as $k=>$v){
                    if(strpos($v,'-')){//必须包含-
                        $v_arr = explode("-",$v);//必须拆分为2个值
                        if(count($v_arr) >= 2){
                            if(is_numeric($v_arr[0]) && is_numeric($v_arr[1])){
                                $gr .= " when  area >=".$v_arr[0]." and area < ".$v_arr[1]." then '".$k."' ";
                            }
                        }
                    }
                }
                $gr .= " else 'other' end k";
                switch($group2){
                    case "D":
                        $query = 'select D,k,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,open_date D,'.$gr.',count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by D,k,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        group by k,D';
                        break;
                    case "W":
                        $query = 'select Y,W,k,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,week(open_date,1) W,'.$gr.',count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,W,k,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        group by k,Y,W';
                        break;
                    case "M":
                        $query = 'select Y,M,k,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,month(open_date) M,'.$gr.',count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,M,k,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        group by k,Y,M';
                        break;
                    case "Q":
                        $query = 'select Y,Q,k,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,quarter(open_date) Q,'.$gr.',count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,Q,k,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        group by k,Y,Q';
                        break;
                    case "HY":
                        $query = 'select Y,case when Q <= 2 then 1 when Q>2 and Q<= 4 then 2 else "other" end  HY,k,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,quarter(open_date) Q,'.$gr.',count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,Q,k,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        group by k,Y,HY';
                        break;
                    case "Y":
                        $query = 'select Y,k,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,'.$gr.',count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,Q,k,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        group by k,Y';
                        break;
                    case "District":
                        $query = 'select d.district_id,district_name,k,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,'.$gr.',count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by k,house_id ) t1 inner join (select house_id,district_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join district d on d.district_id = t2.district_id group by k,district_id,district_name';
                        break;
                    case "Plate":
                        $query = 'select p.plate_id,plate_name,k,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,'.$gr.',count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by k,house_id ) t1 inner join (select house_id,plate_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join plate p on p.plate_id = t2.plate_id group by k,plate_id,plate_name';
                        break;
                    case "Loop":
                        $query = 'select l.loop_id,loop_name,k,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,'.$gr.',count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by k,house_id ) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join `loop` l on l.loop_id = t2.loop_id group by k,loop_id,loop_name';
                        break;
                    case "HouseType":
                        $query = 'select k,hti.house_type_id,house_type_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,house_type_id,'.$gr.',count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by house_type_id,house_id,k ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join house_type_info hti on hti.house_type_id = t1.house_type_id group by k,house_type_id,house_type_name';
                        break;
                    case "Room":
                        $query = 'select k,room,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,room,'.$gr.',count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by room,house_id,k ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        group by k,room';
                        break;
                }
                break;//面积
            case "HouseType":
                switch($group2){
                    case "D":
                        $query = 'select D,hti.house_type_id,house_type_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,open_date D,house_type_id,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by D,house_type_id,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join house_type_info hti on hti.house_type_id = t1.house_type_id group by house_type_id,house_type_name,D';
                        break;
                    case "W":
                        $query = 'select Y,W,hti.house_type_id,house_type_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,week(open_date,1) W,house_type_id,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,W,house_type_id,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join house_type_info hti on hti.house_type_id = t1.house_type_id group by house_type_id,house_type_name,Y,W';
                        break;
                    case "M":
                        $query = 'select Y,M,hti.house_type_id,house_type_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,month(open_date) M,house_type_id,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,M,house_type_id,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join house_type_info hti on hti.house_type_id = t1.house_type_id group by house_type_id,house_type_name,Y,M';
                        break;
                    case "Q":
                        $query = 'select Y,Q,hti.house_type_id,house_type_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,quarter(open_date) Q,house_type_id,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,Q,house_type_id,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join house_type_info hti on hti.house_type_id = t1.house_type_id group by house_type_id,house_type_name,Y,Q';
                        break;
                    case "HY":
                        $query = 'select Y,case when Q <= 2 then 1 when Q>2 and Q<= 4 then 2 else "other" end  HY,hti.house_type_id,house_type_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,quarter(open_date) Q,house_type_id,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,Q,house_type_id,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join house_type_info hti on hti.house_type_id = t1.house_type_id group by house_type_id,house_type_name,Y,HY';
                        break;
                    case "Y":
                        $query = 'select Y,hti.house_type_id,house_type_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,house_type_id,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,house_type_id,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join house_type_info hti on hti.house_type_id = t1.house_type_id group by house_type_id,house_type_name,Y';
                        break;
                    case "District":
                        $query = 'select d.district_id,district_name,hti.house_type_id,house_type_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,house_type_id,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by house_type_id,house_id ) t1 inner join (select house_id,district_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join district d on d.district_id = t2.district_id left join house_type_info hti on hti.house_type_id = t1.house_type_id group by house_type_id,house_type_name,district_id,district_name';
                        break;
                    case "Plate":
                        $query = 'select p.plate_id,plate_name,hti.house_type_id,house_type_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,house_type_id,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by house_type_id,house_id ) t1 inner join (select house_id,plate_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join plate p on p.plate_id = t2.plate_id left join house_type_info hti on hti.house_type_id = t1.house_type_id group by house_type_id,house_type_name,plate_id,plate_name';
                        break;
                    case "Loop":
                        $query = 'select l.loop_id,loop_name,hti.house_type_id,house_type_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,house_type_id,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by house_type_id,house_id ) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join `loop` l on l.loop_id = t2.loop_id left join house_type_info hti on hti.house_type_id = t1.house_type_id group by house_type_id,house_type_name,loop_id,loop_name';
                        break;
                    case "Area":
                        $query = 'select k,hti.house_type_id,house_type_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,house_type_id,'.$gr.',count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by house_type_id,house_id,k ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join house_type_info hti on hti.house_type_id = t1.house_type_id group by house_type_id,house_type_name,k';
                        break;
                    case "Room":
                        $query = 'select hti.house_type_id,house_type_name,room,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,room,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by room,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        group by house_type_id,house_type_name,room';
                        break;
                }
                break;//房屋类型
            case "Room":
                switch($group2){
                    case "D":
                        $query = 'select D,room,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,open_date D,room,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by D,room,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        group by room,D';
                        break;
                    case "W":
                        $query = 'select Y,W,room,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,week(open_date,1) W,room,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,W,room,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        group by room,Y,W';
                        break;
                    case "M":
                        $query = 'select Y,M,room,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,month(open_date) M,room,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,M,room,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        group by room,Y,M';
                        break;
                    case "Q":
                        $query = 'select Y,Q,room,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,quarter(open_date) Q,room,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,Q,room,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        group by room,Y,Q';
                        break;
                    case "HY":
                        $query = 'select Y,case when Q <= 2 then 1 when Q>2 and Q<= 4 then 2 else "other" end  HY,room,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,quarter(open_date) Q,room,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,Q,room,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        group by room,Y,HY';
                        break;
                    case "Y":
                        $query = 'select Y,room,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,year(open_date) Y,room,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by Y,room,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        group by room,Y';
                        break;
                    case "District":
                        $query = 'select d.district_id,district_name,room,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,room,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by room,house_id ) t1 inner join (select house_id,district_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join district d on d.district_id = t2.district_id group by room,district_id,district_name';
                        break;
                    case "Plate":
                        $query = 'select p.plate_id,plate_name,room,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,room,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by room,house_id ) t1 inner join (select house_id,plate_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join plate p on p.plate_id = t2.plate_id group by room,plate_id,plate_name';
                        break;
                    case "Loop":
                        $query = 'select l.loop_id,loop_name,room,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,room,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by room,house_id ) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        left join `loop` l on l.loop_id = t2.loop_id group by room,loop_id,loop_name';
                        break;
                    case "Area":
                        $gr = "case ";//比如传进来的0-50，50-100
                        foreach($user_area_arr as $k=>$v){
                            if(strpos($v,'-')){//必须包含-
                                $v_arr = explode("-",$v);//必须拆分为2个值
                                if(count($v_arr) >= 2){
                                    if(is_numeric($v_arr[0]) && is_numeric($v_arr[1])){
                                        $gr .= " when  area >=".$v_arr[0]." and area < ".$v_arr[1]." then '".$k."' ";
                                    }
                                }
                            }
                        }
                        $gr .= " else 'other' end k";
                        $query = 'select k,room,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,room,'.$gr.',count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by room,house_id,k ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        group by room,k';
                        break;
                    case "HouseType":
                        $query = 'select hti.house_type_id,house_type_name,room,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area from (select house_id,room,count(1) cnt,sum(area) s_area
                        from house_supply '.$where_supply.'group by room,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                        group by room,house_type_id,house_type_name';
                        break;
                }
                break;//房型
        }
        $result = $this->db->query($query)->result_array();
        //echo $query;
        return $result;
    }

    // 形成楼盘where条件
    function get_where_house($is_first,$developer_company,$house_id,$house_name,$min_volume_rate,$max_volume_rate,$district_ids,$plate_ids,$loop_ids){
        $where = 'where house_info.is_first = '.$is_first;
        if($house_id){
            $where .= ' and house_info.house_id = '.$house_id.'';
        }
        if($min_volume_rate){
            $where .= ' and volume_rate >= '.$min_volume_rate.'';
        }
        if($max_volume_rate){
            $where .= ' and volume_rate <= '.$max_volume_rate.'';
        }
        if($district_ids){
            $district_ids = rtrim($district_ids,',');
            $where .= ' and house_info.district_id in ('.$district_ids.')';
        }
        if($plate_ids){
            $plate_ids = rtrim($plate_ids,',');
            $where .= ' and house_info.plate_id in ('.$plate_ids.')';
        }
        if($loop_ids){
            $loop_ids = rtrim($loop_ids,',');
            $where .= ' and house_info.loop_id in ('.$loop_ids.')';
        }
        if(!$house_id && $house_name){
            $where .= ' and house_name like "%'.$house_name.'%"';
        }
        if($developer_company){
            $where .= ' and developer_id like "%'.$developer_company.'%"';
        }
        return $where;
    }
    // 形成供应where条件
    function get_where_supply($s_date,$e_date,$house_type_ids,$min_area,$max_area,$room_ids){
        $where = 'where 1 = 1';
        if($s_date){
            $where .= ' and open_date >= "'.$s_date.'"';
        }
        if($e_date){
            $where .= ' and open_date <= "'.$e_date.'"';
        }
        if($min_area){
            $where .= ' and area >= '.$min_area.'';
        }
        if($max_area){
            $where .= ' and area <= '.$max_area.'';
        }
        if($house_type_ids){
            $house_type_ids = rtrim($house_type_ids,',');
            $where .= ' and house_supply.house_type_id in ('.$house_type_ids.')';
        }
        if($room_ids){
            $room_ids = rtrim($room_ids,',');
            $where .= ' and room in ('.$room_ids.')';
        }
        return $where;
    }

}