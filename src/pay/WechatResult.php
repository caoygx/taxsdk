<?php
namespace mpayment\pay;
class WechatResult{
    public $payResult = [];

    /**
     * @return array
     */
    public function getPayResult()
    {
        return $this->payResult;
    }
    function __construct($payResult)
    {
        $payInfo = [];
        $payInfo['pay_price'] = $payResult['cash_fee']/100;
        $payInfo['pay_time'] = $payResult['time_end'];
        $payInfo['pay_order_id'] = $payResult['transaction_id'];
        $payInfo['order_no'] = $payResult['out_trade_no'];
        $payInfo['pay_type'] = 'wechat';
        $payInfo['callback_data'] = json_encode($payResult);
        $this->payResult = $payInfo;
    }
}