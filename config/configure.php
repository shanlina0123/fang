<?php
return [
    'salt'=>[
        "admin"=>"30b06afa21235689666220154e1adc540fa==HDDSmsl5895HG$##6",
        "home"=>'30b06afa2e3b11e8b20154e##gsdgsdgHHHH==ddgg32231adc540f3a'
    ],
    "DB_PREFIX"=>"renren_", //防止获取不到env的DB_PREFIX
    "sPage"=>10,//每页显示条数
    "sCache"=>120,//缓存时长
    "uploads"=>"uploads",//图片文件路径
    "temp"=>"/temp/",//图片临时目录
    //微信配置
    'wechat'=>[
        'appid'=>'wxbe1cdb19d2290193',
        'secret'=>'01b3d066ca1181a7f5d1aed2b1f4baae',
        'template_id'=>'fgPw0n6T2g4DlASSKAU4om66xyDxuG8e_Zy3hp6oKic',
        'url'=>'http://wx.rrzhaofang.com/pages/my.html'
    ],
    //跨域-手机端，允许访问接口的域名
    "allow"=>[
        'http://local.renrenmobile.com',
        'http://dev.renrenmobile.com',
        'http://wx.rrzhaofang.com',
        'http://local.fang.com',
        'http://dev.renren.com',
        'http://api.rrzhaofang.com',
    ],
    //跨域-PC端，允许访问接口的域名
    "allow_admin"=>[
        'http://local.fang.com',
        'http://dev.renren.com',
        'http://local.renrenpc.com',
        'http://dev.renrenpc.com',
        'http://admin.rrzhaofang.com',
    ],

];