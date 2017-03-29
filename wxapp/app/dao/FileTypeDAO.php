<?php
/**
 * Description of UserInfo
 * 用户文件资源的DAO
 * @author kinglu
 */
class FileTypeDAO extends BaseDaoImpl {

    /**
     * 初始化数据
     */
    function __construct() {
        $this->table = "file_type";
        $this->tableSet = "tid,type_name,suffix";
        parent::__construct();
    }
    
    public function setInsertOneData($arr){
        $this->arrSet="'{$arr['tid']}','{$arr['type_name']}','{$arr['suffix']}'";
    }

}
