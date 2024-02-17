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
include '../Class/Function.php';//函数库

@$page=$_GET["page"];

function GetPluginInfo($id){
    //加载Plugin下的所有的插件
    $list = glob('./Plugin/*');
    $i=0;
    foreach($list as $file){
        $config = file_get_contents($file.'/Config.json');//引入插件配置文件
        $config_data = json_decode($config);//解析配置文件
    	$i++;
    	if($i==$id){//匹配上了
            //判断插件是否开启
            if($config_data->plugin->config->isopen==true){
                $isopen="开启";
            }else{
                $isopen="关闭";
            }
            //获取权限列表
            foreach ($config_data->plugin->listenings as $listening) {
                $eventname=Get_Event_Name($listening->name);
                $listeningevent.=$eventname."\n";
            }
        	$plugin="[插件".$config_data->plugin->config->name."]\nID:".$i."\n状态:".$isopen."\nListingEvent:\n".$listeningevent;
        	}
    }
    if(!$plugin){
        $plugin="插件ID错误";
    }
    return $plugin;
}

function GetAllPage(){
    //加载Plugin下的所有的插件
    $list = glob('../Plugin/*');
    $count=count($list);
    if($count>10){
        $allpage=ceil($count/10);
    }else{
        $allpage=1;
    }
    return $allpage;
}
function GetPluginList($page){
    //加载Plugin下的所有的插件
    $list = glob('../Plugin/*');
    $count=count($list);
    //echo count($list);
    if($count>10){
        if(!$page or $page==1){
            $min_i=1;
            $max_i=10;
        }else{
            if($page>1){
                $min_i=($page - 1)*10 + 1;
                $max_i=$page*10;
            }else{
                $min_i=1;
                $max_i=10;
            }
        }
    }else{
        $min_i=1;
        $max_i=10;
    }
    $i=0;
    foreach($list as $flie){
        $i++;
        if($i>=$min_i and $i<=$max_i){
            $config = file_get_contents($flie.'/Config.json');//引入插件配置文件
            $config_data = json_decode($config);//解析配置文件
        	$plugin[]=(object)array("i"=>$i,"flie"=>$flie,"config"=>$config_data->plugin->config,"listenings"=>$config_data->plugin->listenings);
        }
    }
    return (object)$plugin;
}
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

function Jump() {
    window.location.replace("");
    window.event.returnValue=false;
}

