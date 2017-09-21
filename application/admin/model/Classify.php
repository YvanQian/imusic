<?php
/**
 * Created by PhpStorm.
 * User: Yvan
 * Date: 2017/4/24
 * Time: 11:44
 */
namespace app\admin\model;

use think\Model;
use think\Db;

class Classify extends Model{
    public static function showClassify(){
        $lists = Db::table('classify')->paginate(10);
        return $lists;
    }

    public static function lists(){
        $lists = Db::table('classify')->select();
        return $lists;
    }

    public static function search($id){
        $where['id'] = $id;
        $name = Db::table('classify')->where($where)->select();
        return $name;
    }

    public static function isexist($classname){
        $where['classname'] = $classname;
        $find = Db::table('classify')->where($where)->find();
        return $find;
    }

    public static function add($classname){
        $data['classname'] = $classname;
        $data['classid'] = 'FL'.uniqid();
        $Isinsert = Db::table('classify')->insert($data);
        if($Isinsert){
            return true;
        }else{
            return false;
        }
    }

    public static function del($id){
        $Isdel = Db::table('classify')->where('id','in',$id)->delete();
        if($Isdel){
            return true;
        }else{
            return false;
        }
    }

    public static function updateclassify($id,$name){
        $where['id'] = $id;
        $Isupdate = Db::table('classify')->where($where)->update(['classname'=>$name]);
        if($Isupdate){
            return true;
        }else{
            return false;
        }
    }
}