<?php

/**
 * Created by PhpStorm.
 * User: jmillerfun
 * Date: 2019/2/25
 * Time: 14:34
 */
class ReportInfo  extends  CI_Model{

    function __construct(){
        parent::__construct();
    }

    //总计
    function tj($city_code,$year,$month,$is_first,$house_type_id,$is_sjprice){

        $this->db = $this->load->database('data_'.$city_code,TRUE);
        $where = 'is_first='.$is_first;
        if($year)
            $where .= ' and cj_year = '.$year;
        if($month)
            $where .= ' and cj_month = '.$month;
        if($house_type_id == 100)
            $where .= ' and house_type_id in (1,2,3,4,5,6,7)';

        $query = 'select count(1) h_cnt, sum(cnt) d_cnt,sum(totalprice) s_totalprice,sum(totalprice)/sum(area) avg_price,sum(area) s_area
from (select house_id,avg(price) price,sum(totalprice) totalprice,sum(area) area,count(1) cnt from house_deal where '.$where.' group by house_id ) hd inner join house_info hi on hd.house_id = hi.house_id
where hi.is_first = '.$is_first;
        if($is_sjprice == 2){
            $query = 'select count(1) h_cnt, sum(cnt) d_cnt,sum(totalprice) s_totalprice,sum(totalprice)/sum(area) avg_price,sum(area) s_area
from (select house_id,avg(cankaoprice) price,sum(cankaototalprice) totalprice,sum(area) area,count(1) cnt from house_deal where '.$where.' group by house_id ) hd inner join house_info hi on hd.house_id = hi.house_id
where hi.is_first = '.$is_first;
        }

        $result = $this->db->query($query)->row();
        return $result;
    }

