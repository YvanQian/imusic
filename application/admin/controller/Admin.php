<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;

class Admin extends Controller{
    public function admin(){
        if (!session('?ext_user')) {
            header(strtolower("location: /adminlogin"));
            exit();
        }
        return $this->fetch();
    }

//    退出登录
    public function logout(){
        \app\admin\model\Admin::logout();

        if (!session('?ext_user')) {
            header(strtolower("location: /adminlogin"));
            exit();
        }
        return NULL;
    }
//    修改密码页面
    public function changepwd(){
        if (!session('?ext_user')) {
            header(strtolower("location: /adminlogin"));
            exit();
        }
        return $this->fetch("operate/changepwd");
    }

    public function changepassword(){
        $oldpassword = md5(input('post.oldpwd'));
        $newpassword  = input('post.newpwd');
        $newpassword1  = input('post.newpwd1');
        $name=session('ext_user')['name'];
        $changepwd=\app\admin\model\Admin::search($name);
        $password=$changepwd['password'];
        if ($password==$oldpassword ) {
            if ($newpassword==$newpassword1) {
                $updatepassword=\app\admin\model\Admin::updatepassword($name,$newpassword);
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

    public function info(){
        return $this->fetch('list/info');
    }
}