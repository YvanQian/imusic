<?php
namespace app\index\model;

use think\Model;
use think\Db;

class Detil extends Model{
    public static function findsinger($gsname){
        $where['gsname'] = $gsname;
        $singer = Db::table('singer')->where($where)->find();
        return $singer;
    }

    public static function listssong($gsid){
        $where['song.gsid']=$gsid;
        $songs = Db::field('song.*,album.zjname')->table(['song','album'])->where('song.zjid=album.zjid')->where($where)->select();
        return $songs;
    }

    public static function listalbum($gsid){
        $where['album.gsid'] = $gsid;
        $albums = Db::table('album')->where($where)->select();
        return $albums;
    }

    public static function findalbum($zjid){
        $where['album.zjid'] = $zjid;
        $album = Db::field('album.*,singer.gsname')->table(['album','singer'])->where('album.gsid=singer.gsid')->where($where)->find();
        return $album;
    }

    public static function listalbumsong($zjid){
        $where['zjid'] = $zjid;
        $songs = Db::field('song.*,classify.classname')->table(['song','classify'])->where('song.classid=classify.classid')->where($where)->select();
        return $songs;
    }

    public static function findsong($gqid){
        $where['song.gqid'] = $gqid;
        $songs = Db::field('song.*,singer.gsname,album.zjname,album.imgurl')
                ->table(['song','singer','album'])
                ->where('song.gsid=singer.gsid')
                ->where('song.zjid=album.zjid')
                ->where($where)->find();
        $update = Db::table('song')->where($where)->setInc('hot');
        if($update){
            return $songs;
        }
    }

    public static function listcomments($gqid){
        $where['comment.gqid'] = $gqid;
        $comments = Db::field('comment.*,user.uname')->table(['comment','user'])->where('comment.uid=user.uid')->where($where)->order('id desc')->paginate(10);
        return $comments;
    }

    public static function addcomment($uname,$gqid,$content){
        $where['uname'] = $uname;
        $user = DB::table('user')->where($where)->find();
        $data['plid'] = 'PL'.uniqid();
        $data['uid'] = $user['uid'];
        $data['gqid'] = $gqid;
        $data['content'] = $content;
        $data['commenttime'] = date('y-m-d H:i:s',time());
        $isinsert = Db::table('comment')->insert($data);
        if($isinsert){
            return true;
        }else{
            return false;
        }
    }

    public static function searchsong($keyword){
        $where['song.gqname'] = ['like',"%{$keyword}%"];
        $songs = Db::field('song.*,album.zjname,album.zjid,singer.gsname')
                    ->table(['song','album','singer'])
                    ->where('song.zjid=album.zjid')
                    ->where('song.gsid=singer.gsid')
                    ->where($where)
                    ->paginate(10);
        return $songs; 
    }

    public static function searchsinger($keyword){
        $where['gsname'] = ['like',"%{$keyword}%"];
        $singers = Db::table('singer')->where($where)->paginate(10);
        return $singers;
    }

    public static function listclassify(){
        $classify = Db::table('classify')->select();
        return $classify;
    }

    public static function listsongs($classid=''){
        if($classid){
            $where['classid'] = $classid;
            $songs = Db::field('song.*,album.imgurl')->table(['song','album'])->where('song.zjid=album.zjid')->where($where)->select();
        }else{
            $songs = Db::field('song.*,album.imgurl')->table(['song','album'])->where('song.zjid=album.zjid')->select();
        }
        return $songs;
    }
}