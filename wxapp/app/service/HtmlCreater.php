<?php
/**
 * auther : 陆佰晓
 * 20170301
 * html文件管理类
 * 作用：返回请求的html文件
 */

class HtmlCreaterService {

    private $htmlStr = null;
    private $htmlSrc = null;

    function __construct($jsonData) {
        $this->htmlSrc = "html/" . $jsonData["need"] . ".html";
    }

    function getHtmlStr() {
        if (file_exists($this->htmlSrc)) {
           return $this->htmlStr = file_get_contents($this->htmlSrc);
        }else{
           return false;
        }
    }
}
