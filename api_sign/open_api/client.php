<?php
require_once '../common.php';


$AccessKey = '061TLYN90boKu';
$SecretKey = 'v1d1KP90HoSNm';
//要提交的数据
$data = array(
    'key1' => 'aaa',
    'key2' => 'bbb',
    'key3' => 'ccc'
);
//请求的api
$url= 'http://point.com/api_sign/open_api/server.php';

//防止重放攻击
$once = get_random_str();
$timestamp = time();

//生成签名(作用:防止篡改请求信息)
$sign = get_sign($data,$AccessKey,$SecretKey,$once,$timestamp);


$query_data = array(
  'data' => $data,
  'accesskey' => $AccessKey,
  'sign' => $sign,
  'once' => $once,
  'timestamp' => $timestamp
);
$res = http_post($url,$query_data);
var_dump($res);

function get_sign($data,$ak,$sk,$once,$timestamp){
    sort($data);
    $query_str = http_build_query($data).'&accesskey='.$ak.'&secretkey='.$sk.'&once='.$once.'&timestamp='.$timestamp;
    return strtoupper(md5($query_str));
}
//取随机10位字符串
function get_random_str(){
    $chars = "QWERTYUIOPASDFGHJKLZXCVBNM1234567890qwertyuiopasdfghjklzxcvbnm";
    return  substr(str_shuffle($chars),mt_rand(0,strlen($chars)-11),10);
}

