<?php
namespace app\admin\model;

use think\Db;
use think\Model;

class Song extends Model{
    public static function showsongs(){
        $lists = Db::field('song.*,singer.gsname,album.zjname,classify.classname')
            ->table(['album','singer','song','classify'])
            ->where('song.gsid=singer.gsid')
            ->where('song.zjid=album.zjid')
            ->where('song.classid=classify.classid')
            ->paginate(5);
        return $lists;
    }

    public static function searchsong($id){
        $song = Db::field('song.*,singer.gsname,album.zjname,classify.classname')
            ->table(['album','singer','song','classify'])
            ->where('song.gsid=singer.gsid')
            ->where('song.zjid=album.zjid')
            ->where('song.classid=classify.classid')
            ->where('song.id='.$id)
            ->select();
        return $song;
    }

    //添加歌曲
    public static function addsong($gqname,$zjname,$gsname,$gqurl,$mvurl,$classname){
        $data['gqname'] = $gqname;
        $data['gqurl'] = $gqurl;
        $data['mvurl'] = $mvurl;
        $data['gqid'] = 'GQ'.uniqid();
        $album = \app\admin\model\Album::search($zjname,$gsname);
        $classify = \app\admin\model\Classify::isexist($classname);
        if($album){
            $data['zjid'] = $album['zjid'];
            $data['gsid'] = $album['gsid'];
        }else{
            $insert = \app\admin\model\Album::addalbum($zjname,'','','',$gsname);
            if($insert){
                $album = \app\admin\model\Album::search($zjname,$gsname);
                $data['zjid'] = $album['zjid'];
                $data['gsid'] = $album['gsid'];
            }
        }
        $data['classid'] = $classify['classid'];
        $Isinsert = Db::table('song')->insert($data);
        if($Isinsert){
            return true;
        }else{
            return false;
        }
    }

    //删除歌曲
    public static function delsong($id){
        $Isdel = Db::table('song')->where('id','in',$id)->delete();
        if($Isdel){
            return true;
        }else{
            return false;
        }
    }

    //修改歌曲
    public static function updatesong($id,$gqname,$zjname,$gsname,$gqurl,$mvurl,$classname){
        $album = \app\admin\model\Album::search($zjname,$gsname);
        $classify = \app\admin\model\Classify::isexist($classname);
        if($album){
            $zjid = $album['zjid'];
            $gsid = $album['gsid'];
        }else{
            $insert = \app\admin\model\Album::addalbum($zjname,'','','',$gsname);
            if($insert){
                $album = \app\admin\model\Album::search($zjname,$gsname);
                $zjid = $album['zjid'];
                $gsid = $album['gsid'];
            }
        }
        $classid = $classify['classid'];
        $where['id'] = $id;
        $Isupdate = Db::table('song')->where($where)->update(['gqname'=>$gqname,'zjid'=>$zjid,'gqurl'=>$gqurl,'gsid'=>$gsid,'mvurl'=>$mvurl,'classid'=>$classid]);
        if($Isupdate){
            return true;
        }else{
            return false;
        }
    }
}