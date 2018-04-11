<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 16:36
 */

/***
 * 格式：模块+控制器+方法+错误
 * 00+00+00+000
 * Class StatusCode
 */
class StatusCode
{
    const SUCCESS=1;//成功
    const PUBLIC_STATUS= 1;//1成功
    const ERROR=0;//失败
    const PARAM_ERROR=2;//参数错误
    const DB_ERROR=3;//数据库错误失败
    const EMPTY_ERROR=4;//空数据
    const TOKEN_ERROR=5;//token错误
    const REQUEST_ERROR=6;//非法请求
    const CATCH_ERROR=7;//catch异常
    const EXIST_ERROR=8;//已存在
    const TOKEN_GET_ERROR=9;//token解析失败
    const OUT_ERROR=10;//超出管理员所属
    const NOT_DEFINED=11;//非预定义
    const NOT_EXIST_ERROR=12;//不存在
    const NOT_CHANGE=13;//无变化
    const EXIST_NOT_DELETE=14;//存在不能删除的数据
    const ROLE_ERROR=15;//角色无权限
    const AUTH_ERROR=16;//无权限
    const AUTH_NOT_DEFINED_ERROR=17;//未定义暂未开放
    const CHECK_FROM = 100100100; //表单数据验证失败
    const USER_LOCKING = 100100101; //用户锁定
    const LOGIN_FAILURE = 100100102; //用户名密码不正确
}