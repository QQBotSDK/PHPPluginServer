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
class GuildUserAPI{
    public function __construct($url,$headers){
        //对象化$url变量
        $this->url=$url;
        //对象化$headers变量
        $this->headers=$headers;
    }
    
    function Get_GuildUser_Info($guild_id,$user_id){
        if($guild_id=='' or $user_id==''){
            return '';
        }
        $url=$this->url.'/guilds/'.$guild_id.'/members/'.$user_id;
        $info = json_decode(Send_Get($url, $this->headers),true);
        $info=(Object)$info;
        return $info;
    }
}
?>