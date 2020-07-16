<?php

/**
 * Created by PhpStorm.
 * User: jmillerfun
 * Date: 2018/8/9
 * Time: 15:16
 */
class RoomType extends  CI_Model{
    function __construct(){
        parent::__construct();
    }

    //房型名称
    function get_room_list(){
        $Room_arr=array('1'=>'一房','2'=>'二房','3'=>'三房','4'=>'四房','5'=>'五房','50'=>'复式','60'=>'双拼','70'=>'联体','80'=>'独栋','0'=>'其他');
        return $Room_arr;
    }

    //房型名称
    function get_room_name($room){
        $Room_arr=array('0'=>'其他','1'=>'一房','2'=>'二房','3'=>'三房','4'=>'四房','5'=>'五房','50'=>'复式','60'=>'双拼','70'=>'联体','80'=>'独栋');
        return $Room_arr[$room];
    }

}