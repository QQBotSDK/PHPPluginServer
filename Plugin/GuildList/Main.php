<?php
if($event=='AT_MESSAGE_CREATE' or $event=='MESSAGE_CREATE'){//频道消息
    if($data->data->content_1=='GuildList'){
        $info=$bot->Get_Bot_Guild_List();//频道列表
        $i=0;
        foreach($info as $guildinfo){
            $i++;
            $name=$name.$i."[".$guildinfo->id."-".$guildinfo->name."]";
        }
        $return=$guild->Send_Guild_Message($channel_id,$name,$msg_id);//发送消息
    }elseif($data->data->content_1=='ChannelList'){
        $info=$guild->Get_Channel_List($guild_id);//子频道列表
        $i=0;
        foreach($info as $channelinfo){
            $i++;
            $name=$name.$i."[".$channelinfo->id."-".$channelinfo->name."]";
        }
        $return=$guild->Send_Guild_Message($channel_id,$name,$msg_id);//发送消息
    }
}