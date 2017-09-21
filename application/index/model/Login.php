<?php
namespace app\index\model;

use think\Db;
use think\Input;

class Login extends \think\Model{
    /*登录验证*/
    public static function login($name, $password)
    {
        $where['uname'] = $name;
        $where['password'] = md5($password);

        $user = Db::table('user')->where($where)->find();
        if ($user) {
            unset($user["password"]);
            session("ext_user", $user);
            return true;
        }else{
            return false;
        }
    }

    /*退出登录*/
    public static function logout(){
        session("ext_user", NULL);
        return ;
    }

    /*查询一条数据*/
    public static function search($name){
        $where['uname'] = $name;
        $user=Db::table('user')->where($where)->find();
        return $user;
    }

    /*更改用户密码*/
    public static function updatepassword($name,$newpassword){
        $where['uname'] = $name;
        $user=Db::table('user')->where($where)->update(['password' => md5($newpassword)]);
        if ($user) {
            return true;
        }else{
            return false;
        }
    }

    /*添加用户*/
    public static function adduser($name,$password,$sex,$email){
        $data['uname'] = $name;
        $data['password'] = md5($password);
        $data['sex'] = $sex;
        $data['email'] = $email;
        $data['regdate'] = date('y-m-d H:i:s',time());
        $data['uid'] = 'YH'.uniqid();
        $Isinsert = Db::table('user')->insert($data);
        if($Isinsert){
            return true;
        }else{
            return false;
        }
    }
}