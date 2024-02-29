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
?>
<html lang="en" data-bs-theme="light">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PHPQQ机器人框架-插件端-安装程序</title>
  <!--favicon-->
	<link rel="icon" href="../Assets/Images/Logo.ico" type="image/png">

  <!--plugins-->
  <link href="../Assets/Plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="../Assets/Plugins/metismenu/metisMenu.min.css">
  <link rel="stylesheet" type="text/css" href="../Assets/Plugins/metismenu/mm-vertical.css">
  <link rel="stylesheet" href="../Assets/Plugins/notifications/css/lobibox.min.css">
  <link href="../Assets/Plugins/bs-stepper/css/bs-stepper.css" rel="stylesheet">
  
  <!--bootstrap css-->
  <link href="../Assets/Css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=ZCOOL+KuaiLe&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet">
  <!--main css-->
  <link href="../Assets/Css/bootstrap-extended.css" rel="stylesheet">
  <link href="../Assets/Sass/main.css" rel="stylesheet">
  <link href="../Assets/Sass/dark-theme.css" rel="stylesheet">
  <link href="../Assets/Sass/semi-dark.css" rel="stylesheet">
  <link href="../Assets/Sass/bordered-theme.css" rel="stylesheet">
  <link href="../Assets/Sass/responsive.css" rel="stylesheet">
<script>

