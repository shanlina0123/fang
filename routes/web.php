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
        //房源
        $router->post('house/create', 'HouseController@create');//发房下拉数据
        $router->post('house/store', 'HouseController@store');//发布房源
        $router->get('house/index', 'HouseController@index');//房源列表
        $router->post('house/tag', 'HouseController@storeTag');//房源标签
        $router->post('house/img', 'HouseController@storeImg');//房源图片
        $router->get('house/edit/{uuid}', 'HouseController@edit');//房源信息
        $router->put('house/update/{uuid}', 'HouseController@update');//房源编辑
        $router->delete('house/delete/{uuid}', 'HouseController@destroy');//房源删除
        $router->post('img/upload', 'PublicController@uploadImgToTemp');//图片上传到临时目录
        //公司
        $router->get('company/index', 'CompanyController@index');//公司列表
        $router->post('company/store', 'CompanyController@store');//添加公司
        //客户
        $router->get('client/index', 'ClientController@index');//客户列表
        $router->delete('client/delete/{uuid}', 'ClientController@destroy');//客户删除
        $router->get('client/edit/{uuid}', 'ClientController@edit');//客户编辑信息
        $router->put('client/update/{uuid}', 'ClientController@update');//客户编辑信息
        $router->get('client-follow/edit/{client}', 'ClientController@followEdit');//客户跟进
        $router->put('client-follow/store', 'ClientController@followStore');//客户跟进保存
        $router->post('client-transfer/update', 'ClientController@transferUpdate');//客户移交


        //系统设置
        //角色

        $router->get('roles', 'RolesController@index');//获取角色列表 ----OK
        $router->get('roles/{uuid}', 'RolesController@edit');//角色详情  ----OK
        $router->post('roles', 'RolesController@store');//添加角色  ---进行中
        $router->put('roles/{uuid}', 'RolesController@update');//修改角色
        $router->delete('roles/{uuid}', 'RolesController@delete');//删除角色

        //权限Auth
        $router->get('auth', 'AuthController@index');//获取功能列列表
        $router->get('auth/{role_uuid}', 'AuthController@edit');//角色权限详情
        $router->post('auth/{role_uuid}', 'AuthController@update');//修改角色权限

        //用户
        $router->get('admin', 'AdminController@index');//获取用户列表
        $router->get('admin/{uuid}', 'AdminController@edit');//用户详情
        $router->post('admin', 'AdminController@store');//添加用户
        $router->put('admin/{uuid}', 'AdminController@update');//修改用户
        $router->delete('admin/{uuid}', 'AdminController@delete');//删除用户
    });
});