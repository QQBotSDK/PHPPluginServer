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
error_reporting(1);//屏蔽报错
include './Config.php';//配置文件
include './Version.php';//版本文件
include './Class/Function.php';//函数库，默认为空
include './Class/Http.Class.php';//Http操作库
include './Class/Secret.Class.php';//Secret获取工具
include './Class/Bot.Class.php';//BotApi库
include './Class/Group.Class.php';//群Api库
include './Class/Guild.Class.php';//频道Api库
include './Class/GuildUser.Class.php';//频道用户Api库
include './Class/MarkDown.Class.php';//MrakDown构建库

$content = file_get_contents('php://input');//获取服务端提供的参数

if(empty($content)){
    header('Content-Type: application/json; charset=utf8');
    echo "[当前插件库版本".$Version."]插件库服务正常".PHP_EOL;
    exit;
}

//插件库密钥鉴权
$HTTP_Plugin_Key=print_r($_SERVER['HTTP_PLUGINKEY'],true);
if ($HTTP_Plugin_Key!=$Plugin_Key)
{
	die("\033[47;31m[密钥验证失败]请检查您的插件库密钥\033[0m".PHP_EOL);
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
$md=new MrakDown();

//重置$authorization和$headers等敏感数据避免恶意插件窃取数据
$authorization='';
$headers='';
$botid='';
$secret='';

//处理消息
$event = $Data["t"];

if($event=='AT_MESSAGE_CREATE' or $event=='MESSAGE_CREATE'){//文字子频道消息
    $guild_id=$Data["d"]["guild_id"];
    $msg_id=$Data["d"]["id"];
    $channel_id=$Data["d"]["channel_id"];
    $user_id=$Data["d"]["author"]["id"];
    $username=$Data["d"]["author"]["username"];
    $avatar=$Data["d"]["author"]["avatar"];
    $joined_at=$Data["d"]["member"]["joined_at"];
    $roles=$Data["d"]["member"]["roles"];
    $event_id=$Data["id"];
    $content=$Data["d"]["content"];
    $seq=$Data["d"]["seq"];
    $seq_in_channel=$Data["d"]["seq_in_channel"];
    $timestamp=$Data["d"]["timestamp"];
    
    $content_arr=Compatible($content,$bot->Get_Bot_Info()->id);
    
    $data = [
        'event' => $event,
        'event_id' => $event_id,
        'data' => [
            'msg_id' => $msg_id,
            'guild_id' => $guild_id,
            'channel_id' => $channel_id,
            'author' => [
                'user_id' => $user_id,
                'avatar' => $avatar,
                'username' => $username,
                'joined_at' => $joined_at,
                'roles' => $roles,
            ],
            'content' => $content,
            'content_1' => $content_arr['content_1'],
            'content_2' => $content_arr['content_2'],
            'content_3' => $content_arr['content_3'],
            'seq' => $seq,
            'seq_in_channel' => $seq_in_channel,
            'timestamp' => $timestamp,
        ],
    ];
    $data=json_decode(json_encode($data));//转换为Object
}elseif($event=='GROUP_AT_MESSAGE_CREATE'){//群消息
    $group_id=$Data["d"]["group_id"];
    $group_openid=$Data["d"]["group_openid"];
    $user_id=$Data["d"]["author"]["id"];
    $msg_id=$Data["d"]["id"];
    $member_openid=$Data["d"]["author"]["member_openid"];
    $event_id=$Data["id"];
    $content=$Data["d"]["content"];
    $timestamp=$Data["d"]["timestamp"];
    
    $content_arr=Compatible($content,$bot->Get_Bot_Info()->id);
    
    $data = [
        'event' => $event,
        'event_id' => $event_id,
        'data' => [
            'msg_id' => $msg_id,
            'group_id' => $group_id,
            'group_openid' => $group_openid,
            'author' => [
                'user_id' => $user_id,
                'member_openid' => $member_openid
            ],
            'content' => $content,
            'content_1' => $content_arr['content_1'],
            'content_2' => $content_arr['content_2'],
            'content_3' => $content_arr['content_3'],
            'timestamp' => $timestamp,
        ],
    ];
    $data=json_decode(json_encode($data));//转换为Object
}else{
    header('Content-Type: application/json; charset=utf8');
    echo "[Event:".$event."]推送了不受支持的事件".PHP_EOL;
    exit;
}
 
//加载Plugin下的所有的插件目录
$list = glob('./Plugin/*');
foreach($list as $file){
    $config = file_get_contents($file.'/Config.json');//引入插件配置文件
    $config_data = json_decode($config);//解析配置文件
    //判断插件是否开启
    if($config_data->plugin->config->isopen==true){
        foreach ($config_data->plugin->listenings as $listening) {
            //判断插件是否有权限接受消息
            if($listening->name==$event){
                //引入插件主文件
                require $file.'/Main.php';
                break;
            }
        }
    }
}

//整合日志
$plugin_return=array_merge($group->Get_Plugin_Return(),$guild->Get_Plugin_Return());

//返回
$return = array 
(
    'server_version' => $Version,//插件库版本
    'plugin_return' => $plugin_return//插件库的返回数据
);
echo json_encode($return);
?>