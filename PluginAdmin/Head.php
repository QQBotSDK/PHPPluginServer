<?php
// +----------------------------------------------------------------------
// | Quotes [二次开发请留版权,严禁用于非法用途]
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author:书迷  <jsrcode@qq.com>
// +----------------------------------------------------------------------
// | Date: 2024年02月16日
// +----------------------------------------------------------------------
error_reporting(0);//屏蔽报错
include("../Mysql/Mysql.php");//数据库链接
/*验证Cookie*/
if(isset($_COOKIE["Login_Token"])){
    $cookie=hash('sha256',$config->GetConfig('admin_username').$config->GetConfig('admin_password'));
    if($_COOKIE["Login_Token"]!=$cookie){
        header("Location:./Login.php");
        exit;
    }
}else{
    header("Location:./Login.php");
    exit;
}
/*设置高亮*/
$fliename=basename($_SERVER['SCRIPT_NAME']);
if($fliename=='index.php'){
    $index="class='mm-active'";
}elseif($fliename=='PluginList.php' or $fliename=='PluginAdmin.php'){
    $plugin="class='mm-active'";
    $pluginlist="class='mm-active'";
}elseif($fliename=='Doc.php'){
    $doc="class='mm-active'";
}elseif($fliename=='UploadPlugin.php'){
    $plugin="class='mm-active'";
    $uploadplugin="class='mm-active'";
}elseif($fliename=='UserInfo.php'){
    $userinfo="class='mm-active'";
}elseif($fliename=='UserSet.php'){
    $userset="class='mm-active'";
}elseif($fliename=='Set.php'){
    $set="class='mm-active'";
}else{
    //未知Page
}
?>
<html lang="en" data-bs-theme="light">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PHPQQ机器人框架-插件端-管理后台</title>
  <!--favicon-->
	<link rel="icon" href="./Assets/Images/Logo.ico" type="image/png">

  <!--plugins-->
  <link href="./Assets/Plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="./Assets/Plugins/metismenu/metisMenu.min.css">
  <link rel="stylesheet" type="text/css" href="./Assets/Plugins/metismenu/mm-vertical.css">
  <link rel="stylesheet" href="./Assets/Plugins/notifications/css/lobibox.min.css">
  <link rel="stylesheet" href="./Assets/Css/extra-icons.css">
  <link href="./Assets/Plugins/bs-stepper/css/bs-stepper.css" rel="stylesheet">
  
  
  <link rel="stylesheet" href="https://cdn.staticfile.net/select2/4.1.0-rc.0/css/select2.min.css">
  <link rel="stylesheet" href="https://cdn.staticfile.net/select2-bootstrap-5-theme/1.3.0/select2-bootstrap-5-theme.min.css">
  <!--bootstrap css-->
  <link href="./Assets/Css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=ZCOOL+KuaiLe&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet">
  <!--main css-->
  <link href="./Assets/Css/bootstrap-extended.css" rel="stylesheet">
  <link href="./Assets/Sass/main.css" rel="stylesheet">
  <link href="./Assets/Sass/dark-theme.css" rel="stylesheet">
  <link href="./Assets/Sass/semi-dark.css" rel="stylesheet">
  <link href="./Assets/Sass/bordered-theme.css" rel="stylesheet">
  <link href="./Assets/Sass/responsive.css" rel="stylesheet">
<script>
function Show_Success(message) {
	Lobibox.notify('success', {
		pauseDelayOnHover: true,
		continueDelayOnInactiveTab: false,
		position: 'top right',
		icon: 'bi bi-check2-circle',
		msg: message
	});
}

function Show_Error(message) {
	Lobibox.notify('error', {
		pauseDelayOnHover: true,
		continueDelayOnInactiveTab: false,
		position: 'top right',
		icon: 'bi bi-x-circle',
		msg: message
	});
}
</script>
</head>

