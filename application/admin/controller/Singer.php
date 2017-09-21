<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;

class Singer extends Controller {
    public function singer(){
        $singers = \app\admin\model\Singer::showsingers();
        $this->assign('lists',$singers);
        return $this->fetch('list/singer');
    }

    public function singeradd(){
        return $this->fetch('operate/singer_add');
    }

    public function addsinger(){
        $gsname = input('post.gsname');
        $summary = input('post.summary');
        $birthday = input('post.birthday');
        $imgurl = input('post.imgurl');
        $isexist = \app\admin\model\Singer::search($gsname);
        if($isexist){
            return ["status" => "0"];
        }else{
            $insert = \app\admin\model\Singer::addsinger($gsname,$summary,$birthday,$imgurl);
            if($insert){
                return ["status" => "1"];
            }
        }
    }

    public function delsinger(){
        $id = input('post.id/a');
        $del = \app\admin\model\Singer::delsinger($id);
        if($del){
            return ["status" => "1"];
        }
    }

    public function singeredit($id){
        if(Request::instance()->isPost()){
            $file = request()->file('image');
            if($file){
                $info = $file->rule('md5')->move(ROOT_PATH.'upload/singer');
                if($info){
                    $res['message'] = '上传成功';
                    $res['url'] = '/upload/singer/'.$info->getSaveName();
                    return json($res);
                }else{
                    $res['message'] = '上传失败';
                    $res['error'] = $file->getError();
                    return json($res);
                }
            }else{
                $gsname = input('post.gsname');
                $summary = input('post.summary');
                $birthday = input('post.birthday');
                $imgurl = input('post.imgurl');
                $update = \app\admin\model\Singer::updatesinger($id,$gsname,$summary,$birthday,$imgurl);
                if($update){
                    return ['status' => '1'];
                }
            }
        }
        $singer = \app\admin\model\Singer::searchsinger($id);
        $this->assign('list',$singer);
        return $this->fetch('operate/singer_edit');
    }

    public function upload(){
        $file = request()->file('image');
        $info = $file->rule('md5')->move(ROOT_PATH.'upload/singer');
        if($info){
            $res['message'] = '上传成功';
            $res['url'] = '/upload/singer/'.$info->getSaveName();
            return json($res);
        }else{
            $res['message'] = '上传失败';
            $res['error'] = $file->getError();
            return json($res);
        }
    }
}