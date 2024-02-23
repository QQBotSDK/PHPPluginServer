<?php
// +----------------------------------------------------------------------
// | Quotes [二次开发请留版权,严禁用于非法用途]
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author:书迷  <jsrcode@qq.com>
// +----------------------------------------------------------------------
// | Date: 2024年02月14日
// +----------------------------------------------------------------------

function GetPluginInfo($id){
    //加载Plugin下的所有的插件
    $list = glob('./Plugin/*');
    $i=0;
    foreach($list as $file){
        $config = file_get_contents($file.'/Config.json');//引入插件配置文件
        $config_data = json_decode($config);//解析配置文件
    	$i++;
    	if($i==$id){//匹配上了
            //判断插件是否开启
            if($config_data->plugin->config->isopen==true){
                $isopen="开启";
            }else{
                $isopen="关闭";
            }
            //获取权限列表
            foreach ($config_data->plugin->listenings as $listening) {
                $eventname=Get_Event_Name($listening->name);
                $listeningevent.=$eventname."\n";
            }
        	$plugin="[插件".$config_data->plugin->config->name."]\nID:".$i."\n状态:".$isopen."\nListingEvent:\n".$listeningevent;
        	}
    }
    if(!$plugin){
        $plugin="插件ID错误";
    }
    return $plugin;
}

function GetPluginList(){
    //加载Plugin下的所有的插件
    $list = glob('./Plugin/*');
    $i=0;
    foreach($list as $file){
        $config = file_get_contents($file.'/Config.json');//引入插件配置文件
        $config_data = json_decode($config);//解析配置文件
    	$i++;
        //判断插件是否开启
        if($config_data->plugin->config->isopen==true){
            $isopen="开启";
        }else{
            $isopen="关闭";
        }
    	$plugin.="[插件".$i."]".$config_data->plugin->config->name."-".$isopen."\n";
    }
    return $plugin;
}

