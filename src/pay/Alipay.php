<?php

namespace mpayment\pay;

use Yansongda\Pay\Pay;
use Yansongda\Pay\Log;

class Alipay implements BasePay
{

/*    protected $config2 = [
        'app_id' => '2016082000295641',
        'notify_url' => 'http://yansongda.cn/notify.php',
        'return_url' => 'http://yansongda.cn/return.php',
        'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAuWJKrQ6SWvS6niI+4vEVZiYfjkCfLQfoFI2nCp9ZLDS42QtiL4Ccyx8scgc3nhVwmVRte8f57TFvGhvJD0upT4O5O/lRxmTjechXAorirVdAODpOu0mFfQV9y/T9o9hHnU+VmO5spoVb3umqpq6D/Pt8p25Yk852/w01VTIczrXC4QlrbOEe3sr1E9auoC7rgYjjCO6lZUIDjX/oBmNXZxhRDrYx4Yf5X7y8FRBFvygIE2FgxV4Yw+SL3QAa2m5MLcbusJpxOml9YVQfP8iSurx41PvvXUMo49JG3BDVernaCYXQCoUJv9fJwbnfZd7J5YByC+5KM4sblJTq7bXZWQIDAQAB',
        // 加密方式： **RSA2**
        'private_key' => 'MIIEpAIBAAKCAQEAs6+F2leOgOrvj9jTeDhb5q46GewOjqLBlGSs/bVL4Z3fMr3p+Q1Tux/6uogeVi/eHd84xvQdfpZ87A1SfoWnEGH5z15yorccxSOwWUI+q8gz51IWqjgZxhWKe31BxNZ+prnQpyeMBtE25fXp5nQZ/pftgePyUUvUZRcAUisswntobDQKbwx28VCXw5XB2A+lvYEvxmMv/QexYjwKK4M54j435TuC3UctZbnuynSPpOmCu45ZhEYXd4YMsGMdZE5/077ZU1aU7wx/gk07PiHImEOCDkzqsFo0Buc/knGcdOiUDvm2hn2y1XvwjyFOThsqCsQYi4JmwZdRa8kvOf57nwIDAQABAoIBAQCw5QCqln4VTrTvcW+msB1ReX57nJgsNfDLbV2dG8mLYQemBa9833DqDK6iynTLNq69y88ylose33o2TVtEccGp8Dqluv6yUAED14G6LexS43KtrXPgugAtsXE253ZDGUNwUggnN1i0MW2RcMqHdQ9ORDWvJUCeZj/AEafgPN8AyiLrZeL07jJz/uaRfAuNqkImCVIarKUX3HBCjl9TpuoMjcMhz/MsOmQ0agtCatO1eoH1sqv5Odvxb1i59c8Hvq/mGEXyRuoiDo05SE6IyXYXr84/Nf2xvVNHNQA6kTckj8shSi+HGM4mO1Y4Pbb7XcnxNkT0Inn6oJMSiy56P+CpAoGBAO1O+5FE1ZuVGuLb48cY+0lHCD+nhSBd66B5FrxgPYCkFOQWR7pWyfNDBlmO3SSooQ8TQXA25blrkDxzOAEGX57EPiipXr/hy5e+WNoukpy09rsO1TMsvC+v0FXLvZ+TIAkqfnYBgaT56ku7yZ8aFGMwdCPL7WJYAwUIcZX8wZ3dAoGBAMHWplAqhe4bfkGOEEpfs6VvEQxCqYMYVyR65K0rI1LiDZn6Ij8fdVtwMjGKFSZZTspmsqnbbuCE/VTyDzF4NpAxdm3cBtZACv1Lpu2Om+aTzhK2PI6WTDVTKAJBYegXaahBCqVbSxieR62IWtmOMjggTtAKWZ1P5LQcRwdkaB2rAoGAWnAPT318Kp7YcDx8whOzMGnxqtCc24jvk2iSUZgb2Dqv+3zCOTF6JUsV0Guxu5bISoZ8GdfSFKf5gBAo97sGFeuUBMsHYPkcLehM1FmLZk1Q+ljcx3P1A/ds3kWXLolTXCrlpvNMBSN5NwOKAyhdPK/qkvnUrfX8sJ5XK2H4J8ECgYAGIZ0HIiE0Y+g9eJnpUFelXvsCEUW9YNK4065SD/BBGedmPHRC3OLgbo8X5A9BNEf6vP7fwpIiRfKhcjqqzOuk6fueA/yvYD04v+Da2MzzoS8+hkcqF3T3pta4I4tORRdRfCUzD80zTSZlRc/h286Y2eTETd+By1onnFFe2X01mwKBgQDaxo4PBcLL2OyVT5DoXiIdTCJ8KNZL9+kV1aiBuOWxnRgkDjPngslzNa1bK+klGgJNYDbQqohKNn1HeFX3mYNfCUpuSnD2Yag53Dd/1DLO+NxzwvTu4D6DCUnMMMBVaF42ig31Bs0jI3JQZVqeeFzSET8fkoFopJf3G6UXlrIEAQ==',
        'log' => [ // optional
            'file' => './logs/alipay.log',
            'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
            'type' => 'single', // optional, 可选 daily.
            'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
        ],
        'http' => [ // optional
            'timeout' => 5.0,
            'connect_timeout' => 5.0,
            // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
        ],
        'mode' => 'dev', // optional,设置此参数，将进入沙箱模式
    ];*/

