<?php

namespace mpayment\pay;

use app\model\Order;
use app\model\Recharge;
use app\payment\Alipay;
use app\payment\BasePay;
use mpayment\pay\{AlipayResult,WechatResult};
use app\service\OrderService;


class Refund
{
    protected $payMethod;
    function __construct($payMethod=null)
    {

    }

    function refund($order_no){
        $rOrder = Order::where(['order_no'=>$order_no])->find();
        //if($rOrder['status'] !='1') return false; // 1已支付 待确认 2待发货 3待收货 4已完成 5退款中 6退款完成 7已关闭

        $this->payMethod = PayFactory::getInstance($rOrder['pay_type']);
        $r = $this->payMethod->refund($rOrder);
        if($r){
            //退款成功
            return true;
        }else{
            return false;
        }
    }

}