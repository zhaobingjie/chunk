<?php
$expire_time = 300;//请求有效时间
$data = $_POST;
//echo json_encode($data);exit;
if(empty($data['accesskey']) || empty($data['once']) || empty($data['timestamp']) || empty($data['sign'])){
    res_json(404,'params error');
}

//check timeout
if(time()-$expire_time>$data['timestamp']){
    res_json(404,'timeout');
}

//check once
if(!check_once($data['accesskey'],$data['once'])){
    res_json(404,'multiple request');
}

//get secertKey
$sk = get_sk($data['accesskey']);
if(!$sk){
    res_json(404,'accesskey does not exist');
}

//check sign
$sign = get_sign($data['data'],$data['accesskey'],$sk,$data['once'],$data['timestamp']);
if($sign != $data['sign']){
    res_json(404,'sign error');
}

//save once
save_once($data['accesskey'],$data['once'],$expire_time);

res_json(200,'ok');

function res_json($code,$msg='OK',$data=array()){
    $return['code'] = $code;
    $return['msg'] = $msg;
    $return['data'] = $data;
    echo json_encode($return);exit;
}
function get_sk($ak){
    $AccessKey = '061TLYN90boKu';
    $SecretKey = 'v1d1KP90HoSNm';
    if($AccessKey == $ak){
        return $SecretKey;
    }
    return false;
}
function get_sign($data,$ak,$sk,$once,$timestamp){
    sort($data);
    $query_str = http_build_query($data).'&accesskey='.$ak.'&secretkey='.$sk.'&once='.$once.'&timestamp='.$timestamp;
    return strtoupper(md5($query_str));
}
//保证每个随机字符串在有效时间内只请求一次
function check_once($ak,$once){
    return true;
}
//save once
function save_once($ak,$once,$expire='300'){
    return true;
}