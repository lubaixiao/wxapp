<?php

error_reporting(E_ALL); //E_ALL
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING); //屏蔽一切警告
require_once 'app/wxApp.php';
$webapp = new wxApp();
$webapp->run();
function cache_shutdown_error() {
    $_error = error_get_last();
    if ($_error && in_array($_error['type'], array(1, 4, 16, 64, 256, 4096, E_ALL))) {
        appLogs("致命错误:{$_error['message']}");
        appLogs("文件:{$_error['file']}");
        appLogs("在第:{$_error['line']}");
    }
}
register_shutdown_function("cache_shutdown_error");
