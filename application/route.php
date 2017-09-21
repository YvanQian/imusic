<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],

    "adminlogin"=>"admin/login/login",      //后台登录页面
    "admincheck"=>"admin/login/logincheck", //后台登录验证
    "admin"=>"admin/admin/admin",           //后台首页
    "adminlogout"=>"admin/admin/logout",    //后台登出
    "info" => "admin/admin/info",       //控制面板
    "changepwd" => "admin/admin/changepwd", //修改密码页面
    "changepassword" => "admin/admin/changepassword", //修改密码

    "users" => "admin/user/users",    //用户列表
    "user_add" => "admin/user/useradd", //添加用户表单
    'adduser' => 'admin/user/adduser',
    'user_edit/:id$' => "admin/user/useredit", //编辑用户表单
    "deluser" => "admin/user/deluser", //删除用户
    "updateuser" => "admin/user/updateuser",//修改用户
    //"searchuser" => "admin/operate/mhsearch",//模糊查找用户

    "singer" =>"admin/singer/singer", //歌手列表
    'singer_add' => 'admin/singer/singeradd',//添加歌手表单
    'addsinger' => 'admin/singer/addsinger',//添加歌手
    'singerimg' => 'admin/singer/upload',//上传歌手照片
    'delsinger' => 'admin/singer/delsinger',//删除歌手
    'singer_edit/:id' => 'admin/singer/singeredit',//编辑歌手

    "album" => "admin/album/album",   //专辑列表
    'delalbum' => 'admin/album/delalbum',//删除专辑
    'albumimg' => 'admin/album/upload', //上传专辑封面
    'album_add' => 'admin/album/albumadd',//添加专辑表单
    'addalbum' => 'admin/album/addalbum',//添加专辑
    'album_edit/:id' => 'admin/album/albumedit',//编辑专辑


    "song" => "admin/song/song",      //歌曲列表
    'song_add' => 'admin/song/songadd',//添加歌曲表单
    'addsong' => 'admin/song/addsong',//添加歌曲
    'upsong' => 'admin/song/upsong',//上传歌曲
    'upmv' => 'admin/song/upmv',//上传视频
    'delsong' => 'admin/song/delsong',//删除歌曲
    'song_edit/:id' => 'admin/song/songedit',//编辑歌曲
    'video' => 'admin/song/video',

    "comment" => "admin/comment/comment",//评论列表
    'delcomment' => 'admin/comment/delcomment',
    'comment_detil/:id' => 'admin/comment/detil',

    'classify' => 'admin/classify/classify',
    'classify_add' => 'admin/classify/addclassify',
    'delclassify' => 'admin/classify/delclassify',
    'classify_edit/:id' => 'admin/classify/classifyedit',


    "login"=>"index/login/login",           //用户登录页面
    'register' => 'index/login/register',   //用户注册页面
    "/"    =>"index/index/index",           //默认首页

];

