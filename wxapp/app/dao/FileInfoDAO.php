<?php
/**
 * Description of UserInfo
 * 用户文件资源的DAO
 * @author kinglu
 */
class FileInfoDAO extends BaseDaoImpl {

    /**
     * 初始化数据
     */
    function __construct() {
        $this->table = "file_info";
        $this->tableSet = "file_name,file_size,file_type,content_type,upload_date,upload_user";
        parent::__construct();
    }
    
    public function setInsertOneData($arr){
        $this->arrSet="'{$arr['file_name']}','{$arr['file_size']}','{$arr['file_type']}','{$arr['content_type']}','{$arr['upload_date']}','{$arr['upload_user']}'";
    }

}
