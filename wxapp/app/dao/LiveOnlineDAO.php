<?php
/**
 * Description of UserInfo
 * 用户信息表的DAO
 * @author 陆佰晓
 */
class LiveOnlineDAO extends BaseDaoImpl {

    /**
     * 初始化数据
     */
    function __construct() {
        $this->table = "live_online";
        $this->tableSet = "online_id,time_char,count";
        parent::__construct();
    }
    
	//生成插入字符串
    public function setInsertOneData($arr) {
    	$str = "'%s','%s','%s'";
        $this->arrSet = vsprintf($str,$arr);
    }

}
