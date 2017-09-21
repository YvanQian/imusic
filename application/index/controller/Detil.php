<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

class Detil extends Controller{
    public function singerdetil($gsname){
        $singer = \app\index\model\Detil::findsinger($gsname);
        $songs = \app\index\model\Detil::listssong($singer['gsid']);
        $albums = \app\index\model\Detil::listalbum($singer['gsid']);
        $this->assign('gsname',$singer['gsname']);
        $this->assign('imgurl',$singer['imgurl']);
        $this->assign('summary',$singer['summary']);
        $this->assign('songs',$songs);
        $this->assign('albums',$albums);

        return $this->fetch('singer_detil');
    }

    public function albumdetil($zjid){
        $album = \app\index\model\Detil::findalbum($zjid);
        $songs = \app\index\model\Detil::listalbumsong($album['zjid']);
        $this->assign('zjname',$album['zjname']);
        $this->assign('imgurl',$album['imgurl']);
        $this->assign('summary',$album['summary']);
        $this->assign('gsname',$album['gsname']);
        $this->assign('createtime',$album['createtime']);
        $this->assign('songs',$songs);

        return $this->fetch('album_detil');
    }

    public function songdetil($gqid,$page=1,$content=''){
        if($content){
            $uname = input('get.uname');
            $isinsert = \app\index\model\Detil::addcomment($uname,$gqid,$content);
            if(!$isinsert){
                return false;
            }
        }

        $song = \app\index\model\Detil::findsong($gqid);

        $this->assign('gqid',$gqid);
        $this->assign('imgurl',$song['imgurl']);
        $this->assign('gqname',$song['gqname']);
        $this->assign('gsname',$song['gsname']);
        $this->assign('gqurl',$song['gqurl']);
        $this->assign('mvurl',$song['mvurl']);
        $this->assign('zjname',$song['zjname']);

        $comment = \app\index\model\Detil::listcomments($gqid);
        $show = $comment->render();
        $show=preg_replace("(<a[^>]*page[=|/](\d+).+?>(.+?)<\/a>)","<a href='javascript:ajax_page($1);'>$2</a>",$show);
        $this->assign('comment',$comment);
        $this->assign('page',$show);

        if(request()->isAjax()){
            return $this->fetch('comment');
        }else{
            return $this->fetch('song_detil');
        }
    }

    public function search($keyword=''){
        $songs = \app\index\model\Detil::searchsong($keyword);
        $this->assign('songs',$songs);
        $this->assign('keyword',$keyword);
        return $this->fetch('search');
    }

    public function vedio(){
        return $this->fetch('vedio');
    }

    public function classdetil(){
        $classid = input('classid');
        trace($classid);
        $classifys = \app\index\model\Detil::listclassify();
        $this->assign('classify',$classifys);

        $songs = \app\index\model\Detil::listsongs($classid);
        $this->assign('song',$songs);

        $classname = Db::table('classify')->where('classid',$classid)->find();
        $this->assign('classname',$classname['classname']);

        return $this->fetch('classify_detil');
    }
}