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

<script>
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
  <!--start main wrapper-->
  <main class="main-wrapper">
    <div class="main-content">
      <!--breadcrumb-->
       <div class="row">
          <div class="col-12 col-lg-12">
              <div class="card">
                 <div class="card-body">
                   <div class="mb-4">
                    <h5 class="mb-3">导入插件</h5>
                    <input id="fancy-file-upload" type="file" name="files" accept=".zip" multiple>
                    <p class="fs--1 fw-semi-bold mb-0">请选择一个符合规范的ZIP压缩文件</p>
                    <p class="fs--1 fw-semi-bold mb-0">安全警告：请不要导入您不信任的非开源插件，否则后果自负！</p>
                  </div>
                    <div class="col-12">
                      <div class="d-grid">
                        <button type="button" class="btn btn-primary" onclick="Show_Error('开发中')">导入</button>
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