<?php

namespace App\Http\Controllers\Model;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserModel extends Controller
{
    public static function curlPost($url,$data)
    {
        //初始化
        $ch = curl_init();
        // 设置参数
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        //执行会话
        $response = curl_exec($ch);
        //关闭会话
        curl_close($ch);
        return $response;
    }
}
