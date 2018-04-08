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


$router->group(['prefix' => 'api/admin', 'namespace' => 'Admin'], function () use ($router) {

    $router->get('user', 'UserController@index');//客户分析----OK


    $router->get('login', 'LoginController@login');//登陆
    $router->group(['middleware' => 'token'], function () use ($router) {
        $router->post('house/create', 'HouseController@create');//发房下拉数据
        $router->post('house/store', 'HouseController@store');//发布房源

        //系统设置
        //角色
        $router->get('roles', 'RolesController@index');//获取角色列表 ----OK
        $router->get('roles/{uuid}', 'RolesController@edit');//角色详情  ----OK
        $router->post('roles', 'RolesController@store');//添加角色  ----OK
        $router->put('roles/{uuid}', 'RolesController@update');//修改角色  ----OK
        $router->delete('roles/{uuid}', 'RolesController@delete');//删除角色 ----OK

        //权限Auth
        $router->get('auth', 'AuthController@index');//获取功能列列表----OK
        $router->get('auth/{role_uuid}', 'AuthController@detail');//角色权限详情----OK
        $router->put('auth/{role_uuid}', 'AuthController@update');//修改角色权限----OK

        //用户
        $router->get('admin', 'AdminController@index');//获取用户列表----OK
        $router->get('admin/{uuid}', 'AdminController@edit');//用户详情----OK
        $router->post('admin', 'AdminController@store');//添加用户----OK
        $router->put('admin/{uuid}', 'AdminController@update');//修改用户----OK
        $router->put('admin-setting/{uuid}', 'AdminController@setting');//禁用启用用户----OK

        //自定义属性管理
        $router->get('datas', 'DatasController@index');//获取自定义所有属性列表----OK
        $router->get('datas-one/{cateid}', 'DatasController@getOne');//获取单个属性列表----OK
        $router->get('datas-detail/{uuid}', 'DatasController@edit');//属性详情----OK
        $router->post('datas', 'DatasController@store');//添加属性----OK
        $router->put('datas/{uuid}', 'DatasController@update');//修改属性----OK
        $router->put('datas-setting/{uuid}', 'DatasController@setting');//禁用启用属性----OK

        //默认属性管理
        $router->get('datas-default', 'DatasController@getDefault');//获取默认所有属性列表----OK
        $router->get('datas-default-one/{cateid}', 'DatasController@getDefaultOne');//获取默认单个属性列表----OK

        //数据分析
        $router->get('chart', 'ChartController@index');//客户分析----OK


        //数据分析
       // $router->get('user', 'UserController@index');//客户分析----OK

    });
});
