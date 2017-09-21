<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;

class User extends Controller{
    public function users(){
        $get = input('get.');
        $name = input('get.name');
        $pageParam = ['query' => []];
        $userModel = \app\admin\model\User::showusers();
        if($name){
            $userModel->where('uname','like','%'.$name.'%');
            $this->assign('name',$name);
            $pageParam['query']['name'] = $name;
        }
        $users = $userModel->paginate(10,false,$pageParam);
        $this->assign('lists',$users);
        return $this->fetch('list/users');
    }

    public function useradd(){
        return $this->fetch('operate/user_add');
    }

    public function adduser(){
        $name = input('post.name');
        $password = input('post.password');
        $email = input('post.email');
        $sex = input('post.sex');
        $isexist = \app\admin\model\User::search($name);
        if($isexist){
            return ["status" => "0"];
        }else{
            $insert = \app\admin\model\User::adduser($name,$password,$sex,$email);
            if($insert){
                return ["status" => "1"];
            }
        }
    }

    public function useredit($id){
        if(Request::instance()->isPost()){
            $name = input('post.name');
            $password = input('post.password');
            $email = input('post.email');
            $sex = input('post.sex');
            $update = \app\admin\model\User::updateuser($id,$name,$password,$sex,$email);
            if($update){
                return ['status' => '1'];
            }
        }
        $user = \app\admin\model\User::searchuser($id);
        $this->assign('list',$user);
        return $this->fetch('operate/user_edit');
    }

    public function mhsearch(){
        $name = input('post.name');
        $users = \app\admin\model\User::mosearch($name);
        $this->assign('list',$users);
        return $this->fetch('operate/user_search');
    }

    public function deluser(){
        $id = input('post.id/a');
        $del = \app\admin\model\User::deluser($id);
        if($del){
            return ["status" => "1"];
        }
    }
}