function SetPlugin($id,$mode){
    //加载Plugin下的所有的插件
    $list = glob('./Plugin/*');
    $i=0;
    foreach($list as $file){
        $config = file_get_contents($file.'/Config.json');//引入插件配置文件
        $config_data = json_decode($config);//解析配置文件
    	$i++;
    	if($i==$id){//匹配上了
            //判断插件是否开启
            if($mode=='Open'){
                if($config_data->plugin->config->isopen==true){
                    $plugin="插件已经开启了";
                }else{
                    $config_data->plugin->config->isopen=true;
                    $myfile = fopen($file.'/Config.json', "w");
                    $data = json_encode($config_data, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
                    fwrite($myfile, $data);
                    fclose($myfile);
                    $plugin="插件开启成功";
                }
            }elseif($mode=='Close'){
                if($config_data->plugin->config->isopen==false){
                    $plugin="插件已经关闭了";
                }else{
                    $config_data->plugin->config->isopen=false;
                    $myfile = fopen($file.'/Config.json', "w");
                    $data = json_encode($config_data, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
                    fwrite($myfile, $data);
                    fclose($myfile);
                    $plugin="插件关闭成功";
                }
            }
    	}
    }
    if(!$plugin){
        $plugin="插件ID错误";
    }
    return $plugin;
}

if($event=='GROUP_AT_MESSAGE_CREATE'){//群消息
    if($data->data->content_1=='PluginList'){
        $plugin=GetPluginList();
        $return=$group->Send_Group_Message($data->data->group_openid,"\nPluginList：\n".$plugin."\nPluginInfo PluginID",$data->data->msg_id);//发送消息
        if($return['return']['code']=='400'){
            $return=$group->Send_Group_Message($data->data->group_openid,"\n消息发送失败",$data->data->msg_id);//发送消息
        }
    }elseif($data->data->content_3=='PluginInfo'){
        if(isset($data->data->content_2[1])){
            $plugin=GetPluginInfo($data->data->content_2[1]);
            $return=$group->Send_Group_Message($data->data->group_openid,$plugin."\n开启:SetPlugin PluginID Open\n关闭:SetPlugin PluginID Close",$data->data->msg_id);//发送消息
            if($return['return']['code']=='400'){
                $return=$group->Send_Group_Message($data->data->group_openid,"\n消息发送失败",$data->data->msg_id);//发送消息
            }
        }else{
            $return=$group->Send_Group_Message($data->data->group_openid,"请提供PluginID",$data->data->msg_id);//发送消息
            if($return['return']['code']=='400'){
                $return=$group->Send_Group_Message($data->data->group_openid,"\n消息发送失败",$data->data->msg_id);//发送消息
            }
        }
    }elseif($data->data->content_3=='SetPlugin'){
        if(isset($data->data->content_2[1]) and isset($data->data->content_2[2])){
            $plugin=SetPlugin($data->data->content_2[1],$data->data->content_2[2]);
            $return=$group->Send_Group_Message($data->data->group_openid,$plugin,$data->data->msg_id);//发送消息
            if($return['return']['code']=='400'){
                $return=$group->Send_Group_Message($data->data->group_openid,"\n消息发送失败",$data->data->msg_id);//发送消息
            }
        }else{
            $return=$group->Send_Group_Message($data->data->group_openid,"请提供PluginID和Mode",$data->data->msg_id);//发送消息
            if($return['return']['code']=='400'){
                $return=$group->Send_Group_Message($data->data->group_openid,"\n消息发送失败",$data->data->msg_id);//发送消息
            }
        }
    }
}elseif($event=='AT_MESSAGE_CREATE' or $event=='MESSAGE_CREATE'){//频道消息
    if($data->data->content_1=='PluginList'){
        $plugin=GetPluginList();
        $return=$guild->Send_Guild_Message($data->data->channel_id,"PluginList：\n".$plugin."\nPluginInfo PluginID",$data->data->msg_id);//发送消息
        if($return['return']['code']=='400'){
            $return=$guild->Send_Guild_Message($data->data->channel_id,"\n消息发送失败",$data->data->msg_id);//发送消息
        }
    }elseif($data->data->content_3=='PluginInfo'){
        if(isset($data->data->content_2[1])){
            $plugin=GetPluginInfo($data->data->content_2[1]);
            $return=$guild->Send_Guild_Message($data->data->channel_id,$plugin."\n开启:SetPlugin PluginID Open\n关闭:SetPlugin PluginID Close",$data->data->msg_id);//发送消息
            if($return['return']['code']=='400'){
                $return=$guild->Send_Guild_Message($data->data->channel_id,"\n消息发送失败",$data->data->msg_id);//发送消息
            }
        }else{
            $return=$guild->Send_Guild_Message($data->data->channel_id,"请提供PluginID",$data->data->msg_id);//发送消息
            if($return['return']['code']=='400'){
                $return=$guild->Send_Guild_Message($data->data->channel_id,"\n消息发送失败",$data->data->msg_id);//发送消息
            }
        }
    }elseif($data->data->content_3=='SetPlugin'){
        if(isset($data->data->content_2[1]) and isset($data->data->content_2[2])){
            $plugin=SetPlugin($data->data->content_2[1],$data->data->content_2[2]);
            $return=$guild->Send_Guild_Message($data->data->channel_id,$plugin,$data->data->msg_id);//发送消息
            if($return['return']['code']=='400'){
                $return=$guild->Send_Guild_Message($data->data->channel_id,"\n消息发送失败",$data->data->msg_id);//发送消息
            }
        }else{
            $return=$guild->Send_Guild_Message($data->data->channel_id,"请提供PluginID和Mode",$data->data->msg_id);//发送消息
            if($return['return']['code']=='400'){
                $return=$guild->Send_Guild_Message($data->data->channel_id,"\n消息发送失败",$data->data->msg_id);//发送消息
            }
        }
    }
}