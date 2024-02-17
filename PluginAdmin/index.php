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
include './Head.php';//载入头文件
include '../Version.php';//版本文件
//加载Plugin下的所有的插件
$list = glob('../Plugin/*');
$PluginCount=count($list);
$LogCount=0;//临时
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
						<li class="breadcrumb-item active" aria-current="page">数据概览</li>
					</ol>
				</nav>
			</div>
		</div>
		<!--end breadcrumb-->
				
        <div class="row">
          <div class="col-12 col-xl-12">
            <div class="card rounded-6">
              <div class="card-body">
                <div class="d-flex align-items-center justify-content-around flex-wrap gap-4 p-4">
                  <div class="d-flex flex-column align-items-center justify-content-center gap-2">
                    <a href="javascript:;" class="mb-2 wh-48 bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center">
                      <i class="material-icons-outlined">apps</i>
                    </a>
                    <h3 class="mb-0"><?php echo $PluginCount ?></h3>
                    <p class="mb-0">插件数量</p>
                  </div>
                  <div class="d-flex flex-column align-items-center justify-content-center gap-2">
                    <a href="javascript:;" class="mb-2 wh-48 bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center">
                      <i class="material-icons-outlined">payment</i>
                    </a>
                    <h3 class="mb-0"><?php echo $LogCount ?></h3>
                    <p class="mb-0">日志数量</p>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div><!--end row-->

          <div class="col-12 col-xl-12 col-xxl-3 d-flex">
            <div class="card w-100 rounded-4">
              <div class="card-body">
                <div class="d-flex align-items-start justify-content-between mb-3">
                  <div class="">
                    <h5 class="mb-0 fw-bold">关于</h5>
                  </div>
                 </div>
				<div class="d-flex align-items-center">
					<div class="flex-grow-1 ms-3">
						<h5 class="mt-0">当前版本</h5>
						<p class="mb-0"><?php echo $Version?></p>
					</div>
				</div>
				<div class="d-flex align-items-center">
					<div class="flex-grow-1 ms-3">
						<h5 class="mt-0">作者</h5>
						<p class="mb-0">JSRCode</p>
					</div>
				</div>
				<div class="d-flex align-items-center">
					<div class="flex-grow-1 ms-3">
						<h5 class="mt-0">作者联系方式</h5>
						<p class="mb-0">jsrcode@qq.com</p>
					</div>
				</div>
				<div class="d-flex align-items-center">
					<div class="flex-grow-1 ms-3">
						<h5 class="mt-0">本项目Github地址</h5>
						<p class="mb-0"><a href="https://github.com/QQBotSDK/PHPPulginServer">点击前往</a></p>
					</div>
				</div>
				<div class="d-flex align-items-center">
					<div class="flex-grow-1 ms-3">
						<h5 class="mt-0">本项目Gitee地址</h5>
						<p class="mb-0">暂无</p>
					</div>
				</div>
				<div class="d-flex align-items-center">
					<div class="flex-grow-1 ms-3">
						<h5 class="mt-0">温馨提示</h5>
						<p class="mb-0">本项目免费开源，如果您是付费购买，请要求商家退款并予以举报</p>
					</div>
				</div>
              </div>
            </div>  
          </div>
        </div><!--end row-->

    </div>
  </main>
  <!--end main wrapper-->

<?php
include './Footer.php';//载入页尾文件
?>