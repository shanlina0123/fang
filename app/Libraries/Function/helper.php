<?php

/**
 * @param $password
 * @param $salt
 * @param int $saltGain
 * @return string
 * 加密
 */
function optimizedSaltPwd($type="home",$password,  $saltGain = 1)
{
    $salt = config('app.salt.'.$type);
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


/**
 * @return array
 * 获取控制器和方法
 */
function getControllerOrFunctionName()
{
    $request=app("request");
    $route = $request->route();
    $method= strtoupper($request->method());
    if( !empty($route[1]['uses']) )
    {
        $action = $route[1]['uses'];
        list($controller, $action) = explode('@', $action);
        $controller = substr(strrchr($controller,'\\'),1);
        return ['controller' => $controller, 'action' => $action,"method"=>$method];
    }
}

/**
 * 返回信息
  * 调用
 *  if ($validator->fails()) {
        responseData(\StatusCode::PARAM_ERROR,"参数错误","",$validator->errors());
    }
 */
function responseData($status="",$messages="",$data="",$errorparam="")
{
    $res["status"] = $status;//请求结果的状态
    $res["messages"] = $messages;//请求结果的文字描述
    $res["data"] = $data;//返回的数据结果
    /*if(!empty($errorparam))
    {
        if(!is_array($errorparam))
        {
            $errorparam=$errorparam->toArray();
        }
    }*/
    if( $errorparam )
    {
        $res["errorparam"]=$errorparam; //错误参数对应提示
    }
    echo json_encode($res);die;
}


/**
 * 兼容低版本的array_column
 * @param $input
 * @param $columnKey
 * @param null $indexKey
 * @return array
 */
function i_array_column($input, $columnKey, $indexKey=null){
    if(!function_exists('array_column')){
        $columnKeyIsNumber  = (is_numeric($columnKey))?true:false;
        $indexKeyIsNull            = (is_null($indexKey))?true :false;
        $indexKeyIsNumber     = (is_numeric($indexKey))?true:false;
        $result                         = array();
        foreach((array)$input as $key=>$row){
            if($columnKeyIsNumber){
                $tmp= array_slice($row, $columnKey, 1);
                $tmp= (is_array($tmp) && !empty($tmp))?current($tmp):null;
            }else{
                $tmp= isset($row[$columnKey])?$row[$columnKey]:$row;
            }
            if(!$indexKeyIsNull){
                if($indexKeyIsNumber){
                    $key = array_slice($row, $indexKey, 1);
                    $key = (is_array($key) && !empty($key))?current($key):null;
                    $key = is_null($key)?0:$key;
                }else{
                    $key = isset($row[$indexKey])?$row[$indexKey]:0;
                }
            }
            $result[$key] = $tmp;
        }
        return $result;
    }else{
        return array_column($input, $columnKey, $indexKey);
    }
}

// $field 为一维数字数组，$field[0]为用于分组的单一字段。
 function combine($array,$field){
    $tmpArray = array();
    $distinct_field = $field[0];
    unset($field[0]);
    foreach ($array as $row) {
        $key = $row[$distinct_field];
        if (array_key_exists($key, $tmpArray)) {
            foreach($field as $value){
                if (is_array($tmpArray[$key][$value])) {
                    $tmpArray[$key][$value][] = $row[$value];
                } else {
                    $tmpArray[$key][$value] = array($tmpArray[$key][$value], $row[$value]);
                }
            }
        } else {
            $tmpArray[$key][$distinct_field] = $row[$distinct_field];
            foreach ($field as $value){
                $tmpArray[$key][$value] = array($row[$value]);
            }
        }
    }
    return $tmpArray;
}

/**
 * 发送HTTP请求方法
 * @param  string $url    请求URL
 * @param  array  $params 请求参数
 * @param  string $method 请求方法GET/POST
 * @return array  $data   响应数据
 */
function httpRequest($url, $params, $method = 'GET', $header = array(), $multi = false){
    $opts = array(
        CURLOPT_TIMEOUT        => 30,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_HTTPHEADER     => $header
    );
    /* 根据请求类型设置特定参数 */
    switch(strtoupper($method)){
        case 'GET':
            $opts[CURLOPT_URL] = $url . '?' . http_build_query($params);
            break;
        case 'POST':
            //判断是否传输文件
            $params = $multi ? $params : http_build_query($params);
            $opts[CURLOPT_URL] = $url;
            $opts[CURLOPT_POST] = 1;
            $opts[CURLOPT_POSTFIELDS] = $params;
            break;
        default:
            return false;// throw new Exception('不支持的请求方式！');
    }

    /* 初始化并执行curl请求 */
    $ch = curl_init();
    curl_setopt_array($ch, $opts);
    $data  = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    if($error)  return false;//throw new Exception('请求发生错误：' . $error);
    return  $data;
}


function checkParam($arr,$method){
    //数组且是数字
    if($method =="is_array_int")
    {
        if(!is_array($arr))
        {
            return false;
        }
        foreach($arr as $k=>$v)
        {
            if (strlen($v) > 0) {
                if (!is_numeric($v)) {
                    return false;
                }
            }
        }
        return true;
    }
}

/***
 * 判断一个字符串是不是base64编码
 * @param $str
 * @return bool
 */
function checkStringIsBase64($str){
    return $str == base64_encode(base64_decode($str)) ? true : false;
}

/***
 * 二位数组转为 一对多tree
 * @param $list
 * @param string $pk
 * @param string $pid
 * @param string $child
 * @param int $root
 * @return array
 */
function array_to_parent($list,$pid = 'pid') {
    // 创建Tree
    $tree = array();
    if(is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pid]][] =& $list[$key];
        }
    }
    return $refer;
}


/**
 * 把返回的数据集转换成Tree
 * @param array $list 要转换的数据集
 * @param string $pid parent标记字段
 * @param string $level level标记字段
 * @return array
 */
function list_to_tree($list, $pk='id', $pid = 'pid', $child = '_child', $root = 0) {
    // 创建Tree
    $tree = array();
    if(is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] =& $list[$key];
        }

        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId =  $data[$pid];
            if ($root == $parentId) {
                $tree[] =& $list[$key];
            }else{
                if (isset($refer[$parentId])) {
                    $parent =& $refer[$parentId];
                    $parent[$child][] =& $list[$key];
                }
            }
        }
    }
    return $tree;
}

/**
 * 将list_to_tree的树还原成列表
 * @param  array $tree  原来的树
 * @param  string $child 孩子节点的键
 * @param  string $order 排序显示的键，一般是主键 升序排列
 * @param  array  $list  过渡用的中间数组，
 * @return array        返回排过序的列表数组
 */
function tree_to_list($tree, $child = '_child', $order='id', &$list = array()){
    if(is_array($tree)) {
        $refer = array();
        foreach ($tree as $key => $value) {
            $reffer = $value;
            if(isset($reffer[$child])){
                unset($reffer[$child]);
                tree_to_list($value[$child], $child, $order, $list);
            }
            $list[] = $reffer;
        }
        $list = list_sort_by($list, $order, $sortby='asc');
    }
    return $list;
}

/***
 * 拼接字符串
 * @return string
 */
function mosaic($segmentation="")
{
    $params=func_get_args();
    unset($params[0]);
    return implode($segmentation,$params);
}