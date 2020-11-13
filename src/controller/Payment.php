<?php

namespace mpayment\controller;

use Cgf\Framework\Thinkphp\BaseController;
use morder\model\Order;
use mpayment\model\Recharge;
use mpayment\pay\Refund;
use mpayment\payment\Alipay;
use mpayment\payment\BasePay;
use mpayment\pay\PayFactory;
use mpayment\Request;
use think\helper\Str;
use mpayment\pay\{AlipayResult,WechatResult};
use mpayment\service\OrderService;


class Payment extends BaseController
{
    public $autoInstantiateModel=false;
    /** @var  BasePay */
    protected $payMethod;

    function initialize()
    {
        //$method = 'Wechat';
        //$method = 'Alipay';
        $pay_type = input('pay_type','alipay');
        $this->payMethod = PayFactory::getInstance($pay_type);
        //var_dump($this->payMethod);exit;
    }

    public function pay()
    {
        $order_no = input('order_no');
        $pay_type = input('pay_type');
        $channel = input('channel');
        $rOrder = $this->getOrderInfo($order_no);
        $rOrder['channel'] = $channel;

        if($pay_type == 'balance'){
            $this->getAuth();
            if(empty($this->uid)) return $this->error('未登录');
            $rOrder['uid'] = $this->uid;
        }elseif ($channel == 'miniapp'){
            $this->getAuth();
            if(empty($this->uid)) return $this->error('未登录');
            $rOrder['openid'] = $this->user['openid'];
        }
        $r = $this->payMethod->pay($rOrder);
        $this->assign('pay_info',$r);
        return $this->toview();
    }

    function getOrderInfo($order_no){

        if(substr($order_no,0,2) == 'ch'){ //This is a recharge order
            $rOrder = Recharge::where('order_no',$order_no)->find();
        }else{
            $rOrder = Order::where('order_no',$order_no)->find();
        }
        /*$rOrder = [
            'out_trade_no' => $rOrder['order_no'],
            'total_amount' => $rOrder['pay_price'],
            'subject' => $rOrder['title'],
        ];*/
        return $rOrder;
        //return $rOrder->toArray();
    }


    public function notifyAlipay()
    {
        return PayFactory::getInstance('Alipay')->notify($this,'alipayNotify');
    }

    public function notifyWechat()
    {
        return PayFactory::getInstance('Wechat')->notify($this,'wechatNotify');
    }

    /**
     * 支付宝回调处理业务方法
     * * @param $payResutl
    $payResutl 内容如下
    array (
        'gmt_create' => '2019-11-29 18:01:10',
        'charset' => 'utf-8',
        'seller_email' => 'jay@droi.com',
        'subject' => 'test subject - 测试',
        'sign' => 'iiJhrQ3A1JVNEGUBIkyA2sWJDorlj72R+TNQ5QXuNWaN3vvStCSHqliyKClgW5RuY+5wnhWVv69Lyryyj2MfE2c0o8ZDaSqCc0ubb+uf+Yb5bVERTw0VVSynzRlJwxfenvV9HS1vXKxs6XlHHBSzZibziC2URXgIZdACIcAa9X6hnaItpwyEp1yi0rfwWpkn2893tyZ//biRtqNdu/kvzePwsAe3ttCkj3ZqyO+6M49Qy/rT+tCkIaVQJZAkQ2rsMX6bkZBKkTPlofPJpLw4q2mlY9Lyuma0tP5In0cy+Ugg9f/qp1KbTxMRiD3Rc3+GY3bcigl5f8zJ9vpAJbcVBg==',
        'buyer_id' => '2088802531875410',
        'invoice_amount' => '0.01',
        'notify_id' => '2019112900222180110075410575051891',
        'fund_bill_list' => '[{"amount":"0.01","fundChannel":"ALIPAYACCOUNT"}]',
        'notify_type' => 'trade_status_sync',
        'trade_status' => 'TRADE_SUCCESS',
        'receipt_amount' => '0.01',
        'app_id' => '2019090366860330',
        'buyer_pay_amount' => '0.01',
        'sign_type' => 'RSA2',
        'seller_id' => '2088011354228910',
        'gmt_payment' => '2019-11-29 18:01:10',
        'notify_time' => '2019-11-29 18:01:11',
        'version' => '1.0',
        'out_trade_no' => '1575021662',
        'total_amount' => '0.01',
        'trade_no' => '2019112922001475410569848381',
        'auth_app_id' => '2019090366860330',
        'buyer_logon_id' => 'wei***@qq.com',
        'point_amount' => '0.00',
    ),
     */
    /**
    POST http://linco.uzipm.com/payment/notifyAlipay HTTP/1.1
    Content-Length: 1085
    Host: linco.uzipm.com
    Content-Type: application/x-www-form-urlencoded; charset=utf-8
    User-Agent: Mozilla/4.0

    gmt_create=2019-11-29+18%3A01%3A10&charset=utf-8&seller_email=jay%40droi.com&subject=test+subject+-+%E6%B5%8B%E8%AF%95&sign=a2v6n7b2ogk%2FZ6ieuXXncDnKqMTDf7%2BrFcDSKpOKK1ImfkYelB0KdJE%2BYmc8INoWJGl6vvXhJ641P4f%2BNRd0TtAy5FvOKR45NzkX%2F9U9GSTV2NUvNS1EixW6wMlqlKsDkT%2FVZFc%2FlevcVhsX7uzdTQA72iXuHhfqBdklw%2Bh9XEaMRlsgyZ8MlL7yrRE48UUMR7e2cPHKDzm4Tf9QSPdRoBQorw0Ef5O%2B%2FUVdzcSsxKchnqj4zAtATgKBnEJgsDwL3PoPF9q2ikQ5iUo0tApojdvrSgIr5cbEV3ROKCCYigq1WCJ3OPqSs3aAvN4ha9OtEBdMEI63lVBzozftflVTNQ%3D%3D&buyer_id=2088802531875410&invoice_amount=0.01&notify_id=2019112900222180110075410575051891&fund_bill_list=%5B%7B%22amount%22%3A%220.01%22%2C%22fundChannel%22%3A%22ALIPAYACCOUNT%22%7D%5D&notify_type=trade_status_sync&trade_status=TRADE_SUCCESS&receipt_amount=0.01&app_id=2019090366860330&buyer_pay_amount=0.01&sign_type=RSA2&seller_id=2088011354228910&gmt_payment=2019-11-29+18%3A01%3A10&notify_time=2019-11-29+18%3A04%3A23&version=1.0&out_trade_no=1575021662&total_amount=0.01&trade_no=2019112922001475410569848381&auth_app_id=2019090366860330&buyer_logon_id=wei%2A%2A%2A%40qq.com&point_amount=0.00
     */
    function alipayNotify($alipayResult){
        $payResult = (new AlipayResult($alipayResult))->getPayResult();
            //$payResult['order_no'] = 'ch'.$payResult['order_no']; //debug
        if(substr($payResult['order_no'],0,2) == 'ch'){ //This is a recharge order
            //充值回调处理
            $this->rechargeCallback($payResult);
        }else{
            //订单回调处理
            $this->orderCallback($payResult);
        }
    }


