<?php
// +----------------------------------------------------------------------
// | Quotes [二次开发请留版权,严禁用于非法用途]
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author:书迷  <jsrcode@qq.com>
// +----------------------------------------------------------------------
// | Date: 2023年12月21日
// +----------------------------------------------------------------------
function Get_Secret($botid,$secret){
    $headers = array(
        'Content-Type: application/json'
    );
    $get_access_token_data = '{"appId": "'.$botid.'","clientSecret": "'.$secret.'"}';
    $send = json_decode(Send_Post('https://bots.qq.com/app/getAppAccessToken', $get_access_token_data,$headers),true);
    $access_token=$send['access_token'];
    return $access_token;
}

function Get_Authorization($botid,$secret){
    $headers = array(
        'Content-Type: application/json'
    );
    $get_access_token_data = '{"appId": "'.$botid.'","clientSecret": "'.$secret.'"}';
    $send = json_decode(Send_Post('https://bots.qq.com/app/getAppAccessToken', $get_access_token_data,$headers),true);
    $access_token=$send['access_token'];
    $authorization = "QQBot " . $access_token;
    return $authorization;
}