function Jump() {
    window.location.replace("../PluginAdmin");
    window.event.returnValue=false;
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

function Install() {
   	var db_host=$("#db_host").val();
   	var db_port=$("#db_port").val();
   	var db_user=$("#db_user").val();
   	var db_pwd=$("#db_pwd").val();
   	var db_name=$("#db_name").val();
   	var db_prefix=$("#db_prefix").val();
   	if(db_host==''){
   	    Show_Error("请输入db_host~");
   	}else if(db_port==''){
   	    Show_Error("请输入db_port~");
   	}else if(db_user==''){
   	    Show_Error("请输入db_user~");
   	}else if(db_pwd==''){
   	    Show_Error("请输入db_pwd~");
   	}else if(db_name==''){
   	    Show_Error("请输入db_name~");
   	}else if(db_prefix==''){
   	    Show_Error("请输入db_prefix~");
   	}else{
    	$.ajax({
    		type : "GET",
    		url : "./InstallApi.php?db_host="+db_host+"&db_port="+db_port+"&db_user="+db_user+"&db_pwd="+db_pwd+"&db_name="+db_name+"&db_prefix="+db_prefix,
    		dataType:"json",
    		timeout: 15000, //ajax请求超时时间15s
    		success : function(data) {
    		    if(data.code==200){
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
}
</script>
</head>

<body>
  <!--start main wrapper-->
  <main class="main-wrapper">
    <div class="main-content">
      <!--breadcrumb-->
		<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
			<div class="breadcrumb-title pe-3">PHPQQ机器人框架-插件端</div>
			<div class="ps-3">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-0 p-0">
						<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">安装程序</li>
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
											<h5 class="mb-0 steper-title">系统说明</h5>
											<p class="mb-0 steper-sub-title">关于系统</p>
										</div>
									  </div>
									</div>
								
									<div class="step" data-target="#test-vl-2">
										<div class="step-trigger" role="tab" id="stepper1trigger2" aria-controls="test-vl-2">
										  <div class="bs-stepper-circle">2</div>
										  <div class="">
											  <h5 class="mb-0 steper-title">安装环境检测</h5>
											  <p class="mb-0 steper-sub-title">不通过无法安装</p>
										  </div>
										</div>
									</div>
								
									<div class="step" data-target="#test-vl-3">
										<div class="step-trigger" role="tab" id="stepper1trigger3" aria-controls="test-vl-3">
										  <div class="bs-stepper-circle">3</div>
										  <div class="">
											  <h5 class="mb-0 steper-title">安装完成</h5>
											  <p class="mb-0 steper-sub-title">开始使用插件库服务</p>
										  </div>
										</div>
									  </div>
									
								</div>
			

			
								   <div class="bs-stepper-content">
									<form onSubmit="return false">
									  <div id="test-vl-1" class="bs-stepper-pane content fade" aria-labelledby="stepper1trigger1">
										<h5 class="mb-1">系统说明</h5>
										<iframe src="./About.html" height="60%" width="150%"></iframe>
			
										<div class="row g-3">
											<div class="col-12">
												<button class="btn btn-primary px-4" onclick="stepper1.next()">继续<i class='bx bx-right-arrow-alt ms-2'></i></button>
											</div>
										</div><!---end row-->
										
									  </div>
			
									  <div id="test-vl-2" class="bs-stepper-pane content fade" aria-labelledby="stepper1trigger2">
			
										<h5 class="mb-1">安装环境检测</h5>
			
										<div class="row g-3">
                                        <?php
                                        $install=true;
                                        if(!file_exists('./Install.lock')){
                                            $check[2]='<span class="badge bg-success">未锁定</span>';
                                        }else{
                                            $check[2]='<span class="badge bg-danger">已锁定</span>';
                                            $install=false;
                                        }
                                        if(class_exists("Mysqli")){
                                            $check[0]='<span class="badge bg-success">支持</span>';
                                        }else{
                                            $check[0]='<span class="badge bg-danger">不支持</span>';
                                            $install=false;
                                        }
                                        if($fp = @fopen("../test.txt", 'w')) {
                                            @fclose($fp);
                                            @unlink("../test.txt");
                                            $check[1]='<span class="badge bg-success">支持</span>';
                                        }else{
                                            $check[1]='<span class="badge bg-danger">不支持</span>';
                                            $install=false;
                                        }
                                        if(version_compare(PHP_VERSION,'8.1.0','<')){
                                            $check[3]='<span class="badge bg-danger">不支持</span>';
                                            $install=false;
                                        }else{
                                            $check[3]='<span class="badge bg-success">支持</span>';
                                        }
                    
                                        ?>
                                        <ul class="list-group">
                                            <li class="list-group-item">检测安装是否锁定 <?php echo $check[2];?></li>
                                            <li class="list-group-item">MYSQLI组件 <?php echo $check[0];?></li>
                                            <li class="list-group-item">主目录写入权限 <?php echo $check[1];?></li>
                                            <li class="list-group-item">PHP版本>=8.1 <?php echo $check[3];?></li>
                                            <li class="list-group-item">成功安装后安装文件就会锁定，如需重新安装，请手动删除Install目录下Install.lock配置文件！</li>
                                        </ul>
											<div class="col-12">
												<div class="d-flex align-items-center gap-3">
													<button class="btn btn-outline-secondary px-4" onclick="stepper1.previous()"><i class='bx bx-left-arrow-alt me-2'></i>返回上一页</button>
                                                <?php
                                                if($install){ 
                                                echo<<<HTML
													<button class="btn btn-primary px-4"  data-bs-toggle="modal" data-bs-target="#Modal-install"">开始安装<i class='bx bx-right-arrow-alt ms-2'></i></button>
HTML;
                                                }else{
                                                echo<<<HTML
													<button class="btn btn-primary px-4 disabled">条件不允许<i class='bx bx-right-arrow-alt ms-2'></i></button>
HTML;
                                                }
                                                ?>

												</div>
											</div>
										</div><!---end row-->
										
									  </div>

                                    <!-- Modal -->
                                    <div class="modal fade" id="Modal-install" tabindex="-1" aria-hidden="true" data-backdrop="static">
                                      <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title">MYSQL数据库信息配置</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>
                                          <div class="modal-body">
                                            <h4>MYSQL数据库信息配置</h4>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">数据库地址</label>
                                                <div class="col-sm-10">
                                                    <input type="text" id="db_host" class="form-control" value="localhost">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">数据库端口</label>
                                                <div class="col-sm-10">
                                                    <input type="text" id="db_port" class="form-control" value="3306">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">数据库用户名</label>
                                                <div class="col-sm-10">
                                                    <input type="text" id="db_user" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">数据库密码</label>
                                                <div class="col-sm-10">
                                                    <input type="text" id="db_pwd" class="form-control">
                                                </div>
                                            </div>
                							<div class="form-group">
                                                <label class="col-sm-2 control-label">数据库名称</label>
                                                <div class="col-sm-10">
                                                    <input type="text" id="db_name" class="form-control">
                                                </div>
                                            </div>
                							<div class="form-group">
                                                <label class="col-sm-2 control-label">数据库前缀</label>
                                                <div class="col-sm-10">
                                                    <input type="text" id="db_prefix" class="form-control" value='server_'>
                                                </div>
                                            </div>
                                            </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">关闭</button>
                                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close" onclick="Install()">继续</button>
                                            <!-- 下一步：stepper1.next() -->
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    
									  <div id="test-vl-3" class="bs-stepper-pane content fade" aria-labelledby="stepper1trigger3">
										<h5 class="mb-1">安装完成</h5>
			
										<div class="row g-3">
											<div class="col-12">
											后台账号:admin<br>
											后台密码:123456<br>
											</div>
											<div class="col-12">
												<div class="d-flex align-items-center gap-3">
													<button class="btn btn-success px-4" onclick="Jump()">前往后台<i class='bx bx-right-arrow-alt ms-2'></i></button>
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

  <!--bootstrap js-->
  <script src="../Assets/Js/bootstrap.bundle.min.js"></script>

  <!--plugins-->
  <script src="../Assets/Js/jquery.min.js"></script>
  <!--plugins-->
  <script src="../Assets/Plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
  <script src="../Assets/Plugins/metismenu/metisMenu.min.js"></script>
  <script src="../Assets/Plugins/apexchart/apexcharts.min.js"></script>
  <script src="../Assets/Js/index.js"></script>
  <script src="../Assets/Plugins/peity/jquery.peity.min.js"></script>
  
  <script src="../Assets/Plugins/bs-stepper/js/bs-stepper.min.js"></script>
	<script src="../Assets/Plugins/bs-stepper/js/main.js"></script>
	
  <!--notification js -->
	<script src="../Assets/Plugins/notifications/js/lobibox.min.js"></script>
	<script src="../Assets/Plugins/notifications/js/notifications.min.js"></script>
	
  <script>
    $(".data-attributes span").peity("donut")
	</script>
  <script src="../Assets/Js/main.js"></script>

</body>

</html>