    /**
     * 微信回调处理
     * @param $payResutl
     */
    /*
POST http://www.linco.com/payment/notifyWechat HTTP/1.1
Content-Type: text/xml
User-Agent: Mozilla/4.0
Host: www.linco.com
Content-Length: 762
Pragma: no-cache
Connection: Keep-Alive


<xml><appid><![CDATA[wxc1b45b5a936aa15e]]></appid>
<bank_type><![CDATA[OTHERS]]></bank_type>
<cash_fee><![CDATA[1]]></cash_fee>
<fee_type><![CDATA[CNY]]></fee_type>
<is_subscribe><![CDATA[N]]></is_subscribe>
<mch_id><![CDATA[1534657661]]></mch_id>
<nonce_str><![CDATA[R6G7hSytH1EMW8hQ]]></nonce_str>
<openid><![CDATA[o4C_GwQcv0ctK8ymgIh5wzZsWjsA]]></openid>
<out_trade_no><![CDATA[2019121356485756]]></out_trade_no>
<result_code><![CDATA[SUCCESS]]></result_code>
<return_code><![CDATA[SUCCESS]]></return_code>
<sign><![CDATA[D45B633E7991FC1D51F51F9A765FE7EC]]></sign>
<time_end><![CDATA[20191213141226]]></time_end>
<total_fee>1</total_fee>
<trade_type><![CDATA[APP]]></trade_type>
<transaction_id><![CDATA[4200000455201912130858567766]]></transaction_id>
</xml>
*/
    function wechatNotify($wechatResult){
        $payResult = (new WechatResult($wechatResult))->getPayResult();
            //$payResult['order_no'] = 'ch'.$payResult['order_no']; //debug
        if(substr($payResult['order_no'],0,2) == 'ch'){ //This is a recharge order
            //充值回调处理
            $this->rechargeCallback($payResult);
        }else{
            //订单回调处理
            $this->orderCallback($payResult);
        }

    }

    /**
     * 余额回调处理,由类call_user_func调用
     * @param $payResutl
     */
    function balanceNotify($payResult){
       dump($payResult);

    }


    /**
     * 用于订单模块退款调用
     * @param $order_no
     */
    function refund($order_no){

        /*$order = [
            'order_no' => $order_no,
            'pay_price' => '0.01',
            'title' => 'test subject - 测试',
        ];*/
        //$rOrder = Order::where(['order_no'=>$order_no])->find();
        $refund = new Refund();
        $refund->refund($order_no);
    }


    private function rechargeCallback($payResult){
        $m = new \mpayment\model\OutletUser();
        /*$rOutletUser = $m->where('id',1)->inc('balance',987)->update();
        var_dump($rOutletUser);exit;*/


        $order_no = $payResult['order_no'];
        $rOrder = Recharge::where('order_no',$order_no)->where('status','<>','2')->find();
        if(empty($rOrder)) return $this->error('已经处理过');


        $rRecharge = Recharge::where('order_no',$order_no)->update(['status'=>2,'pay_order_id'=>$payResult['pay_order_id'],'pay_type'=>$payResult['pay_type']]);
        $rOutletUser = $m->where('id',$rOrder['uid'])->inc('balance', $rOrder['pay_price'])->update(); //or add balance of outlet
        if(empty($rOutletUser)) return $this->error('充值失败');
        return $this->toview();

    }

    private function orderCallback($payResult){
        $orderService = new OrderService();
        $orderService->orderPay($payResult['order_no'], $payResult['pay_price'], $payResult['pay_type'],$payResult['pay_time'], $payResult['pay_order_id']);
    }


}