<?php
namespace app\index\controller;
use think\Input;
use think\Controller;
use think\captcha\Captcha;
class Login extends Controller{
    public function login(){
        return $this->fetch();
    }

    public function register(){
        return $this->fetch('login/register');
    }

    public function registercheck(){
        $name = input('post.name');
        $password = input('post.password');
        $password1 = input('post.password1');
        $sex = input('post.sex');
        $email = input('post.email');
        $data = input('post.captcha');

        $isexist = \app\index\model\Login::search($name);
        if($isexist){
            return ['msg'=>'该用户已存在','status'=>'0'];
        }else if(!captcha_check($data)){
            return ['msg'=>'验证码错误','status'=>'0'];
        }else{
            $insert = \app\index\model\Login::adduser($name,$password,$sex,$email);
            if($insert){
                return ['msg' => '注册成功','status' => '1'];
            }
        }
    }

    public function logincheck(){
        $name = input('post.name');
        $password = input('post.password');
        $data = input('post.captcha');

        $check=\app\index\model\Login::login($name, $password);
        if (!$check) {
            return ["msg" => "用户名或密码错误" , "status" => "0"];
        }else if(!captcha_check($data)){
            return ["msg" => "验证码错误" , "status" => "0"];
        }else{
            return ["msg" => "登录成功" , "status" => "1"];
        }
    }

    public function logout(){
        \app\index\model\Login::logout();

        if (!session('?ext_user')) {
            header(strtolower("location: /"));
            exit();
        }
        return NULL;
    }

    public function changepwd(){
        if (!session('?ext_user')) {
            header(strtolower("location: /"));
            exit();
        }
        return $this->fetch("changepwd");
    }

    public function changepassword(){
        $oldpassword = md5(input('post.oldpwd'));
        $newpassword  = input('post.newpwd');
        $newpassword1  = input('post.newpwd1');
        $name=session('ext_user')['uname'];
        $changepwd=\app\index\model\Login::search($name);
        $password=$changepwd['password'];
        if ($password==$oldpassword ) {
            if ($newpassword==$newpassword1) {
                $updatepassword=\app\index\model\Login::updatepassword($name,$newpassword);
                if ($updatepassword) {
                    session("ext_user", NULL);
                    return ["msg" => "修改密码成功，请重新登录" , "status" => "0"];
                }else{
                    return ["msg" => "修改密码失败" , "status" => "1"];
                }
            }else{
                return ["msg" => "两次新密码输入不一致" , "status" => "1"];
            }
        }else{
            return ["msg" => "原密码输入错误" , "status" => "1"];
        }
    }
}