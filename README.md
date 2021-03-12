tax sdk



安装方法：

```
composer require rrbrr/taxsdk
```
使用方法


```php

//加密
$security = \taxsdk\security\SecurityHelper::type("rsa")->setPublicKey($public);
$ciphertext = $security->encrypt("tax");


//解密
$security = \taxsdk\security\SecurityHelper::type("rsa")->setPrivateKey($private);
echo $security->decrypt($ciphertext); //输出原文 tax


//签名
$security = \taxsdk\security\SecurityHelper::type("rsa")->setPrivateKey($private);
$sign = $security->generateSign(['a'=>'b',"sign"=>""]);
        

//校验签名
$security = \taxsdk\security\SecurityHelper::type("rsa")->setPublicKey($public);
$r = $security->check(['a'=>'b',"sign"=>$sign],$sign);
var_dump($r); //输出 true

```


生成私钥
openssl genrsa -out private.key 1024 
 
生成私钥
openssl rsa -in private.key -pubout -out public.key 
 