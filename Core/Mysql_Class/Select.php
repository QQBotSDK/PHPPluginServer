<?php
namespace GetSqlFunc\Select;
class Select
{
    private $stmt;
    private $bind_mark;
    private $bind;
    function Stmt_Loader($value)
    {
        $this->stmt = $value;
    }
    public function Do($data)
    {
        $exception = true;
        try {
            $listrow=null;
            $allcount=null;
            $allpages=null;
            $page=null;
            $by=null;
            $order=null;
            if(!isset($data['by'])){
                $data['by']=null;
            }
            if(!isset($data['order'])){
                $data['order']=null;
            }
            if (!isset($data['clause'])) {
                if(isset($data['listrow']) and isset($data['page'])){
                    if($data['listrow']<=0 or $data['page']<=0 or !is_numeric($data['listrow']) or !is_numeric($data['page'])){
                        return array('status' => false, 'reason' => 'listrow参数或page参数不合法');
                    }else{
                        $listrow=$data['listrow'];
                        $page=$data['page'];
                        $sql = $this->GenerateSql(false, $data['key'], $data['table'],null,null,$data['by'],$data['order']);
                        mysqli_stmt_prepare($this->stmt, $sql);
                        mysqli_stmt_execute($this->stmt);
                        $res = $this->stmt->get_result();
                        $allcount = mysqli_num_rows($res);
                        $allpages = ceil($allcount / $listrow);
                        $sql = $this->GenerateSql(false, $data['key'], $data['table'],$data['listrow'],$data['page'],$data['by'],$data['order']);
                    }
                }else{
                    $sql = $this->GenerateSql(false, $data['key'], $data['table'],null,null,$data['by'],$data['order']);
                }
                mysqli_stmt_prepare($this->stmt, $sql);
                mysqli_stmt_execute($this->stmt);
                goto common;
            }
            if (isset($data['bind'])) {
                $this->bind = $data['bind'];
            }
            if(isset($data['listrow']) and isset($data['page'])){
                if($data['listrow']<=0 or $data['page']<=0 or !is_numeric($data['listrow']) or !is_numeric($data['page'])){
                    return array('status' => false, 'reason' => 'listrow参数或page参数不合法');
                }else{
                    $listrow=$data['listrow'];
                    $page=$data['page'];
                    $sql = $this->GenerateSql($data['clause'], $data['key'], $data['table'],null,null,$data['by'],$data['order']);
                    mysqli_stmt_prepare($this->stmt, $sql);
                    $this->stmt->bind_param($this->bind_mark, ...(array) $data['bind']);
                    mysqli_stmt_execute($this->stmt);
                    $res = $this->stmt->get_result();
                    $allcount = mysqli_num_rows($res);
                    $allpages = ceil($allcount / $listrow);
                    $this->bind_mark='';
                    $sql = $this->GenerateSql($data['clause'], $data['key'], $data['table'],$data['listrow'],$data['page'],$data['by'],$data['order']);
                }
            }else{
                $sql = $this->GenerateSql($data['clause'], $data['key'], $data['table'],null,null,$data['by'],$data['order']);
            }
            mysqli_stmt_prepare($this->stmt, $sql);
            $this->stmt->bind_param($this->bind_mark, ...(array) $data['bind']);
            mysqli_stmt_execute($this->stmt);
            common:
            
            $tmparray = array();
            $res = $this->stmt->get_result();
            while ($row = $res->fetch_assoc()) {
                array_unshift($tmparray, $row);
            }
            if (empty(mysqli_stmt_error($this->stmt))) {
                $count = count ($tmparray);
                if($tmparray==array()){
                    return array('status' => true, 'isnull' => true, 'reason' => null, 'callback' => $tmparray, 'count' => $count, 'allcount' => $allcount, 'listrow' => $listrow, 'allpage' => $allpages, 'page' => $page);
                }else{
                    return array('status' => true, 'isnull' => false, 'reason' => null, 'callback' => $tmparray, 'count' => $count, 'allcount' => $allcount, 'listrow' => $listrow, 'allpage' => $allpages, 'page' => $page);
                }
            } else {
                return array('status' => false, 'reason' => '查询失败');
            }
        } catch (Exception $e) {
            return array('status' => false, 'reason' => '查询失败'.$e);
        }
    }
    private function GenerateSql($clause, $args, $table, $listrow=null,$page=null,$by=null,$order=null)
    {
        $key_data = '';
        foreach ($args as $tmp) {
            if ($tmp !== end($args)) {
                $key_data .= $tmp . ', ';
            } else {
                $key_data .= $tmp;
            }
        }
        $ordertext='';
        if($by and $order){
            $ordertext=' ORDER BY '.$by.' '.$order;
        }
        if (!$clause) {
            if($listrow!=null and $page!=null){
                $start = ($page-1) * $listrow; 
                $sql = 'SELECT ' . $key_data . ' FROM ' . $table .$ordertext.' LIMIT '. $start.','. $listrow;
                return $sql;
            }else{
                $sql = 'SELECT ' . $key_data . ' FROM ' . $table.$ordertext;
                return $sql;
            }
        }
        $bind_data = '';
        $mark_data = '';
        $tmpnum = 0;
        $notend = true;
        $count = count($this->bind) - 1;
        foreach ($this->bind as $tmp) {
            if ($tmpnum == $count) {
                $notend = false;
            }
            if (is_int($tmp)) {
                $this->bind_mark .= 'i';
            } else {
                $this->bind_mark .= 's';
            }
            if ($notend) {
                $bind_data .= $tmp . ', ';
                $mark_data .= '? ,';
            } else {
                $bind_data .= $tmp;
                $mark_data .= '?';
            }
            $tmpnum++;
        }
        if($listrow!=null and $page!=null){
            $start = ($page-1) * $listrow; 
            $sql = 'SELECT ' . $key_data . ' FROM ' . $table . ' WHERE ' . $clause .$ordertext.' LIMIT '. $start.','. $listrow;
            return $sql;
        }else{
            $sql = 'SELECT ' . $key_data . ' FROM ' . $table . ' WHERE ' . $clause.$ordertext;
            return $sql;
        }
    }
}