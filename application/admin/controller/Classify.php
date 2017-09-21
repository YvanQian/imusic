<?php
/**
 * Created by PhpStorm.
 * User: Yvan
 * Date: 2017/4/24
 * Time: 11:41
 */

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Classify extends Controller{
    public function classify(){
        $lists = \app\admin\model\Classify::showClassify();
        $this->assign('lists',$lists);
        return $this->fetch('list/classify');
    }

    public function addclassify(){
        if(Request::instance()->isPost()){
            $name = input('post.name');
            $isexist = \app\admin\model\Classify::isexist($name);
            if($isexist){
                return ["status" => "0"];
            }else{
                $insert = \app\admin\model\Classify::add($name);
                if($insert){
                    return ["status" => "1"];
                }
            }
        }
        return $this->fetch('operate/classify_add');
    }

    public function delclassify(){
        $id = input('post.id/a');
        $del = \app\admin\model\Classify::del($id);
        if($del){
            return ["status" => "1"];
        }
    }

    public function classifyedit($id){
        if(Request::instance()->isPost()){
            $name = input('post.name');
            $update = \app\admin\model\Classify::updateclassify($id,$name);
            if($update){
                return ['status' => '1'];
            }
        }
        $classify = \app\admin\model\Classify::search($id);
        $this->assign('list',$classify);
        return $this->fetch('operate/classify_edit');
    }
}