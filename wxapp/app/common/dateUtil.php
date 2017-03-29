<?php

/**
 * 日期工具类
 * author : 陆佰晓
 */

class dateUtil{
    private $timestamp;
    function __construct($timestamp){
        $this->timestamp = $timestamp;
    }
    public function  getDateFramt($str){
        return date($str,1490104548);
    }
}
$date = new dateUtil(1490104548);
echo $date->getDateFramt("Y-m-d h:i:s");