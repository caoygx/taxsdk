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
 
生成公钥  
openssl rsa -in private.key -pubout -out public.key 


测试秘钥
```php
$public = '-----BEGIN PUBLIC KEY-----
          MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC7V1Rzu6K7hAj3/5xUCel4g8bH
          WUDXuvVFC6nIQzndAEJSeam9y1BDcoD4jbvRZqjh8EjWoWS6kvmQeSlgJHGOI0EP
          VMyOGokQ0FSJ/jyv8JBYFoQ2KZwRrJjfxy1KI6AdSLScLzzeZsSuZ8SFZnr1Mcrc
          nRBNHLTnwuqGEcB8IwIDAQAB
          -----END PUBLIC KEY-----';
          
$private = '-----BEGIN RSA PRIVATE KEY-----
           MIICWwIBAAKBgQC7V1Rzu6K7hAj3/5xUCel4g8bHWUDXuvVFC6nIQzndAEJSeam9
           y1BDcoD4jbvRZqjh8EjWoWS6kvmQeSlgJHGOI0EPVMyOGokQ0FSJ/jyv8JBYFoQ2
           KZwRrJjfxy1KI6AdSLScLzzeZsSuZ8SFZnr1McrcnRBNHLTnwuqGEcB8IwIDAQAB
           AoGAWfzA3DatHFV32Wg2t0drli/2M5tzwixT1C6eB0wDZ1zQfr1iA4C9tSgzOzEZ
           nqQpSx4YXsB3mgcvSW5pqXzX7hKtKcss36TNXogr/Rvkn61IiyRqa9ApT8AVQtBi
           qNwBzdYPH7vjH3BbIizN46tdQyW3VT7QEzJ1hEMzz/U860ECQQD2xqSlCnQ1evKn
           okYk2lCulf2JZ0NL3HUVM/m2hNeqhyNGjYgxD3rEVW01bA5qnrn/Or1HFO4uiE7/
           I7d2AOjFAkEAwlf3E8MN2HVWIM3ObAJRlIihW7B/G8V3sU+qnzgEqtg6znT4MGDS
           h1mR7uF4qkVgMNnwLzrJBJz1/GAvqkgPxwJATsAhdpGZeB+eJCTC4avRp4Ux/ZE4
           hpL5wiRuAfLup/qsJS2xUoawFMt2KGAtUZUJogtqr65cO/k/zGfnef7cSQJAIzbT
           M0Z9pMImGA2SoKmO5K4ZJscFUR/nvz4jOXRqDBbgGPbC3ek9XH8TXUiHl7q4YkGr
           LrOlJuvV+qPnHyCtkwJAD85NcVb+LHYl7TaQYQoW7NQHXt9dGdEjAnMdOYsojvme
           wkobojEQ6XSOTswlQprjo6u0UYfwArKHRGq+AkMMag==
           -----END RSA PRIVATE KEY-----';
```
 