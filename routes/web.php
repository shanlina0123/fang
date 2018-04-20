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
$router->get('/', 'IndexController@index'); //入口
/**
 * 后台
 */
//$router->get('api-test','Admin\TestController@index');
$router->group(['prefix' => 'admin', 'namespace' => 'Admin'], function () use ($router) {

    //PC端跨域访问
    //$router->group(['middleware' => 'cors_admin_ware'], function () use ($router) {
        //跨域访问设置
      /*  $router->options("{all}", function () {});
        $router->options('house/index',  function () {});
        $router->options('datas-default-one/{cateid}',  function () {});
        $router->options('datas-one/{cateid}',  function () {});
        $router->options('house/delete/{uuid}',  function () {});
        $router->options('house/create',  function () {});*/

        //登录前
        $router->post('login', 'LoginController@login');//登录
        $router->get('get/poc', 'PublicController@getAddress');//省市数据
        //微信授权接口
        $router->get('wechat/authorization', 'WechatController@authorization');
        //忘记密码
        $router->get('wechat/forget', 'WechatController@forget');//忘记密码扫码
        $router->get('wechat/testing', 'LoginController@testing');//检测扫码结果
        $router->post('user/modify-pass', 'LoginController@modifyPass');//修改密码
        //登录后
        $router->group(['middleware' => 'admin_token'], function () use ($router) {
            $router->get('token', 'TokenController@index');//检查已有token
            //检测是否绑定
            $router->get('user/binding', 'LoginController@binding');
            //修改密码
            $router->post('user/update-pass', 'UserController@update');
            //菜单
            $router->get('auth-menu', 'AuthController@getMenu');//获取权限菜单数据
            $router->post('admin-user-check', 'AdminController@checkUserMobile');//检测后端手机号手否于经纪人有关----OK
            $router->get('house/create', 'HouseController@create');//发房下拉数据
            $router->post('img/upload', 'PublicController@uploadImgToTemp');//图片上传到临时目录
            //默认属性管理
            $router->get('datas-default', 'DatasController@getDefault');//获取默认所有属性列表----OK
            $router->get('datas-default-one/{cateid}', 'DatasController@getDefaultOne');//获取默认单个属性列表----OK
            //权限后
            $router->group(['middleware' => 'admin_auth'], function () use ($router) {
                //房源
                $router->get('house/index', 'HouseController@index');//房源列表
                $router->post('house/store', 'HouseController@store');//添加房源基本信息
                $router->post('house/tag', 'HouseController@storeTag');//添加房源标签
                $router->post('house/img', 'HouseController@storeImg');//添加房源图片+ 发布
                $router->get('house/edit/{uuid}', 'HouseController@edit');//房源详情
                $router->put('house/update/{uuid}', 'HouseController@update');//修改房源
                $router->post('house/recommend', 'HouseController@recommend');//推荐房源
                $router->delete('house/delete/{uuid}', 'HouseController@destroy');//删除房源

                //公司
                $router->get('company/index', 'CompanyController@index');//列表
                $router->post('company/store', 'CompanyController@store');//添加
                $router->get('company/edit/{uuid}', 'CompanyController@edit');//详情
                $router->put('company/update/{uuid}', 'CompanyController@update');//修改
                $router->delete('company/delete/{uuid}', 'CompanyController@destroy');//删除

                //经纪人管理
                $router->get('user/broker', 'UserController@broker');//经纪人列表
                $router->put('setting/{uuid}', 'UserController@setting');//禁用启用
                //客户
                $router->get('client/index', 'ClientController@index');//客户列表
                $router->get('client/edit/{uuid}', 'ClientController@edit');//客户详情
                $router->put('client/update/{uuid}', 'ClientController@update');//客户修改
                $router->get('client-follow/edit/{client}', 'ClientController@followEdit');//跟进详情
                $router->put('client-follow/store', 'ClientController@followStore');//跟进修改
                $router->post('client-transfer/update', 'ClientController@transferUpdate');//客户移交
                $router->delete('client/delete/{uuid}', 'ClientController@destroy');//客户删除
                //角色
                $router->get('roles', 'RolesController@index');//获取角色列表 ----OK
                $router->get('roles/{uuid}', 'RolesController@edit');//角色详情  ----OK
                $router->post('roles', 'RolesController@store');//添加角色  ----OK
                $router->put('roles/{uuid}', 'RolesController@update');//修改角色  ----OK
                $router->delete('roles/{uuid}', 'RolesController@delete');//删除角色 ----OK
                //权限Auth
                $router->get('auth', 'AuthController@index');//获取功能列列表----OK
                $router->get('auth/{role_uuid}', 'AuthController@edit');//角色权限详情----OK
                $router->put('auth/{role_uuid}', 'AuthController@update');//修改角色权限----OK

                //用户
                $router->get('admin', 'AdminController@index');//获取用户列表----OK
                $router->get('admin/{uuid}', 'AdminController@edit');//用户详情----OK
                $router->post('admin', 'AdminController@store');//添加用户----OK
                $router->put('admin/{uuid}', 'AdminController@update');//修改用户----OK
                $router->put('admin-setting/{uuid}', 'AdminController@setting');//禁用启用用户----OK


                //自定义属性管理
                $router->get('datas', 'DatasController@index');//获取自定义所有属性列表----OK
                $router->get('datas-all', 'DatasController@getall');//获取全部自定义属性
                $router->get('datas-one/{cateid}', 'DatasController@getOne');//获取单个属性列表----OK
                $router->get('datas-detail/{uuid}', 'DatasController@edit');//属性详情----OK
                $router->post('datas', 'DatasController@store');//添加属性----OK
                $router->put('datas/{uuid}', 'DatasController@update');//修改属性----OK
                $router->put('datas-setting/{uuid}', 'DatasController@setting');//禁用启用属性----OK

                //数据分析
                $router->post('chart', 'ChartController@index');//客户分析----OK
                $router->get('chart-user', 'ChartController@getUsers');//前端经纪人/业务员列表----OK
            });
        });


});


