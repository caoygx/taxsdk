<?php

namespace mpayment\pay;

use app\model\Order;
use app\model\Recharge;
use app\payment\Alipay;
use app\payment\BasePay;
use mpayment\pay\{AlipayResult,WechatResult};
use app\service\OrderService;


class Notify
{


    /**
     * 余额回调处理,由类call_user_func调用
     * @param $payResutl
     */
    function balanceNotify($payResult){
        $payResult = (new BalanceResult($payResult))->getPayResult();
            //$payResult['order_no'] = 'ch'.$payResult['order_no']; //debug

        //无充值回调处理

        //订单回调处理
        $this->orderCallback($payResult);
    }


    private function orderCallback($payResult){
        $orderService = new OrderService();
        $orderService->orderPay($payResult['order_no'], $payResult['pay_price'], $payResult['pay_type']);
    }


}