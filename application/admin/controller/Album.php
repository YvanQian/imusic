<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;

class Album extends Controller {
    public function album(){
        $albums = \app\admin\model\Album::showalubms();
        $this->assign('lists',$albums);
        return $this->fetch('list/album');
    }

    public function albumadd(){
        return $this->fetch('operate/album_add');
    }

    public function addalbum(){
        $zjname = input('post.zjname');
        $summary = input('post.summary');
        $createtime = input('post.createtime');
        $imgurl = input('post.imgurl');
        $gsname = input('post.gsname');
//        $isexist = \app\admin\model\Singer::search($zjname);
//        if($isexist){
//            return ["status" => "0"];
//        }else{
            $insert = \app\admin\model\Album::addalbum($zjname,$summary,$createtime,$imgurl,$gsname);
            if($insert){
                return ["status" => "1"];
            }
//        }
    }

    public function delalbum(){
        $id = input('post.id/a');
        $del = \app\admin\model\Album::delalbum($id);
        if($del){
            return ["status" => "1"];
        }
    }

    public function albumedit($id){
        if(Request::instance()->isPost()) {
            $file = request()->file('image');
            if ($file) {
                $info = $file->rule('md5')->move(ROOT_PATH . 'upload/album');
                if ($info) {
                    $res['message'] = '上传成功';
                    $res['url'] = '/upload/album/' . $info->getSaveName();
                    return json($res);
                } else {
                    $res['message'] = '上传失败';
                    $res['error'] = $file->getError();
                    return json($res);
                }
            } else {
                $zjname = input('post.zjname');
                $summary = input('post.summary');
                $createtime = input('post.createtime');
                $imgurl = input('post.imgurl');
                $gsname = input('post.gsname');
                $update = \app\admin\model\Album::updatealbum($id, $zjname, $summary, $createtime, $imgurl, $gsname);
                if ($update) {
                    return ['status' => '1'];
                }
            }
        }
        $album = \app\admin\model\Album::searchalbum($id);
        $this->assign('list',$album);
        return $this->fetch('operate/album_edit');
    }

    public function upload(){
        $file = request()->file('image');
        $info = $file->rule('md5')->move(ROOT_PATH.'upload/album');
        if($info){
            $res['message'] = '上传成功';
            $res['url'] = '/upload/album/'.$info->getSaveName();
            return json($res);
        }else{
            $res['message'] = '上传失败';
            $res['error'] = $file->getError();
            return json($res);
        }
    }
}