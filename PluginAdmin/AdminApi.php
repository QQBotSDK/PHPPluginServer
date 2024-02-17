<?php
// +----------------------------------------------------------------------
// | Quotes [二次开发请留版权,严禁用于非法用途]
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author:书迷  <jsrcode@qq.com>
// +----------------------------------------------------------------------
// | Date: 2024年02月16日
// +----------------------------------------------------------------------
//error_reporting(1);//屏蔽报错
$mode=$_GET["mode"];
include '../Config.php';//配置文件
if($mode!='Login'){
    /*验证Cookie*/
    if(isset($_COOKIE["Login_Token"])){
        $cookie=hash('sha256',$Admin_Username.$Admin_Password);
        if($_COOKIE["Login_Token"]!=$cookie){
            $return = array('code' => 400,'message' => '请先登录1');
            exit(json_encode($return));
        }
    }else{
        $return = array('code' => 400,'message' => '请先登录2');
        exit(json_encode($return));
    }
}

//逻辑部分
if($mode=='Login'){
    include '../Config.php';//载入配置文件
    $username=$_GET["username"];
    $password=$_GET["password"];
    if($Admin_Username==$username and $Admin_Password==$password){
        $cookie=hash('sha256',$Admin_Username.$Admin_Password);
        $return = array('code' => 200,'message' => '登录成功','cookie' => $cookie);
        exit(json_encode($return));
    }else{
        $return = array('code' => 401,'message' => '登录信息不匹配');
        exit(json_encode($return));
    }
}elseif($mode=='SetPlugin'){
    $id=$_GET["id"];
    $do=$_GET["do"];
    //加载Plugin下的所有的插件
    $list = glob('../Plugin/*');
    $i=0;
    foreach($list as $file){
        $config = file_get_contents($file.'/Config.json');//引入插件配置文件
        $config_data = json_decode($config);//解析配置文件
    	$i++;
    	if($i==$id){//匹配上了
            //判断插件是否开启
            if($do=='Open'){
                if($config_data->plugin->config->isopen==true){
                    $code=401;
                    $message="插件已经开启了";
                }else{
                    $config_data->plugin->config->isopen=true;
                    $myfile = fopen($file.'/Config.json', "w");
                    $data = json_encode($config_data, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
                    fwrite($myfile, $data);
                    fclose($myfile);
                    $code=200;
                    $message="插件开启成功";
                }
            }elseif($do=='Close'){
                if($config_data->plugin->config->isopen==false){
                    $code=401;
                    $message="插件已经关闭了";
                }else{
                    $config_data->plugin->config->isopen=false;
                    $myfile = fopen($file.'/Config.json', "w");
                    $data = json_encode($config_data, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
                    fwrite($myfile, $data);
                    fclose($myfile);
                    $code=200;
                    $message="插件关闭成功";
                }
            }else{
                $code=401;
                $message="参数不合法";
            }
    	}
    }
    if(!$message){
        $code=401;
        $message="插件ID错误";
    }
    $return = array('code' => $code,'message' => $message);
    exit(json_encode($return));
}elseif($mode=='UpdateUserInfo'){
    include '../Config.php';//载入配置文件
    $username=$_GET["username"];
    $oldpassword=$_GET["oldpassword"];
    $newpassword=$_GET["newpassword"];
    if($Admin_Password==$oldpassword){
        $myfile = fopen('../Config.php', "w");
        $data = '<?php $Plugin_Key="'.$Plugin_Key.'";$Admin_Username="'.$username.'";$Admin_Password="'.$newpassword.'"; ?>';
        fwrite($myfile, $data);
        fclose($myfile);
        $return = array('code' => 200,'message' => '修改成功');
        exit(json_encode($return));
    }else{
        $return = array('code' => 401,'message' => '原密码不正确');
        exit(json_encode($return));
    }
}elseif($mode=='UpdateSet'){
    include '../Config.php';//载入配置文件
    $key=$_GET["key"];
    $myfile = fopen('../Config.php', "w");
    $data = '<?php $Plugin_Key="'.$key.'";$Admin_Username="'.$Admin_Username.'";$Admin_Password="'.$Admin_Password.'"; ?>';
    fwrite($myfile, $data);
    fclose($myfile);
    $return = array('code' => 200,'message' => '修改成功');
    exit(json_encode($return));
}else{
    
}