<?php
// +----------------------------------------------------------------------
// | Quotes [二次开发请留版权,严禁用于非法用途]
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author:书迷  <jsrcode@qq.com>
// +----------------------------------------------------------------------
// | Date: 2024年02月26日
// +----------------------------------------------------------------------
include './Version.php';//版本文件
include './Core/Function.php';//函数库
include './Core/Api_Class/Http.Class.php';//Http操作库
include './Core/Api_Class/Secret.Class.php';//Secret获取工具
include './Core/Api_Class/Bot.Class.php';//BotApi库
include './Core/Api_Class/Group.Class.php';//群Api库
include './Core/Api_Class/Guild.Class.php';//频道Api库
include './Core/Api_Class/GuildUser.Class.php';//频道用户Api库
include './Core/Api_Class/MarkDown.Class.php';//MrakDown构建库
include './Core/Mysql.php';//数据库链接
if($config->GetConfig('debug_mode')=='false'){//非Debug模式
    error_reporting(0);
    $mode='';//提示
}else{//Debug模式
    $mode='[Debug模式]';//提示
}

$content = file_get_contents('php://input');//获取服务端提供的参数

if(empty($content)){
	if($_SERVER['REQUEST_METHOD'] === 'POST'){
        //返回
        $return = array (
            'code' => 400,//状态码
            'message' => $mode.'插件库服务正常',//返回
            'server_version' => $Version,//插件库版本
        );
        echo json_encode($return);//返回数据
        exit();
	}else{
	    echo $mode."[当前插件库版本".$Version."]插件库服务正常".PHP_EOL;
	    exit();
	}
}

//插件库密钥鉴权
$HTTP_Plugin_Key=print_r($_SERVER['HTTP_PLUGINKEY'],true);
if ($HTTP_Plugin_Key!=$config->GetConfig('plugin_key')){
    //返回
    $return = array (
        'code' => 401,//状态码
        'message' => '[密钥验证失败]请检查您的插件库密钥',//返回
        'server_version' => $Version,//插件库版本
    );
    echo json_encode($return);//返回数据
    exit();
}

header('content-type:application/json');
$Data=json_decode($content,true);

//组装鉴权数组
$botid = print_r($_SERVER['HTTP_BOTID'],true);
$secret = print_r($_SERVER['HTTP_SECRET'],true);
$authorization=Get_Authorization($botid,$secret);
$headers = array(
    'Content-Type: application/json',
    'Authorization:' . $authorization,
    'X-Union-Appid:' . $botid
);

//请求的Url
$url=print_r($_SERVER['HTTP_URL'],true);

//引入GroupAPI类
$group=new GroupAPI($url,$headers);
//引入GuildAPI类
$guild=new GuildAPI($url,$headers);
//引入GroupAPI类
$guilduser=new GuildUserAPI($url,$headers);
//引入GroupAPI类
$bot=new BotAPI($url,$headers);
//引入Mrakdown类
$md=new MarkDown();

//处理消息
$event = $Data["t"];

if($event=='AT_MESSAGE_CREATE' or $event=='MESSAGE_CREATE'){//文字子频道消息
    
    $content_arr=Compatible($Data["d"]["content"],$bot->Get_Bot_Info()->id);
    
    $data = [
        'event' => $event,
        'event_id' => $Data["id"],
        'data' => [
            'msg_id' => $Data["d"]["id"],
            'guild_id' => $Data["d"]["guild_id"],
            'channel_id' => $Data["d"]["channel_id"],
            'author' => [
                'user_id' => $Data["d"]["author"]["id"],
                'avatar' => $Data["d"]["author"]["avatar"],
                'username' => $Data["d"]["author"]["username"],
                'joined_at' => $Data["d"]["member"]["joined_at"],
                'roles' => $Data["d"]["member"]["roles"],
            ],
            'content' => $Data["d"]["content"],
            'content_1' => $content_arr['content_1'],
            'content_2' => $content_arr['content_2'],
            'content_3' => $content_arr['content_3'],
            'seq' => $Data["d"]["seq"],
            'seq_in_channel' => $Data["d"]["seq_in_channel"],
            'timestamp' => $Data["d"]["timestamp"],
        ],
    ];
    $data=json_decode(json_encode($data));//转换为Object
}elseif($event=='GROUP_AT_MESSAGE_CREATE'){//群消息
    
    $content_arr=Compatible($Data["d"]["content"],$bot->Get_Bot_Info()->id);
    
    $data = [
        'event' => $event,
        'event_id' => $Data["id"],
        'data' => [
            'msg_id' => $Data["d"]["id"],
            'group_id' => $Data["d"]["group_id"],
            'group_openid' => $Data["d"]["group_openid"],
            'author' => [
                'user_id' => $Data["d"]["author"]["id"],
                'avatar' => "https://q.qlogo.cn/qqapp/".$botid."/".$Data["d"]["author"]["member_openid"]."/100",
                'member_openid' => $Data["d"]["author"]["member_openid"]
            ],
            'content' => $Data["d"]["content"],
            'content_1' => $content_arr['content_1'],
            'content_2' => $content_arr['content_2'],
            'content_3' => $content_arr['content_3'],
            'timestamp' => $Data["d"]["timestamp"],
        ],
    ];
    $data=json_decode(json_encode($data));//转换为Object
}else{
    //返回
    $return = array (
        'code' => 402,//状态码
        'message' => '推送了不受支持的事件',//返回
        'server_version' => $Version,//插件库版本
        'event' => $event//不支持的事件
    );
    echo json_encode($return);//返回数据
    exit;
}

//载入插件函数
function Include_Plugin($path,$event,$data,$guild,$group,$md,$bot,$guilduser,$conn=false,$sql=false){
    require $path;
}

$plugin_list=[];
//载入插件列表
$list=$config->Get_Plugin_List_Event($event)['value'];
foreach($list as $plugin){
    //读取插件详情
    $plugininfo=$config->GetPlugin_I($plugin['pluginid']);
    //读取是否有Mysql权限
    $mysql_check=$config->Get_Plugin_Event($plugin['pluginid'],'mysql');
    if($mysql_check['code']=='200'){
        $r_conn=$conn;
        $r_sql=$sql;
    }else{
        $r_conn=false;
        $r_sql=false;
    }
    $plugin_list[]=$plugininfo['value']['name'];
    //载入插件
    Include_Plugin('./Plugin/'.$plugininfo['value']['path'].'/Main.php',$event,$data,$guild,$group,$md,$bot,$guilduser,$r_conn,$r_sql);
    break;
}

//整合日志
$plugin_return=array_merge($group->Get_Plugin_Return(),$guild->Get_Plugin_Return());

//返回
$return = array (
    'code' => 200,//状态码
    'message' => '成功',//返回
    'plugin_list' => $plugin_list,//触发的插件列表
    'server_version' => $Version,//插件库版本
    'plugin_return' => $plugin_return//插件库的返回数据
);
echo json_encode($return);//返回日志数据
?>