<?php

/**
 * Created by PhpStorm.
 * User: yz
 * Date: 2018/4/12
 * Time: 15:03
 * Description: 写一些公用方法和设定约定字段描述
 */
define('APP_KEY', 'yuwuWeb');//可以定死也可以

class Yuwu_dict
{
    /*判断请求头部*/
    function page_load(){
        header('Access-Control-Allow-Origin:http://new.yuwudata.com');
        header('Access-Control-Allow-Methods:GET,POST');
        header('Access-Control-Allow-Headers:x-requested-with,content-type');
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
        {
            exit;
        }
    }

    /*
    * 所有的方法必须包含 code(返回编码),msg(返回结果),data(返回值)
    * 1000,成功//1001,缺少参数//1002,请求超时 ,访问超过1分钟//1003,签名错误//1004,系统错误
    */
    function get_json_result($code,$data){
        $msg = '';
        switch($code){
            case 1000: $msg='成功'; break;
            case 1001: $msg='缺少参数'; break;
            case 1002: $msg='请求超时'; break;
            case 1003: $msg='签名错误'; break;
            case 1004: $msg='系统错误'; break;
            //----------------------------------
            case 1005: $code = 1000; $msg='已存在'; break;
            case 1006: $code = 1000; $msg='更新成功'; break;
        }
        return json_encode(array('code'=>$code,'msg'=>$msg,'data'=>$data));
    }

    /*
     * 判断是否签名成功
     * */
    function is_signature($timestamp,$randomstr,$signature){
        //访问超时 传的时间戳超过2分钟则访问超时
        $code = 1;
        // $time = time();
        // if($time - $timestamp > 120){
        //     $code = 1002;
        // }
        //签名错误
        if($this->get_signature($timestamp,$randomstr) !=  $signature){
            $code = 1003;
        }
        return $code;
    }

    /*
    * 生成签名规则 (appkey+timestamp+randomstr) 大小写排序之后先sha1，再md5，最后转成小写=$signature
    */
    function get_signature($timestamp,$randomstr){
        $arr['timeStamp'] = str_split($timestamp) ;
        $arr['randomStr'] = str_split($randomstr);
        $arr['appkey'] = str_split(APP_KEY);
        $new_arr = array();
        for($i= 0; $i< count($arr['timeStamp']); $i++){
            $new_arr[] = $arr['timeStamp'][$i];
        }
        for($i= 0; $i< count($arr['randomStr']); $i++){
            $new_arr[] = $arr['randomStr'][$i];
        }
        for($i= 0; $i< count($arr['appkey']); $i++){
            $new_arr[] = $arr['appkey'][$i];
        }
        //按照首字母大小写顺序排序
        sort($new_arr,SORT_STRING);
        //拼接成字符串
        $str = '';
        for($i= 0; $i< count($new_arr); $i++){
            $str .= $new_arr[$i];
        }
        //进行加密
        $signature = sha1($str);
        $signature = md5($signature);
        //转换成小写
        $signature = strtolower($signature);
        return $signature;
    }

    //随机生成字符串
    function createNonceStr($length = 8) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    //获得环比日期
    function getHbDate($s_date,$e_date){
        $new_date_arr = [];
        $s_time=strtotime($s_date);
        $e_time=strtotime($e_date);
        $s_year = date('Y',$s_time);$s_month = date('m',$s_time);$s_day = date('d',$s_time);
        $e_year = date('Y',$e_time);$e_month = date('m',$e_time);$e_day = date('d',$e_time);
        $max_day = date('d',strtotime(date('Y-m-t',$e_time)));
        //这里分为2种吧，1：如果日期是整月，则减去整月，2：其他，根据日期差距时间减
        if($s_day == 1 && $e_day == $max_day){
            $diff = abs($e_year-$s_year) * 12 + abs($e_month-$s_month);
            $new_s_date = date("Y-m-1",strtotime($s_date."-".($diff+1)." month"));//因为要包括当前1月
            $new_e_date = date("Y-m-t",strtotime($s_date."-1 month"));
            $new_date_arr[] =  $new_s_date;
            $new_date_arr[] =  $new_e_date;
        }else{
            $diff = ($e_time-$s_time) / 86400;
            $new_s_date = date("Y-m-d",strtotime($s_date."-".($diff+2)." day"));//因为要包括当前2天所有要加2
            $new_e_date = date("Y-m-d",strtotime($s_date."-1 day"));
            $new_date_arr[] =  $new_s_date;
            $new_date_arr[] =  $new_e_date;
        }
        return $new_date_arr;
    }