    //楼盘排名
    function house_top($city_code,$year,$month,$is_first,$house_type_id,$top,$wheres,$is_sjprice){
        $this->db = $this->load->database('data_'.$city_code,TRUE);
        $where = 'is_first='.$is_first;
        if($year)
            $where .= ' and cj_year = '.$year;
        if($month)
            $where .= ' and cj_month = '.$month;
        if($house_type_id == 100)
            $where .= ' and house_type_id in (1,2,3,4,5,6,7)';
        if($wheres)
            $where .= $wheres;

        $query = 'select house_name,district_name,count(1) d_cnt,sum(totalprice)/sum(area) avg_price from (
select house_id,price,totalprice,area from house_deal where '.$where.') hd inner join house_info hi on hd.house_id = hi.house_id
left join district d on d.district_id = hi.district_id group by house_name,district_name order by count(1) desc limit '.$top;
        if($is_sjprice == 2){
            $query = 'select house_name,district_name,count(1) d_cnt,sum(cankaototalprice)/sum(area) avg_price from (
select house_id,cankaoprice,cankaototalprice,area from house_deal where '.$where.') hd inner join house_info hi on hd.house_id = hi.house_id
left join district d on d.district_id = hi.district_id group by house_name,district_name order by count(1) desc limit '.$top;
        }
        $result = $this->db->query($query)->result();
        //echo $query.'<br/>';
        return $result;
    }

    //月份分析
    function deal_month_top($city_code,$year,$month,$is_first,$house_type_id,$top,$min_year,$min_month,$is_sjprice){
        $this->db = $this->load->database('data_'.$city_code,TRUE);
        $where = 'hd.is_first='.$is_first;
        if($year && $min_year){
            if($year == $min_year)
                $where .= ' and (cj_year = '.$year.' and cj_month <= '.$month.')';
            else{
                $where .= ' and ( (cj_year = '.$min_year.' and cj_month >= '.$min_month.') or (cj_year = '.$year.' and cj_month <= '.$month.'))';
            }
        }
        if($house_type_id == 100)
            $where .= ' and house_type_id in (1,2,3,4,5,6,7)';

        $query = 'select cj_year,cj_month,count(1) d_cnt,sum(area) s_area,sum(totalprice) s_totalprice,sum(totalprice)/sum(area) avg_price from house_deal hd inner join house_info hi on hd.house_id = hi.house_id
where hi.is_first = '.$is_first.' and '.$where.'
         group by cj_year,cj_month order by cj_year desc,cj_month desc limit '.$top;
        if($is_sjprice == 2){
            $query = 'select cj_year,cj_month,count(1) d_cnt,sum(area) s_area,sum(cankaototalprice) s_totalprice,sum(cankaototalprice)/sum(area) avg_price from house_deal hd inner join house_info hi on hd.house_id = hi.house_id
where hi.is_first = '.$is_first.' and '.$where.'
         group by cj_year,cj_month order by cj_year desc,cj_month desc limit '.$top;
        }
        //echo $query;
        $result = $this->db->query($query)->result();
        return $result;
    }

    //环线统计
    function loop_top($city_code,$year,$month,$is_first,$house_type_id,$is_sjprice){
        $this->db = $this->load->database('data_'.$city_code,TRUE);
        $where = 'is_first='.$is_first;
        if($year)
            $where .= ' and cj_year = '.$year;
        if($month)
            $where .= ' and cj_month = '.$month;
        if($house_type_id == 100)
            $where .= ' and house_type_id in (1,2,3,4,5,6,7)';

        $query = 'select loop_name,count(1) d_cnt,sum(totalprice)/sum(area) avg_price,sum(area) s_area,sum(totalprice) s_totalprice from (
select house_id,price,totalprice,area from house_deal where '.$where.') hd inner join house_info hi on hd.house_id = hi.house_id
left join `loop` l on l.loop_id = hi.loop_id where hi.is_first = '.$is_first.' group by loop_name order by count(1) desc ';
        if($is_sjprice == 2){
            $query = 'select loop_name,count(1) d_cnt,sum(cankaototalprice)/sum(area) avg_price,sum(area) s_area,sum(cankaototalprice) s_totalprice from (
select house_id,cankaoprice,cankaototalprice,area from house_deal where '.$where.') hd inner join house_info hi on hd.house_id = hi.house_id
left join `loop` l on l.loop_id = hi.loop_id where hi.is_first = '.$is_first.' group by loop_name order by count(1) desc ';
        }
        $result = $this->db->query($query)->result();
        return $result;
    }

    //区域统计
    function district_top($city_code,$year,$month,$is_first,$house_type_id,$is_sjprice){
        $this->db = $this->load->database('data_'.$city_code,TRUE);
        $where = 'is_first='.$is_first;
        if($year)
            $where .= ' and cj_year = '.$year;
        if($month)
            $where .= ' and cj_month = '.$month;
        if($house_type_id == 100)
            $where .= ' and house_type_id in (1,2,3,4,5,6,7)';

        $query = 'select district_name,count(1) d_cnt,sum(totalprice)/sum(area) avg_price,sum(area) s_area,sum(totalprice) s_totalprice from (
select house_id,price,totalprice,area from house_deal where '.$where.') hd inner join house_info hi on hd.house_id = hi.house_id
left join district d on d.district_id = hi.district_id where hi.is_first = '.$is_first.' group by district_name order by count(1) desc ';
        if($is_sjprice == 2){
            $query = 'select district_name,count(1) d_cnt,sum(cankaototalprice)/sum(area) avg_price,sum(area) s_area,sum(cankaototalprice) s_totalprice from (
select house_id,cankaoprice,cankaototalprice,area from house_deal where '.$where.') hd inner join house_info hi on hd.house_id = hi.house_id
left join district d on d.district_id = hi.district_id where hi.is_first = '.$is_first.' group by district_name order by count(1) desc ';
        }
        $result = $this->db->query($query)->result();
        return $result;
    }

    //总价段分析
    function deal_month_tprice($city_code,$year,$month,$is_first,$house_type_id,$tprice_arr,$is_sjprice){
        $this->db = $this->load->database('data_'.$city_code,TRUE);
        $where = 'is_first='.$is_first;
        if($year)
            $where .= ' and cj_year = '.$year;
        if($month)
            $where .= ' and cj_month = '.$month;
        if($house_type_id == 100)
            $where .= ' and house_type_id in (1,2,3,4,5,6,7)';

        $gr = "case ";//比如传进来的0-50，50-100
        foreach($tprice_arr as $k=>$v){
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
        $query = 'select k,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_totalprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$gr.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal where '.$where.'
                group by house_id,k ) t1  inner join house_info hi on t1.house_id = hi.house_id
where hi.is_first = '.$is_first.'  group by k ';
        if($is_sjprice == 2){
            $query = 'select k,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_totalprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$gr.',count(1) cnt,sum(area) s_area,sum(cankaototalprice) s_tprice from house_deal where  '.$where.'
                group by house_id,k ) t1 inner join house_info hi on t1.house_id = hi.house_id
where hi.is_first = '.$is_first.'  group by k ';
        }
        $result = $this->db->query($query)->result();
        //echo $query;
        return $result;
    }

    //面积段分析
    function deal_month_area($city_code,$year,$month,$is_first,$house_type_id,$area_arr,$is_sjprice){
        $this->db = $this->load->database('data_'.$city_code,TRUE);
        $where = 'is_first='.$is_first;
        if($year)
            $where .= ' and cj_year = '.$year;
        if($month)
            $where .= ' and cj_month = '.$month;
        if($house_type_id == 100)
            $where .= ' and house_type_id in (1,2,3,4,5,6,7)';

        $gr = "case ";//比如传进来的0-50，50-100
        foreach($area_arr as $k=>$v){
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
        $query = 'select k,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_totalprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$gr.',count(1) cnt,sum(area) s_area,sum(totalprice) s_tprice from house_deal where '.$where.'
                group by house_id,k ) t1 inner join house_info hi on t1.house_id = hi.house_id
where hi.is_first = '.$is_first.'   group by k ';
        if($is_sjprice == 2)
        {
            $query = 'select k,count(1) h_cnt,sum(cnt) d_cnt,sum(s_area) s_area,sum(s_tprice) s_totalprice,sum(s_tprice)/sum(s_area) avg_price,sum(s_area)/sum(cnt) avg_area,
                sum(s_tprice)/sum(cnt) avg_tprice from (select house_id,'.$gr.',count(1) cnt,sum(area) s_area,sum(cankaototalprice) s_tprice from house_deal where '.$where.'
                group by house_id,k ) t1 inner join house_info hi on t1.house_id = hi.house_id
where hi.is_first = '.$is_first.'   group by k ';
        }
        //echo $query;
        $result = $this->db->query($query)->result();
        return $result;
    }

    //中介分析
    function deal_month_medium($city_code,$year,$month,$is_first,$house_type_id,$top,$is_sjprice){
        $this->db = $this->load->database('data_'.$city_code,TRUE);
        $where = 'hd.is_first='.$is_first;
        if($year)
            $where .= ' and cj_year = '.$year;
        if($month)
            $where .= ' and cj_month = '.$month;
        if($house_type_id == 100)
            $where .= ' and house_type_id in (1,2,3,4,5,6,7)';
        $limit = '';
        if($top)
            $limit = ' limit '.$top;
        $query = 'select short_medium_name,count(1) d_cnt,sum(area) s_area,sum(totalprice) s_totalprice,sum(totalprice)/sum(area) avg_price
             from house_deal hd inner join house_info hi on hd.house_id = hi.house_id where hi.is_first = 2 and '.$where.' and short_medium_name != ""  group by short_medium_name order by d_cnt desc '.$limit;
        if($is_sjprice == 2){
            $query = 'select short_medium_name,count(1) d_cnt,sum(area) s_area,sum(cankaototalprice) s_totalprice,sum(cankaototalprice)/sum(area) avg_price
             from house_deal hd inner join house_info hi on hd.house_id = hi.house_id where hi.is_first = 2 and '.$where.' and short_medium_name != ""  group by short_medium_name order by d_cnt desc '.$limit;
        }
        //echo $query;
        $result = $this->db->query($query)->result();
        return $result;
    }
}