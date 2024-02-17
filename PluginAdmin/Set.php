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

function UpdateSet() {
   	var key=$("#key").val();
   	if(key==''){
   	    Show_Error("请输入key~");
   	}else{
    	$.ajax({
    		type : "GET",
    		url : "./AdminApi.php?mode=UpdateSet&key="+key,
    		dataType:"json",
    		timeout: 15000, //ajax请求超时时间15s
    		success : function(data) {
    		    if(data.code==200){
        		    Show_Success('修改成功');
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
						<li class="breadcrumb-item active" aria-current="page">系统设置</li>
					</ol>
				</nav>
			</div>
		</div>
		<!--end breadcrumb-->
      

        <div class="row">
					<div class="col-xl-12">
						<h6 class="mb-0 text-uppercase">基础配置</h6>
						<hr>
						<div class="card">
							<div class="card-body">
							    <label for="inputEmailAddress" class="form-label">APIKEY</label>
								<div class="input-group mb-3">
									<input id="key" type="text" class="form-control" placeholder="key" value='<?php echo $Plugin_Key;?>' aria-label="Username" aria-describedby="basic-addon1">
								</div>
                                <div class="col-12">
                                  <div class="d-grid">
                                    <button type="button" class="btn btn-primary" onclick="UpdateSet()">修改</button>
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