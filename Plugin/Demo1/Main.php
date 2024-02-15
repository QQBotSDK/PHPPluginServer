<?php
if($event=='AT_MESSAGE_CREATE' or $event=='MESSAGE_CREATE'){//频道消息
    $info=$guild->Get_Message_Info($channel_id,$msg_id);//获取消息详情
    $return=$guild->Send_Guild_Message($channel_id,"msgid:".$msg_id.",msgid2:".$info->message->id,$msg_id);//发送消息
}