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
if($_FILES['plugin']){
    header("Content-Type: text/html; charset=UTF-8");
    $flie=$_FILES['plugin'];
    if ($shangchuan['type'] == "application/zip") {
        echo "<script>alert('文件类型错误');</script>";
    }else{
        copy($flie['tmp_name'], '../Plugin/'.$flie['name']);
        $zip = new ZipArchive;
        if ($zip->open('../Plugin/'.$flie['name']) === TRUE) {
            $path=Rand1(12);
            // 解压缩文件到指定目录
            $zip->extractTo('../Plugin/'.$path);
            $zip->close();
            unlink('../Plugin/'.$flie['name']);
            echo "<script>alert('上传成功,即将启动插件安装器');window.location.replace('./InstallPlugin.php?pluginpath={$path}');</script>";
            exit();
        } else {
            echo "<script>alert('解压错误');</script>";
            unlink('../Plugin/'.$flie['name']);
        }
    }
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
						<li class="breadcrumb-item active" aria-current="page">导入插件</li>
					</ol>
				</nav>
			</div>
		</div>
		<!--end breadcrumb-->
       <div class="row">
          <div class="col-12 col-lg-12">
              <div class="card">
                 <div class="card-body">
					<form action="./UploadPlugin.php" method="post" enctype="multipart/form-data">
                   <div class="mb-4">
                    <h5 class="mb-3">导入插件</h5>
                    <input id="fancy-file-upload" type="file" id="plugin" name="plugin" accept=".zip" multiple>
                    <p class="fs--1 fw-semi-bold mb-0">请选择一个符合规范的ZIP压缩文件</p>
                    <p class="fs--1 fw-semi-bold mb-0">安全警告：请不要导入您不信任的非开源插件，否则后果自负！</p>
                  </div>
                    <div class="col-12">
                      <div class="d-grid">
                        <button type="submit" class="btn btn-primary">导入</button>
                      </div>
                    </div>
                 </div>
                     </form>
              </div>
          </div> 
    </div>
  </main>
  <!--end main wrapper-->
<?php
include './Footer.php';//载入页尾文件
?>