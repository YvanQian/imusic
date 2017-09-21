<?php
namespace app\admin\model;
use think\Db;
use think\Input;

class Admin extends \think\Model
{
    /*登录验证*/
    public static function login($name, $password)
    {
        $where['name'] = $name;
        $where['password'] = md5($password);

        $user = Db::table('admin')->where($where)->find();
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
        $where['name'] = $name;
        $user=Db::table('admin')->where($where)->find();
        return $user;
    }

    /*更改用户密码*/
    public static function updatepassword($name,$newpassword){
        $where['name'] = $name;
        $user=Db::table('admin')->where($where)->update(['password' => md5($newpassword)]);
        if ($user) {
            return true;
        }else{
            return false;
        }
    }

}
