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
class ImportData{
    //数据库信息
    private $dbhost;
    private $dbuser;
    private $dbpw;
    private $dbport;
    private $dbname;
    private $dbcharset;
    private $link;
    private $tablepre;
    public function __construct($data)
    {
         $this->dbhost=isset($data['dbhost'])?$data['dbhost']:'';
         $this->dbuser=isset($data['dbuser'])?$data['dbuser']:'';
         $this->dbpw=isset($data['dbpw'])?$data['dbpw']:'';
         $this->dbport=isset($data['dbport'])?$data['dbport']:'3306';
         $this->dbname=isset($data['dbname'])?$data['dbname']:'';
         $this->dbcharset=isset($data['dbcharset'])?$data['dbcharset']:'utf8';
         $this->tablepre=isset($data['tablepre'])?$data['tablepre']:'server_';
         $link_info=$this->link_data();
         if(!@$link_info['status']){
             return $link_info;
         }
    }

    //链接设置数据库
    protected function link_data(){
        $link=mysqli_connect($this->dbhost,$this->dbuser,$this->dbpw,null,$this->dbport);
        if(!$link)
            return array('status'=>false,'info'=>'数据库连接失败');
        else
            $this->link=$link;
        //mysql 版本
        //获得mysql版本
        $version = mysqli_get_server_info($this->link);
        //设置字符集
        if($version > '4.1' && $this->dbcharset) {
            mysqli_query($link, "SET NAMES {$this->dbcharset}");
        }
        //选择数据库
        mysqli_select_db($this->link,$this->dbname);
    }

    //导数据

    /**
     * @param $dbfile  要导入的sql数据文件
     * @param string $dbfile_table_pre  导入的sql文件的表前缀
     * @return array
     */
    public function import_data($dbfile,$dbfile_table_pre='server_'){
        if(!file_exists($dbfile)){
           return array('status'=>false,'info'=>'数据库文件不存在');
        }
        $sql = file_get_contents($dbfile);
        $status=$this->_sql_execute($this->link, $sql,$dbfile_table_pre);
        if($status){
//            echo '导入数据库成功';
            return array('status'=>true,'info'=>'导入数据库成功');
        }else{
            return array('status'=>false,'info'=>'导入数据库失败');
//            echo '导入数据库失败';
        }

    }

    /**
     * @param $link  数据库链接
     * @param $sql   要导入的sql语句
     * @param $dbfile_table_pre 导入的sql文件的表前缀
     * @return bool
     */
   protected function _sql_execute($link,$sql,$dbfile_table_pre) {
        $sqls =$this-> _sql_split($link,$sql,$dbfile_table_pre);
        if(is_array($sqls))
        {
            foreach($sqls as $sql)
            {
                if(trim($sql) != '')
                {
                    mysqli_query($link,$sql);
                }
            }
        }
        else
        {
            mysqli_query($link,$sqls);
        }
        return true;
    }


    /**
     * @param $link  表链接对象
     * @param $sql   导入的sql
     * @param $dbfile_table_pre  sql文件中的sql表前缀
     * @return array
     */
    protected function _sql_split($link,$sql,$dbfile_table_pre) {
        if(mysqli_get_server_info($link) > '4.1' && $this->dbcharset)
        {
            $sql = preg_replace("/TYPE=(InnoDB|MyISAM|MEMORY)( DEFAULT CHARSET=[^; ]+)?/", "ENGINE=\\1 DEFAULT CHARSET=".$this->dbcharset,$sql);
        }
        //如果有表前缀就替换现有的前缀
        if($this->tablepre){
            $sql=str_replace($dbfile_table_pre, $this->tablepre, $sql);
        }
        $sql = str_replace("\r", "\n", $sql);
        $ret = array();
        $num = 0;
        $queriesarray = explode(";\n", trim($sql));
        unset($sql);
        foreach($queriesarray as $query)
        {
            $ret[$num] = '';
            $queries = explode("\n", trim($query));
            $queries = array_filter($queries);
            foreach($queries as $query)
            {
                $str1 = substr($query, 0, 1);
                if($str1 != '#' && $str1 != '-') $ret[$num] .= $query;
            }
            $num++;
        }
        return $ret;
    }

}


$db_host=$_GET["db_host"];
$db_port=$_GET["db_port"];
$db_user=$_GET["db_user"];
$db_pwd=$_GET["db_pwd"];
$db_name=$_GET["db_name"];
$db_prefix=$_GET["db_prefix"];
if(empty($db_host) || empty($db_port) || empty($db_user) || empty($db_pwd) || empty($db_name) || empty($db_prefix)){
    $arr=array('code'=>"400",'msg'=>"请填完所有数据库信息");
    exit (json_encode($arr));
}else{
    if(file_exists('./Install.lock')){
        $arr=array('code'=>"400",'msg'=>"请勿重复安装");
        exit (json_encode($arr));
    }
    // 创建连接
    $conn = new mysqli($db_host, $db_user, $db_pwd,$db_name,$db_port);
    // 检测连接
    if ($conn->connect_error) {
        $arr=array('code'=>"400",'msg'=>"Mysql数据库连接失败: " . $conn->connect_error);
        exit (json_encode($arr));
    }else{
        @file_put_contents('../Config.php','
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
function Safe(){}//防恶意引入函数
// 数据库配置
$servername = "'.$db_host.'";//数据库服务器
$port= '.$db_port.';//数据库端口
$username = "'.$db_user.'";//数据库用户名
$password = "'.$db_pwd.'";//数据库密码
$datename= "'.$db_name.'";//数据库名
$prefix = "'.$db_prefix.'";//数据库前缀
?>');
        // 导入SQL文件
        $sqlFile = './Install.sql';
        $sql = file_get_contents($sqlFile);
        
        // Temporary variable, used to store current query
        $tempLine = '';
        /**
         * 初始化数据库信息
         */
        $data=array(
             'dbhost'=>$db_host
            ,'dbuser'=>$db_user
            ,'dbpw'=>$db_pwd
            ,'dbname'=>$db_name
        );
        $obj=new ImportData($data);
        $return=$obj->import_data('./Install.sql',$db_prefix);
        
        if($return['status']){
            $myfile = fopen('./Install.lock', "w");
            $data = 'code by jsrcode';
            fwrite($myfile, $data);
            fclose($myfile);
            $arr=array('code'=>"200",'msg'=>"安装完毕");
            exit (json_encode($arr));
        }else{
            $arr=array('code'=>"400",'msg'=>"数据库导入失败");
            exit (json_encode($arr));
        }
    }
}