<?php
namespace app\index\model;

use think\Model;
use think\Db;

class Index extends Model{
    public static function randalbums(){
        $albums = Db::field('album.*,singer.gsname')->table(['album','singer'])->where('album.gsid=singer.gsid')->order('rand()')->select();
        return $albums;
    }

    public static function randsingers(){
        $singers = Db::table('singer')->order('rand()')->select();
        return $singers;
    }

    public static function randsongs(){
        $song = Db::field('song.*,singer.gsname,album.imgurl')
                ->table(['song','singer','album'])
                ->where('song.gsid=singer.gsid')
                ->where('song.zjid=album.zjid')
                ->order('rand()')->select();
        return $song;
    }

    public static function descsong(){
        $songs = Db::field('song.*,singer.gsname')
                    ->table(['song','singer'])
                    ->where('song.gsid=singer.gsid')
                    ->order('hot desc')->select();
        return $songs;
    }

    public static function countsong(){
        $count = Db::table('song')->count();
        return $count;
    }

    public static function listalbums(){
        $albums = Db::field('album.*,singer.gsname')->table(['album','singer'])->where('album.gsid=singer.gsid')->select();
        return $albums;
    }

    public static function listsingers(){
        $singers = Db::table('singer')->select();
        return $singers;
    }
}