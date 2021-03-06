<?php
appLogs("Conn加载");
/**
 * Description of conn
 * 获取数据库pdo对象类
 * @author kinglu
 */
class Conn {
    private $pdo = null;
    public function getPdo() {
        $db_conf=$GLOBALS['db_conf'];
        try {
            $mysalset = "mysql:host={$db_conf['host']};port={$db_conf['port']};dbname={$db_conf['db']}";
            $this->pdo = new pdo($mysalset, $db_conf['user'], $db_conf['pwd']);
            $this->pdo->exec("SET names utf8");
            return $this->pdo;
        } catch (PDDException $e) {
            rJsonMsg("数据库连接失败！"+ $e);
        }
    }
    function __destruct() {
        $this->pdo = null;
    }
}
