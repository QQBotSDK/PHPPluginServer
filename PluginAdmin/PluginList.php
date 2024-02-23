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

//
if(!$page){
    $page=1;
}elseif($page<=0){
    $page=1;
}

// function GetAllPage(){
//     //加载Plugin下的所有的插件
//     $list = glob('../Plugin/*');
//     $count=count($list);
//     if($count>10){
//         $allpage=ceil($count/10);
//     }else{
//         $allpage=1;
//     }
//     return $allpage;
// }
// function GetPluginList($page){
//     //加载Plugin下的所有的插件
//     $list = glob('../Plugin/*');
//     $count=count($list);
//     //echo count($list);
//     if($count>10){
//         if(!$page or $page==1){
//             $min_i=1;
//             $max_i=10;
//         }else{
//             if($page>1){
//                 $min_i=($page - 1)*10 + 1;
//                 $max_i=$page*10;
//             }else{
//                 $min_i=1;
//                 $max_i=10;
//             }
//         }
//     }else{
//         $min_i=1;
//         $max_i=10;
//     }
//     $i=0;
//     foreach($list as $flie){
//         $i++;
//         if($i>=$min_i and $i<=$max_i){
//             $config = file_get_contents($flie.'/Config.json');//引入插件配置文件
//             $config_data = json_decode($config);//解析配置文件
//         	$plugin[]=(object)array("i"=>$i,"flie"=>$flie,"config"=>$config_data->plugin->config,"listenings"=>$config_data->plugin->listenings);
//         }
//     }
//     return (object)$plugin;
// }

//$pluginlist=GetPluginList($page);
$pluginlist=$config->Get_Plugin_List_Page($page);
if($pluginlist['code']==401){
    $pluginlist['allpage']=1;
    $html=<<<HTML
          <tr>
            <td>暂无插件，请先导入</td>
          </tr>
HTML;
}elseif($pluginlist['code']==200){
    $pluginlist1=$pluginlist['value'];
    foreach($pluginlist1 as $plugin){
        $plugin=(object)$plugin;
        $i=$plugin->id;
        $flie=$plugin->path;
        //判断插件是否开启
        if($plugin->isopen=='true'){
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
        $listeningeventjs1='';
        $listeningeventjs2='';
        foreach ($config->Get_Plugin_Event_List($i)["value"] as $listening) {
            $listening=(object)$listening;
            $eventname=Get_Event_Name($listening->event);
            if($listening->auth=='true'){
                $checked=' checked';
            }else{
                $checked='';
            }
            if($listening->event=='mysql'){
                $eventname='Mysql数据库权限';
                $tips='<span style="color:red">*敏感权限，请确定您可以信任该插件*</span>';
            }else{
                $tips='';
            }
            $listeningeventlist.=<<<HTML
<div class="form-check form-switch"> 
    <input class="form-check-input" type="checkbox" id="{$i}_{$listening->event}"{$checked}> 
    <label class="form-check-label" for="flexSwitchCheckChecked">{$eventname}{$tips}</label> 
</div>
HTML;
            $listeningeventjs1.=<<<JS
    var {$listening->event}_{$i}=$("#{$i}_{$listening->event}").get(0).checked;
    //console.log({$listening->event}_{$i})
    
JS;
            $listeningeventjs2.=<<<JS
+"&{$listening->event}="+{$listening->event}_{$i}
JS;
            //$listeningeventlist.=$eventname."<br>";
        }
//         if($plugin->auth_mysql=='true'){
//             $listeningeventlist.=<<<HTML
// <div class="form-check form-switch"> 
//     <input class="form-check-input" type="checkbox" id="{$i}_mysql" checked> 
//     <label class="form-check-label" for="flexSwitchCheckChecked">Mysql数据库权限</label> 
// </div>
// HTML;
//             $listeningeventjs1.=<<<JS
//     var mysql_{$i}=$("#{$i}_mysql").get(0).checked;
//     //console.log(mysql_{$i})
    
// JS;
//             $listeningeventjs2.=<<<JS
// +"&mysql="+mysql_{$i}
// JS;
//         }
        if($plugin->pluginadmin=='true'){
            $pluginadmin=' href="./PluginAdmin.php?id='.$i.'"';
        }else{
            $pluginadmin=<<<HTML
  href="#" onclick="Show_Error('该插件没有独立管理页面')"
HTML;
        }
        $html.=<<<HTML
          <tr>
            <td>{$plugin->name}</td>
            <td>{$flie}</td>
            <td>{$plugin->author}</td>
            <td>{$plugin->version}</td>
            <td>
              <a href="#" type="button" data-bs-toggle="modal" data-bs-target="#Modal-{$i}">插件权限管理</a>
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
                  <li><a class="dropdown-item" {$pluginadmin}>插件配置</a></li>
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
                <h5 class="modal-title">插件[{$plugin->name}]的权限列表</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">{$listeningeventlist}</div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">关闭</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close" data-bs-toggle="modal" data-bs-target="#Modal-1-{$i}">保存配置</button>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Modal-1 -->
        <div class="modal fade" id="Modal-1-{$i}" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">[{$plugin->name}]</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">您确定要更改这些权限的配置吗</div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">取消</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close" onclick="SetPluginEvent_{$i}()">确定</button>
              </div>
            </div>
          </div>
        </div>

        <script>
        function SetPluginEvent_{$i}() {
           	$listeningeventjs1
        	$.ajax({
        		type : "GET",
        		url : "./AdminApi.php?mode=SetPluginEvent&pluginid="+"{$i}"{$listeningeventjs2},
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
        </script>
HTML;
    }
}else{
    $pluginlist['allpage']=1;
    $html=<<<HTML
          <tr>
            <td>异常</td>
          </tr>
HTML;
}
?>
<script>
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
            <button onclick="window.location.href='./PluginShop.php'" class="btn btn-primary px-4"><i class="bx bx-shopping-bag me-2"></i>插件商城</button>
            <button onclick="window.location.href='./LoadPlugin.php'" class="btn btn-primary px-4" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="意思是加载已经位于插件目录但是列表内未载入的插件"><i class="bi bi-plus-lg me-2"></i>载入插件</button>
            <button onclick="window.location.href='./UploadPlugin.php'" class="btn btn-primary px-4" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="意思是从您的设备中导入插件的安装包[ZIP格式]"><i class="bx bx-upload me-2"></i>导入插件</button>
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
echo$html;
?>
                </tbody>
              </table>
            </div>
          </div>
            <div class="row">
              <div class="col-sm-12 col-md-12">
                <div class="dataTables_info" id="example_info" role="status" aria-live="polite">当前为第<?php echo$page;?>页/共<?php echo $allpage=$pluginlist['allpage']; ?>页</div>
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