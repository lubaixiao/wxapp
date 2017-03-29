<?php

/**
 * author : 陆佰晓(kinglu)
 * 系统的入口,接受前台的数据。系统环境加载，运行。
 * 初步判定是否允许执行
 */
require_once "app/common/commonFunction.php";
require_once "app/service/service/ServiceCookie.php";
require_once "app/requires/AppRequire.php";

class WebApp {

    private $action = null; //下一步执行的动作。
    private $jsonData = null; //下一步执行的动作所需数据

    /* 前台的请求统一使用POST,GET方法用于传递action */

    function __construct() {
        $this->setActionByGet();
        $this->setDataByPost();
    }

    /*
     * 获取get方法传过来的参数，确定下一步执行的动作。
     */

    private function setActionByGet() {
        if (is_string($_GET)||isset($_GET["action"])) {//是否存在"action"的参数
            $this->action = $_GET["action"];
        } else {
            rJsonMsg("拒绝访问！");
        }
    }

    /*
     * 获取post数据，为执行动提供数据
     */

    private function setDataByPost() {
            if (is_string($_POST) || $_POST["jsonData"]) {//是否存在"jsonData"的参数
                $this->jsonData = $_POST["jsonData"];
            } else {
                rJsonMsg("拒绝访问！");
            }
    }

    public function run() {
        appLogs($this->action);
        appLogs($this->jsonData);
        rJsonArray(array(1,2,3,4,array("a","b","c")));
        exit;
        $requires = new AppRequire($this->action);
        if ($requires->loadNeeds()) {
            $service = new ServiceController($this->jsonData);
            $action = $this->action;
            if (is_callable(array($service, $action))) {
                print_r($service->$action());
            } else {
                rJsonMsg("访问为非法，拒绝访问！");
            }
        } else {
            rJsonMsg("访问为非法，拒绝访问！");
        }
    }

}