    protected $config = [
        'app_id' => '2019090366860330',
        'notify_url' => 'http://linco.uzipm.com/payment/notifyAlipay',
        //'return_url' => 'http://linco.uzipm.com/return.php',
        'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAka7IpUdbaJdqPdmb8Hbs+q6BapdE+S+iox0ULVpD4HqGJTezBFeVnwqsSV6Z3dEX0q1TD5PTiooZ5KUxSj6Mr32su/zNy0OVFir5LUh9IC5v6Jd7KVVM96tAPlS/KBAoWIJFvQpQbT4Gusby2nGTMa7jmCU6mLxEYa1F2b7pK+zcjFpYYwtHycVXaB6SBoTOzDoB91quSXJ6RwxrORe6mE6oPNIvYKokI6RjeABlfHz3T8NmWVtkikHNiydKhIJo66AJ88Lmlg3ysdSn1y01FUbPAwXxZZbsBcYp/mBo92i6bqSkkIdwiaHN3fEKALmZtmK/Yz7UXU8R8U0i57/YWwIDAQAB',
        // 加密方式： **RSA2**
        'private_key' => 'MIIEogIBAAKCAQEAivuFwx3WkDjiy3DB3+TL30swEWoYeA2uHqLVpMkHFhEyYNFDH/3ba/15JjeWcPZ5iTSOZAr27CPxSJcBq1BikBbAOPq+P1DcBGWPIYXSw1TxjBKcWhSvZrXF3vEkoveqK9WpJB6l70M6LJlwpg1r6gTzFPiObJT31A0vTSTL1at9zZu4zZWy95tkNPmEe8HFbbu3Vw1NgApoxnsuOtMjta0+3Pm6zoeRnt9dddVyatJjSuV7fy90tjkjk69OXwGfhZgtGHzz0cON3DpQR9FgV9b7fHt02B9IiETha/pFpJzAW5PMVwH/gYlXk4QvDzqhxaUsSSVcRaROFpdn9gu3QwIDAQABAoIBACBSOBxVLxXhNNUNBvlTkxn9uVMDcmdQ/yI+yiKFYbF/FFExuUOSXNnzW55IpSLmHwOKhma7qgrmnPE9tPSrQBC0ScW2glHlMxWOrMemAIrOkVH67gOA9f2T3k1nlRaVNCz3hltRCVPoNXozwN/NFUCaIBHLcAvOZQgafNqa6RBqdemF61uH8Pngxj65SmmU2XQAXEkhOLWw/XISWVdHPWGozyowUKFKUTBt/aYukTRAlgOfWRwqrOu1h200WSUuGFWWPr205DzBtudUl3aqyDfnNeArRDGeHbApG3Vdo9quhHtyeDHRjk2UV17WJBZFiw7jDYkhxeWnX/iYmY+2OIECgYEA1iTxLFlnkSzbLYFu0NhNZOvWFsANpQoai3RG/7ntfVPKijiNLTxLxRZ6eGGzGG2jnTqSzyXlsRf1rtb4baFGE+eLf63+Jwg/yO5BgG+YNQ1lXPCJAaVCHlqwqNNs/6vFNdZAq33VkHkoC7XNKQJZnq8fBYnFHqjCkFEHxY6W2kECgYEApiW87SU68H8V4BJmr+Ub38Mwc8SLBhZm3he81V6BF9z8cPfP5G8hETPNa4RvFvBv/b3cgyM5DMMGLdNX63LZMyu4hRrAEsBx/LYDcp44R+JdGOv406GMs/Ug3fgfvNq4E/PqaALzjsbCzXeZPoOjdoq9PN2nxxqvbKTH6vYICIMCgYB7xi5/680o5DxrOPzMSbmyM34y+B7q3cQqBrNi7ByQ6/WNntI66zcAW9W97vqNjBGdt1VT1hvFGIww2qAM/cJ7jsHasr7L4MC9arkBe38Gaw/DgGQwR0zILrMdYdcGkEoUrBoFBV6DewPigNpscadLSP0tPkxpRDHxKGTNk3UuAQKBgCDzvyKxjZ0BN493VtJv+DVK+yMayg/tBX3q61LOKYBYHeEx5RODTuWgho9adsXv7eY/b6q6o6f6ThFspzVVU+qoMzKC+bE+Zd0fJFPpOXRYWuqEcpdWpRdT+K7NdU35eyTJ7aWvYCrjFOO3YrdZWGQ8ZAfcVlhQ3JYJoHTjUviNAoGAUH/cIHuQXph1s8SVyCkcjoOTVSlVjUe5TSfzgUBqY3YkE21jzHPZ34cbBykSweYzLaQOyUTgvhUlt4eiIPDRBABUBDwy+PouRlhVmyi3wxf+F+BsH8ngYu2MGkaHmPEsuQIfZXckU+CYvcILb3hG33SriPkZGNzHVkbw9RKbXp0=',
        'log' => [ // optional
            'file' => './logs/alipay.log',
            'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
            'type' => 'single', // optional, 可选 daily.
            'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
        ],
        'http' => [ // optional
            'timeout' => 5.0,
            'connect_timeout' => 5.0,
            // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
        ],
        'mode' => 'dev', // optional,设置此参数，将进入沙箱模式
    ];

    public function pay($order)
    {
        $payParam = [];
        $payParam['out_trade_no'] = $order['order_no'];
        //$payParam['total_amount'] = $order['pay_price'];
        $payParam['total_amount'] = 0.01;
        $payParam['subject'] = !empty($order['title'])? $order['title'] :'零酷';
        //$alipay = Pay::alipay($this->config)->web($order);
        //$alipay = Pay::alipay($this->config)->wap($order);
        $alipay = Pay::alipay($this->config)->app($payParam);
        return $alipay->getContent();

        return $alipay->send();// laravel 框架中请直接 `return $alipay`
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

        return true;

        $payOrder['out_trade_no'] = $order['order_no']; //商户系统内部订单号
        $payOrder['out_refund_no'] = $order['order_no']; //商户系统内部的退款单号
        $payOrder['total_fee'] = $order['pay_price']*100;
        $payOrder['refund_fee'] = $order['pay_price']*100;

        $payParam = [];
        $payParam['out_trade_no'] = $order['order_no'];
        $payParam['total_amount'] = $order['pay_price'];
        //$payParam['total_amount'] = 0.01;
        $payParam['subject'] = $order['title'];

        $data = Pay::alipay($this->config)->refund($payParam);
    }



}