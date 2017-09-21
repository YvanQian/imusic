<?php
namespace app\admin\controller;
use think\Input;
use think\Controller;
use Captcha;

class Login extends Controller{
    public function login(){
        return $this->fetch();
    }

    public function logincheck(){
        $name = input('post.name');
        $password = input('post.password');
        $data = input('post.captcha');

        $check=\app\admin\model\Admin::login($name, $password);
        if (!$check) {
            return ["msg" => "用户名或密码错误" , "status" => "0"];
        }else if(!captcha_check($data)){
            return ["msg" => "验证码错误" , "status" => "0"];
        }else{
            return ["msg" => "登录成功" , "status" => "1"];
        }
    }
}