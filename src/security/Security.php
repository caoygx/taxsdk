<?php

namespace taxsdk\security;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/3/12
 * Time: 11:26
 */
interface Security
{
    public function encrypt($text);
    public function decrypt($ciphertext);

}