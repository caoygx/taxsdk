<?php

namespace mpayment\pay;

use mpayment\model\Order;
use mpayment\model\OutletUser;
use think\App;
use Yansongda\Pay\Pay;
use Yansongda\Pay\Log;

class Balance implements BasePay
{

    protected $config = [
        'notify_class' => '\mpayment\pay\Notify',
        'notify_method' => 'balanceNotify',
        ];

    public function pay($order)
    {
        $payOrder = $order['order_no'];
        //$rUser = OutletUser::find($payOrder['uid']);
        $uid = $order['uid'];

        $rUser = OutletUser::find($uid);
        if($order['pay_price'] > $rUser['balance']) return ['code'=>0,'msg'=>'余额不足'];

        $rUpdate = OutletUser::where('id','=',$uid)->dec('balance',$order['pay_price'])->update();
        if(empty($rUpdate)) return ['code'=>0,'msg'=>'扣款失败'];


        $payInfo = [];
        $payInfo['pay_price'] = $order['pay_price'];
        $payInfo['pay_time'] = date('Y-m-d h:i:s');
        $payInfo['pay_order_id'] = 'b'.$order['order_no'];
        $payInfo['order_no'] = $order['order_no'];
        $payInfo['pay_type'] = 'balance';
        $payInfo['trade_status'] = 'success';
        $payInfo['callback_data'] = json_encode($payInfo);


        //回调
        $class = new $this->config['notify_class']();
        call_user_func_array([$class, $this->config['notify_method']], [$payInfo]);
        return ['code'=>1,'msg'=>'成功'];
        //return $payInfo;
    }

    public function return()
    {
        $data = Pay::alipay($this->config)->verify(); // 是的，验签就这么简单！

        // 订单号：$data->out_trade_no
        // 支付宝交易号：$data->trade_no
        // 订单总金额：$data->total_amount
    }

    public function notify($class,$method)
    {
        $alipay = Pay::alipay($this->config);

        //try{
            $data = $alipay->verify(); // 是的，验签就这么简单！
            if( in_array($data->all()['trade_status'],['TRADE_SUCCESS','TRADE_FINISHED'])){
                call_user_func_array([$class, $method], [$data->all()]); //调用订单成功处理程序
            }

            // 请自行对 trade_status 进行判断及其它逻辑进行判断，在支付宝的业务通知中，只有交易通知状态为 TRADE_SUCCESS 或 TRADE_FINISHED 时，支付宝才会认定为买家付款成功。
            // 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号；
            // 2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额）；
            // 3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）；
            // 4、验证app_id是否为该商户本身。
            // 5、其它业务逻辑情况

            Log::debug('Alipay notify', $data->all());
        //} catch (\Exception $e) {
        //     echo $e->getMessage();
        //}

        return $alipay->success()->send();// laravel 框架中请直接 `return $alipay->success()`
    }

    public function refund($order){
        /*$payOrder['out_trade_no'] = $order['order_no']; //商户系统内部订单号
        $payOrder['out_refund_no'] = $order['order_no']; //商户系统内部的退款单号
        $payOrder['total_fee'] = $order['pay_price']*100;
        $payOrder['refund_fee'] = $order['pay_price']*100;
        $data = Pay::alipay($this->config)->refund($payOrder);*/

        //$rOrder = Order::where('order','=',$order['order_no'])->find();
        $rUpdate = OutletUser::where('id','=',$order['uid'])->inc('balance',$order['pay_price'])->update();
        return !empty($rUpdate);

    }


}