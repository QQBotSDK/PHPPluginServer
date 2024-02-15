<?php
// +----------------------------------------------------------------------
// | Quotes [二次开发请留版权,严禁用于非法用途]
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author:书迷  <jsrcode@qq.com>
// +----------------------------------------------------------------------
// | Date: 2024年02月13日
// +----------------------------------------------------------------------
class MrakDown{
    public function __construct(){
        //暂时没有代码
    }
    
    /*MarkDown消息构建模块*/
    
    //增加一个MarkDown消息ID
    function Add_MarkDown_Template($template_name,$template_id){
        $this->markdown_template_list[$template_name]=$template_id;
        return 'success';
    }
    
    //使用MarkDown消息ID创建一条MarkDown消息模板
    function Create_Template_MarkDown($template_name){
        if(@$this->markdown_template_list[$template_name]){
            $custom_template_id=$this->markdown_template_list[$template_name];
            $markdown=array("custom_template_id"=>$custom_template_id,"params"=>array());
            return $markdown;
        }else{
            return false;
        }
    }
    
    //向MarkDown消息模板添加一个参数
    function Add_Template_MarkDown_Param($markdown,$key,$value){
        if($markdown){
            $param['key']=$key;
            $param['values'][]=$value;
            $markdown['params'][]=$param;
            // $markdown['params'][]['key']=$key;
            // $markdown['params'][]['value'][]=$value;
            return $markdown;
        }else{
            return false;
        }
    }
    
    //使用MarkDown消息ID快速构建MarkDown消息
    function Create_Template_MarkDown_Fast($template_name,$params){
        if(@$this->markdown_template_list[$template_name]){
            $custom_template_id=$this->markdown_template_list[$template_name];
            $markdown=array("custom_template_id"=>$custom_template_id,"params"=>array());
            foreach($params as $key => $value){
                $param=[];
                $param['key']=$key;
                $param['values'][]=$value;
                $markdown['params'][]=$param;
            }
            return $markdown;
        }else{
            return false;
        }
    }
    
    /*消息按钮构建模块*/
    
    //增加一个消息按钮ID
    function Add_KeyBoard_Template($keyboard_name,$keyboard_id){
        $this->keyboard_template_list[$keyboard_name]=$keyboard_id;
        return 'success';
    }
    
    //使用消息按钮ID创建一个消息按钮
    function Create_Template_Keyboard($template_name){
        if(@$this->keyboard_template_list[$template_name]){
            $custom_template_id=$this->keyboard_template_list[$template_name];
            $keyboard=array("id"=>$custom_template_id);
            return $keyboard;
        }else{
            return false;
        }
    }
    
    //不使用消息按钮ID创建原生消息按钮模板
    function Create_Keyboard(){
        $keyboard=array("content"=>array("rows"=>array()));
        return $keyboard;
    }
    
    //创建一个原生消息按钮
    function Create_Keyboard_Button($name,$data,$style=1,$action=2,$auth=2,$tips="请更新到最新版本QQ客户端",$visited_name=null){
        if($visited_name==null){
            $visited_name=$name;
        }
        // if(@!$id){
        //     return false;
        // }
        if(@!$name){
            return false;
        }
        if(@!$data){
            return false;
        }
        $button=array("render_data"=>array("label"=>$name,"visited_label"=>$visited_name,"style"=>$style),"action"=>array("type"=>$action,"unsupport_tips"=>$tips,"data"=>$data,"permission"=>array("type"=>$auth)));
        return $button;
    }
    
    //向原生消息按钮模板中加入一行消息按钮
    function Add_Keyboard_Button_Row($keyboard,$buttons){
        if (count($buttons)>5) { 
            return false;
        } 
        $keyboard['content']["rows"][]["buttons"]=$buttons;
        return $keyboard;
    }
    
    //快速构建原生消息按钮
    function Create_Keyboard_Fast($rows){
        $keyboard=array("content"=>array("rows"=>array()));
        foreach($rows as $row){
            $buttons=[];
            foreach($row as $button){
                $button=(Object)$button;
                //print_r($button);
                // if(@!$button->id){
                //     return false;
                // }
                if(@!$button->name){
                    return false;
                }
                if(@!$button->data){
                    return false;
                }
                if(@!$button->visited_name){
                    $button->visited_name=$button->name;
                }
                if(@!$button->style){
                    $button->style=1;
                }
                if(@!$button->action){
                    $button->action=2;
                }
                if(@!$button->auth){
                    $button->auth=2;
                }
                if(@!$button->tips){
                    $button->tips="请更新到最新版本QQ客户端";
                }
                $buttons[]=array("render_data"=>array("label"=>$button->name,"visited_label"=>$button->name,"style"=>$button->style),"action"=>array("type"=>$button->action,"unsupport_tips"=>$button->tips,"data"=>$button->data,"permission"=>array("type"=>$button->auth)));
            }
            if (count($buttons)>5) { 
                return false;
            } 
            $keyboard['content']["rows"][]["buttons"]=$buttons;
        }
        return $keyboard;
    }
}