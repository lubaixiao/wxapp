<?php

/**
 * auther : 陆佰晓
 * 20160618
 * 文件下载类
 * 
 */
class LoadFile {

    private $file_name = null; //下载的文件名
    private $file_content_type = null; //minu 媒体类型

    function __construct($file_name, $file_content_type) {
        $this->file_name = $file_name;
        $this->file_content_type = $file_content_type;
    }

    public function runLoadFile() {
        $file_path = "uploads/" . $this->file_name;
        $file_size = filesize($file_path);
        //构造头部信息，让浏览器以文件下载模式下载文件
        Header("Content-type: {$this->file_content_type}");
        Header("Accept-Ranges: bytes");
        Header("Accept-Length:{$file_size}");
        Header("Content-Disposition: attachment; filename= {$this->file_name}");
        //单个文件下载
        $buffer = 1024;
        $file_count = 0;
        while (true) {
            if ($file_size <= $buffer) {
                echo file_get_contents($file_path, 1, null, $file_count, $file_size);
                break;
            } else {
                echo file_get_contents($file_path, 1, null, $file_count, $buffer);
                if ($buffer < 1024) {
                    break;
                } else {
                    $file_count+=$buffer;
                    if (($file_count + $buffer) > $file_size) {
                        $buffer = $file_size - $file_count;
                    }
                }
            }
        }
    }

}
