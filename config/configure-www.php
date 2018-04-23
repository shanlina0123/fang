<?php
return [
    "projectRun"=>"",
    'salt'=>[
        "admin"=>"YWRtaW4ucnJ6aGFvZmFuZy5jb20udXNlcnMyMDE4MDQxNzEzNTA=",
        "home"=>'d3gucnJ6aGFvZmFuZy5jb20udXNlcnMyMDE4MDQxNzEzNTI='
    ],
    "DB_PREFIX"=>"renren_", //防止获取不到env的DB_PREFIX
    "sPage"=>10,//每页显示条数
    "sCache"=>120,//缓存时长
    "uploads"=>"uploads",//图片文件路径
    "temp"=>"/temp/",//图片临时目录
    "adminPwd"=>"xxs111111",//后台用户默认密码
    //微信配置
    'wechat'=>[
        'appid'=>'wxbe1cdb19d2290193',
        'secret'=>'01b3d066ca1181a7f5d1aed2b1f4baae',
        'template_id'=>'fgPw0n6T2g4DlASSKAU4om66xyDxuG8e_Zy3hp6oKic',
        'url'=>'http://wx.rrzhaofang.com/pages/my.html'
    ],
    //跨域-手机端，允许访问接口的域名
    "allow"=>[
        //生产 - 域名
        'http://api.rrzhaofang.com',//接口
        'http://wx.rrzhaofang.com',//手机
        'http://admin.rrzhaofang.com',//PC
    ],


];