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
						<li class="breadcrumb-item active" aria-current="page">管理员信息</li>
					</ol>
				</nav>
			</div>
		</div>
		<!--end breadcrumb-->
     
        <div class="row">
          <div class="col-12">
            <div class="card overflow-hidden">
              <div class="card-body">
                <div class="position-relative">
                  <img src="https://placehold.co/1920x780" class="img-fluid rounded" alt="">
                  <div class="position-absolute top-100 start-50 translate-middle">
                    <img src="https://placehold.co/110x110" width="110" height="110" class="rounded-circle raised p-1 bg-white" alt="">
                  </div>
                </div>
                <div class="mt-5 d-flex align-items-start justify-content-between">
                  <div class="">
                    <h3 class="mb-2"><?php echo $config->GetConfig('admin_username') ?></h3>
                    <p class="mb-1">超级管理员</p>
                  </div>
                </div>
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