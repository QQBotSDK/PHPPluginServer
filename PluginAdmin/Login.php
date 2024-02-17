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


if(isset($_GET["logout"])){
    setcookie('Login_Token', "", time()-3600);
}

/*验证Cookie*/
if(isset($_COOKIE["Login_Token"])){
    include '../Config.php';//载入配置文件
    $cookie=hash('sha256',$Admin_Username.$Admin_Password);
    if($_COOKIE["Login_Token"]==$cookie){
        header("Location:./index.php");
        exit;
    }
}

?>
<html lang="en" data-bs-theme="light">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PHPQQ机器人框架-插件端-管理后台-登录</title>
  <!--favicon-->
	<link rel="icon" href="./Assets/Images/Logo.ico" type="image/png">

  <!--plugins-->
  <link href="./Assets/Plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="./Assets/Plugins/metismenu/metisMenu.min.css">
  <link rel="stylesheet" type="text/css" href="./Assets/Plugins/metismenu/mm-vertical.css">
  <link rel="stylesheet" href="./Assets/Plugins/notifications/css/lobibox.min.css">
  <!--bootstrap css-->
  <link href="./Assets/Css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=ZCOOL+KuaiLe&display=swap" rel="stylesheet">
  <!--main css-->
  <link href="./Assets/Css/bootstrap-extended.css" rel="stylesheet">
  <link href="./Assets/Sass/main.css" rel="stylesheet">
  <link href="./Assets/Sass/dark-theme.css" rel="stylesheet">
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

function JumpIndex() {
    window.location.replace("./index.php");
    window.event.returnValue=false;
}


/**
* 添加 Cookie
* @param {[string]} name       [Cookie 的名称]
* @param {[string]} value      [Cookie 的值]
* @param {[number]} daysToLive [Cookie 的过期时间]
*/
function setCookie(name, value, daysToLive) {
    // 对 cookie 值进行编码以转义其中的分号、逗号和空格
    var cookie = name + "=" + encodeURIComponent(value);
   
    if(typeof daysToLive === "number") {
        /* 设置 max-age 属性 */
        cookie += "; max-age=" + (daysToLive*24*60*60);
    }else{
        /* 设置 max-age 属性 */
        cookie += "; max-age=session";
    }
    
    document.cookie = cookie;
}

function Login() {
   	var username=$("#username").val();
   	var password=$("#password").val();
   	var rememberlogin=$("#rememberlogin").get(0).checked;
   	if(username==''){
   	    Show_Error("请输入账号~");
   	}else if(password==''){
   	    Show_Error("请输入密码~");
   	}else{
    	$.ajax({
    		type : "GET",
    		url : "./AdminApi.php?mode=Login&username="+username+"&password="+password,
    		dataType:"json",
    		timeout: 15000, //ajax请求超时时间15s
    		success : function(data) {
    		    if(data.code==200){
        		    Show_Success('登录成功[3秒后跳转后台首页]');
        		    if(rememberlogin==true){
                        setCookie('Login_Token', data.cookie, 3);
        		    }else{
        		        setCookie('Login_Token', data.cookie, '');
        		    }
   	                window.setTimeout(JumpIndex, 3000);
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

  <body class="bg-login">


    <!--authentication-->

     <div class="container-fluid my-5">
        <div class="row">
           <div class="col-12 col-md-8 col-lg-6 col-xl-5 col-xxl-4 mx-auto">
            <div class="card rounded-4">
              <div class="card-body p-5">
                  <img src="./Assets/Images/Logo.png" class="mb-4" width="145" alt="">
                  <h4 class="fw-bold">PHPQQ机器人框架-插件端</h4>
                  <p class="mb-0">管理后台-登录</p>

                  <div class="form-body my-4">
					<form class="row g-3" onsubmit="return false">
						<div class="col-12">
							<label for="inputEmailAddress" class="form-label">Admin账号</label>
							<input type="text" class="form-control" id="username" placeholder="admin">
						</div>
						<div class="col-12">
							<label for="inputChoosePassword" class="form-label">Admin密码</label>
							<div class="input-group" id="show_hide_password">
								<input type="password" class="form-control border-end-0" id="password" placeholder="123456"> 
                                <a href="javascript:;" class="input-group-text bg-transparent"><i class="bi bi-eye-slash-fill"></i></a>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-check form-switch">
								<input class="form-check-input" type="checkbox" id="rememberlogin">
								<label class="form-check-label" for="flexSwitchCheckChecked">记住登录[保持3天]</label>
							</div>
						</div>
						<div class="col-12">
							<div class="d-grid">
								<button class="btn btn-primary" onclick="Login()">登录</button>
							</div>
						</div>
					</form>
				</div>
              </div>
            </div>
           </div>
        </div>
     </div>
      
  <!--plugins-->
  <!--<script src="./Assets/Plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>-->
  <!--<script src="./Assets/Plugins/metismenu/metisMenu.min.js"></script>-->
  
  <!--bootstrap js-->
  <!--<script src="./Assets/Js/bootstrap.bundle.min.js"></script>-->

  <!--plugins-->
    <script src="./Assets/Js/jquery.min.js"></script>
      <!--notification js -->
    	<script src="./Assets/Plugins/notifications/js/lobibox.min.js"></script>
    	<script src="./Assets/Plugins/notifications/js/notifications.min.js"></script>
    	<!--<script src="./Assets/Plugins/notifications/js/notification-custom-script.js"></script>-->
      <script src="./Assets/Js/main.js"></script>
      
    <script>
      $(document).ready(function () {
        $("#show_hide_password a").on('click', function (event) {
          event.preventDefault();
          if ($('#show_hide_password input').attr("type") == "text") {
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass("bi-eye-slash-fill");
            $('#show_hide_password i').removeClass("bi-eye-fill");
          } else if ($('#show_hide_password input').attr("type") == "password") {
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass("bi-eye-slash-fill");
            $('#show_hide_password i').addClass("bi-eye-fill");
          }
        });
      });
    </script>
  
  </body>
</html>