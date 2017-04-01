<?php

//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING); //屏蔽一切警告
require_once 'app/wxApp.php';
try {
    $webapp = new wxApp();
    $webapp->run();
} catch (Exception $e) {
    appLogs($e);
}