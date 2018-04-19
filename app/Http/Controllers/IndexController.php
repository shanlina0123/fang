<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class IndexController extends Controller
{


    public function  index()
    {
        header("Content-type: text/html; charset=utf-8");
        Cache::flush();
        echo "您不能访问哦~";
        die;
    }

}
