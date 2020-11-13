<?php

namespace mpayment\pay;


interface BasePay
{
    public function pay($order);

    public function return();

    public function notify($class,$method);

    public function refund($order);
}