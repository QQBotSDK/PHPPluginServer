<?php
// +----------------------------------------------------------------------
// | Quotes [二次开发请留版权,严禁用于非法用途]
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author:书迷  <jsrcode@qq.com>
// +----------------------------------------------------------------------
// | Date: 2024年02月18日
// +----------------------------------------------------------------------
include './Head.php';//载入头文件
include './Footer.php';//载入页尾文件
$id=$_GET['id'];
function GetPluginAdmin($id){
    $plugin=$config->GetPlugin_I($id);
    if($plugin['code']==200){
        if($plugin['value']['pluginadmin']=='true'){
            $code=200;
            $adminurl=$plugin['value']['path'].'/'.$plugin['value']['pluginadminurl'];
        }else{
            $code=400;
            $adminurl="该插件没有独立管理页面";
        }
    }else{
        $code=400;
        $adminurl="插件ID错误";
    }
    return array("code"=>$code,"adminurl"=>$adminurl);
}
$arr=GetPluginAdmin($id);
if($arr['code']!=200){
?>
  <!--start main wrapper-->
  <main class="main-wrapper">
      <h1><?php echo $arr['adminurl'];?></h1>
  </main>
  <!--end main wrapper-->
<?php
}else{
?>
  <!--start main wrapper-->
  <main class="main-wrapper">
      <iframe src="<?php echo $arr['adminurl'];?>?Login_Token=<?php echo $_COOKIE["Login_Token"];?>" style="border:none;" height="100%" width="100%" title="description">
  </main>
  <!--end main wrapper-->
<?php
}
?>