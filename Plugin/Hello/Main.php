<?php
if($event=='GROUP_AT_MESSAGE_CREATE'){//群消息
    $return=$group->Send_Group_Message($group_openid,'Hello,world',$msg_id);//发送消息
}elseif($event=='AT_MESSAGE_CREATE' or $event=='MESSAGE_CREATE'){//频道消息
    $return=$guild->Send_Guild_Message($channel_id,'Hello,world',$msg_id);//发送消息
}