<body>
  <!--start header-->
  <header class="top-header">
    <nav class="navbar navbar-expand align-items-center justify-content-between gap-3">
      <div class="btn-toggle">
        <a href="#offcanvasPrimaryMenu" data-bs-toggle="offcanvas"><i class="material-icons-outlined">menu</i></a>
      </div>
    </nav>
  </header>
  <!--end top header-->
  
  <!--start mini sidebar-->
  <aside class="mini-sidebar d-flex align-items-center flex-column justify-content-between">
    <div class="user">
      <a href="#offcanvasUserDetails" data-bs-toggle="offcanvas" class="user-icon">
        <i class="material-icons-outlined">account_circle</i>
      </a>
    </div>
    <div class="mini-footer dark-mode">
      <a href="javascript:;" class="footer-icon dark-mode-icon">
        <i class="material-icons-outlined">dark_mode</i>  
      </a>
    </div>
  </aside>
  <!--end mini sidebar-->
  
  <!--start primary menu offcanvas-->
  <div class="offcanvas offcanvas-start w-260" data-bs-scroll="true" tabindex="-1" id="offcanvasPrimaryMenu">
    <div class="offcanvas-header border-bottom h-70">
      <img src="./Assets/Images/Logo.png" height="64" width="64" alt="">
      <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="offcanvas">
        <i class="material-icons-outlined">close</i>
      </a>
    </div>
    <div class="offcanvas-body">
      <nav class="sidebar-nav">
        <ul class="metismenu" id="sidenav">
          <li <?php echo $index ?>>
            <a href="./index.php" href="javascript:;">
              <div class="parent-icon"><i class="material-icons-outlined">home</i>
              </div>
              <div class="menu-title">控制面板</div>
            </a>
          </li>
          <li class="menu-label">插件库配置</li>
          <li <?php echo $plugin ?>>
            <a href="javascript:;" class="has-arrow">
              <div class="parent-icon"><i class="material-icons-outlined">apps</i>
              </div>
              <div class="menu-title">插件管理</div>
            </a>
            <ul>
              <li <?php echo $pluginlist ?>><a href="./PluginList.php"><i class="material-icons-outlined">arrow_right</i>插件列表</a>
              </li>       
              <li <?php echo $uploadplugin ?>><a href="./UploadPlugin.php"><i class="material-icons-outlined">arrow_right</i>导入插件</a>
              </li>
            </ul>
          </li>
          <li <?php echo $doc ?>>
            <a href="./Doc.php" href="javascrpt:;">
              <div class="parent-icon"><i class="material-icons-outlined">description</i>
              </div>
              <div class="menu-title">插件开发文档</div>
            </a>
          </li>
          <li <?php echo $set ?>>
            <a href="./Set.php" href="javascrpt:;">
              <div class="parent-icon"><i class="material-icons-outlined">tune</i>
              </div>
              <div class="menu-title">系统设置</div>
            </a>
          </li>
          <li class="menu-label">管理员账户</li>
          <li <?php echo $userinfo ?>>
            <a href="./UserInfo.php" href="javascrpt:;">
              <div class="parent-icon"><i class="material-icons-outlined">person_outline</i>
              </div>
              <div class="menu-title">账户信息</div>
            </a>
          </li>
          <li <?php echo $userset ?>>
            <a href="./UserSet.php" href="javascrpt:;">
              <div class="parent-icon"><i class="material-icons-outlined">local_bar</i>
              </div>
              <div class="menu-title">账户设置</div>
            </a>
          </li>
          <li>
            <a href="./Login.php?logout" href="javascrpt:;">
              <div class="parent-icon"><i class="material-icons-outlined">power_settings_new</i>
              </div>
              <div class="menu-title">退出登录</div>
            </a>
          </li>
        </ul>
      </nav>
    </div>
    <div class="offcanvas-footer p-3 border-top h-70">
      <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" role="switch" id="DarkMode">
        <label class="form-check-label" for="DarkMode">黑夜模式</label>
      </div>
    </div>
  </div>
  <!--end primary menu offcanvas-->

  <!--start user details offcanvas-->
  <div class="offcanvas offcanvas-start w-260" data-bs-scroll="true" tabindex="-1" id="offcanvasUserDetails">
    <div class="offcanvas-body">
      <div class="user-wrapper">
        <div class="text-center p-3 bg-light rounded">
          <img src="https://placehold.co/110x110" class="rounded-circle p-1 shadow mb-3" width="120" height="120"
            alt="">
          <h5 class="user-name mb-0 fw-bold"><?php echo $config->GetConfig('admin_username') ?></h5>
          <p class="mb-0">超级管理员</p>
        </div>
        <div class="list-group list-group-flush mt-3 profil-menu fw-bold">
          <a href="./UserInfo.php" class="list-group-item list-group-item-action d-flex align-items-center gap-2 border-top"><i class="material-icons-outlined">person_outline</i>账户信息</a>
          <a href="./UserSet.php" href="javascript:;" class="list-group-item list-group-item-action d-flex align-items-center gap-2"><i
              class="material-icons-outlined">local_bar</i>账户设置</a>
          <a href="./Login.php?logout" href="javascript:;"
            class="list-group-item list-group-item-action d-flex align-items-center gap-2 border-bottom"><i
              class="material-icons-outlined">power_settings_new</i>退出登录</a>
        </div>
      </div>

    </div>
    <div class="offcanvas-footer p-3 border-top">
      <div class="text-center">
        <button type="button" class="btn d-flex align-items-center gap-2" data-bs-dismiss="offcanvas"><i
            class="material-icons-outlined">close</i><span>关闭菜单栏</span></button>
      </div>
    </div>
  </div>
  <!--end user details offcanvas-->