function SetPlugin(id,do1) {
   	if(id==''){
   	    Show_Error("参数缺失-id");
   	}else if(do1==''){
   	    Show_Error("参数缺失-do");
   	}else{
    	$.ajax({
    		type : "GET",
    		url : "./AdminApi.php?mode=SetPlugin&id="+id+"&do="+do1,
    		dataType:"json",
    		timeout: 15000, //ajax请求超时时间15s
    		success : function(data) {
    		    if(data.code==200){
        		    Show_Success(data.message + '[3秒后刷新]');
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
              <li class="breadcrumb-item active" aria-current="page">插件列表</li>
            </ol>
          </nav>
        </div>
      </div>
      <!--end breadcrumb-->

      <div class="row g-6">
        <div class="col-auto">
          <div class="position-relative">
            <input id='pluginname' class="form-control px-5" type="search" placeholder="搜索插件">
            <!--<span-->
            <!--  class="material-icons-outlined position-absolute ms-3 translate-middle-y start-0 top-50 fs-5" type="button" onclick="Search()">search</span>-->
            <span
            class="material-icons-outlined position-absolute ms-3 translate-middle-y start-0 top-50 fs-5" type="button" onclick="Show_Error('功能暂时没有开发完成')">search</span>
          </div>
        </div>
        <div class="col-auto flex-grow-1 overflow-auto">

        </div>
        <div class="col-auto">
          <div class="d-flex align-items-center gap-2 justify-content-lg-end">
            <button onclick="window.location.href='./UploadPlugin.php'" class="btn btn-primary px-4"><i class="bi bi-plus-lg me-2"></i>导入插件</button>
          </div>
        </div>
      </div><!--end row-->

      <div class="card mt-4">
        <div class="card-body">
          <div class="product-table">
            <div class="table-responsive white-space-nowrap">
              <table class="table align-middle">
                <thead class="table-light">
                  <tr>
                    <th>插件名</th>
                    <th>目录</th>
                    <th>作者</th>
                    <th>版本</th>
                    <th>权限</th>
                    <th>状态</th>
                    <th>操作</th>
                  </tr>
                </thead>
                <tbody>
<?php
$pluginlist=GetPluginList($page);
foreach($pluginlist as $plugin){
    $i=$plugin->i;
    $flie=str_replace('../Plugin/', '', $plugin->flie);
    $config=$plugin->config;
    //判断插件是否开启
    if($config->isopen==true){
        $isopen="开启";
        $dotext="关闭";
        $do='Close';
    }else{
        $isopen="关闭";
        $dotext="开启";
        $do='Open';
    }
    //获取权限列表
    $listeningeventlist='';
    foreach ($plugin->listenings as $listening) {
        $eventname=Get_Event_Name($listening->name);
        $listeningeventlist.=$eventname."<br>";
    }
    echo $html=<<<HTML
                  <tr>
                    <td>{$config->name}</td>
                    <td>{$flie}</td>
                    <td>{$config->author}</td>
                    <td>{$config->version}</td>
                    <td>
                      <a href="#" type="button" data-bs-toggle="modal" data-bs-target="#Modal-{$i}">查看权限</a>
                    </td>
                    <td>{$isopen}</td>
                    <td>
                      <div class="dropdown">
                        <button class="btn btn-sm btn-filter dropdown-toggle dropdown-toggle-nocaret"
                          type="button" data-bs-toggle="dropdown">
                          <i class="bi bi-three-dots"></i>
                        </button>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="#" onclick="SetPlugin('{$i}','{$do}')">{$dotext}插件</a></li>
                          <!--<li><a class="dropdown-item" href="./PluginAdmin.php?id={$i}">插件配置</a></li>-->
                          <li><a class="dropdown-item" href="#" onclick="Show_Error('功能暂时没有开发完成')">插件配置</a></li>
                          <li><a class="dropdown-item" href="#" onclick="Show_Error('功能暂时没有开发完成')">卸载插件</a></li>
                        </ul>
                      </div>
                    </td>
                  </tr>
                
                <!-- Modal -->
                <div class="modal fade" id="Modal-{$i}" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">插件[{$config->name}]的权限列表</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">{$listeningeventlist}</div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">关闭</button>
                      </div>
                    </div>
                  </div>
                </div>
HTML;
}
?>
                </tbody>
              </table>
            </div>
          </div>
            <div class="row">
              <div class="col-sm-12 col-md-12">
                <div class="dataTables_info" id="example_info" role="status" aria-live="polite">当前为第<?php if(!$page) $page=1; echo$page;?>页/共<?php echo $allpage=GetAllPage(); ?>页</div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-12">
                <div class="dataTables_paginate paging_simple_numbers" id="example_paginate">
                  <ul class="pagination">
<?php
if($page==1){
    $previoushtml=<<<HTML
    <li class="paginate_button page-item previous disabled" id="example_previous">
      <a href="#" aria-controls="example" data-dt-idx="0" tabindex="0" class="page-link">上一页</a>
    </li>
HTML;
}else{
    $previous=$page - 1;
    $previoushtml=<<<HTML
    <li class="paginate_button page-item previous" id="example_previous">
      <a href="?page={$previous}" aria-controls="example" data-dt-idx="0" tabindex="0" class="page-link">上一页</a>
    </li>
HTML;
}
if($page==$allpage){
    $nexthtml=<<<HTML
    <li class="paginate_button page-item next disabled" id="example_next">
      <a href="#" aria-controls="example" data-dt-idx="7" tabindex="0" class="page-link">下一页</a>
    </li>
HTML;
}else{
    $next=$page + 1;
    $nexthtml=<<<HTML
    <li class="paginate_button page-item next" id="example_next">
      <a href="?page={$next}" aria-controls="example" data-dt-idx="7" tabindex="0" class="page-link">下一页</a>
    </li>
HTML;
}

$nowpage=1;
while($nowpage<=$allpage) {
    if($nowpage==$page){
        $pagehtml.=<<<HTML
            <li class="paginate_button page-item active">
              <a href="?page={$nowpage}" aria-controls="example" data-dt-idx="1" tabindex="0" class="page-link">{$nowpage}</a>
            </li>
HTML;
    }else{
        $pagehtml.=<<<HTML
            <li class="paginate_button page-item">
              <a href="?page={$nowpage}" aria-controls="example" data-dt-idx="1" tabindex="0" class="page-link">{$nowpage}</a>
            </li>
HTML;
    }
    $nowpage++;
} 
echo $previoushtml;
echo $pagehtml;
echo $nexthtml;
?>
                  </ul>
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