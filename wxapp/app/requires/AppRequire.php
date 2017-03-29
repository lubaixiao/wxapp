<?php

/**
 * 加载环境类。
 * 根据前台传回来的action参数判定要加载那些文件
 * author : 陆佰晓    
 * 2016.10.29
 */
class AppRequire {

    private $action; //下一步执行的动作。; 

    function __construct($action) {
        $this->action = $action;
    }

    public function loadNeeds() {
        
        //有些action需要登录，检查是否登录,根据登录状态和参数action的值进行必要的php页面加载，
        //构成可运行环境。
        //未登录状态
        $zt = false;
        switch ($this->action) {
            case "getUserList":
                include_once "Require_login.php";
                $zt = true;
                break;
            case "getLiveOnline":
                include_once "Require_live.php";
                $zt = true;
                break;
            default: break;
        }
        if ($zt) {
            return $zt;
        }
        if ($this->checkLogin()) {
            //登录状态
            switch ($this->action) {
                case "scoreList":

                    break;
                default:
                    return false;
                    break;
            }
            return true;
        }
    }

    private function checkLogin() {
        //检查登录情况  ，如果是登录状态，更新会话的保存时间，半小时。
        $login_cookie = new ServiceCookie();
        $userName = $login_cookie->getCookie("userName");
        if (!$userName) {
            return false;
        } else {
            $login_cookie->registerCookie("userName", $userName, 1800);
            return true;
        }
    }

}