    //获得同比日期 2018-7-1 2017-7-1
    function getTbDate($s_date,$e_date){
        $new_date_arr = [];
        $new_s_date = date("Y-m-d",strtotime($s_date."-1 year"));//因为要包括当前1月
        $new_e_date = date("Y-m-d",strtotime($e_date."-1 year"));
        $new_date_arr[] =  $new_s_date;
        $new_date_arr[] =  $new_e_date;

        return $new_date_arr;
    }

    //根据日期获取，日期数组
    function getDateArr($g,$s_date,$e_date){
        //根据日，周，月，季，半年，年
        $arr = array();
        switch($g){
            case "D":
                $diff = $this->diffBetweenTwoDays($s_date,$e_date);
                for($i = 0;$i<=$diff;$i++){
                    $arr[]  = date('Y-m-d',strtotime('+'.$i.' day',strtotime($s_date)));
                }
                break;
            case "W":
                //查出结束日期的下周一
                $e_date_w = date('Y-m-d',strtotime('+1 day',strtotime($e_date)));
                $i_date = $s_date;
                while($i_date != $e_date_w)
                {
                    $arr[]  = date('Y-W',strtotime('+6 day',strtotime($i_date)));
                    $i_date = date('Y-m-d',strtotime('+7 day',strtotime($i_date)));
                }
                break;
            case "M":
                $e_date = date('Y-n-1',strtotime($e_date));//查出当月第一天
                $e_date_m = date('Y-n-1',strtotime('+1 month',strtotime($e_date)));//查出结束日期的下一月
                $i_date = $s_date;//2017-12-1
                while($i_date != $e_date_m)
                {
                    $arr[]  = date('Y-n',strtotime($i_date));
                    $i_date = date('Y-n-1',strtotime('+1 month',strtotime($i_date)));
                }
                break;
            case "Q":
                //查出开始日期的季度和年度
                $s_year = date('Y',strtotime($s_date));
                $s_month = date('m',strtotime($s_date));
                $i_date = $s_quarter = ceil($s_month/3);
                //查出结尾日期的季度和年度
                $e_year = date('Y',strtotime($e_date));
                $e_month = date('m',strtotime($e_date));
                $e_quarter = ceil($e_month/3);
                $e_quarter_q = $e_quarter+1;
                if($s_year == $e_year){//年相等，直接判断季节
                    while($i_date != $e_quarter_q)
                    {
                        $arr[]  = $s_year.'-'.$i_date;
                        $i_date ++;
                    }
                }else{
                    for($i=0;$i<=($e_year-$s_year);$i++){
                        $j_s = 1;
                        if($i == 0)
                            $j_s = $s_quarter;
                        for($j=$j_s;$j<= 4;$j++){
                            if(($s_year+$i) == $e_year && $j==$e_quarter_q)
                                break;
                            $arr[]  = ($s_year+$i).'-'.$j;
                        }
                    }
                }
                break;
            case "HY":
                //查出开始日期的半年和年度
                $s_year = date('Y',strtotime($s_date));
                $s_month = date('m',strtotime($s_date));
                $i_date = $s_quarter = ceil($s_month/6);
                //查出结尾日期的半年和年度
                $e_year = date('Y',strtotime($e_date));
                $e_month = date('m',strtotime($e_date));
                $e_quarter = ceil($e_month/6);
                $e_quarter_q = $e_quarter+1;
                if($s_year == $e_year){//年相等，直接判断半年
                    while($i_date != $e_quarter_q)
                    {
                        $arr[]  = $s_year.'-'.$i_date;
                        $i_date ++;
                    }
                }else{
                    for($i=0;$i<=($e_year-$s_year);$i++){
                        $j_s = 1;
                        if($i == 0)
                            $j_s = $s_quarter;
                        for($j=$j_s;$j<= 2;$j++){
                            if(($s_year+$i) == $e_year && $j==$e_quarter_q)
                                break;
                            $arr[]  = ($s_year+$i).'-'.$j;
                        }
                    }
                }
                break;
            case "Y":
                $s_year = date('Y',strtotime($s_date));
                $e_year = date('Y',strtotime($e_date));
                for($i = 0;$i<=$e_year-$s_year;$i++){
                    $arr[]  = $s_year+$i;
                }
                break;
        }
        return $arr;
    }

    //获取日期天数差
    function diffBetweenTwoDays($day1, $day2)
    {
        $second1 = strtotime($day1);
        $second2 = strtotime($day2);

        if ($second1 < $second2) {
            $tmp = $second2;
            $second2 = $second1;
            $second1 = $tmp;
        }
        return ($second1 - $second2) / 86400;
    }
}