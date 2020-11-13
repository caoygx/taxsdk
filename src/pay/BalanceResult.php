<?php
namespace mpayment\pay;
class BalanceResult{
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
        $this->payResult = $payResult;
        //return $payInfo;
    }

}