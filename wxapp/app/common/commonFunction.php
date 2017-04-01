<?php

/**
 * 常用的自定义全局函数
 * author : 陆佰晓
 */

/**
 * 将字符串以JSON数据格式返回
 */
function rJsonMsg($data) {
    /* 输出的数据设置格式为json */
    header("Content-type: text/json; charset=utf-8");
    echo json_encode(array("msg" => $data));
    exit;
}

/**
 * 将数组以JSON数据格式返回
 */
function rJsonArray($arr) {
    /* 输出的数据设置格式为json */
    header("Content-type: text/json; charset=utf-8");
    echo json_encode(array("data" => $arr));
    exit;
}

/**
 * 将日记写入指定文件夹
 * @param type $log
 */
function appLogs($log) {
    if (is_array($log)) {
        $log = implode('', $log);
    }
    $myfile = fopen("app/logs/applogs.txt", "a+") or die("Unable to open file!");
    $txt = date("Y-m-d H:i:s") . " msg:  " . $log . "\r\n";
    fwrite($myfile, $txt);
    fclose($myfile);
}

/**
 * 获取get方法传过来的参数
 * @param type $str
 * @return type
 */
function getDataByGET($str = "action") {
    if (is_string($_GET[$str]) || isset($_GET[$str])) {
        return $_GET[$str];
    }
}

/**
 * 获取POST方法传过来的数据
 * @param type $str
 * @return type
 */
function getDataByPOST($str = "jsonData") {
    if (is_string($_POST[$str]) || isset($_POST[$str])) {
        return $_POST[$str];
    }
}

/**
 * 多维数组转字符串
 * @param type $data
 * @return type
 */
function arraysToString($data) {
    if (is_array($data)) {
        return implode("|", array_map("arraysToString", $data));
    }
    return $data;
}

/**
 * 将字符串转换成二维数组
 * @param type $str
 * @param type $num
 * @return type
 */
function stringToArrays($str = "", $num = 0) {
    $arr = explode("|", $str);
    $data = array();
    for ($i = 0; $i < sizeof($arr) / $num; $i++) {
        $data[] = array_slice($arr, $i * $num, $num);
    }
    return $data;
}
