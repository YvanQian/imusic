<?php
namespace app\index\controller;
use think\Controller;

class Index extends Controller{
    public function index(){
        $albums = \app\index\model\Index::randalbums();
        $this->assign('albums',$albums);

        $singers = \app\index\model\Index::randsingers();
        $this->assign('singers',$singers);

        $song = \app\index\model\Index::randsongs();
        $this->assign('randsong',$song);

        $songs = \app\index\model\Index::descsong();
        $this->assign('songs',$songs);
        
        return $this->fetch();
    }

    public function recommend(){
        $albums = \app\index\model\Index::randalbums();
        $this->assign('albums',$albums);

        $singers = \app\index\model\Index::randsingers();
        $this->assign('singers',$singers);

        $song = \app\index\model\Index::randsongs();
        $this->assign('randsong',$song);

        $songs = \app\index\model\Index::descsong();
        $this->assign('songs',$songs);

        return $this->fetch('index');
    }

    public function charts(){
        $songs = \app\index\model\Index::descsong();
        $this->assign('songs',$songs);

        $count = \app\index\model\Index::countsong();
        $this->assign('count',$count);

        return $this->fetch('charts');
    }

    public function singer(){
        $singers = \app\index\model\Index::listsingers();
        $this->assign('singers',$singers);

        return $this->fetch('singer');
    }

    public function albums(){
        $albums = \app\index\model\Index::listalbums();
        $this->assign('albums',$albums);
        
        return $this->fetch('albums');
    }

}
