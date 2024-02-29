<?php
// +----------------------------------------------------------------------
// | Quotes [二次开发请留版权,严禁用于非法用途]
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author:书迷  <jsrcode@qq.com>
// +----------------------------------------------------------------------
// | Date: 2024年02月26日
// +----------------------------------------------------------------------
define('SYSTEM_ROOT', dirname(__FILE__).'/');//根目录
define('ROOT', dirname(SYSTEM_ROOT).'/');//Core目录


if(!@include(ROOT."Config.php")){//获取数据库配置文件
    echo"请先安装 <a href='./Install'>一键安装1</a> <a href='../Install'>一键安装2[一键安装1无法打开时点我]</a>";
    exit();
}

// 创建连接
$conn = new mysqli($servername, $username, $password,$datename,$port);
// 检测连接
if ($conn->connect_error) {
    $arr=array('code'=>"400",'msg'=>"Mysql数据库连接失败: " . $conn->connect_error);
    exit (json_encode($arr));
} 

//载入数据库操作支持库
include(SYSTEM_ROOT."Mysql_Class/SQLFunc.php");
//引入数据库操作函数
$sql = new \GetSqlFunc\GetSqlFunc();
//绑定连接
$sql->Connect_Loader($conn);
// 数据库链接部分 End

//脱敏处理
$servername = "";
$username = "";
$password = "";
$datename= "";

class Config{
    public function __construct($sql,$prefix){
        //对象化$sql变量
        $this->sql=$sql;
        //对象化$prefix变量
        $this->prefix=$prefix;
    }
    
    //获取配置表
    function GetConfig($key){
        $config=$this->sql->select($this->prefix.'config')->key(array('*'))->clause(array('keyname'))->bind(array($key))->run();
        if($config["status"]==false or $config["isnull"]==true){
            $arr=array('code'=>"400",'msg'=>"数据库异常:配置表读取异常");
            exit (json_encode($arr));
        }else{
            return $config['callback'][0]["value"];
        }
    }
    
    //获取插件详情-路径
    function GetPlugin_P($path){
        $config=$this->sql->select($this->prefix.'plugin')->key(array('*'))->clause(array('path'))->bind(array($path))->run();
        if($config["status"]==false){
            $arr=array('code'=>"400",'msg'=>"数据库异常:配置表读取异常");
            exit (json_encode($arr));
        }elseif($config["isnull"]==true){
            return array('code'=>"401",'msg'=>"NoPlugin");
        }else{
            return array('code'=>"200",'msg'=>"NoPlugin",'value'=>$config['callback'][0]);
        }
    }
    
    //获取插件详情-插件名
    function GetPlugin_N($name){
        $config=$this->sql->select($this->prefix.'plugin')->key(array('*'))->clause(array('name'))->bind(array($name))->run();
        if($config["status"]==false){
            $arr=array('code'=>"400",'msg'=>"数据库异常:配置表读取异常");
            exit (json_encode($arr));
        }elseif($config["isnull"]==true){
            return array('code'=>"401",'msg'=>"NoPlugin");
        }else{
            return array('code'=>"200",'msg'=>"NoPlugin",'value'=>$config['callback'][0]);
        }
    }
    
    //获取插件详情-插件ID
    function GetPlugin_I($id){
        $config=$this->sql->select($this->prefix.'plugin')->key(array('*'))->clause(array('id'))->bind(array($id))->run();
        if($config["status"]==false){
            $arr=array('code'=>"400",'msg'=>"数据库异常:配置表读取异常");
            exit (json_encode($arr));
        }elseif($config["isnull"]==true){
            return array('code'=>"401",'msg'=>"NoPlugin");
        }else{
            return array('code'=>"200",'msg'=>"NoPlugin",'value'=>$config['callback'][0]);
        }
    }
    
    //获取插件列表
    function Get_Plugin_List(){
        $config=$this->sql->select($this->prefix.'plugin')->key(array('*'))->run();
        if($config["status"]==false){
            $arr=array('code'=>"400",'msg'=>"数据库异常:配置表读取异常");
            exit (json_encode($arr));
        }elseif($config["isnull"]==true){
            return array('code'=>"401",'msg'=>"NoPlugin");
        }else{
            return array('code'=>"200",'msg'=>"NoPlugin",'value'=>$config['callback'],'allpage'=>$config['allpage']);
        }
    }
    
    //分页的插件列表
    function Get_Plugin_List_Page($page){
        $config=$this->sql->select($this->prefix.'plugin')->key(array('*'))->listrow('10')->page($page)->run();
        if($config["status"]==false){
            $arr=array('code'=>"400",'msg'=>"数据库异常:配置表读取异常");
            exit (json_encode($arr));
        }elseif($config["isnull"]==true){
            return array('code'=>"401",'msg'=>"NoPlugin");
        }else{
            return array('code'=>"200",'msg'=>"NoPlugin",'value'=>$config['callback'],'allpage'=>$config['allpage']);
        }
    }
    
    //获取某插件的Event列表
    function Get_Plugin_Event_List($id){
        $config=$this->sql->select($this->prefix.'plugin_event')->key(array('*'))->clause(array('pluginid'))->bind(array($id))->run();
        if($config["status"]==false){
            $arr=array('code'=>"400",'msg'=>"数据库异常:配置表读取异常");
            exit (json_encode($arr));
        }elseif($config["isnull"]==true){
            return array('code'=>"401",'msg'=>"NoPlugin");
        }else{
            return array('code'=>"200",'msg'=>"NoPlugin",'value'=>$config['callback']);
        }
    }
    
    //获取允许某Event的插件列表
    function Get_Plugin_List_Event($event){
        $config=$this->sql->select($this->prefix.'plugin_event')->key(array('*'))->clause(array('event','auth','pluginauth'))->bind(array($event,'true','true'))->run();
        if($config["status"]==false){
            $arr=array('code'=>"400",'msg'=>"数据库异常:配置表读取异常");
            exit (json_encode($arr));
        }elseif($config["isnull"]==true){
            return array('code'=>"401",'msg'=>"NoPlugin");
        }else{
            return array('code'=>"200",'msg'=>"NoPlugin",'value'=>$config['callback']);
        }
    }
    
    //获取某插件的Event授权状态
    function Get_Plugin_Event($id,$event){
        $config=$this->sql->select($this->prefix.'plugin_event')->key(array('*'))->clause(array('event','auth','pluginid'))->bind(array($event,'true',$id))->run();
        if($config["status"]==false){
            $arr=array('code'=>"400",'msg'=>"数据库异常:配置表读取异常");
            exit (json_encode($arr));
        }elseif($config["isnull"]==true){
            return array('code'=>"401",'msg'=>"No");
        }else{
            return array('code'=>"200",'msg'=>"Allow");
        }
    }
}

$config=new Config($sql,$prefix);
?>