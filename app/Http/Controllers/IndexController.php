<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{


    public function  index()
    {
        header("Content-type: text/html; charset=utf-8");
        echo "您不能访问哦~";
        die;
    }

}
