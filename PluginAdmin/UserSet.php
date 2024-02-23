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
function JumpLogin() {
    window.location.replace("./Login.php");
    window.event.returnValue=false;
}

function UpdateUserInfo() {
   	var username=$("#username").val();
   	var oldpassword=$("#oldpassword").val();
   	var newpassword=$("#newpassword").val();
   	if(username==''){
   	    Show_Error("请输入账号~");
   	}else if(oldpassword==''){
   	    Show_Error("请输入原密码~");
   	}else if(newpassword==''){
   	    Show_Error("请输入新密码~");
   	}else{
    	$.ajax({
    		type : "GET",
    		url : "./AdminApi.php?mode=UpdateUserInfo&username="+username+"&oldpassword="+oldpassword+"&newpassword="+newpassword,
    		dataType:"json",
    		timeout: 15000, //ajax请求超时时间15s
    		success : function(data) {
    		    if(data.code==200){
        		    Show_Success('修改成功[3秒后跳转登录页面]');
   	                window.setTimeout(JumpLogin, 3000);
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
						<li class="breadcrumb-item active" aria-current="page">账户设置</li>
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
							    <label for="inputEmailAddress" class="form-label">Admin账号</label>
								<div class="input-group mb-3">
									<input id="username" type="text" class="form-control" placeholder="新账户" value='<?php echo $Admin_Username;?>' aria-label="Username" aria-describedby="basic-addon1">
								</div>
							    <label for="inputChoosePassword" class="form-label">原Admin密码</label>
    							<div class="input-group mb-3" id="show_hide_password">
    								<input type="password" class="form-control border-end-0" id="oldpassword" placeholder="原密码"> 
                                    <a href="javascript:;" class="input-group-text bg-transparent"><i class="bi bi-eye-slash-fill"></i></a>
    							</div>
							    <label for="inputChoosePassword" class="form-label">新Admin密码</label>
    							<div class="input-group mb-3" id="show_hide_password">
    								<input type="password" class="form-control border-end-0" id="newpassword" placeholder="新密码-不修改请填写原密码"> 
                                    <a href="javascript:;" class="input-group-text bg-transparent"><i class="bi bi-eye-slash-fill"></i></a>
    							</div>
                                <div class="col-12">
                                  <div class="d-grid">
                                    <button type="button" class="btn btn-primary" onclick="UpdateUserInfo()">修改</button>
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