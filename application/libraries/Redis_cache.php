<?php

/**
 * Created by PhpStorm.
 * User: jmillerfun
 * Date: 2018/10/29
 * Time: 14:56
 */
//redis 缓存类
class Redis_cache
{
    private static $handler;

    private static function handler(){
        if(!self::$handler){
            self::$handler = new Redis();
            self::$handler -> connect('127.0.0.1','6379');
        }
        return self::$handler;
    }

    public static function get($key){
        $value = self::handler() -> get($key);
        $value_serl = @unserialize($value);
        if(is_object($value_serl)||is_array($value_serl)){
            return $value_serl;
        }
        return $value;
    }

    //$expire 单位秒
    public static function set($key,$value,$expire){
        if(is_object($value)||is_array($value)){
            $value = serialize($value);
        }
        //return self::handler() -> set($key,$value);
        return self::handler() -> setex($key,$expire,$value);
    }

    /**
     *删除key
     */
    public static function del($key){
        return self::handler() -> del($key);
    }
}