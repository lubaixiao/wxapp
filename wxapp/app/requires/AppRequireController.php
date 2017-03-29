<?php

/**
 * 加载环境类。
 * 根据前台传回来的action参数判定要加载那些文件
 * author : 陆佰晓    
 * 2016.10.29
 */
class AppRequireController {

    private $action = null; //下一步执行的动作。; 

    function __construct($action) {
        $this->action = $action;
    }

    public function loadRequires() {
        $load = FALSE;
        switch ($this->action) {
            case "Login":
                include_once "LoginRequire.php";
                $load = TRUE;
                break;
        }
        return $load;
    }

}
