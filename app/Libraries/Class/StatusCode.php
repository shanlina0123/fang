<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 16:36
 */

class StatusCode
{
    const PUBLIC_STATUS= 1;//1成功
    const CHECK_FROM = 100100100; //表单数据验证失败
    const USER_LOCKING = 100100101; //用户锁定
    const LOGIN_FAILURE = 100100102; //用户名密码不正确
}