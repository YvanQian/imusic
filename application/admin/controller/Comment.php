<?php
namespace app\admin\controller;

use think\Controller;

class Comment extends Controller {
    public function comment(){
        $comments = \app\admin\model\Comment::showcomments();
        $this->assign('lists',$comments);
        return $this->fetch('list/comment');
    }

    public function delcomment(){
        $id = input('post.id/a');
        $del = \app\admin\model\Comment::delcomment($id);
        if($del){
            return ["status" => "1"];
        }
    }

    public function detil($id){
        $content = \app\admin\model\Comment::detil($id);
        $this->assign('content',$content['content']);
        return $this->fetch('operate/comment_detil');
    }
}