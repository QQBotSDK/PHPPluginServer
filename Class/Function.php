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

/*可以自行添加有需要的函数*/

//处理消息
function Compatible($content,$botuid){
    //对消息进行处理
    $content_1=str_replace('/', '', $content);//去除/
    $content_1=str_replace('<@!'.$botuid.'>', '', $content_1);//去除掉@本机器人（频道消息生效）
    $content_1=trim($content_1);//去除字符串两端的空白字符
    $content_1=str_replace('  ', ' ', $content_1);//将俩个空白合并为一个
    $content_1=str_replace('   ', ' ', $content_1);//将三个空白合并为一个
    @$content_2=explode(' ',$content_1);//按照空格分隔
    @$content_3=$content_2[0];//第一分割区的内容
    $content_arr=array('content_1'=>$content_1,'content_2'=>$content_2,'content_3'=>$content_3);
    return $content_arr;
}

//获取事件名
function Get_Event_Name($event){
    switch ($event) {
        case 'AT_MESSAGE_CREATE':
            $eventname='频道@消息事件';
            break;
        case 'PUBLIC_MESSAGE_DELETE':
            $eventname='频道消息撤回事件';
            break;
        case 'MESSAGE_CREATE':
            $eventname='频道全量消息事件(私域)';
            break;
        case 'MESSAGE_DELETE':
            $eventname='频道全量消息撤回事件(私域)';
            break;
        case 'GROUP_AT_MESSAGE_CREATE':
            $eventname='群@消息事件';
            break;
        case 'GUILD_CREATE':
            $eventname='机器人加入频道事件';
            break;
        case 'GUILD_UPDATE':
            $eventname='频道资料更新事件';
            break;
        case 'GUILD_DELETE':
            $eventname='机器人被移除频道事件';
            break;
        case 'CHANNEL_CREATE':
            $eventname='子频道创建事件';
            break;
        case 'CHANNEL_UPDATE':
            $eventname='子频道资料更新事件';
            break;
        case 'CHANNEL_DELETE':
            $eventname='子频道删除事件';
            break;
        case 'GUILD_MEMBER_ADD':
            $eventname='频道成员加入事件';
            break;
        case 'GUILD_MEMBER_UPDATE':
            $eventname='频道成员资料更新事件';
            break;
        case 'GUILD_MEMBER_REMOVE':
            $eventname='频道成员退出事件';
            break;
        case 'MESSAGE_REACTION_ADD':
            $eventname='用户为消息添加表情表态事件';
            break;
        case 'MESSAGE_REACTION_REMOVE':
            $eventname='用户为消息删除表情表态事件';
            break;
        case 'DIRECT_MESSAGE_CREATE':
            $eventname='频道私聊消息事件';
            break;
        case 'DIRECT_MESSAGE_DELETE':
            $eventname='频道私聊消息撤回事件';
            break;
        case 'INTERACTION_CREATE':
            $eventname='互动消息创建事件';
            break;
        case 'MESSAGE_AUDIT_PASS':
            $eventname='主动消息审核通过事件';
            break;
        case 'MESSAGE_AUDIT_REJECT':
            $eventname='主动消息审核不通过事件';
            break;
        //还有没弄完的
        // case '':
        //     $eventname='事件';
        //     break;
        // case '':
        //     $eventname='事件';
        //     break;
        // case '':
        //     $eventname='事件';
        //     break;
        // case '':
        //     $eventname='事件';
        //     break;
        // case '':
        //     $eventname='事件';
        //     break;
        // case '':
        //     $eventname='事件';
        //     break;
        // case '':
        //     $eventname='事件';
        //     break;
        // case '':
        //     $eventname='事件';
        //     break;
        default:
            $eventname='未知权限';
            break;
    }
    return $eventname;
}
?>