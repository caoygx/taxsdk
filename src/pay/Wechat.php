<?php

namespace mpayment\pay;

use Yansongda\Pay\Pay;
use Yansongda\Pay\Log;

class Wechat implements BasePay
{

    protected $config = [
        'appid' => 'wxc1b45b5a936aa15e', // APP APPID
        'app_id' => 'wx615ee8269a321268', // 公众号 APPID
        'miniapp_id' => 'wx523d2d2cbcce80d9', // 小程序 APPID
        'mch_id' => '1534657661',
        'key' => 'quh5qmvd5hdgvh2tbtm214exr3tpicms',
        'notify_url' => 'http://linco.uzipm.com/payment/notifyWechat',
        'cert_client' => './cert/apiclient_cert.pem', // optional，退款等情况时用到
        'cert_key' => './cert/apiclient_key.pem',// optional，退款等情况时用到
        'log' => [ // optional
            'file' => './logs/wechat.log',
            'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
            'type' => 'single', // optional, 可选 daily.
            'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
        ],
        'http' => [ // optional
            'timeout' => 5.0,
            'connect_timeout' => 5.0,
            // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
        ],
        //'mode' => 'dev', // optional, dev/hk;当为 `hk` 时，为香港 gateway。
    ];


    public function pay($order)
    {
        $payParam = [];
        //$payParam['total_fee'] = $order['pay_price']*100;
        $payParam['total_fee'] = 1;
        $payParam['out_trade_no'] = $order['order_no'];
        //$payParam['body'] = $order['title'];
        $payParam['body'] = '零酷';
        //$payParam['body'] = !empty($order['title'])? $order['title'] :'购物';
        if($order['channel'] == 'miniapp'){
            $payParam['openid'] = $order['openid'];
            $pay = Pay::wechat($this->config)->miniapp($payParam);
            return $pay->all();
        }else{
            $pay = Pay::wechat($this->config)->app($payParam);
            return json_decode($pay->getContent());
        }


        // $pay->appId
        // $pay->timeStamp
        // $pay->nonceStr
        // $pay->package
        // $pay->signType
    }

    public function return(){

    }

    public function notify($class,$method)
    {
        $pay = Pay::wechat($this->config);

        //try{
            $data = $pay->verify(); // 是的，验签就这么简单！
            call_user_func_array([$class, $method], [$data->all()]);
            Log::debug('Wechat notify', $data->all());
        //} catch (\Exception $e) {
            // $e->getMessage();
        //}

        return $pay->success()->send();// laravel 框架中请直接 `return $pay->success()`
    }

    public function refund($order){

        $payParam = [];
        $payParam['total_fee'] = $order['pay_price']*100;
        //$payParam['total_fee'] = 1;
        $payParam['out_trade_no'] = $order['order_no'];
        $payParam['body'] = '零酷';

        $data = Pay::wechat($this->config)->refund($order);
    }

}