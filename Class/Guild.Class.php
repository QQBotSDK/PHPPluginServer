<?php
// +----------------------------------------------------------------------
// | Quotes [二次开发请留版权,严禁用于非法用途]
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author:书迷  <jsrcode@qq.com>
// +----------------------------------------------------------------------
// | Date: 2024年02月13日
// +----------------------------------------------------------------------
class GuildAPI{
    public function __construct($url,$headers){
        //对象化$url变量
        $this->url=$url;
        //对象化$headers变量
        $this->headers=$headers;
        //对象化日志数组
        $this->plugin_return=[];
    }
    
    //发送消息
    function Send_Guild_Message($channel_id,$content=null,$msg_id=null,$image=null,$event_id=null){
        if($channel_id==''){
            return '';
        }
        if($content==null and $image==null){
            return '';
        }
        $key=array();
        $value=array();
        if($content!=null){
            array_push($key,'content');
            array_push($value,$content);
        }
        if($image!=null){
            array_push($key,'image');
            array_push($value,$image);
        }
        if($msg_id!=null){
            array_push($key,'msg_id');
            array_push($value,$msg_id);
        }
        if($event_id!=null){
            array_push($key,'event_id');
            array_push($value,$event_id);
        }
        $msg=array_combine($key,$value);
        $url=$this->url.'/channels/'.$channel_id.'/messages';
        $json = json_encode($msg);
        $send = json_decode(Send_Post($url, $json, $this->headers));
        if($event_id){
            $type="被动";
        }elseif($msg_id){
            $type="被动";
        }else{
            $type="主动";
        }
        if(@$send->id){
            $return_log="向子频道[$channel_id]发送{$type}消息成功,消息内容[$content],消息ID为[$send->id]";
            $return=array('code'=>200);
        }else{
            $send = json_encode($send);
            $return_log="向子频道[$channel_id]发送{$type}消息失败,消息内容[$content],返回数据为[$send]";
            $return=array('code'=>400);
        }
        $this->plugin_return[]=$return_log;//把发送消息的接口返回写入日志
        $return_arr=array('return'=>$return,'return_log'=>$return_log,'fulljson'=>$send);
        return $return_arr;
    }
    
    //获取指定消息详情
    function Get_Message_Info($channel_id,$msg_id){
        if($channel_id=='' or $msg_id==''){
            return '';
        }
        $url=$this->url.'/channels/'.$channel_id.'/messages/'.$msg_id;
        $info = json_decode(Send_Get($url, $this->headers));
        return $info;
    }
    
    //获取指定频道详情
    function Get_Guild_Info($guild_id){
        if($guild_id==''){
            return '';
        }
        $url=$this->url.'/guilds/'.$guild_id;
        $info = json_decode(Send_Get($url, $this->headers));
        return $info;
    }
    
    //获取指定子频道详情
    function Get_Channel_Info($channel_id){
        if($channel_id==''){
            return '';
        }
        $url=$this->url.'/channels/'.$channel_id;
        $info = json_decode(Send_Get($url, $this->headers));
        return $info;
    }
    
    //获取某频道的子频道列表
    function Get_Channel_List($guild_id){
        if($guild_id==''){
            return '';
        }
        $url=$this->url.'/guilds/'.$guild_id.'/channels';
        $info = json_decode(Send_Get($url, $this->headers));
        return $info;
    }
    
    //返回日志[不懂不要改，改了有可能输出不了日志]
    function Get_Plugin_Return(){
        return $this->plugin_return;
    }
}