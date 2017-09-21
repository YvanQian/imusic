<?php
namespace app\admin\model;

use think\Db;
use think\Model;

class Singer extends Model{
    //查询所有歌手数据
    public static function showsingers(){
        $lists = Db::table('singer')->paginate(10);
        return $lists;
    }

    //通过name查询单条歌手数据
    public static function search($gsname){
        $where['gsname'] = $gsname;
        $user=Db::table('singer')->where($where)->find();
        return $user;
    }

    //通过id查询单条歌手数据
    public static function searchsinger($id){
        $where['id'] = $id;
        $singer = Db::table('singer')->where($where)->select();
        return $singer;
    }

    //添加歌手
    public static function addsinger($gsname,$summary,$birthday,$imgurl){
        $data['gsname'] = $gsname;
        $data['summary'] = $summary;
        $data['birthday'] = $birthday;
        $data['imgurl'] = $imgurl;
        $data['gsid'] = 'GS'.uniqid();
        $Isinsert = Db::table('singer')->insert($data);
        if($Isinsert){
            return true;
        }else{
            return false;
        }
    }

    //删除歌手
    public static function delsinger($id){
        $Isdel = Db::table('singer')->where('id','in',$id)->delete();
        if($Isdel){
            return true;
        }else{
            return false;
        }
    }

    //修改歌手
    public static function updatesinger($id,$gsname,$summary,$birthday,$imgurl){
        $where['id'] = $id;
        $Isupdate = Db::table('singer')->where($where)->update(['gsname'=>$gsname,'summary'=>$summary,'birthday'=>$birthday,'imgurl'=>$imgurl]);
        if($Isupdate){
            return true;
        }else{
            return false;
        }
    }
}