<?php

namespace mpayment\pay;


class PayFactory
{
    public static function getInstance($payMethod){

        $payMethod = \think\helper\Str::studly($payMethod);
        $class = '\\mpayment\pay\\'.$payMethod;

        try {
            //return new $class();
            $args=[];
            return (new \ReflectionClass($class))->newInstanceArgs($args);
        } catch (ReflectionException $e) {
            throw new ClassNotFoundException('class not exists: ' . $class, $class, $e);
        }

    }
}