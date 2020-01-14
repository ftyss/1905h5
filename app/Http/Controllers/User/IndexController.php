<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cookie;

class IndexController extends Controller
{
    public function reg()
    {
        return view('user.reg');
    }

    /**
     * 用户注册
     */
    public function doReg()
    {
        unset($_POST['_token']);
        // echo '<pre>';print_r($_POST);echo '</pre>';
        //请求passport注册
        $url = 'http://passport1905.com/api/user/reg';
        $client = new Client();
        $response = $client->request('post',$url,[
            'form_params'   => $_POST
        ]);
        $json_data = $response->getBody();
        $info = json_decode($json_data,true);
        // echo '<pre>';print_r($info);echo '</pre>';
        //判断结果
        if($info['errno']){
            header('Refresh:2;url=/user/reg');            //页面跳转
            // echo "错误信息：" . $info['msg'] . " 正在跳转>>>>";
            // die;
        }else{
            header('Refresh:2;url=/user/login'); 
        }
    }


     //登录
     public function login()
     {
         return view('user.login');
     }


     /**
     * 登录
     */
    public function doLogin()
    {
        unset($_POST['_token']);
        //echo '<pre>';print_r($_POST);echo '</pre>';
        $url = 'http://passport1905.com/api/user/login';
        $client = new Client();
        $response = $client->request('post',$url,[
            'form_params'   => $_POST
        ]);
        $json_data = $response->getBody();
        $info = json_decode($json_data,true);
        //echo '<pre>';print_r($info);echo '</pre>';
        //判断结果
        if($info['errno']){
            //header('Refresh:2;url=/user/reg');            //页面跳转
            echo "错误信息：" . $info['msg'] . " 正在跳转>>>>";
            die;
        }
        $uid = $info['data']['uid'];
        $token = $info['data']['token'];
        //将 token 保存至 客户端 cookie 中
        Cookie::queue('token',$token,600);
        Cookie::queue('uid',$uid,600);
        //登录成功
        header('Refresh:2;url=/user/center');
        echo "登录成功，正在跳转至个人中心";
    }


    /**
     * 个人中心
     */
    public function center()
    {
        $token = Cookie::get('token');
        $uid = Cookie::get('uid');
        if(empty($token) || empty($uid)){
            header('Refresh:2;url=/user/login');
            echo "请先登录, 页面跳转中";
            die;
        }
        //请求passport 鉴权
        $url = 'http://passport1905.com/api/auth';
        $client = new Client();
        $response = $client->request('post',$url,[
            'form_params'   => ['uid'=>$uid,'token'=>$token]
        ]);
        $json_data = $response->getBody();
        $info = json_decode($json_data,true);
        //echo '<pre>';print_r($info);echo '</pre>';
        if($info['errno'])
        {
            echo "错误信息： ". $info['msg'];
            die;
        }
        //个人中心
        echo "欢迎来到个人中心";
    }
}
