<?php
//注册Md模板
$md->Add_MarkDown_Template("t","102021656_1705464684");//
if($event=='GROUP_AT_MESSAGE_CREATE'){//群消息
    /*消息1*/
    $markdown=$md->Create_Template_MarkDown_Fast('t',array('title'=>'标题','data'=>"内容\r测试"));//创建MD消息
    $return=$group->Send_Group_Message($group_openid,null,$msg_id,$markdown);//发送消息，发送md消息时候content请传参null
    
    /*消息2-创建MD消息*/
    $markdown=$md->Create_Template_MarkDown_Fast('t',array('title'=>'标题','data'=>"内容\r测试"));//创建MD消息
    /*消息2-创建按钮*/
    $button1=$md->Create_Keyboard_Button('测试1','测试1');//创建消息按钮1
    $button2=$md->Create_Keyboard_Button('测试2','测试2');//创建消息按钮2
    $button3=$md->Create_Keyboard_Button('测试3','测试3');//创建消息按钮3
    $keyboard=$md->Add_Keyboard_Button_Row($md->Create_Keyboard(),array($button1,$button2));//把消息按钮1和2放在一行内
    $keyboard=$md->Add_Keyboard_Button_Row($keyboard,array($button3));//把消息按钮3放在一行内
    /*消息2-发送*/
    $return=$group->Send_Group_Message($group_openid,null,$msg_id,$markdown,$keyboard);//发送消息，发送md消息时候content请传参null
}elseif($event=='AT_MESSAGE_CREATE' or $event=='MESSAGE_CREATE'){//频道消息
    $info=$guild->Get_Guild_Info($guild_id);//获取频道消息
    $return=$guild->Send_Guild_Message($channel_id,$info->name,$msg_id);//发送消息
}