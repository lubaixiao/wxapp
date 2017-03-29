<?php
/**
 * Description of UserInfo
 * 用户信息表的DAO
 * @author 陆佰晓
 */
class UserInfoDao extends BaseDaoImpl {

    /**
     * 初始化数据
     */
    function __construct() {
        $this->table = "user_info";
        $this->tableSet = "login_name,password,is_forbid,real_name,face_img,birthday,tel,virtual_money,register_date";
        parent::__construct();
    }
    
	//生成插入字符串
    public function setInsertOneData($arr) {
    	$str = "'%s','%s','%s','%s','%s','%s','%s','%s','%s'";
        $this->arrSet = vsprintf($str,$arr);
    }

}
