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
class BotAPI{
    public function __construct($url,$headers){
        //对象化$url变量
        $this->url=$url;
        //对象化$headers变量
        $this->headers=$headers;
    }
    
    function Get_Bot_Info(){
        $url=$this->url.'/users/@me';
        $info = json_decode(Send_Get($url, $this->headers));
        return $info;
    }
    
    function Get_Bot_Guild_List(){
        $url=$this->url.'/users/@me/guilds';
        $info = json_decode(Send_Get($url, $this->headers));
        return $info;
    }
}