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
class GroupAPI{
    public function __construct($url,$headers){
        //对象化$url变量
        $this->url=$url;
        //对象化$headers变量
        $this->headers=$headers;
        //对象化$msg_seq变量
        $this->msg_seq=1;
        //对象化日志数组
        $this->plugin_return=[];
    }
    
    //发送消息
    function Send_Group_Message($group_openid,$content=null,$msg_id=null,$markdown=null,$keyboard=null){
        if($group_openid==''){
            return '';
        }
        if($content==null and $image==null and $markdown==null){
            return '';
        }
        
        $msg_seq=$this->msg_seq;
        $this->msg_seq++;//seq自增
        
        $key=array();
        $value=array();
        // if($content!=null and $image!=null){//图文消息
        //     array_push($key,'msg_type');
        //     array_push($value,1);
        // }
        if($markdown!=null){//md消息
            array_push($key,'msg_type');
            array_push($value,2);
            array_push($key,'markdown');
            array_push($value,$markdown);
            if($keyboard!=null){
                array_push($key,'keyboard');
                array_push($value,$keyboard);
            }
        }
        if($content!=null){//文本消息
            array_push($key,'msg_type');
            array_push($value,0);
            array_push($key,'content');
            array_push($value,$content);
        }
        // if($image!=null){
        //     array_push($key,'image');
        //     array_push($value,$image);
        // }
        if($msg_id!=null){
            array_push($key,'msg_id');
            array_push($value,$msg_id);
        }
        // if($event_id!=null){
        //     array_push($key,'event_id');
        //     array_push($value,$event_id);
        // }
        if($msg_seq!=null){
            array_push($key,'msg_seq');
            array_push($value,$msg_seq);
        }
        
        $msg=array_combine($key,$value);
        //print_r($msg);
        $url=$this->url.'/v2/groups/'.$group_openid.'/messages';
        $json = json_encode($msg);
        //print_r($json);
        $send = json_decode(Send_Post($url, $json, $this->headers));
        if($event_id){
            $type="被动";
        }elseif($msg_id){
            $type="被动";
        }else{
            $type="主动";
        }
        if($markdown!=null){//md消息
            $type=$type.'MarkDown';
            $content="\nMarkDown:".json_encode($markdown);
            if($keyboard!=null){
                $content=$content."\nKeyBoard:".json_encode($keyboard);
            }
        }
        if($content!=null){//文本消息
            $type=$type.'普通文本';
        }
        if($content!=null and $image!=null){//图文消息
            $type=$type.'图文';
        }
        //print_r($send);
        if(@$send->id){
            $return_log="[Seq:{$msg_seq}]向群聊[$group_openid]发送{$type}消息成功,消息内容[$content],消息ID为[$send->id]";
            $return=array('code'=>200);
        }else{
            $send = json_encode($send);
            $return_log="[Seq:{$msg_seq}]向群聊[$group_openid]发送{$type}消息失败,消息内容[$content],返回数据为[$send]";
            $return=array('code'=>400);
        }
        $this->plugin_return[]=$return_log;//把发送消息的接口返回写入日志
        $return_arr=array('return'=>$return,'return_log'=>$return_log,'fulljson'=>$send);
        return $return_arr;
    }
    
    //返回日志[不懂不要改，改了有可能输出不了日志]
    function Get_Plugin_Return(){
        return $this->plugin_return;
    }
}