<?php

/**
 * Created by PhpStorm.
 * User: jmillerfun
 * Date: 2018/8/8
 * Time: 16:16
 */
class HouseDeal extends  CI_Model{

    function __construct(){
        parent::__construct();
    }
    //统计
    function deal_tj($city_code,$is_first,$s_date,$e_date,$house_type_ids,$min_area,$max_area,$min_price,$max_price,$min_tprice,$max_tprice,$room_ids,
                       $developer_company,$house_id,$house_name,$min_volume_rate,$max_volume_rate,$district_ids,$plate_ids,$loop_ids){
        $this->db = $this->load->database('data_'.$city_code,TRUE);
        $where_house = $this->get_where_house($is_first,$developer_company,$house_id,$house_name,$min_volume_rate,$max_volume_rate,$district_ids,$plate_ids,$loop_ids);
        $where_deal = $this->get_where_deal($is_first,$s_date,$e_date,$house_type_ids,$min_area,$max_area,$min_price,$max_price,$min_tprice,$max_tprice,$room_ids);
        $query_d = 'select house_id,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.' group by house_id ';
        $query_h = 'select house_id from house_info '.$where_house.'';
        $query = 'select count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_pirce from ('.$query_d.') t1 inner join ('.$query_h.') t2 on t1.house_id=t2.house_id';
        $result = $this->db->query($query)->result();
        return $result;
    }

    //列表
    function deal_list($city_code,$is_first,$s_date,$e_date,$house_type_ids,$min_area,$max_area,$min_price,$max_price,$min_tprice,$max_tprice,$room_ids,
                     $developer_company,$house_id,$house_name,$min_volume_rate,$max_volume_rate,$district_ids,$plate_ids,$loop_ids,$group,
                       $user_area_arr,$user_price_arr,$user_tprice_arr){
        $this->db = $this->load->database('data_'.$city_code,TRUE);
        $where_house = $this->get_where_house($is_first,$developer_company,$house_id,$house_name,$min_volume_rate,$max_volume_rate,$district_ids,$plate_ids,$loop_ids);
        $where_deal = $this->get_where_deal($is_first,$s_date,$e_date,$house_type_ids,$min_area,$max_area,$min_price,$max_price,$min_tprice,$max_tprice,$room_ids);
        switch($group){
            case "D":
                $query = 'select D, count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,cj_date D,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by D,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by D ';
                break;//天
            case "W":
                $query = 'select Y,W,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,week(cj_date,1) W,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,W,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by Y,W ';
                break;//周
            case "M":
                $query = 'select Y,M,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,month(cj_date) M,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,M,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by Y,M ';
                break;//月
            case "Q":
                $query = 'select Y,Q,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,quarter(cj_date) Q,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,Q,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by Y,Q ';
                break;//季度
            case "HY":
                $query = 'select Y,case when Q <= 2 then 1 when Q>2 and Q<= 4 then 2 else "other" end  HY,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,quarter(cj_date) Q,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,Q,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by Y,HY ';
                break;//半年
            case "Y":
                $query = 'select Y,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by Y ';
                break;//年
            case "District":
                $query = 'select d.district_id,district_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id ) t1 inner join (select house_id,district_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join district d on d.district_id=t2.district_id group by district_id,district_name';
                break;//区域
            case "Plate":
                $query = 'select p.plate_id,plate_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id ) t1 inner join (select house_id,plate_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join plate p on p.plate_id=t2.plate_id group by plate_id,plate_name ';
                break;//板块
            case "Loop":
                $query = 'select l.loop_id,loop_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
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
                $query = 'select k,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$gr.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,k ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by k ';
                break;//面积
            case "Price":
                $gr = "case ";//比如传进来的0-50，50-100
                foreach($user_price_arr as $k=>$v){
                    if(strpos($v,'-')){//必须包含-
                        $v_arr = explode("-",$v);//必须拆分为2个值
                        if(count($v_arr) >= 2){
                            if(is_numeric($v_arr[0]) && is_numeric($v_arr[1])){
                                $gr .= " when  price >=".$v_arr[0]." and price < ".$v_arr[1]." then '".$k."' ";
                            }
                        }
                    }
                }
                $gr .= " else 'other' end k";
                $query = 'select k,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$gr.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,k ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by k ';
                break;//单价段
            case "TPrice":
                $gr = "case ";//比如传进来的0-50，50-100
                foreach($user_tprice_arr as $k=>$v){
                    if(strpos($v,'-')){//必须包含-
                        $v_arr = explode("-",$v);//必须拆分为2个值
                        if(count($v_arr) >= 2){
                            if(is_numeric($v_arr[0]) && is_numeric($v_arr[1])){
                                $gr .= " when  totalprice >=".$v_arr[0]."*10000 and totalprice < ".$v_arr[1]."*10000 then '".$k."' ";
                            }
                        }
                    }
                }
                $gr .= " else 'other' end k";
                $query = 'select k,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$gr.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,k ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by k ';
                break;//总价段
            case "HouseType":
                $query = 'select hti.house_type_id,house_type_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,house_type_id,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,house_type_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id
                left join house_type_info hti on hti.house_type_id = t1.house_type_id group by house_type_id,house_type_name ';
                break;//房屋类型
            case "Room":
                $query = 'select room,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,room,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,room ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by room ';
                break;//房型
        }
        $result = $this->db->query($query)->result_array();
        //echo $query;
        return $result;
    }

    //列表总套数
    function deal_list_totalpage($city_code,$is_first,$s_date,$e_date,$house_type_ids,$min_area,$max_area,$min_price,$max_price,$min_tprice,$max_tprice,$room_ids,
                       $developer_company,$house_id,$house_name,$min_volume_rate,$max_volume_rate,$district_ids,$plate_ids,$loop_ids,$group,$page,$pagesize,
                       $user_area_arr,$user_price_arr,$user_tprice_arr){
        $this->db = $this->load->database('data_'.$city_code,TRUE);
        $where_house = $this->get_where_house($is_first,$developer_company,$house_id,$house_name,$min_volume_rate,$max_volume_rate,$district_ids,$plate_ids,$loop_ids);
        $where_deal = $this->get_where_deal($is_first,$s_date,$e_date,$house_type_ids,$min_area,$max_area,$min_price,$max_price,$min_tprice,$max_tprice,$room_ids);
        switch($group){
            case "D":
                $query = 'select count(1) cnt from (select D, count(1) h_cnt from (select house_id,cj_date D,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by D,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by D) temp';
                break;//天
            case "W":
                $query = 'select count(1) cnt from (select Y,W,count(1) h_cnt from (select house_id,year(cj_date) Y,week(cj_date,1) W,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,W,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by Y,W) temp';
                break;//周
            case "M":
                $query = 'select count(1) cnt from (select Y,M,count(1) h_cnt from (select house_id,year(cj_date) Y,month(cj_date) M,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,M,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by Y,M) temp';
                break;//月
            case "Q":
                $query = 'select count(1) cnt from (select Y,Q,count(1) h_cnt from (select house_id,year(cj_date) Y,quarter(cj_date) Q,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,Q,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by Y,Q) temp';
                break;//季度
            case "HY":
                $query = 'select count(1) cnt from (select Y,case when Q <= 2 then 1 when Q>2 and Q<= 4 then 2 else "other" end  HY,count(1) h_cnt from (select house_id,year(cj_date) Y,quarter(cj_date) Q,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,Q,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by Y,HY) temp';
                break;//半年
            case "Y":
                $query = 'select count(1) cnt from (select Y,count(1) h_cnt from (select house_id,year(cj_date) Y,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by Y) temp';
                break;//年
            case "District":
                $query = 'select count(1) cnt from (select district_id,count(1) h_cnt from (select house_id,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id ) t1 inner join (select house_id,district_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by district_id) temp';
                break;//区域
            case "Plate":
                $query = 'select count(1) cnt from (select plate_id,count(1) h_cnt from (select house_id,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id ) t1 inner join (select house_id,plate_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by plate_id) temp';
                break;//板块
        }
        $result = $this->db->query($query)->row();
        //echo $query;
        return $result;
    }

