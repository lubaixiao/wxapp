<?php
require_once "app/common/commonFunction.php";
require_once "app/requires/AppRequireController.php";
require_once "app/service/ServiceController.php";

/**
 * author : 陆佰晓(kinglu)
 * 系统的入口,接受前台的数据。系统环境加载，运行。
 * 初步判定是否允许执行
 */
class wxApp {
    
    private $action = null; //下一步执行的动作。
    private $jsonData = null; //下一步执行的动作所需数据

    /**
     * 前台的请求统一使用POST,GET方法用于传递action 
     */
    function __construct() {
        $this->setActionByGet();
        $this->setDataByPost();
    }

    /*
     * 获取get方法传过来的参数，确定下一步执行的动作。
     */
    private function setActionByGet() {
        if ( is_string($_GET) || isset($_GET["action"])) {//是否存在"action"的参数
            $this->action = $_GET["action"];
        } else {
            rJsonMsg("拒绝访问！");
        }
    }

    /*
     * 获取post数据，为执行动提供数据
     */
    private function setDataByPost() {
        if (is_string($_POST) || isset($_POST["jsonData"])) {//是否存在"jsonData"的参数
            $this->jsonData = $_POST["jsonData"];
        } else {
            rJsonMsg("拒绝访问！");
        }
    }

    public function run() {
        $require = new AppRequireController();
        if ($require->loadRequires()) {
            $service = new ServiceController($this->jsonData);
            $action = $this->action;
            if (is_callable(array($service, $action))) {
                $service->$action();
            } else {
                rJsonMsg("访问为非法，拒绝访问！");
            }
        } else {
            rJsonMsg("环境文件加载失败，拒绝访问！");
        }
    }

}
