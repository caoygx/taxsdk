<?php
namespace taxsdk\security;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/3/12
 * Time: 11:27
 */
class Rsa implements Security
{
    public  $publicKey = "";
    public $privateKey = "";

    public $postCharset = "UTF-8";
    private $fileCharset = "UTF-8";


    /**
     * @param string $publicKey
     */
    public function setPublicKey($publicKey)
    {
        $this->publicKey = $publicKey;
        return $this;
    }

    /**
     * @param string $privateKey
     */
    public function setPrivateKey($privateKey)
    {
        $this->privateKey = $privateKey;
        return $this;
    }

    public function encrypt($text)
    {
        //公钥解密
        $public_key = openssl_pkey_get_public($this->publicKey);
        if(!$public_key){
            die('公钥不可用');
        }
        $return_en = openssl_public_encrypt($text, $ciphertext, $public_key);
        if(!$return_en){
            return('加密失败,请检查RSA秘钥');
        }
        $ciphertextBase64 = base64_encode($ciphertext);
        return $ciphertextBase64;
    }

    public function decrypt($ciphertext)
    {

        //私钥加密
        $private_key = openssl_pkey_get_private($this->privateKey);
        if(!$private_key){
            die('私钥不可用');
        }
        $return_de = openssl_private_decrypt(base64_decode($ciphertext), $decrypted, $private_key);
        if(!$return_de){
            return('解密失败,请检查RSA秘钥');
        }
        return $decrypted;


    }

    /**
     * 校验$value是否非空
     *  if not set ,return true;
     *    if is null , return true;
     **/
    protected function checkEmpty($value) {
        if (!isset($value))
            return true;
        if ($value === null)
            return true;
        if (trim($value) === "")
            return true;

        return false;
    }

    public function generateSign($params) {
        return $this->sign($this->getSignContent($params));
    }

    public function check($params) {
        $sign = $params['sign'];
        $params['sign'] = null;
        return $this->verify($this->getSignContent($params), $sign);
    }

    protected function getSignContent($params) {
        ksort($params);

        $stringToBeSigned = "";
        $i = 0;
        foreach ($params as $k => $v) {
            if (false === $this->checkEmpty($v) && "@" != substr($v, 0, 1)) {

                // 转换成目标字符集
                $v = $this->characet($v, $this->postCharset);

                if ($i == 0) {
                    $stringToBeSigned .= "$k" . "=" . "$v";
                } else {
                    $stringToBeSigned .= "&" . "$k" . "=" . "$v";
                }
                $i++;
            }
        }

        unset ($k, $v);
        return $stringToBeSigned;
    }

    public function sign($data, $signType = "RSA") {
        $res = openssl_get_privatekey($this->privateKey);
        ($res) or die('您使用的私钥格式错误，请检查RSA私钥配置');
        openssl_sign($data, $sign, $res, OPENSSL_ALGO_SHA256);
        openssl_free_key($res);
        $sign = base64_encode($sign);
        return $sign;
    }

    function verify($data, $sign) {
        $res = openssl_get_publickey($this->publicKey);
        ($res) or die('支付宝RSA公钥错误。请检查公钥文件格式是否正确');
        $result = (bool)openssl_verify($data, base64_decode($sign), $res, OPENSSL_ALGO_SHA256);
        openssl_free_key($res);
        return $result;
    }

    function characet($data, $targetCharset) {

        if (!empty($data)) {
            $fileType = $this->fileCharset;
            if (strcasecmp($fileType, $targetCharset) != 0) {
                $data = mb_convert_encoding($data, $targetCharset, $fileType);
                //				$data = iconv($fileType, $targetCharset.'//IGNORE', $data);
            }
        }


        return $data;
    }

}