/**
 * 前台手机端
 */
$router->group(['prefix' => 'home', 'namespace' => 'Home'], function () use ($router) {

        //登录前
        $router->post('user/register', 'LoginOrRegisterController@register');//注册
        $router->post('user/login', 'LoginOrRegisterController@login');//登陆
        $router->get('get/poc', 'PublicController@getAddress');//省市数据
        $router->get('get-openid/{code}', 'LoginOrRegisterController@wxOpenid');//获取openid
        //首页
        $router->get('house/recommend', 'HouseController@recommend');//首页房源推荐

        //房源
        $router->get('house/list', 'HouseController@index');//房源列表
        $router->get('house/info/{id}', 'HouseController@info');//房源详情

        //自定义属性管理
        $router->get('datas', 'DatasController@index');//获取自定义所有属性列表----OK
        $router->get('datas-one/{cateid}', 'DatasController@getOne');//获取单个属性列表----OK

        //默认属性管理
        $router->get('datas-default', 'DatasController@getDefault');//获取默认所有属性列表----OK
        $router->get('datas-default-one/{cateid}', 'DatasController@getDefaultOne');//获取默认单个属性列表----OK

        //配置
        $router->get('conf', 'ConfController@index');//获取web手机端配置列表 ----OK


        //登录后
        $router->group(['middleware' => 'user_token'], function () use ($router) {

            $router->get('token', 'TokenController@index');//检查已有token

            //个人中心
            $router->get('users', 'UsersController@index');//获取用户信息 ----OK
            $router->put('users-update', 'UsersController@update');//修改用户信息 ----OK

            //默认属性管理-区分内外部人员
            $router->get('datas-default-user', 'DatasController@getDefaultUser');//获取自定义所有属性列表区分内部和外部人员----OK
            $router->get('datas-default-user-one/{cateid}', 'DatasController@getDefaultUserOne');//获取自定义单个分类的属性列表区分内部和外部人员----OK

            //推荐客户
            $router->post('client', 'ClientController@index');//我的推荐客户列表
            $router->post('client-houses', 'ClientController@houseData');//推荐客户的房源下拉框内容
            $router->get('client-statistics', 'ClientController@statistics');//我的推荐客户量统计
            $router->post('client-refree', 'ClientController@store');//推荐客户
            $router->put('client-update/{uuid}', 'ClientController@update');//修改客户
            $router->post('user-updateinfo', 'UsersController@updateInfo');//修改用户信息

            //公司信息
            $router->get('company', 'CompanyController@index');

        });
});