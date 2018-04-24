<?php
return [
    'salt'=>[
        "admin"=>"30b06afa21235689666220154e1adc540fa==HDDSmsl5895HG$##6",
        "home"=>'30b06afa2e3b11e8b20154e##gsdgsdgHHHH==ddgg32231adc540f3a'
    ],
    "DB_PREFIX"=>"renren_", //防止获取不到env的DB_PREFIX
    "sPage"=>10,//每页显示条数
    "sCache"=>120,//缓存时长
    "uploads"=>"upload",//图片文件路径
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
        //local - 单莉娜 - 域名
        'http://local.fang.com', //接口
        'http://local.renrenmobile.com',//手机
        'http://local.renrenpc.com',//PC
        //local- 单莉娜 - IP
        'http://192.168.15.28:8081', //接口
        "http://192.168.15.28:8082",//手机
        "http://192.168.15.28:8083",//PC

        //local - 舒全刚- 域名
        'http://local.fang.com', //接口
        'http://local.renrenmobile.com',//手机
        'http://admin.renrenpc.com',//PC
        //local - 舒全刚- IP
        'http://192.168.15.30:8081', //接口
        "http://192.168.15.30:8082",//手机
        "http://192.168.15.30:8083",//PC

        //local - 赵颖- 域名
        'http://local.renrenmobile.com',//手机
        'http://local.renrenpc.com',//PC
        //local - 赵颖- IP
        "http://192.168.15.37:8082",//手机
        "http://192.168.15.37:8083",//PC

        //local - 王彤- 域名
        'http://local.renrenmobile.com',//手机
        'http://local.renrenpc.com',//PC
        //local - 王彤- IP
        "http://192.168.15.32:8082",//手机
        "http://192.168.15.32:8083",//PC

        //dev - 域名
        'http://dev.renren.com',//接口
        'http://dev.renrenmobile.com',//手机
        'http://dev.renrenpc.com',//PC
        //dev - IP
        "http://192.168.15.222:8081",//接口
        "http://192.168.15.222:8082",//手机
        "http://192.168.15.222:8083",//PC

        //生产 - 域名
        'http://api.rrzhaofang.com',//接口
        'http://wx.rrzhaofang.com',//手机
        'http://admin.rrzhaofang.com',//PC
        'https://apis.map.qq.com',
    ],

];