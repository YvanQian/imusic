<?php
namespace app\admin\model;
use think\Db;
use think\Input;

class User extends \think\Model{
    //查询所有用户数据
    public static function showusers(){
        $lists = Db::table('user');
        return $lists;
    }

    //通过id查询单条用户数据
    public static function searchuser($id){
        $where['id'] = $id;
        $user = Db::table('user')->where($where)->select();
        return $user;
    }

    //通过name查询单条用户数据
    public static function search($name){
        $where['uname'] = $name;
        $user=Db::table('user')->where($where)->find();
        return $user;
    }


    //添加用户
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

    //删除用户
    public static function deluser($id){
        $Isdel = Db::table('user')->where('id','in',$id)->delete();
        if($Isdel){
            return true;
        }else{
            return false;
        }
    }

    //修改用户
    public static function updateuser($id,$name,$password,$sex,$email){
        $where['id'] = $id;
        $Isupdate = Db::table('user')->where($where)->update(['uname'=>$name,'password'=>md5($password),'sex'=>$sex,'email'=>$email]);
        if($Isupdate){
            return true;
        }else{
            return false;
        }
    }
}