<?php
// +----------------------------------------------------------------------
// | Quotes [二次开发请留版权,严禁用于非法用途]
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author:书迷  <jsrcode@qq.com>
// +----------------------------------------------------------------------
// | Date: 2024年02月23日
// +----------------------------------------------------------------------
include './Head.php';//载入头文件
//加载Plugin下的所有的插件
$list = glob('../Plugin/*');
foreach($list as $flie){
    $config_flie = file_get_contents($flie.'/Config.json');//引入插件配置文件
    $config_data = json_decode($config_flie);//解析配置文件
	$plugin=$config->GetPlugin_N($config_data->plugin->config->name);
	if($plugin['code']==401){
	    $path=str_replace("../Plugin/","",$flie);
	    $loadplugin.='<option value="'.$path.'">'.$config_data->plugin->config->name.'</option>';
	}
}
if(!$loadplugin){
    $loadplugin='<option value="noplugin">目前没有可载入的插件，如果需要导入插件请选择导入插件</option>';
}
?>
  <!--start main wrapper-->
  <main class="main-wrapper">
    <div class="main-content">
      <!--breadcrumb-->
		<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
			<div class="breadcrumb-title pe-3">控制台</div>
			<div class="ps-3">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-0 p-0">
						<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">载入插件</li>
					</ol>
				</nav>
			</div>
		</div>
		<!--end breadcrumb-->



        <div class="row">
					<div class="col-xl-12">
						<h6 class="mb-0 text-uppercase">基础信息</h6>
						<hr>
						<div class="card">
							<div class="card-body">
							    <form action="./InstallPlugin.php" method="get">
    								<div class="mb-4">
        							    <label for="single-select-clear-field" class="form-label">可载入插件列表</label>
        								<select class="form-select mb-3" id="single-select-clear-field" name="pluginpath" data-placeholder="Choose one thing">
        									<?php echo$loadplugin;?>
        								</select>
        							</div>
                                    <div class="col-12">
                                      <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">载入</button>
                                      </div>
                                    </div>
                                </form>
							</div>
						</div>
					</div>
				</div>
				
    </div>
  </main>
  <!--end main wrapper-->
<?php
include './Footer.php';//载入页尾文件
?>