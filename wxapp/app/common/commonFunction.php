<?php

/**
 * 常用的自定义全局函数
 * author : 陆佰晓
 */

/**
 * 将字符串以JSON数据格式返回
 */
function rJsonMsg($data) {
    echo json_encode(array("msg" => $data));
    exit;
}

/**
 * 将数组以JSON数据格式返回
 */
function rJsonArray($arr) {
    echo json_encode($arr);
    exit;
}

/**
 * 将日记写入指定文件夹
 * @param type $log
 */
function appLogs($log) {
    if(is_array($log)){
        $log = implode('',$log);
    }
    $myfile = fopen("app/logs/applogs.txt", "a+") or die("Unable to open file!");
    $txt = date("Y-m-d H:i:s") . " msg:  " . $log . "\r\n";
    fwrite($myfile, $txt);
    fclose($myfile);
}
