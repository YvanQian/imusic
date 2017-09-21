<?php
namespace app\admin\model;

use think\Model;
use think\Db;

class Comment extends Model{
    public static function showcomments(){
        $comments = Db::field('comment.*,song.gqname,user.uname')
                    ->table(['comment','song','user'])
                    ->where('comment.uid=user.uid')
                    ->where('comment.gqid=song.gqid')
                    ->paginate(10);
        return $comments;
    }

    public static function delcomment($id){
        $Isdel = Db::table('comment')->where('id','in',$id)->delete();
        if($Isdel){
            return true;
        }else{
            return false;
        }
    }

    public static function detil($id){
        $content = Db::field('content')
                ->table('comment')
                ->where('id='.$id)
                ->find();
        return $content;
    }
}