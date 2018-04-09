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

/**
 * 后台
 */
$router->group(['prefix' => 'api/admin', 'namespace' => 'Admin'], function () use ($router) {
    //登录前
    $router->post('login', 'LoginController@login');//登录
    //登录后
    $router->group(['middleware' => 'admin_token'], function () use ($router) {
        //房源
        $router->post('house/create', 'HouseController@create');//发房下拉数据
        $router->post('house/store', 'HouseController@store');//发布房源
        $router->get('house/index', 'HouseController@index');//房源列表
        $router->post('house/tag', 'HouseController@storeTag');//房源标签
        $router->post('house/img', 'HouseController@storeImg');//房源图片
        $router->get('house/edit/{uuid}', 'HouseController@edit');//房源信息
        $router->put('house/update/{uuid}', 'HouseController@update');//房源编辑
        $router->post('house/recommend', 'HouseController@recommend');//房源推荐
        $router->delete('house/delete/{uuid}', 'HouseController@destroy');//房源删除
        $router->post('img/upload', 'PublicController@uploadImgToTemp');//图片上传到临时目录
        //公司
        $router->get('company/index', 'CompanyController@index');//公司列表
        $router->post('company/store', 'CompanyController@store');//添加公司
        $router->get('company/edit/{uuid}', 'CompanyController@edit');//公司修改信息
        $router->post('company/update/{uuid}', 'CompanyController@update');//公司修改信息
        $router->delete('company/delete/{uuid}', 'CompanyController@destroy');//公司修改信息
        $router->get('user/broker', 'UserController@broker');//经纪人
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


        //经纪人列表
        $router->get('user', 'UserController@index');//经纪人列表----OK

    });
});


/**
 * 前台手机端
 */
$router->group(['prefix' => 'api/home', 'namespace' => 'Home'], function () use ($router) {

    //登录前
    $router->post('user/register', 'LoginOrRegisterController@register');//注册
    $router->post('user/login', 'LoginOrRegisterController@login');//登陆

    //首页
    $router->get('house/recommend', 'HouseController@recommend');//首页房源推荐

    //房源列表
    $router->get('house/list', 'HouseController@index');//房源列表

    $router->get('users', 'UsersController@index');//获取用户列表 ----OK
    $router->post('users', 'UsersController@update');//修改用户信息 ----OK


    //登录后
    $router->group(['middleware' => 'user_token'], function () use ($router) {
        //自定义属性管理
        $router->get('datas', 'DatasController@index');//获取自定义所有属性列表----OK
        $router->get('datas-one/{cateid}', 'DatasController@getOne');//获取单个属性列表----OK

        //默认属性管理
        $router->get('datas-default', 'DatasController@getDefault');//获取默认所有属性列表----OK
        $router->get('datas-default-one/{cateid}', 'DatasController@getDefaultOne');//获取默认单个属性列表----OK

        //配置
        $router->get('conf', 'ConfController@index');//获取web手机端配置列表 ----OK

        //个人中心
//        $router->get('users', 'UsersController@index');//获取用户列表 ----OK
//        $router->post('users', 'UsersController@update');//修改用户信息 ----OK

    });

});