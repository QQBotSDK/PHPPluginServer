<?php
// +----------------------------------------------------------------------
// | Quotes [二次开发请留版权,严禁用于非法用途]
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author:书迷  <jsrcode@qq.com>
// +----------------------------------------------------------------------
// | Date: 2024年02月17日
// +----------------------------------------------------------------------
include './Head.php';//载入头文件
@$pluginpath=$_GET['pluginpath'];
if (@file_exists('../Plugin/'.$pluginpath.'/Config.json')) {
    //have
    @$path=str_replace("../Plugin/","",$pluginpath);
    $plugin=$config->GetPlugin_P($path);
    if($plugin['code']==401){
        //PathNoInstall
        @$config_flie = file_get_contents('../Plugin/'.$pluginpath.'/Config.json');//引入插件配置文件
        @$config_data = json_decode($config_flie);//解析配置文件
    	@$plugin=$config->GetPlugin_N($config_data->plugin->config->name);
    	if($plugin['code']==401){
    	    //noinstall
    	    
            //获取权限列表
            foreach ($config_data->plugin->listenings as $listening) {
                @$eventname=Get_Event_Name($listening->name);
                @$listeningevent.=<<<HTML
    <div class="form-check form-switch"> 
        <input class="form-check-input" type="checkbox" id="{$listening->name}" checked> 
        <label class="form-check-label" for="flexSwitchCheckChecked">{$eventname}</label> 
    </div>
HTML;
                @$js1.=<<<JS
        var {$listening->name}=$("#{$listening->name}").get(0).checked;
        //console.log({$listening->name})
        
JS;
                @$js2.=<<<JS
    +"&{$listening->name}="+{$listening->name}
JS;
            }
            
            //MYSQL权限
            if($config_data->plugin->config->mysql==true){
                @$listeningevent.=<<<HTML
    <div class="form-check form-switch"> 
        <input class="form-check-input" type="checkbox" id="mysql" checked> 
        <label class="form-check-label" for="flexSwitchCheckChecked">Mysql数据库权限<span style="color:red">*敏感权限，请确定您可以信任该插件*</span></label> 
    </div>
HTML;
                @$js1.=<<<JS
        var mysql=$("#mysql").get(0).checked;

JS;
                @$js2.=<<<JS
    +"&mysql="+mysql
JS;
            }
?>
<script>
function InstallPlugin() {
   	<?php echo$js1;?>
	$.ajax({
		type : "GET",
		url : "./AdminApi.php?mode=InstallPlugin&pluginpath=<?php echo$pluginpath;?>"<?php echo$js2;?>,
		dataType:"json",
		timeout: 15000, //ajax请求超时时间15s
		success : function(data) {
		    if(data.code==200){
    		    Show_Success('安装成功');
    		    id=data.id;
    		    stepper1.next();
		    }else{
		        Show_Error(data.message);
		    }
		},
      error:function(res){
          Show_Error('云端数据读取失败！('+res.status+')');
      }
	});
}

function Jump() {
    window.location.replace("./PluginList.php");
    window.event.returnValue=false;
}

function EndInstall() {
    var open=$("#open").get(0).checked;
    if(open){
        wdo='Open';
    }else{
        wdo='Close';
    }
	$.ajax({
		type : "GET",
		url : "./AdminApi.php?mode=SetPlugin&id="+id+"&do="+wdo,
		dataType:"json",
		timeout: 15000, //ajax请求超时时间15s
		success : function(data) {
		    if(data.code==200){
    		    Show_Success('设置成功[3秒后跳转]');
   	            window.setTimeout(Jump, 3000);
		    }else{
		        Show_Error(data.message);
		    }
		},
      error:function(res){
          Show_Error('云端数据读取失败！('+res.status+')');
      }
	});
}
</script>

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
						<li class="breadcrumb-item active" aria-current="page">插件安装</li>
					</ol>
				</nav>
			</div>
		</div>
		<!--end breadcrumb-->

        <div class="row">
            <div class="card">
						<div class="card-body">
							<div id="stepper1" class="bs-stepper gap-4 vertical">
								<div class="bs-stepper-header" role="tablist">
									<div class="step" data-target="#test-vl-1">
									  <div class="step-trigger" role="tab" id="stepper1trigger1" aria-controls="test-vl-1">
										<div class="bs-stepper-circle">1</div>
										<div class="">
											<h5 class="mb-0 steper-title">插件详情</h5>
											<p class="mb-0 steper-sub-title">预览插件详情，确认是否安装此插件</p>
										</div>
									  </div>
									</div>
								
									<div class="step" data-target="#test-vl-2">
										<div class="step-trigger" role="tab" id="stepper1trigger2" aria-controls="test-vl-2">
										  <div class="bs-stepper-circle">2</div>
										  <div class="">
											  <h5 class="mb-0 steper-title">查看插件申请权限</h5>
											  <p class="mb-0 steper-sub-title">合理给予插件权限可以提高框架的消息处理速度</p>
										  </div>
										</div>
									</div>
								
									<div class="step" data-target="#test-vl-3">
										<div class="step-trigger" role="tab" id="stepper1trigger3" aria-controls="test-vl-3">
										  <div class="bs-stepper-circle">3</div>
										  <div class="">
											  <h5 class="mb-0 steper-title">安装完成</h5>
											  <p class="mb-0 steper-sub-title">开始使用插件</p>
										  </div>
										</div>
									  </div>
									
								</div>
			

			
								   <div class="bs-stepper-content">
									<form onSubmit="return false">
									  <div id="test-vl-1" class="bs-stepper-pane content fade" aria-labelledby="stepper1trigger1">
										<h5 class="mb-1"><?php echo $config_data->plugin->config->name?></h5>
                                        <p class="mb-4">作者:<?php echo $config_data->plugin->config->author?>   版本:<?php echo $config_data->plugin->config->version?></p>
										<p class="mb-4">介绍:<?php echo $config_data->plugin->config->info?></p>
			
										<div class="row g-3">
											<div class="col-12">
												<button class="btn btn-primary px-4" onclick="stepper1.next()">确认<i class='bx bx-right-arrow-alt ms-2'></i></button>
											</div>
										</div><!---end row-->
										
									  </div>
			
									  <div id="test-vl-2" class="bs-stepper-pane content fade" aria-labelledby="stepper1trigger2">
			
										<h5 class="mb-1">插件申请权限列表</h5>
			
										<div class="row g-3">
											<div class="col-12">
											    <?php echo $listeningevent?>
											</div>
											<div class="col-12">
												<div class="d-flex align-items-center gap-3">
													<button class="btn btn-outline-secondary px-4" onclick="stepper1.previous()"><i class='bx bx-left-arrow-alt me-2'></i>返回上一页</button>
													<button class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#Modal-install">开始安装<i class='bx bx-right-arrow-alt ms-2'></i></button>
												</div>
											</div>
										</div><!---end row-->
										
									  </div>

                                    <!-- Modal -->
                                    <div class="modal fade" id="Modal-install" tabindex="-1" aria-hidden="true">
                                      <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title">确认开始安装插件[<?php echo $config_data->plugin->config->name?>]吗？</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>
                                          <div class="modal-body">请确定您已经配置好所有参数</div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">关闭</button>
                                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close" onclick="InstallPlugin()">确认</button>
                                            <!-- 下一步：stepper1.next() -->
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    
									  <div id="test-vl-3" class="bs-stepper-pane content fade" aria-labelledby="stepper1trigger3">
										<h5 class="mb-1">插件安装完成</h5>
			
										<div class="row g-3">
											<div class="col-12">
                                                <div class="form-check form-switch"> 
                                                    <input class="form-check-input" type="checkbox" id="open"> 
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">开启该插件</label> 
                                                </div>
											</div>
											<div class="col-12">
												<div class="d-flex align-items-center gap-3">
													<button class="btn btn-success px-4" onclick="EndInstall()">完成并返回插件列表<i class='bx bx-right-arrow-alt ms-2'></i></button>
												</div>
											</div>
										</div><!---end row-->
										
									  </div>
										
									  </div>
									</form>
								  </div>
							   </div>
						</div>
					</div>
				  <!--end stepper three--> 

    </div>
  </main>
  <!--end main wrapper-->
<?php
    	}else{
    	    //install
            $message='不允许重复安装同名插件，如需要安装请修改插件名或者卸载同名插件';
    	    goto returnerror;
    	}
    }else{
        //PathInstall
        $message='插件已经安装过了，不允许覆盖安装，如需要覆盖安装请选择[重载插件]';
	    goto returnerror;
    }
} else {
    //no
    if (is_dir('../Plugin/'.$pluginpath)) {
        $message='插件没有Config配置文件';
    }else{
        $message='插件目录不存在';
    }
returnerror:
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
						<li class="breadcrumb-item active" aria-current="page">插件安装</li>
					</ol>
				</nav>
			</div>
		</div>
		<!--end breadcrumb-->
       <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
                <div class="alert alert-border-danger alert-dismissible fade show">
					<div class="d-flex align-items-center">
						<div class="font-35 text-danger"><span class="material-icons-outlined fs-2">report_gmailerrorred</span>
						</div>
						<div class="ms-3">
							<h6 class="mb-0 text-danger">警告</h6>
							<div class="">启动插件安装器失败:<?php echo $message?></div>
						</div>
					</div>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
              </div>
            </div>
          </div>
         </div>

    </div>
  </main>
  <!--end main wrapper-->
<?php
}
?>
<?php
include './Footer.php';//载入页尾文件
?>