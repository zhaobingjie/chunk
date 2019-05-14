<?php
function http_get($url,$data,$timeout=5){
    if($url == "" || $timeout <= 0){
        return false;
    }
    $url = $url.'?'.http_bulid_query($data);
    $con = curl_init((string)$url);
    curl_setopt($con, CURLOPT_HEADER, false);
    curl_setopt($con, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($con, CURLOPT_TIMEOUT, (int)$timeout);
    return curl_exec($con);
}

function http_post($url,$post_data,$timeout=5){
    if($url == '' ||  $timeout <=0){
        return false;
    }
    //初始化
    $curl = curl_init();
    //设置抓取的url
    curl_setopt($curl, CURLOPT_URL, $url);
    //设置头文件的信息作为数据流输出(true)
    curl_setopt($curl, CURLOPT_HEADER, false);
    //设置获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    //设置post方式提交
    curl_setopt($curl, CURLOPT_POST, true);
    //设置post数据
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post_data));
    //设置超时
    curl_setopt($curl, CURLOPT_TIMEOUT,(int)$timeout);
    //执行命令
    $data = curl_exec($curl);
    //关闭URL请求
    curl_close($curl);
    //显示获得的数据
    return $data;
}