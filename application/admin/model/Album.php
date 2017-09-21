<?php
namespace app\admin\model;

use think\Controller;
use think\Db;

class Album extends \think\Model{
    public static function showalubms(){
        $lists = Db::field('album.*,singer.gsname')
                    ->table(['album','singer'])
                    ->where('album.gsid=singer.gsid')
                    ->paginate(10);
        return $lists;
    }

    //通过id查询单条专辑数据
    public static function searchalbum($id){
        $album = Db::field('album.*,singer.gsname')
                    ->table(['album','singer'])
                    ->where('album.gsid=singer.gsid')
                    ->where('album.id='.$id)
                    ->select();
        return $album;
    }

    public static function search($zjname,$gsname){
        $where['album.zjname'] = $zjname;
        $where['singer.gsname'] = $gsname;
        $album = Db::field('album.*')
                    ->table(['album','singer'])
                    ->where('album.gsid=singer.gsid')
                    ->where($where
                    )
//                    ->where('album.zjname='.$zjname)
//                    ->where('singer.gsname='.$gsname)
                    ->find();
        return $album;
    }

    //添加专辑
    public static function addalbum($zjname,$summary,$createtime,$imgurl,$gsname){
        $data['zjname'] = $zjname;
        $data['summary'] = $summary;
        $data['createtime'] = $createtime;
        $data['imgurl'] = $imgurl;
        $data['zjid'] = 'ZJ'.uniqid();
        $singer = \app\admin\model\Singer::search($gsname);
        if($singer){
            $data['gsid'] = $singer['gsid'];
        }else{
            $insert = \app\admin\model\Singer::addsinger($gsname,'','','');
            if($insert){
                $singer = \app\admin\model\Singer::search($gsname);
                $data['gsid'] = $singer['gsid'];
            }
        }
        $Isinsert = Db::table('album')->insert($data);
        if($Isinsert){
            return true;
        }else{
            return false;
        }
    }

    //删除专辑
    public static function delalbum($id){
        $Isdel = Db::table('album')->where('id','in',$id)->delete();
        if($Isdel){
            return true;
        }else{
            return false;
        }
    }

    //修改专辑
    public static function updatealbum($id,$zjname,$summary,$createtime,$imgurl,$gsname){
        $singer = \app\admin\model\Singer::search($gsname);
        if($singer){
            $gsid = $singer['gsid'];
        }else{
            $insert = \app\admin\model\Singer::addsinger($gsname,'','','');
            if($insert){
                $singer = \app\admin\model\Singer::search($gsname);
                $gsid = $singer['gsid'];
            }
        }
        $where['id'] = $id;
        $Isupdate = Db::table('album')->where($where)->update(['zjname'=>$zjname,'summary'=>$summary,'createtime'=>$createtime,'imgurl'=>$imgurl,'gsid'=>$gsid]);
        if($Isupdate){
            return true;
        }else{
            return false;
        }
    }
}