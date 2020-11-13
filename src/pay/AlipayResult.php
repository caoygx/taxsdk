<?php
namespace mpayment\pay;
class AlipayResult{
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
        $payInfo['pay_price'] = $payResult['total_amount'];
        $payInfo['pay_time'] = $payResult['gmt_create'];
        $payInfo['pay_order_id'] = $payResult['trade_no'];
        $payInfo['order_no'] = $payResult['out_trade_no'];
        $payInfo['pay_type'] = 'alipay';
        $payInfo['callback_data'] = json_encode($payResult);
        $this->payResult = $payInfo;
        //return $payInfo;
    }

}