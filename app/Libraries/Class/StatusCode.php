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
    const ERROR=0;//失败
    const PARAM_ERROR=2;
    const DB_ERROR=3;//数据库错误失败
    const PUBLIC_STATUS= 1;//1成功
    const CHECK_FROM = 100100100; //表单数据验证失败
    const USER_LOCKING = 100100101; //用户锁定
    const LOGIN_FAILURE = 100100102; //用户名密码不正确
    const HOUSE_STORE_FAIL = 100200101; //房源基本信息发布失败
}