    //列表
    function jcdeal_list($city_code,$is_first,$s_date,$e_date,$house_type_ids,$min_area,$max_area,$min_price,$max_price,$min_tprice,$max_tprice,$room_ids,
                       $developer_company,$house_id,$house_name,$min_volume_rate,$max_volume_rate,$district_ids,$plate_ids,$loop_ids,$group1,$group2,
                       $user_area_arr,$user_price_arr,$user_tprice_arr){
        $this->db = $this->load->database('data_'.$city_code,TRUE);
        $where_house = $this->get_where_house($is_first,$developer_company,$house_id,$house_name,$min_volume_rate,$max_volume_rate,$district_ids,$plate_ids,$loop_ids);
        $where_deal = $this->get_where_deal($is_first,$s_date,$e_date,$house_type_ids,$min_area,$max_area,$min_price,$max_price,$min_tprice,$max_tprice,$room_ids);
        switch($group1){
            case "D":
                switch($group2){
                    case "District":
                        $query = 'select D,district_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,cj_date D,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by D,house_id ) t1 inner join (select house_id,district_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join district d on d.district_id = t2.district_id
                group by D,district_name order by district_name asc,D asc';
                        break;
                    case "Plate":
                        $query = 'select D,plate_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,cj_date D,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by D,house_id ) t1 inner join (select house_id,plate_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join plate p on p.plate_id = t2.plate_id
                group by D,plate_name order by plate_name asc,D asc ';
                        break;
                    case "Loop":
                        $query = 'select D,loop_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,cj_date D,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by D,house_id ) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join `loop` p on p.loop_id = t2.loop_id
                group by D,loop_name order by loop_name asc,D asc  ';
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
                        $gr .= " else 'other' end ka";
                        $query = 'select D,ka,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,cj_date D,'.$gr.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by D,house_id,ka) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by  D,ka order by ka asc,D asc';
                        break;
                    case "Price":
                        $gr = "case ";//比如传进来的0-50，50-100
                        foreach($user_price_arr as $k=>$v){
                            if(strpos($v,'-')){//必须包含-
                                $v_arr = explode("-",$v);//必须拆分为2个值
                                if(count($v_arr) >= 2){
                                    if(is_numeric($v_arr[0]) && is_numeric($v_arr[1])){
                                        $gr .= " when  price >=".$v_arr[0]." and price < ".$v_arr[1]." then '".$k."' ";
                                    }
                                }
                            }
                        }
                        $gr .= " else 'other' end kp";
                        $query = 'select D,kp,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,cj_date D,'.$gr.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by D,house_id,kp) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by D,kp order by kp asc,D asc';
                        break;
                    case "TPrice":
                        $gr = "case ";//比如传进来的0-50，50-100
                        foreach($user_tprice_arr as $k=>$v){
                            if(strpos($v,'-')){//必须包含-
                                $v_arr = explode("-",$v);//必须拆分为2个值
                                if(count($v_arr) >= 2){
                                    if(is_numeric($v_arr[0]) && is_numeric($v_arr[1])){
                                        $gr .= " when  totalprice >=".$v_arr[0]."*10000 and totalprice < ".$v_arr[1]."*10000 then '".$k."' ";
                                    }
                                }
                            }
                        }
                        $gr .= " else 'other' end ktp";
                        $query = 'select D,ktp,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,cj_date D,'.$gr.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by D,house_id,ktp) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by  D,ktp order by ktp asc,D asc';
                        break;
                    case "HouseType":
                        $query = 'select D,hti.house_type_id,house_type_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,cj_date D,house_type_id,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by D,house_id,house_type_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join house_type_info hti on hti.house_type_id = t1.house_type_id
                group by D,hti.house_type_id,house_type_name order by house_type_id asc,D asc ';
                        break;
                    case "Room":
                        $query = 'select D,room,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,cj_date D,room,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by D,house_id,room ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by D,room order by room asc,D asc ';
                        break;
                }
                break;//天
            case "W":
                switch($group2){
                    case "District":
                        $query = 'select Y,W,district_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,week(cj_date,1) W,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,W,house_id ) t1 inner join (select house_id,district_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join district d on d.district_id = t2.district_id
                group by Y,W,district_name order by district_name asc,Y asc,W asc';
                        break;
                    case "Plate":
                        $query = 'select Y,W,plate_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,week(cj_date,1) W,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,W,house_id ) t1 inner join (select house_id,plate_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join plate p on p.plate_id = t2.plate_id
                group by Y,W,plate_name order by plate_name asc,Y asc,W asc ';
                        break;
                    case "Loop":
                        $query = 'select Y,W,loop_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,week(cj_date,1) W,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,W,house_id ) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join `loop` p on p.loop_id = t2.loop_id
                group by Y,W,loop_name order by loop_name asc,Y asc,W asc   ';
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
                        $gr .= " else 'other' end ka";
                        $query = 'select Y,W,ka,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,week(cj_date,1) W,'.$gr.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,W,house_id,ka) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by  Y,W,ka order by ka asc,Y asc,W asc';
                        break;
                    case "Price":
                        $gr = "case ";//比如传进来的0-50，50-100
                        foreach($user_price_arr as $k=>$v){
                            if(strpos($v,'-')){//必须包含-
                                $v_arr = explode("-",$v);//必须拆分为2个值
                                if(count($v_arr) >= 2){
                                    if(is_numeric($v_arr[0]) && is_numeric($v_arr[1])){
                                        $gr .= " when  price >=".$v_arr[0]." and price < ".$v_arr[1]." then '".$k."' ";
                                    }
                                }
                            }
                        }
                        $gr .= " else 'other' end kp";
                        $query = 'select Y,W,kp,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,week(cj_date,1) W,'.$gr.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,W,house_id,kp) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by Y,W,kp order by kp asc,Y asc,W asc';
                        break;
                    case "TPrice":
                        $gr = "case ";//比如传进来的0-50，50-100
                        foreach($user_tprice_arr as $k=>$v){
                            if(strpos($v,'-')){//必须包含-
                                $v_arr = explode("-",$v);//必须拆分为2个值
                                if(count($v_arr) >= 2){
                                    if(is_numeric($v_arr[0]) && is_numeric($v_arr[1])){
                                        $gr .= " when  totalprice >=".$v_arr[0]."*10000 and totalprice < ".$v_arr[1]."*10000 then '".$k."' ";
                                    }
                                }
                            }
                        }
                        $gr .= " else 'other' end ktp";
                        $query = 'select Y,W,ktp,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,week(cj_date,1) W,'.$gr.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,W,house_id,ktp) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by  Y,W,ktp order by ktp asc,Y asc,W asc';
                        break;
                    case "HouseType":
                        $query = 'select Y,W,hti.house_type_id,house_type_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,week(cj_date,1) W,house_type_id,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,W,house_id,house_type_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join house_type_info hti on hti.house_type_id = t1.house_type_id
                group by Y,W,hti.house_type_id,house_type_name order by house_type_id asc,Y asc,W asc  ';
                        break;
                    case "Room":
                        $query = 'select Y,W,room,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,week(cj_date,1) W,room,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,W,house_id,room ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by Y,W,room order by room asc,Y asc,W asc ';
                        break;
                }
                break;//周
            case "M":
               switch($group2){
                    case "District":
                        $query = 'select Y,M,district_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,month(cj_date) M,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,M,house_id ) t1 inner join (select house_id,district_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join district d on d.district_id = t2.district_id
                group by Y,M,district_name order by district_name asc,Y asc,M asc ';
                        break;
                    case "Plate":
                        $query = 'select Y,M,plate_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,month(cj_date) M,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,M,house_id ) t1 inner join (select house_id,plate_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join plate p on p.plate_id = t2.plate_id
                group by Y,M,plate_name order by plate_name asc,Y asc,M asc ';
                        break;
                    case "Loop":
                        $query = 'select Y,M,loop_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,month(cj_date) M,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,M,house_id ) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join `loop` p on p.loop_id = t2.loop_id
                group by Y,W,loop_name order by loop_name asc,Y asc,M asc  ';
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
                        $gr .= " else 'other' end ka";
                        $query = 'select Y,M,ka,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,month(cj_date) M,'.$gr.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,M,house_id,ka) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by  Y,M,ka order by ka asc,Y asc,M asc';
                        break;
                    case "Price":
                        $gr = "case ";//比如传进来的0-50，50-100
                        foreach($user_price_arr as $k=>$v){
                            if(strpos($v,'-')){//必须包含-
                                $v_arr = explode("-",$v);//必须拆分为2个值
                                if(count($v_arr) >= 2){
                                    if(is_numeric($v_arr[0]) && is_numeric($v_arr[1])){
                                        $gr .= " when  price >=".$v_arr[0]." and price < ".$v_arr[1]." then '".$k."' ";
                                    }
                                }
                            }
                        }
                        $gr .= " else 'other' end kp";
                        $query = 'select Y,M,kp,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,month(cj_date) M,'.$gr.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,M,house_id,kp) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by  Y,M,kp order by kp asc,Y asc,M asc';
                        break;
                    case "TPrice":
                        $gr = "case ";//比如传进来的0-50，50-100
                        foreach($user_tprice_arr as $k=>$v){
                            if(strpos($v,'-')){//必须包含-
                                $v_arr = explode("-",$v);//必须拆分为2个值
                                if(count($v_arr) >= 2){
                                    if(is_numeric($v_arr[0]) && is_numeric($v_arr[1])){
                                        $gr .= " when  totalprice >=".$v_arr[0]."*10000 and totalprice < ".$v_arr[1]."*10000 then '".$k."' ";
                                    }
                                }
                            }
                        }
                        $gr .= " else 'other' end ktp";
                        $query = 'select Y,M,ktp,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,month(cj_date) M,'.$gr.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,M,house_id,ktp) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by  Y,M,ktp order by ktp asc,Y asc,M asc';
                        break;
                    case "HouseType":
                        $query = 'select Y,M,hti.house_type_id,house_type_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,month(cj_date) M,house_type_id,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,M,house_id,house_type_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join house_type_info hti on hti.house_type_id = t1.house_type_id
                group by Y,M,hti.house_type_id,house_type_name order by house_type_id asc,Y asc,M asc   ';
                        break;
                    case "Room":
                        $query = 'select Y,M,room,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,month(cj_date) M,room,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,M,house_id,room ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by Y,M,room order by room asc,Y asc,M asc ';
                        break;
                }
                break;//月
            case "Q":
                switch($group2){
                    case "District":
                        $query = 'select Y,Q,district_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,quarter(cj_date) Q,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,Q,house_id ) t1 inner join (select house_id,district_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join district d on d.district_id = t2.district_id
                group by Y,Q,district_name order by district_name asc,Y asc,Q asc  ';
                        break;
                    case "Plate":
                        $query = 'select Y,Q,plate_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,quarter(cj_date) Q,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,Q,house_id ) t1 inner join (select house_id,plate_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join plate p on p.plate_id = t2.plate_id
                group by Y,Q,plate_name order by plate_name asc,Y asc,Q asc  ';
                        break;
                    case "Loop":
                        $query = 'select Y,Q,loop_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,quarter(cj_date) Q,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,Q,house_id ) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join `loop` p on p.loop_id = t2.loop_id
                group by Y,Q,loop_name order by loop_name asc,Y asc,Q asc  ';
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
                        $gr .= " else 'other' end ka";
                        $query = 'select Y,Q,ka,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,quarter(cj_date) Q,'.$gr.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,Q,house_id,ka) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by  Y,Q,ka order by ka asc,Y asc,Q asc';
                        break;
                    case "Price":
                        $gr = "case ";//比如传进来的0-50，50-100
                        foreach($user_price_arr as $k=>$v){
                            if(strpos($v,'-')){//必须包含-
                                $v_arr = explode("-",$v);//必须拆分为2个值
                                if(count($v_arr) >= 2){
                                    if(is_numeric($v_arr[0]) && is_numeric($v_arr[1])){
                                        $gr .= " when  price >=".$v_arr[0]." and price < ".$v_arr[1]." then '".$k."' ";
                                    }
                                }
                            }
                        }
                        $gr .= " else 'other' end kp";
                        $query = 'select Y,Q,kp,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,quarter(cj_date) Q,'.$gr.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,Q,house_id,kp) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by  Y,Q,kp order by kp asc,Y asc,Q asc';
                        break;
                    case "TPrice":
                        $gr = "case ";//比如传进来的0-50，50-100
                        foreach($user_tprice_arr as $k=>$v){
                            if(strpos($v,'-')){//必须包含-
                                $v_arr = explode("-",$v);//必须拆分为2个值
                                if(count($v_arr) >= 2){
                                    if(is_numeric($v_arr[0]) && is_numeric($v_arr[1])){
                                        $gr .= " when  totalprice >=".$v_arr[0]."*10000 and totalprice < ".$v_arr[1]."*10000 then '".$k."' ";
                                    }
                                }
                            }
                        }
                        $gr .= " else 'other' end ktp";
                        $query = 'select Y,Q,ktp,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,quarter(cj_date) Q,'.$gr.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,Q,house_id,ktp) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by  Y,Q,ktp order by ktp asc,Y asc,Q asc';
                        break;
                    case "HouseType":
                        $query = 'select Y,Q,hti.house_type_id,house_type_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,quarter(cj_date) Q,house_type_id,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,Q,house_id,house_type_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join house_type_info hti on hti.house_type_id = t1.house_type_id
                group by Y,Q,hti.house_type_id,house_type_name order by house_type_id asc,Y asc,Q asc   ';
                        break;
                    case "Room":
                        $query = 'select Y,Q,room,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,quarter(cj_date) Q,room,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,Q,house_id,room ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by Y,Q,room order by room asc,Y asc,Q asc';
                        break;
                }
                break;//季度
            case "HY":
                switch($group2){
                    case "District":
                        $query = 'select Y,case when Q <= 2 then 1 when Q>2 and Q<= 4 then 2 else "other" end  HY,district_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,quarter(cj_date) Q,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,Q,house_id ) t1 inner join (select house_id,district_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join district d on d.district_id = t2.district_id
                group by Y,HY,district_name order by district_name asc,Y asc,HY asc  ';
                        break;
                    case "Plate":
                        $query = 'select Y,case when Q <= 2 then 1 when Q>2 and Q<= 4 then 2 else "other" end  HY,plate_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,quarter(cj_date) Q,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,Q,house_id ) t1 inner join (select house_id,plate_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join plate p on p.plate_id = t2.plate_id
                group by Y,HY,plate_name order by plate_name asc,Y asc,HY asc  ';
                        break;
                    case "Loop":
                        $query = 'select Y,case when Q <= 2 then 1 when Q>2 and Q<= 4 then 2 else "other" end  HY,loop_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,quarter(cj_date) Q,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,Q,house_id ) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join `loop` p on p.loop_id = t2.loop_id
                group by Y,HY,loop_name order by loop_name asc,Y asc,HY asc  ';
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
                        $gr .= " else 'other' end ka";
                        $query = 'select Y,case when Q <= 2 then 1 when Q>2 and Q<= 4 then 2 else "other" end  HY,ka,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,quarter(cj_date) Q,'.$gr.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,Q,house_id,ka ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by  Y,HY,ka order by ka asc,Y asc,HY asc';
                        break;
                    case "Price":
                        $gr = "case ";//比如传进来的0-50，50-100
                        foreach($user_price_arr as $k=>$v){
                            if(strpos($v,'-')){//必须包含-
                                $v_arr = explode("-",$v);//必须拆分为2个值
                                if(count($v_arr) >= 2){
                                    if(is_numeric($v_arr[0]) && is_numeric($v_arr[1])){
                                        $gr .= " when  price >=".$v_arr[0]." and price < ".$v_arr[1]." then '".$k."' ";
                                    }
                                }
                            }
                        }
                        $gr .= " else 'other' end kp";
                        $query = 'select Y,case when Q <= 2 then 1 when Q>2 and Q<= 4 then 2 else "other" end  HY,kp,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,quarter(cj_date) Q,'.$gr.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,Q,house_id,kp) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by  Y,HY,kp order by kp asc,Y asc,HY asc';
                        break;
                    case "TPrice":
                        $gr = "case ";//比如传进来的0-50，50-100
                        foreach($user_tprice_arr as $k=>$v){
                            if(strpos($v,'-')){//必须包含-
                                $v_arr = explode("-",$v);//必须拆分为2个值
                                if(count($v_arr) >= 2){
                                    if(is_numeric($v_arr[0]) && is_numeric($v_arr[1])){
                                        $gr .= " when  totalprice >=".$v_arr[0]."*10000 and totalprice < ".$v_arr[1]."*10000 then '".$k."' ";
                                    }
                                }
                            }
                        }
                        $gr .= " else 'other' end ktp";
                        $query = 'select Y,case when Q <= 2 then 1 when Q>2 and Q<= 4 then 2 else "other" end  HY,ktp,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,quarter(cj_date) Q,'.$gr.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,Q,house_id,ktp) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by  Y,HY,ktp order by ktp asc,Y asc,HY asc';
                        break;
                    case "HouseType":
                        $query = 'select Y,case when Q <= 2 then 1 when Q>2 and Q<= 4 then 2 else "other" end  HY,hti.house_type_id,house_type_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,quarter(cj_date) Q,house_type_id,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,Q,house_id,house_type_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join house_type_info hti on hti.house_type_id = t1.house_type_id
                group by Y,HY,hti.house_type_id,house_type_name order by house_type_id asc,Y asc,HY asc ';
                        break;
                    case "Room":
                        $query = 'select Y,case when Q <= 2 then 1 when Q>2 and Q<= 4 then 2 else "other" end  HY,room,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,quarter(cj_date) Q,room,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,Q,house_id,room ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by Y,HY,room order by room asc,Y asc,HY asc';
                        break;
                }
                break;//半年
            case "Y":
                switch($group2){
                    case "District":
                        $query = 'select Y,district_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,house_id ) t1 inner join (select house_id,district_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join district d on d.district_id = t2.district_id
                group by Y,district_name order by district_name asc,Y asc';
                        break;
                    case "Plate":
                        $query = 'select Y,plate_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,house_id ) t1 inner join (select house_id,plate_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join plate p on p.plate_id = t2.plate_id
                group by Y,plate_name order by plate_name asc,Y asc ';
                        break;
                    case "Loop":
                        $query = 'select Y,loop_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,house_id ) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join `loop` p on p.loop_id = t2.loop_id
                group by Y,loop_name order by loop_name asc,Y asc ';
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
                        $gr .= " else 'other' end ka";
                        $query = 'select Y,ka,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,'.$gr.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,house_id,ka) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by  Y,ka order by ka asc,Y asc';
                        break;
                    case "Price":
                        $gr = "case ";//比如传进来的0-50，50-100
                        foreach($user_price_arr as $k=>$v){
                            if(strpos($v,'-')){//必须包含-
                                $v_arr = explode("-",$v);//必须拆分为2个值
                                if(count($v_arr) >= 2){
                                    if(is_numeric($v_arr[0]) && is_numeric($v_arr[1])){
                                        $gr .= " when  price >=".$v_arr[0]." and price < ".$v_arr[1]." then '".$k."' ";
                                    }
                                }
                            }
                        }
                        $gr .= " else 'other' end kp";
                        $query = 'select Y,kp,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,'.$gr.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,house_id,kp) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by Y,kp order by kp asc,Y asc';
                        break;
                    case "TPrice":
                        $gr = "case ";//比如传进来的0-50，50-100
                        foreach($user_tprice_arr as $k=>$v){
                            if(strpos($v,'-')){//必须包含-
                                $v_arr = explode("-",$v);//必须拆分为2个值
                                if(count($v_arr) >= 2){
                                    if(is_numeric($v_arr[0]) && is_numeric($v_arr[1])){
                                        $gr .= " when  totalprice >=".$v_arr[0]."*10000 and totalprice < ".$v_arr[1]."*10000 then '".$k."' ";
                                    }
                                }
                            }
                        }
                        $gr .= " else 'other' end ktp";
                        $query = 'select Y,ktp,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,'.$gr.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,house_id,ktp) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by  Y,ktp order by ktp asc,Y asc';
                        break;
                    case "HouseType":
                        $query = 'select Y,hti.house_type_id,house_type_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,house_type_id,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,house_id,house_type_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join house_type_info hti on hti.house_type_id = t1.house_type_id
                group by Y,hti.house_type_id,house_type_name order by house_type_id asc,Y asc ';
                        break;
                    case "Room":
                        $query = 'select Y,room,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,room,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,house_id,room ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by Y,room order by room asc,Y asc ';
                        break;
                }
                break;//年
            case "District":
                switch($group2){
                    case "D":
                        $query = 'select district_name,d.district_id,D,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,cj_date D,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by D,house_id ) t1 inner join (select house_id,district_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join district d on t2.district_id=d.district_id group by district_id,district_name,D';
                        break;
                    case "W":
                        $query = 'select district_name,d.district_id,Y,W,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,week(cj_date,1) W,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,W,house_id ) t1 inner join (select house_id,district_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join district d on t2.district_id=d.district_id group by district_id,district_name,Y,W';
                        break;
                    case "M":
                        $query = 'select district_name,d.district_id,Y,M,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,month(cj_date) M,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,M,house_id ) t1 inner join (select house_id,district_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join district d on t2.district_id=d.district_id group by district_id,district_name,Y,M';
                        break;
                    case "Q":
                        $query = 'select district_name,d.district_id,Y,Q,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,quarter(cj_date) Q,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,Q,house_id ) t1 inner join (select house_id,district_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join district d on t2.district_id=d.district_id group by district_id,district_name,Y,Q ';
                        break;
                    case "HY":
                        $query = 'select district_name,d.district_id, Y,case when Q <= 2 then 1 when Q>2 and Q<= 4 then 2 else "other" end  HY,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,quarter(cj_date) Q,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,Q,house_id ) t1 inner join (select house_id,district_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join district d on t2.district_id=d.district_id group by district_id,district_name,Y,HY ';
                        break;
                    case "Y":
                        $query = 'select district_name,d.district_id,Y,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,house_id ) t1 inner join (select house_id,district_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join district d on t2.district_id=d.district_id group by district_id,district_name,Y';
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
                        $gr .= " else 'other' end ka";
                        $query = 'select district_name,d.district_id,ka,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$gr.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,ka) t1 inner join (select house_id,district_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join district d on t2.district_id=d.district_id group by  district_id,district_name,ka';
                        break;
                    case "Price":
                        $gr = "case ";//比如传进来的0-50，50-100
                        foreach($user_price_arr as $k=>$v){
                            if(strpos($v,'-')){//必须包含-
                                $v_arr = explode("-",$v);//必须拆分为2个值
                                if(count($v_arr) >= 2){
                                    if(is_numeric($v_arr[0]) && is_numeric($v_arr[1])){
                                        $gr .= " when  price >=".$v_arr[0]." and price < ".$v_arr[1]." then '".$k."' ";
                                    }
                                }
                            }
                        }
                        $gr .= " else 'other' end kp";
                        $query = 'select district_name,d.district_id,kp,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$gr.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,kp) t1 inner join (select house_id,district_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join district d on t2.district_id=d.district_id group by district_id,district_name,kp';
                        break;
                    case "TPrice":
                        $gr = "case ";//比如传进来的0-50，50-100
                        foreach($user_tprice_arr as $k=>$v){
                            if(strpos($v,'-')){//必须包含-
                                $v_arr = explode("-",$v);//必须拆分为2个值
                                if(count($v_arr) >= 2){
                                    if(is_numeric($v_arr[0]) && is_numeric($v_arr[1])){
                                        $gr .= " when  totalprice >=".$v_arr[0]."*10000 and totalprice < ".$v_arr[1]."*10000 then '".$k."' ";
                                    }
                                }
                            }
                        }
                        $gr .= " else 'other' end ktp";
                        $query = 'select district_name,d.district_id,ktp,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$gr.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,ktp) t1 inner join (select house_id,district_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join district d on t2.district_id=d.district_id group by  district_id,district_name,ktp';
                        break;
                    case "HouseType":
                        $query = 'select district_name,d.district_id,hti.house_type_id,house_type_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,house_type_id,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,house_type_id ) t1 inner join (select house_id,district_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join district d on t2.district_id=d.district_id
                 left join house_type_info hti on hti.house_type_id = t1.house_type_id group by district_id,district_name,house_type_id,house_type_name ';
                        break;
                    case "Room":
                        $query = 'select district_name,d.district_id,room,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,room,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,room ) t1 inner join (select house_id,district_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join district d on t2.district_id=d.district_id group by district_id,district_name,room ';
                        break;
                }
                break;//区域
            case "Plate":
                switch($group2){
                    case "D":
                        $query = 'select plate_name,p.plate_id,D,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,cj_date D,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by D,house_id ) t1 inner join (select house_id,plate_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join plate p on t2.plate_id=p.plate_id group by plate_id,plate_name,D';
                        break;
                    case "W":
                        $query = 'select plate_name,p.plate_id,Y,W,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,week(cj_date,1) W,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,W,house_id ) t1 inner join (select house_id,plate_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join plate p on t2.plate_id=p.plate_id group by plate_id,plate_name,Y,W';
                        break;
                    case "M":
                        $query = 'select plate_name,p.plate_id,Y,M,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,month(cj_date) M,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,M,house_id ) t1 inner join (select house_id,plate_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join plate p on t2.plate_id=p.plate_id group by plate_id,plate_name,Y,M';
                        break;
                    case "Q":
                        $query = 'select plate_name,p.plate_id,Y,Q,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,quarter(cj_date) Q,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,Q,house_id ) t1 inner join (select house_id,plate_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join plate p on t2.plate_id=p.plate_id group by plate_id,plate_name,Y,Q ';
                        break;
                    case "HY":
                        $query = 'select plate_name,p.plate_id, Y,case when Q <= 2 then 1 when Q>2 and Q<= 4 then 2 else "other" end  HY,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,quarter(cj_date) Q,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,Q,house_id ) t1 inner join (select house_id,plate_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join plate p on t2.plate_id=p.plate_id group by plate_id,plate_name,Y,HY ';
                        break;
                    case "Y":
                        $query = 'select plate_name,p.plate_id,Y,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,house_id ) t1 inner join (select house_id,plate_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join plate p on t2.plate_id=p.plate_id group by plate_id,plate_name,Y';
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
                        $gr .= " else 'other' end ka";
                        $query = 'select plate_name,p.plate_id,ka,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$gr.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,ka) t1 inner join (select house_id,plate_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join plate p on t2.plate_id=p.plate_id group by  plate_id,plate_name,ka';
                        break;
                    case "Price":
                        $gr = "case ";//比如传进来的0-50，50-100
                        foreach($user_price_arr as $k=>$v){
                            if(strpos($v,'-')){//必须包含-
                                $v_arr = explode("-",$v);//必须拆分为2个值
                                if(count($v_arr) >= 2){
                                    if(is_numeric($v_arr[0]) && is_numeric($v_arr[1])){
                                        $gr .= " when  price >=".$v_arr[0]." and price < ".$v_arr[1]." then '".$k."' ";
                                    }
                                }
                            }
                        }
                        $gr .= " else 'other' end kp";
                        $query = 'select plate_name,p.plate_id,kp,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$gr.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,kp) t1 inner join (select house_id,plate_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join plate p on t2.plate_id=p.plate_id group by plate_id,plate_name,kp';
                        break;
                    case "TPrice":
                        $gr = "case ";//比如传进来的0-50，50-100
                        foreach($user_tprice_arr as $k=>$v){
                            if(strpos($v,'-')){//必须包含-
                                $v_arr = explode("-",$v);//必须拆分为2个值
                                if(count($v_arr) >= 2){
                                    if(is_numeric($v_arr[0]) && is_numeric($v_arr[1])){
                                        $gr .= " when  totalprice >=".$v_arr[0]."*10000 and totalprice < ".$v_arr[1]."*10000 then '".$k."' ";
                                    }
                                }
                            }
                        }
                        $gr .= " else 'other' end ktp";
                        $query = 'select plate_name,p.plate_id,ktp,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$gr.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,ktp) t1 inner join (select house_id,plate_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join plate p on t2.plate_id=p.plate_id group by  plate_id,plate_name,ktp';
                        break;
                    case "HouseType":
                        $query = 'select plate_name,p.plate_id,hti.house_type_id,house_type_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,house_type_id,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,house_type_id ) t1 inner join (select house_id,plate_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join plate p on t2.plate_id=p.plate_id
                 left join house_type_info hti on hti.house_type_id = t1.house_type_id group by plate_id,plate_name,house_type_id,house_type_name  ';
                        break;
                    case "Room":
                        $query = 'select plate_name,p.plate_id,room,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,room,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,room ) t1 inner join (select house_id,plate_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join plate p on t2.plate_id=p.plate_id group by plate_id,plate_name,room ';
                        break;
                }
                break;//板块
            case "Loop":
                switch($group2){
                    case "D":
                        $query = 'select loop_name,p.loop_id,D,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,cj_date D,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by D,house_id ) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join `loop` p on p.loop_id = t2.loop_id group by loop_id,loop_name,D';
                        break;
                    case "W":
                        $query = 'select loop_name,p.loop_id,Y,W,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,week(cj_date,1) W,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,W,house_id ) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join `loop` p on p.loop_id = t2.loop_id  group by loop_id,loop_name,Y,W';
                        break;
                    case "M":
                        $query = 'select loop_name,p.loop_id,Y,M,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,month(cj_date) M,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,M,house_id ) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join `loop` p on p.loop_id = t2.loop_id group by loop_id,loop_name,Y,M';
                        break;
                    case "Q":
                        $query = 'select loop_name,p.loop_id,Y,Q,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,quarter(cj_date) Q,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,Q,house_id ) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join `loop` p on p.loop_id = t2.loop_id group by loop_id,loop_name,Y,Q ';
                        break;
                    case "HY":
                        $query = 'select loop_name,p.loop_id, Y,case when Q <= 2 then 1 when Q>2 and Q<= 4 then 2 else "other" end  HY,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,quarter(cj_date) Q,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,Q,house_id ) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join `loop` p on p.loop_id = t2.loop_id group by loop_id,loop_name,Y,HY ';
                        break;
                    case "Y":
                        $query = 'select loop_name,p.loop_id,Y,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,year(cj_date) Y,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,house_id ) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join `loop` p on p.loop_id = t2.loop_id group by loop_id,loop_name,Y';
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
                        $gr .= " else 'other' end ka";
                        $query = 'select loop_name,p.loop_id,ka,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$gr.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,ka) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join `loop` p on p.loop_id = t2.loop_id group by  loop_id,loop_name,ka';
                        break;
                    case "Price":
                        $gr = "case ";//比如传进来的0-50，50-100
                        foreach($user_price_arr as $k=>$v){
                            if(strpos($v,'-')){//必须包含-
                                $v_arr = explode("-",$v);//必须拆分为2个值
                                if(count($v_arr) >= 2){
                                    if(is_numeric($v_arr[0]) && is_numeric($v_arr[1])){
                                        $gr .= " when  price >=".$v_arr[0]." and price < ".$v_arr[1]." then '".$k."' ";
                                    }
                                }
                            }
                        }
                        $gr .= " else 'other' end kp";
                        $query = 'select loop_name,p.loop_id,kp,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$gr.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,kp) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join `loop` p on p.loop_id = t2.loop_id group by loop_id,loop_name,kp';
                        break;
                    case "TPrice":
                        $gr = "case ";//比如传进来的0-50，50-100
                        foreach($user_tprice_arr as $k=>$v){
                            if(strpos($v,'-')){//必须包含-
                                $v_arr = explode("-",$v);//必须拆分为2个值
                                if(count($v_arr) >= 2){
                                    if(is_numeric($v_arr[0]) && is_numeric($v_arr[1])){
                                        $gr .= " when  totalprice >=".$v_arr[0]."*10000 and totalprice < ".$v_arr[1]."*10000 then '".$k."' ";
                                    }
                                }
                            }
                        }
                        $gr .= " else 'other' end ktp";
                        $query = 'select loop_name,p.loop_id,ktp,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$gr.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,ktp) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join `loop` p on p.loop_id = t2.loop_id group by  loop_id,loop_name,ktp';
                        break;
                    case "HouseType":
                        $query = 'select loop_name,p.loop_id,hti.house_type_id,house_type_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,house_type_id,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,house_type_id ) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join  `loop`  p on t2.loop_id=p.loop_id
                 left join house_type_info hti on hti.house_type_id = t1.house_type_id group by loop_id,loop_name,house_type_id,house_type_name';
                        break;
                    case "Room":
                        $query = 'select loop_name,p.loop_id,room,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,room,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,room ) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join `loop` p on p.loop_id = t2.loop_id group by loop_id,loop_name,room ';
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
                $gr .= " else 'other' end ka";
                switch($group2){
                    case "D":
                        $query = 'select ka,D,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$gr.',cj_date D,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by D,house_id,ka) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by ka,D';
                        break;
                    case "W":
                        $query = 'select ka,Y,W,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$gr.',year(cj_date) Y,week(cj_date,1) W,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,W,house_id,ka ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by ka,Y,W';
                        break;
                    case "M":
                        $query = 'select ka,Y,M,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$gr.',year(cj_date) Y,month(cj_date) M,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,M,house_id,ka) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by ka,Y,M';
                        break;
                    case "Q":
                        $query = 'select ka,Y,Q,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$gr.',year(cj_date) Y,quarter(cj_date) Q,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,Q,house_id,ka) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by ka,Y,Q ';
                        break;
                    case "HY":
                        $query = 'select ka, Y,case when Q <= 2 then 1 when Q>2 and Q<= 4 then 2 else "other" end  HY,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$gr.',year(cj_date) Y,quarter(cj_date) Q,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,Q,house_id,ka ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by ka,Y,HY ';
                        break;
                    case "Y":
                        $query = 'select ka,Y,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$gr.',year(cj_date) Y,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,house_id,ka ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by ka,Y';
                        break;
                    case "District":
                        $query = 'select ka,d.district_id,district_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$gr.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,ka ) t1 inner join (select house_id,district_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join district d on t2.district_id = d.district_id group by ka,district_id,district_name';
                        break;
                    case "Plate":
                        $query = 'select ka,p.plate_id,plate_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$gr.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,ka ) t1 inner join (select house_id,plate_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join plate p on t2.plate_id = p.plate_id group by ka,plate_id,plate_name';
                        break;
                    case "Loop":
                        $query = 'select ka,loop_id,l.loop_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$gr.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,ka ) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join `loop` l on l.loop_id = t2.loop_id group by ka,loop_id,loop_name';
                        break;
                    case "Price":
                        $grp = "case ";//比如传进来的0-50，50-100
                        foreach($user_price_arr as $k=>$v){
                            if(strpos($v,'-')){//必须包含-
                                $v_arr = explode("-",$v);//必须拆分为2个值
                                if(count($v_arr) >= 2){
                                    if(is_numeric($v_arr[0]) && is_numeric($v_arr[1])){
                                        $grp .= " when  price >=".$v_arr[0]." and price < ".$v_arr[1]." then '".$k."' ";
                                    }
                                }
                            }
                        }
                        $grp .= " else 'other' end kp";
                        $query = 'select ka,kp,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$gr.','.$grp.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,kp,ka ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by ka,kp ';
                        break;
                    case "TPrice":
                        $grtp = "case ";//比如传进来的0-50，50-100
                        foreach($user_tprice_arr as $k=>$v){
                            if(strpos($v,'-')){//必须包含-
                                $v_arr = explode("-",$v);//必须拆分为2个值
                                if(count($v_arr) >= 2){
                                    if(is_numeric($v_arr[0]) && is_numeric($v_arr[1])){
                                        $grtp .= " when  totalprice >=".$v_arr[0]."*10000 and totalprice < ".$v_arr[1]."*10000 then '".$k."' ";
                                    }
                                }
                            }
                        }
                        $grtp .= " else 'other' end ktp";
                        $query = 'select ka,ktp,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$gr.','.$grtp.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,ka,ktp ) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by ka,ktp';
                        break;
                    case "HouseType":
                        $query = 'select ka,hti.house_type_id,house_type_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,house_type_id,'.$gr.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,house_type_id,ka ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join house_type_info hti on hti.house_type_id = t1.house_type_id group by ka,house_type_id,house_type_name ';
                        break;
                    case "Room":
                        $query = 'select ka,room,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$gr.',room,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,room,ka ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by ka,room ';
                        break;
                }
                break;//面积
            case "Price":
                $grp = "case ";//比如传进来的0-50，50-100
                foreach($user_price_arr as $k=>$v){
                    if(strpos($v,'-')){//必须包含-
                        $v_arr = explode("-",$v);//必须拆分为2个值
                        if(count($v_arr) >= 2){
                            if(is_numeric($v_arr[0]) && is_numeric($v_arr[1])){
                                $grp .= " when  price >=".$v_arr[0]." and price < ".$v_arr[1]." then '".$k."' ";
                            }
                        }
                    }
                }
                $grp .= " else 'other' end kp";
                switch($group2){
                    case "D":
                        $query = 'select kp,D,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$grp.',cj_date D,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by D,house_id,kp) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by kp,D';
                        break;
                    case "W":
                        $query = 'select kp,Y,W,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$grp.',year(cj_date) Y,week(cj_date,1) W,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,W,house_id,kp) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by kp,Y,W';
                        break;
                    case "M":
                        $query = 'select kp,Y,M,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$grp.',year(cj_date) Y,month(cj_date) M,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,M,house_id,kp) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by kp,Y,M';
                        break;
                    case "Q":
                        $query = 'select kp,Y,Q,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$grp.',year(cj_date) Y,quarter(cj_date) Q,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,Q,house_id,kp) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by kp,Y,Q ';
                        break;
                    case "HY":
                        $query = 'select kp, Y,case when Q <= 2 then 1 when Q>2 and Q<= 4 then 2 else "other" end  HY,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$grp.',year(cj_date) Y,quarter(cj_date) Q,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,Q,house_id,kp ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by kp,Y,HY ';
                        break;
                    case "Y":
                        $query = 'select kp,Y,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$grp.',year(cj_date) Y,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,house_id,kp ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by kp,Y';
                        break;
                    case "District":
                        $query = 'select kp,d.district_id,district_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$grp.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,kp ) t1 inner join (select house_id,district_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join district d on t2.district_id = d.district_id group by kp,district_id,district_name';
                        break;
                    case "Plate":
                        $query = 'select ka,p.plate_id,plate_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$grp.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,kp ) t1 inner join (select house_id,plate_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join plate p on t2.plate_id = p.plate_id group by kp,plate_id,plate_name';
                        break;
                    case "Loop":
                        $query = 'select ka,loop_id,l.loop_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$grp.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,kp ) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join `loop` l on l.loop_id = t2.loop_id group by kp,loop_id,loop_name';
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
                        $gr .= " else 'other' end ka";
                        $query = 'select kp,ka,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$gr.','.$grp.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,kp,ka ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by kp,ka ';
                        break;
                    case "TPrice":
                        $grtp = "case ";//比如传进来的0-50，50-100
                        foreach($user_tprice_arr as $k=>$v){
                            if(strpos($v,'-')){//必须包含-
                                $v_arr = explode("-",$v);//必须拆分为2个值
                                if(count($v_arr) >= 2){
                                    if(is_numeric($v_arr[0]) && is_numeric($v_arr[1])){
                                        $grtp .= " when  totalprice >=".$v_arr[0]."*10000 and totalprice < ".$v_arr[1]."*10000 then '".$k."' ";
                                    }
                                }
                            }
                        }
                        $grtp .= " else 'other' end ktp";
                        $query = 'select kp,ktp,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$grp.','.$grtp.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,kp,ktp ) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by kp,ktp';
                        break;
                    case "HouseType":
                        $query = 'select ka,hti.house_type_id,house_type_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,house_type_id,'.$grp.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,house_type_id,kp ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join house_type_info hti on hti.house_type_id = t1.house_type_id group by kp,house_type_id,house_type_name ';
                        break;
                    case "Room":
                        $query = 'select kp,room,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$grp.',room,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,room,kp) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by kp,room ';
                        break;
                }
                break;//单价段
            case "TPrice":
                $grtp = "case ";//比如传进来的0-50，50-100
                foreach($user_tprice_arr as $k=>$v){
                    if(strpos($v,'-')){//必须包含-
                        $v_arr = explode("-",$v);//必须拆分为2个值
                        if(count($v_arr) >= 2){
                            if(is_numeric($v_arr[0]) && is_numeric($v_arr[1])){
                                $grtp .= " when  totalprice >=".$v_arr[0]."*10000 and totalprice < ".$v_arr[1]."*10000 then '".$k."' ";
                            }
                        }
                    }
                }
                $grtp .= " else 'other' end ktp";
                switch($group2){
                    case "D":
                        $query = 'select ktp,D,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$grtp.',cj_date D,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by D,house_id,ktp) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by ktp,D';
                        break;
                    case "W":
                        $query = 'select ktp,Y,W,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$grtp.',year(cj_date) Y,week(cj_date,1) W,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,W,house_id,ktp) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by ktp,Y,W';
                        break;
                    case "M":
                        $query = 'select ktp,Y,M,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$grtp.',year(cj_date) Y,month(cj_date) M,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,M,house_id,ktp) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by ktp,Y,M';
                        break;
                    case "Q":
                        $query = 'select ktp,Y,Q,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$grtp.',year(cj_date) Y,quarter(cj_date) Q,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,Q,house_id,ktp) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by ktp,Y,Q ';
                        break;
                    case "HY":
                        $query = 'select ktp, Y,case when Q <= 2 then 1 when Q>2 and Q<= 4 then 2 else "other" end  HY,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$grtp.',year(cj_date) Y,quarter(cj_date) Q,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,Q,house_id,ktp) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by ktp,Y,HY ';
                        break;
                    case "Y":
                        $query = 'select ktp,Y,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$grtp.',year(cj_date) Y,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,house_id,ktp) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by ktp,Y';
                        break;
                    case "District":
                        $query = 'select ktp,district_id,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$grtp.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,ktp) t1 inner join (select house_id,district_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by ktp,district_id';
                        break;
                    case "Plate":
                        $query = 'select ka,p.plate_id,plate_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$grtp.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,ktp ) t1 inner join (select house_id,plate_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join plate p on t2.plate_id = p.plate_id group by ktp,plate_id,plate_name';
                        break;
                    case "Loop":
                        $query = 'select ka,loop_id,l.loop_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$grtp.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,ktp ) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join `loop` l on l.loop_id = t2.loop_id group by ktp,loop_id,loop_name';
                        break;
                    case "Price":
                        $grp = "case ";//比如传进来的0-50，50-100
                        foreach($user_price_arr as $k=>$v){
                            if(strpos($v,'-')){//必须包含-
                                $v_arr = explode("-",$v);//必须拆分为2个值
                                if(count($v_arr) >= 2){
                                    if(is_numeric($v_arr[0]) && is_numeric($v_arr[1])){
                                        $grp .= " when  price >=".$v_arr[0]." and price < ".$v_arr[1]." then '".$k."' ";
                                    }
                                }
                            }
                        }
                        $grp .= " else 'other' end kp";
                        $query = 'select ktp,kp,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$grtp.','.$grp.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,kp,ktp) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by ktp,kp ';
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
                        $gr .= " else 'other' end ka";
                        $query = 'select ktp,ka,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$gr.','.$grtp.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,ka,ktp ) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by ka,ktp';
                        break;
                    case "HouseType":
                        $query = 'select ka,hti.house_type_id,house_type_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,house_type_id,'.$grtp.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,house_type_id,ktp ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join house_type_info hti on hti.house_type_id = t1.house_type_id group by ktp,house_type_id,house_type_name ';
                        break;
                    case "Room":
                        $query = 'select ktp,room,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$grtp.',room,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,room,ktp) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by ktp,room ';
                        break;
                }
                break;//总价段
            case "HouseType":
                switch($group2){
                    case "D":
                        $query = 'select house_type_id,D,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,house_type_id,cj_date D,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by D,room,house_type_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by house_type_id,D';
                        break;
                    case "W":
                        $query = 'select house_type_id,Y,W,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,house_type_id,year(cj_date) Y,week(cj_date,1) W,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,W,house_id,house_type_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by house_type_id,Y,W';
                        break;
                    case "M":
                        $query = 'select house_type_id,Y,M,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,house_type_id,year(cj_date) Y,month(cj_date) M,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,M,house_id,house_type_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by house_type_id,Y,M';
                        break;
                    case "Q":
                        $query = 'select house_type_id,Y,Q,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,house_type_id,year(cj_date) Y,quarter(cj_date) Q,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,Q,house_id,house_type_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by house_type_id,Y,Q ';
                        break;
                    case "HY":
                        $query = 'select house_type_id, Y,case when Q <= 2 then 1 when Q>2 and Q<= 4 then 2 else "other" end  HY,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,house_type_id,year(cj_date) Y,quarter(cj_date) Q,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,Q,house_id,house_type_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by house_type_id,Y,HY ';
                        break;
                    case "Y":
                        $query = 'select house_type_id,Y,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,house_type_id,year(cj_date) Y,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,house_id,house_type_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by house_type_id,Y';
                        break;
                    case "District":
                        $query = 'select hti.house_type_id,d.district_id,hti.house_type_name,district_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,house_type_id,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,house_type_id ) t1 inner join (select house_id,district_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join district d on t2.district_id = d.district_id
                 left join house_type_info hti on hti.house_type_id = t1.house_type_id group by house_type_id,district_id,house_type_name,district_name';
                        break;
                    case "Plate":
                        $query = 'select hti.house_type_id,p.plate_id,hti.house_type_name,plate_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,house_type_id,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,house_type_id ) t1 inner join (select house_id,plate_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join plate p on t2.plate_id = p.plate_id
                 left join house_type_info hti on hti.house_type_id = t1.house_type_id group by house_type_id,plate_id,house_type_name,plate_name';
                        break;
                    case "Loop":
                        $query = 'select hti.house_type_id,l.loop_id,hti.house_type_name,loop_name,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,house_type_id,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,house_type_id ) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join `loop` l on l.loop_id = t2.loop_id
                 left join house_type_info hti on hti.house_type_id = t1.house_type_id group by house_type_id,loop_id,house_type_name,loop_name';
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
                        $gr .= " else 'other' end ka";
                        $query = 'select hti.house_type_id,house_type_name,ka,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,house_type_id,'.$gr.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,ka,house_type_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join house_type_info hti on hti.house_type_id = t1.house_type_id group by  house_type_id,house_type_name,ka';
                        break;
                    case "Price":
                        $gr = "case ";//比如传进来的0-50，50-100
                        foreach($user_price_arr as $k=>$v){
                            if(strpos($v,'-')){//必须包含-
                                $v_arr = explode("-",$v);//必须拆分为2个值
                                if(count($v_arr) >= 2){
                                    if(is_numeric($v_arr[0]) && is_numeric($v_arr[1])){
                                        $gr .= " when  price >=".$v_arr[0]." and price < ".$v_arr[1]." then '".$k."' ";
                                    }
                                }
                            }
                        }
                        $gr .= " else 'other' end kp";
                        $query = 'select hti.house_type_id,house_type_name,kp,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,house_type_id,'.$gr.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,kp,house_type_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join house_type_info hti on hti.house_type_id = t1.house_type_id group by house_type_id,house_type_name,kp';
                        break;
                    case "TPrice":
                        $gr = "case ";//比如传进来的0-50，50-100
                        foreach($user_tprice_arr as $k=>$v){
                            if(strpos($v,'-')){//必须包含-
                                $v_arr = explode("-",$v);//必须拆分为2个值
                                if(count($v_arr) >= 2){
                                    if(is_numeric($v_arr[0]) && is_numeric($v_arr[1])){
                                        $gr .= " when  totalprice >=".$v_arr[0]."*10000 and totalprice < ".$v_arr[1]."*10000 then '".$k."' ";
                                    }
                                }
                            }
                        }
                        $gr .= " else 'other' end ktp";
                        $query = 'select hti.house_type_id,house_type_name,ktp,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,house_type_id,'.$gr.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,ktp,house_type_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join house_type_info hti on hti.house_type_id = t1.house_type_id group by  house_type_id,house_type_name,ktp';
                        break;
                    case "Room":
                        $query = 'select hti.house_type_id,house_type_name,room,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,house_type_id,room,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,house_type_id,room ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id left join house_type_info hti on hti.house_type_id = t1.house_type_id group by house_type_id,house_type_name,room ';
                        break;
                }
                break;//房屋类型
            case "Room":
                switch($group2){
                    case "D":
                        $query = 'select room,D,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,room,cj_date D,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by D,room,house_id ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by room,D';
                        break;
                    case "W":
                        $query = 'select room,Y,W,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,room,year(cj_date) Y,week(cj_date,1) W,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,W,house_id,room ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by room,Y,W';
                        break;
                    case "M":
                        $query = 'select room,Y,M,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,room,year(cj_date) Y,month(cj_date) M,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,M,house_id,room ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by room,Y,M';
                        break;
                    case "Q":
                        $query = 'select room,Y,Q,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,room,year(cj_date) Y,quarter(cj_date) Q,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,Q,house_id,room ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by room,Y,Q ';
                        break;
                    case "HY":
                        $query = 'select room, Y,case when Q <= 2 then 1 when Q>2 and Q<= 4 then 2 else "other" end  HY,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,room,year(cj_date) Y,quarter(cj_date) Q,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,Q,house_id,room ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by room,Y,HY ';
                        break;
                    case "Y":
                        $query = 'select room,Y,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,room,year(cj_date) Y,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by Y,house_id,room ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by room,Y';
                        break;
                    case "District":
                        $query = 'select room,district_id,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,room,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,room ) t1 inner join (select house_id,district_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by room,district_id';
                        break;
                    case "Plate":
                        $query = 'select room,plate_id,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,room,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,room ) t1 inner join (select house_id,plate_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by room,plate_id';
                        break;
                    case "Loop":
                        $query = 'select room,loop_id,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,room,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,room ) t1 inner join (select house_id,loop_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by room,loop_id';
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
                        $gr .= " else 'other' end ka";
                        $query = 'select room,ka,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,room,'.$gr.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,ka,room ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by  room,ka';
                        break;
                    case "Price":
                        $gr = "case ";//比如传进来的0-50，50-100
                        foreach($user_price_arr as $k=>$v){
                            if(strpos($v,'-')){//必须包含-
                                $v_arr = explode("-",$v);//必须拆分为2个值
                                if(count($v_arr) >= 2){
                                    if(is_numeric($v_arr[0]) && is_numeric($v_arr[1])){
                                        $gr .= " when  price >=".$v_arr[0]." and price < ".$v_arr[1]." then '".$k."' ";
                                    }
                                }
                            }
                        }
                        $gr .= " else 'other' end kp";
                        $query = 'select room,kp,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,room,'.$gr.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,kp,room) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by room,kp';
                        break;
                    case "TPrice":
                        $gr = "case ";//比如传进来的0-50，50-100
                        foreach($user_tprice_arr as $k=>$v){
                            if(strpos($v,'-')){//必须包含-
                                $v_arr = explode("-",$v);//必须拆分为2个值
                                if(count($v_arr) >= 2){
                                    if(is_numeric($v_arr[0]) && is_numeric($v_arr[1])){
                                        $gr .= " when  totalprice >=".$v_arr[0]."*10000 and totalprice < ".$v_arr[1]."*10000 then '".$k."' ";
                                    }
                                }
                            }
                        }
                        $gr .= " else 'other' end ktp";
                        $query = 'select room,ktp,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,room,'.$gr.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,ktp,room ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by  room,ktp';
                        break;
                    case "HouseType":
                        $query = 'select room,house_type_id,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_tprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,house_type_id,room,count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal '.$where_deal.'
                group by house_id,house_type_id,room ) t1 inner join (select house_id from house_info '.$where_house.') t2 on t1.house_id = t2.house_id group by room,house_type_id ';
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
    // 形成成交where条件
    function get_where_deal($is_first,$s_date,$e_date,$house_type_ids,$min_area,$max_area,$min_price,$max_price,$min_tprice,$max_tprice,$room_ids){
        $where = 'where house_deal.is_first = '.$is_first;
        if($s_date){
            $where .= ' and cj_time >= '.strtotime($s_date).'';
        }
        if($e_date){
            $where .= ' and cj_time <= '.strtotime($e_date).'';
        }
        if($min_area){
            $where .= ' and area >= '.$min_area.'';
        }
        if($max_area){
            $where .= ' and area <= '.$max_area.'';
        }
        if($min_price){
            $where .= ' and price >= '.$min_price.'';
        }
        if($max_price){
            $where .= ' and price <= '.$max_price.'';
        }
        if($min_tprice){
            $where .= ' and totalprice >= '.$min_tprice.'';
        }
        if($max_tprice){
            $where .= ' and totalprice <= '.$max_tprice.'';
        }
        if($house_type_ids){
            $house_type_ids = rtrim($house_type_ids,',');
            $where .= ' and house_deal.house_type_id in ('.$house_type_ids.')';
        }
        if($room_ids){
            $room_ids = rtrim($room_ids,',');
            $where .= ' and room in ('.$room_ids.')';
        }
        return $where;
    }

}