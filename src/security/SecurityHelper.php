<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/3/12
 * Time: 15:13
 */

namespace taxsdk\security;


class SecurityHelper
{
    protected static $instance;


    protected static function create()
    {
        if (!self::$instance) {
            $class = "rsa";
            self::$instance = new $class();
        }
        return self::$instance;
    }

    public static function type($algorithmName){
        $class = "\\taxsdk\\security\\".ucfirst($algorithmName);
        if (!self::$instance) {
            self::$instance = new $class();
        }

        return self::$instance;
    }

    public static function __callStatic($method, $params)
    {
        return call_user_func_array([self::create(), $method], $params);
    }
}