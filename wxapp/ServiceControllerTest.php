<?php
header("Content-type: text/html; charset=utf-8");
require_once '/service/ServiceController.php';

$service = new ServiceController();
print_r($service->getUserList());
$service->userRegister();

/*
//登录测试
$data = array("name"=>"admin","password"=>"123456");
$service->setData($data);
$service->userLogin();
exit;
*/