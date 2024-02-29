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
include("../Core/Mysql.php");//数据库链接
include('../Core/Function.php');//函数库
if($mode!='Login'){
    /*验证Cookie*/
    if(isset($_COOKIE["Login_Token"])){
        $cookie=hash('sha256',$config->GetConfig('admin_username').$config->GetConfig('admin_password'));
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
    $username=$_GET["username"];
    $password=$_GET["password"];
    if($config->GetConfig('admin_username')==$username and $config->GetConfig('admin_password')==hash('sha256',$password)){
        $cookie=hash('sha256',$config->GetConfig('admin_username').$config->GetConfig('admin_password'));
        $return = array('code' => 200,'message' => '登录成功','cookie' => $cookie);
        exit(json_encode($return));
    }else{
        $return = array('code' => 401,'message' => '登录信息不匹配');
        exit(json_encode($return));
    }
}elseif($mode=='DeletePlugin'){
    @$id=$_GET["id"];
    @$deleteflie=$_GET["deleteflie"];
    //读取插件参数
	$plugin=$config->GetPlugin_I(@$id);
	if($plugin['code']==401){
        $return = array('code' => 401,'message' => '插件不存在');
        exit(json_encode($return));
	}else{
	    $sql->delete($prefix.'plugin')->clause(array('id'))->bind(array($id))->run();
	    if($deleteflie=='true'){
	        deleteDir('../Plugin/'.$plugin['value']['path']);
	    }
        $return = array('code' => 200,'message' => '卸载成功');
        exit(json_encode($return));
	}
	
}elseif($mode=='SetPlugin'){
    @$id=$_GET["id"];
    @$do=$_GET["do"];
    //读取插件参数
	$plugin=$config->GetPlugin_I(@$id);
	if($plugin['code']==401){
        $return = array('code' => 401,'message' => '插件不存在');
        exit(json_encode($return));
	}else{
        if($do=='Open'){
    	    if($plugin['value']['isopen']=='true'){
                $return = array('code' => 401,'message' => '插件已经开启了');
                exit(json_encode($return));
    	    }else{
                $update=$sql->update($prefix.'plugin')->key(array('isopen'))->value(array('true'))->clause(array('id'))->bind(array($id))->run(); 
                if($update["status"]==false){
                    $return = array('code' => 400,'message' => '数据库操作失败');
                    exit(json_encode($return));
                }else{
                    //配置权限列表
                    $sql->update($prefix.'plugin_event')->key(array('pluginauth'))->value(array('true'))->clause(array('pluginid'))->bind(array($id))->run();
                    $return = array('code' => 200,'message' => '开启成功');
                    exit(json_encode($return));
                }
    	    }
        }else{
    	    if($plugin['value']['isopen']=='false'){
                $return = array('code' => 401,'message' => '插件已经关闭了');
                exit(json_encode($return));
    	    }else{
                $update=$sql->update($prefix.'plugin')->key(array('isopen'))->value(array('false'))->clause(array('id'))->bind(array($id))->run(); 
                if($update["status"]==false){
                    $return = array('code' => 400,'message' => '数据库操作失败');
                    exit(json_encode($return));
                }else{
                    //配置权限列表
                    $sql->update($prefix.'plugin_event')->key(array('pluginauth'))->value(array('false'))->clause(array('pluginid'))->bind(array($id))->run();
                    $return = array('code' => 200,'message' => '关闭成功');
                    exit(json_encode($return));
                }
    	    }
        }
	}
}elseif($mode=='UpdateUserInfo'){
    $username=$_GET["username"];
    $oldpassword=$_GET["oldpassword"];
    $newpassword=$_GET["newpassword"];
    if($config->GetConfig('admin_password')==hash('sha256',$oldpassword)){
        if(strlen($username)<4){
            $return = array('code' => 400,'message' => '账户长度需要大于4位');
            exit(json_encode($return));
        }elseif(strlen($newpassword)<6){
            $return = array('code' => 400,'message' => '新密码长度需要大于6位');
            exit(json_encode($return));
        }else{
            if($username!=$config->GetConfig('admin_username')){
                $update=$sql->update($prefix.'config')->key(array('value'))->value(array($username))->clause(array('keyname'))->bind(array('admin_username'))->run(); 
                if($update["status"]==false){
                    $return = array('code' => 400,'message' => '数据库操作失败1');
                    exit(json_encode($return));
                }
            }
            if($config->GetConfig('admin_password')!=hash('sha256',$newpassword)){
                $update=$sql->update($prefix.'config')->key(array('value'))->value(array(hash('sha256',$newpassword)))->clause(array('keyname'))->bind(array('admin_password'))->run(); 
                if($update["status"]==false){
                    $return = array('code' => 400,'message' => '数据库操作失败2');
                    exit(json_encode($return));
                }
            }
            $return = array('code' => 200,'message' => '修改成功');
            exit(json_encode($return));
        }
    }else{
        $return = array('code' => 401,'message' => '原密码不正确');
        exit(json_encode($return));
    }
}elseif($mode=='UpdateBaseSet'){
    $key=$_GET["key"];
    if($config->GetConfig('plugin_key')!=$key){
        $update=$sql->update($prefix.'config')->key(array('value'))->value(array($key))->clause(array('keyname'))->bind(array('plugin_key'))->run(); 
        if($update["status"]==false){
            $return = array('code' => 400,'message' => '数据库操作失败');
            exit(json_encode($return));
        }else{
            $return = array('code' => 200,'message' => '修改成功');
            exit(json_encode($return));
        }
    }else{
        $return = array('code' => 400,'message' => '啥都没变');
        exit(json_encode($return));
    }
}elseif($mode=='UpdateCodeSet'){
    $debug_mode=$_GET["debug_mode"];
    if($config->GetConfig('debug_mode')!=$debug_mode){
        $update=$sql->update($prefix.'config')->key(array('value'))->value(array($debug_mode))->clause(array('keyname'))->bind(array('debug_mode'))->run(); 
        if($update["status"]==false){
            $return = array('code' => 400,'message' => '数据库操作失败');
            exit(json_encode($return));
        }else{
            $return = array('code' => 200,'message' => '修改成功');
            exit(json_encode($return));
        }
    }else{
        $return = array('code' => 400,'message' => '啥都没变');
        exit(json_encode($return));
    }
}elseif($mode=='InstallPlugin'){
    $pluginpath=$_GET['pluginpath'];
    if (file_exists('../Plugin/'.$pluginpath.'/Config.json')) {
        //have
        $config_flie = file_get_contents('../Plugin/'.$pluginpath.'/Config.json');//引入插件配置文件
        $config_data = json_decode($config_flie);//解析配置文件
    	$plugin=$config->GetPlugin_N($config_data->plugin->config->name);
    	if($plugin['code']==401){
            //获取权限列表-1
            foreach ($config_data->plugin->listenings as $listening) {
                @${$listening->name}=$_GET[$listening->name];
                if(!@${$listening->name}){
                    $return = array('code' => 400,'message' => '参数['.$listening->name.']缺失');
                    exit(json_encode($return));
                }
            }
            
            //MYSQL权限
            if($config_data->plugin->config->mysql==true){
                @$mysql=$_GET['mysql'];
                if(!@$mysql){
                    $return = array('code' => 400,'message' => '参数[mysql]缺失');
                    exit(json_encode($return));
                }
            }
            
            if($config_data->plugin->config->pluginadmin==true){
                $pluginadmin='true';
            }else{
                $pluginadmin='false';
            }
            
            $username=Rand1(12);
            $password=Rand1(24);
                
    	    //导入插件
            $result=$sql->insert($prefix.'plugin')->key(array('name','info','path','author','version','pluginadmin','pluginadminurl','auth_username','auth_password','auth_mysql','isopen'))->value(array($config_data->plugin->config->name,$config_data->plugin->config->info,$pluginpath,$config_data->plugin->config->author,$config_data->plugin->config->version,$pluginadmin,$config_data->plugin->config->pluginadminurl,$username,$password,$config_data->plugin->config->mysql,'false'))->run();
            if($result["status"]==false){
                $arr=array('code'=>"400",'msg'=>"数据库错误:插件数据写入异常");
                exit (json_encode($arr));
            }
            $pluginid=$result["id"];
    	    
            //获取权限列表-2
            foreach ($config_data->plugin->listenings as $listening) {
                $sql->insert($prefix.'plugin_event')->key(array('pluginid','event','auth','pluginauth'))->value(array($pluginid,$listening->name,${$listening->name},'false'))->run();
            }
            
            if(@$mysql){
                $sql->insert($prefix.'plugin_event')->key(array('pluginid','event','auth','pluginauth'))->value(array($pluginid,'mysql',$mysql,'false'))->run();
            }
            
            $return = array('code' => 200,'message' => '安装成功','id'=>$pluginid);
            exit(json_encode($return));
    	}else{
            $return = array('code' => 400,'message' => '插件已经安装过了，不允许覆盖安装，如需要覆盖安装请选择[重载插件]');
            exit(json_encode($return));
    	}
    }else{    
        if (is_dir('../Plugin/'.$pluginpath)) {
            $return = array('code' => 400,'message' => '插件没有Config配置文件');
            exit(json_encode($return));
        }else{
            $return = array('code' => 400,'message' => '插件目录不存在');
            exit(json_encode($return));
        }
    }
}elseif($mode=='SetPluginEvent'){
    $pluginid=$_GET['pluginid'];
	$plugin=$config->GetPlugin_I($pluginid);
	if($plugin['code']==200){
        //获取权限列表
        foreach ($config->Get_Plugin_Event_List($pluginid)["value"] as $listening) {
            $listening=(object)$listening;
            @${$listening->event}=$_GET[$listening->event];
            if(!@${$listening->event}){
                $return = array('code' => 400,'message' => '参数['.$listening->event.']缺失');
                exit(json_encode($return));
            }
        }
        
        //MYSQL权限
        // if($plugin['value']['auth_mysql']=='true'){
        //     @$mysql=$_GET['mysql'];
        //     if(!@$mysql){
        //         $return = array('code' => 400,'message' => '参数[mysql]缺失');
        //         exit(json_encode($return));
        //     }else{
        //         $sql->update($prefix.'plugin_event')->key(array('auth'))->value(array($mysql))->clause(array('pluginid','event'))->bind(array($pluginid,'mysql'))->run();
        //     }
        // }
        
        //配置权限列表
        foreach ($config->Get_Plugin_Event_List($pluginid)["value"] as $listening) {
            $listening=(object)$listening;
            $sql->update($prefix.'plugin_event')->key(array('auth'))->value(array(${$listening->event}))->clause(array('pluginid','event'))->bind(array($pluginid,$listening->event))->run();
        }
        
        $return = array('code' => 200,'message' => '修改成功');
        exit(json_encode($return));
	}else{
        $return = array('code' => 400,'message' => '插件不存在');
        exit(json_encode($return));
	}
}else{
    
}