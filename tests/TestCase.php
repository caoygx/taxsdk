<?php

namespace mapp\tests;

use PHPUnit\Framework\TestCase as BaseTestCase;


class TestCase extends BaseTestCase{

    protected $publicKey = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC7V1Rzu6K7hAj3/5xUCel4g8bH
WUDXuvVFC6nIQzndAEJSeam9y1BDcoD4jbvRZqjh8EjWoWS6kvmQeSlgJHGOI0EP
VMyOGokQ0FSJ/jyv8JBYFoQ2KZwRrJjfxy1KI6AdSLScLzzeZsSuZ8SFZnr1Mcrc
nRBNHLTnwuqGEcB8IwIDAQAB
-----END PUBLIC KEY-----';

    protected $privateKey = '-----BEGIN RSA PRIVATE KEY-----
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

    public function testDecrypt(){
        $publicKey = $this->publicKey;
        $privateKey = $this->privateKey;

        $text = "tax";
        $security = \taxsdk\security\SecurityHelper::type("rsa")->setPublicKey($publicKey);
        $ciphertext = $security->encrypt($text);
        $security = \taxsdk\security\SecurityHelper::type("rsa")->setPrivateKey($privateKey);
        $decryptText = $security->decrypt($ciphertext); //输出原文 tax
        $this->assertEquals($text, $decryptText);



    }

    public function testSign(){
        $publicKey = $this->publicKey;
        $privateKey = $this->privateKey;

        $security = \taxsdk\security\SecurityHelper::type("rsa")->setPrivateKey($privateKey);
        $sign = $security->generateSign(['a'=>'b',"sign"=>""]);

        $security = \taxsdk\security\SecurityHelper::type("rsa")->setPublicKey($publicKey);
        $r = $security->check(['a'=>'b',"sign"=>$sign],$sign);
        $this->assertTrue($r);
    }



}