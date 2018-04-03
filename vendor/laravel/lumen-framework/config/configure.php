<?php
return [
    'salt' => 'ABCDEF%%%!!@@@4444',//登录加密秘钥
    "sPage"=>10,//每页显示条数
    "sCache"=>120,//缓存时长
    "showUploads"=>$_SERVER["REQUEST_SCHEME"]."://".$_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"]."/uploads",//图片预览路径
    "uploads"=>"uploads",//图片文件路径
    "temp"=>"/temp/"//图片临时目录

];