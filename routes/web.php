<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->group(['prefix' => 'api/admin','namespace'=>'Admin'], function () use ($router)
{
    $router->post('login', 'LoginController@login');//登陆
    $router->group(['middleware' =>'token'], function () use ($router)
    {
        $router->post('house/create', 'HouseController@create');//发房下拉数据
    });
});
