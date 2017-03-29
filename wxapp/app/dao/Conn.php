<?php
/**
 * Description of conn
 * 获取数据库pdo对象类
 * @author kinglu
 */
class Conn {
    public function getPdo() {
        $db_conf=$GLOBALS['db_conf'];
        try {
            $mysalset = "mysql:host={$db_conf['host']};port={$db_conf['port']};dbname={$db_conf['db']}";
            return new pdo($mysalset, $db_conf['user'], $db_conf['pwd']);
        } catch (PDDException $e) {
            rJsonMsg("数据库连接失败！"+ $e);
        }
    }
}
