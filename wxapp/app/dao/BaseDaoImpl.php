<?php

/**
 * Description of BaseDaoImpl
 * 所有数据库表操作的父类
 * @author 陆佰晓
 */
class BaseDaoImpl implements IBaseDao {

    public $table = null; //数据库表名
    public $tableSet = null; //数据库插入语句的  (*)values()  *结构
    public $arrSet = null; //数据库插入语句的  ()values(*)  *结构
    public $conn; //pdo连接
    //打开连接

    function __construct() {
        $this->conn = new Conn();
        $GLOBALS['pdo'] = $this->conn->getPdo();
    }

    /**
     * 获取表的总条数
     * return int 整数
     */
    public function getCount() {
        $rs = $GLOBALS['pdo']->query("SELECT COUNT(*) FROM {$this->table}");
        return $rs->fetchColumn();
    }
    
     /**
     * 获取表某列的所有记录的最大值
     * return int 整数
     */
    public function getMax($col) {
        $rs = $GLOBALS['pdo']->query("SELECT MAX({$col}) FROM {$this->table}");
        return $rs->fetchColumn();
    }

    /**
     * 获取表的所有记录
     * 
     */
    public function getAllData() {
        $rs = $GLOBALS['pdo']->query("SELECT * FROM {$this->table}");
        $rs->setFetchMode(PDO::FETCH_ASSOC);
        $arr = $rs->fetchAll();
        return $arr;
    }

    //添加一条记录
    public function addOne() {
        return $rs = $GLOBALS['pdo']->exec("INSERT INTO {$this->table} ({$this->tableSet})  values ({$this->arrSet})");
    }

    //删除
    public function deleteOneByKey($keyPos, $val) {
        return $rs = $GLOBALS['pdo']->exec("delete from {$this->table}  where {$keyPos}={$val}");
    }
    
    //条件删除：大于
    public function deleteSomeByGreater($keyPos, $val) {
        return $rs = $GLOBALS['pdo']->exec("delete from {$this->table}  where {$keyPos}<{$val}");
    }

    //修改
    public function modifyOneByKey($setPos,$setVal,$keyPos,$val) {
        return $rs = $GLOBALS['pdo']->exec("update  {$this->table} set {$setPos}={$setVal} where {$keyPos}={$val}");
    }

    //查找-条件查找，返回一个服务条件的数据
    public function findOneBykey($key, $keyPos) {
        
    }

    public function getOneBykey($keyPos, $val) {
        $rs = $GLOBALS['pdo']->query("select * from {$this->table}  where {$keyPos}={$val}");
        $rs->setFetchMode(PDO::FETCH_ASSOC);
        $arr = $rs->fetchAll();
        if ($arr != FALSE || $arr != NULL) {
            return $arr[0];
        } else {
            return NUll;
        }
    }

    //查找-查找所有符合条件的返回数组
    public function findArrayBykey($key, $keyPos) {
        
    }
    

    //查找-查找符合条件，按分页限制形式返回，返回数组
    public function getArrayBykeyLimit($orderKey, $page, $pageSize) {
        $index = ($page - 1) * $pageSize;
        $rs = $GLOBALS['pdo']->query("SELECT * FROM {$this->table} ORDER BY {$orderKey}  DESC LIMIT {$index},{$pageSize}");
        if ($rs) {
            $rs->setFetchMode(PDO::FETCH_ASSOC);
            $arr = $rs->fetchAll();
            return $arr;
        }else{
            rJsonMsg("表中无记录！");
        }
    }

    public function displayData() {
        $rs = $GLOBALS['pdo']->query("select * from user_info ");
        $rs->setFetchMode(PDO::FETCH_ASSOC);
        $arr = $rs->fetchAll();
        print_r($arr);
    }
}
