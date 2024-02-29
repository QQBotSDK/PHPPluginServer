<?php
// +----------------------------------------------------------------------
// | Quotes [二次开发请留版权,严禁用于非法用途]
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author:书迷  <jsrcode@qq.com>
// +----------------------------------------------------------------------
// | Date: 2024年02月27日
// +----------------------------------------------------------------------
define('SYSTEM_ROOT_1', dirname(__FILE__).'/');
define('ROOT_1', dirname(SYSTEM_ROOT_1).'/');
include SYSTEM_ROOT_1.'Mysql.php';//数据库链接

if(!@$name){
    exit('Error:文件内参数name未传入');
}

@$auth=$_GET['auth'];
if(!@$auth){
    exit('Error:Get参数auth未传入');
}

$decode=base64_decode($auth);
@$decode1=explode('//',$decode);
$un=$decode1[0];
$pw=$decode1[1];

$plugin=$config->GetPlugin_N($name);
if($plugin['code']==200){
    if($plugin['value']['auth_username']==$un and $plugin['value']['auth_password']==$pw){
        //auth通过
    }else{
        exit('Error:auth不通过');
    }
}else{
    exit('Error:文件内参数name无效');
}

$decode=false;
$decode1=false;
$un=false;
$pw=false;
if($plugin['value']['auth_mysql']==true){
    $config=false;
}else{
    $sql=false;
    $conn=false;
    $config=false;
}
$plugin=false;
?>