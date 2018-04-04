<?php

/**
 * @param $password
 * @param $salt
 * @param int $saltGain
 * @return string
 * 加密
 */
function optimizedSaltPwd($password,  $saltGain = 1)
{
    $salt = config('app.salt');
    // 过滤参数
    if(!is_numeric($saltGain)) exit;
    if(intval($saltGain) < 0 || intval($saltGain) > 35) exit;
    // 对 Md5 后的盐值进行变换，添加信息增益
    $tempSaltMd5 = md5($salt);
    for($i = 0;$i < strlen($tempSaltMd5);$i ++)
    {
        if(ord($tempSaltMd5[$i]) < 91 && ord($tempSaltMd5[$i]) > 32)
        {
            // 每一个字符添加同样的增益
            $tempSaltMd5[$i] = chr(ord($tempSaltMd5[$i]) + $saltGain);
        }
    }
    // 返回整个哈希值
    return md5($password . $tempSaltMd5);
}


/**
 * @param string $prefix
 * @return string
 * UUID
 */
function create_uuid($prefix = "")
{
    $str = md5(uniqid(mt_rand(), true));
    $uuid  = substr($str,0,8);
    $uuid .= substr($str,8,4);
    $uuid .= substr($str,12,4);
    $uuid .= substr($str,16,4);
    $uuid .= substr($str,20,12);
    return $prefix . $uuid;
}

/**
 * @param $data
 * @return array
 * 递归去除空格
 */
function trimValue( $data )
{
    $t_data = array();
    foreach ( $data as $k=>$v )
    {
        if( is_array($v) )
        {
            $t_data[$k] = trimValue( $v );
        }else
        {
            $t_data[$k] = trim( $v );
        }
    }
    return $t_data;
}



//对象转数组
function object_to_array($obj) {
    $obj = (array)$obj;
    foreach ($obj as $k => $v) {
        if (gettype($v) == 'resource') {
            return;
        }
        if (gettype($v) == 'object' || gettype($v) == 'array') {
            $obj[$k] = (array)($v);
        }
    }
    return $obj;
}

/***
 * 错误提示转为数组
 * @param $obj
 * @return mixed
 *
 * 调用
 *  if ($validator->fails()) {
        responseData(\StatusCode::PARAM_ERROR,"参数错误","",$validator->errors());
    }
 */
function validateParam($obj)
{
    $arr=object_to_array($obj);
   return head($arr);
}


/**
 * 返回信息
 */
function responseData($status="",$messages="",$data="",$errorparam="")
{
    $res["status"] = $status;//请求结果的状态
    $res["messages"] = $messages;//请求结果的文字描述
    $res["data"] = $data;//返回的数据结果
    if(!empty($errorparam))
    {
        $errorparam=validateParam($errorparam);
    }
    $res["errorparam"]=$errorparam; //错误参数对应提示
   // return response()->json($res,200);die;
    echo json_encode($res);die;
}