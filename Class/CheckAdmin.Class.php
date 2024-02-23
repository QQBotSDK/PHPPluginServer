<?php
// +----------------------------------------------------------------------
// | Quotes [二次开发请留版权,严禁用于非法用途]
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author:书迷  <jsrcode@qq.com>
// +----------------------------------------------------------------------
// | Date: 2024年02月18日
// +----------------------------------------------------------------------
define('SYSTEM_ROOT', dirname(__FILE__).'/');
define('ROOT', dirname(SYSTEM_ROOT).'/');
include ROOT.'Config.php';//配置文件
/*验证Cookie*/
if(isset($_GET["Login_Token"])){
    $cookie=hash('sha256',$Admin_Username.$Admin_Password);
    if($_GET["Login_Token"]!=$cookie){
        exit("鉴权不通过");
    }
}else{
    exit("鉴权不通过");
}
$_GET["Login_Token"]='';
$Debug_Mode='';
$Plugin_Key="";
$Admin_Username="";
$Admin_Password=""; 
