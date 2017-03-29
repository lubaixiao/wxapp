<?php

interface IServiceController {

    //获取用户列表
    public function getUserList();

    //注册
    public function userRegister();
//  //登录
//  public function userLogin();
//  //上传文件
//  public function uploadFile();
//  //文件下载
//  public function loadFile();
//  //删除文件
//  public function deleteFile();
//  //获取文件文件列表按时间顺序
//  public function getFileList();
//  //获取已登录用户的cookie数据
//  public function getUserMessage();
//  //测试时，填充数据使用
//  public function setData($data);
//  //对文件上传结束后返回的数据处理成可以被数据库存储的数据格式
}
