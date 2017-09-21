<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;

class Song extends Controller {
    public function song(){
        $songs = \app\admin\model\Song::showsongs();
        $this->assign('lists',$songs);
        return $this->fetch('list/song');
    }

    public function songadd(){
        $lists = \app\admin\model\Classify::lists();
        $this->assign('list',$lists);
        return $this->fetch('operate/song_add');
    }

    public function video(){
        return $this->fetch('operate/video');
    }

    public function addsong(){
        $gqname = input('post.gqname');
        $zjname = input('post.zjname');
        $gsname = input('post.gsname');
        $gqurl = input('post.gqurl');
        $mvurl = input('post.mvurl');
        $classname = input('post.classname');
        $insert = \app\admin\model\Song::addsong($gqname,$zjname,$gsname,$gqurl,$mvurl,$classname);
        if($insert){
            return ["status" => "1"];
        }
    }

    public function delsong(){
        $id = input('post.id/a');
        $del = \app\admin\model\Song::delsong($id);
        if($del){
            return ["status" => "1"];
        }
    }

    public function songedit($id){
        if(Request::instance()->isPost()){
            $file1 = request()->file('audio');
            $file2 = request()->file('vedio');
            if($file1){
                $info = $file1->rule('md5')->move(ROOT_PATH.'upload/song');
                if($info){
                    $res['message'] = '上传成功';
                    $res['url'] = '/upload/song/'.$info->getSaveName();
                    return json($res);
                }else{
                    $res['message'] = '上传失败';
                    $res['error'] = $file1->getError();
                    return json($res);
                }
            }elseif ($file2){
                $info = $file2->rule('md5')->move(ROOT_PATH.'upload/mv');
                if($info){
                    $res['message'] = '上传成功';
                    $res['url'] = '/upload/mv/'.$info->getSaveName();
                    return json($res);
                }else{
                    $res['message'] = '上传失败';
                    $res['error'] = $file2->getError();
                    return json($res);
                }
            } else{
                $gqname = input('post.gqname');
                $zjname = input('post.zjname');
                $gsname = input('post.gsname');
                $gqurl = input('post.gqurl');
                $mvurl = input('post.mvurl');
                $classname = input('post.classname');
                $update = \app\admin\model\Song::updatesong($id,$gqname,$zjname,$gsname,$gqurl,$mvurl,$classname);
                if($update){
                    return ['status' => '1'];
                }
            }
        }
        $classify = \app\admin\model\Classify::lists();
        $this->assign('classify',$classify);
        $song = \app\admin\model\Song::searchsong($id);
        $this->assign('list',$song);
        return $this->fetch('operate/song_edit');
    }

    public function upsong(){
        $file = request()->file('audio');
        $info = $file->rule('md5')->move(ROOT_PATH.'upload/song');
        if($info){
            $res['message'] = '上传成功';
            $res['url'] = '/upload/song/'.$info->getSaveName();
            return json($res);
        }else{
            $res['message'] = '上传失败';
            $res['error'] = $file->getError();
            return json($res);
        }
    }

    public function upmv(){
        $file = request()->file('vedio');
        $info = $file->rule('md5')->move(ROOT_PATH.'upload/mv');
        if($info){
            $res['message'] = '上传成功';
            $res['url'] = '/upload/mv/'.$info->getSaveName();
            return json($res);
        }else{
            $res['message'] = '上传失败';
            $res['error'] = $file->getError();
            return json($res);
        }
    }
}