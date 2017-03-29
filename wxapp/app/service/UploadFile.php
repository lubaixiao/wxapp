<?php
/**
 *文件上传类 
 * author:lubaixiao
 */
class UploadFile {

    private $name = null; //文件全名称，包括后缀
    private $file_name = null; //文件的名称，无后缀
    private $content_type = null; //网络文件类型
    private $file_extension=null;//文件扩展名/后缀
    private $index = 0; //当前前台传输过来的文件片
    private $total = 0; //文件分片的总数
    private $data = array(); //向前台返回的数据
    private $upload_dir = "uploads"; //文件上传保存目录

    /**
     * 采用构造函数初始化类
     */

    function __construct() {
        $this->name = $this->getPostData('name');
        $this->content_type = $this->getPostData('type');
        $this->index = $this->getPostData('index') + 1;
        $this->total = $this->getPostData('total');
        $this->data['data'] = $this->index;
        $this->setFileNameAndFileExtension();
    }

    /**
     * 上传的类执行方法
     */
    public function run() {
        $this->moveFile();
        if ($this->index == $this->total) {
            $arr=array($this->mergeFile(),$this->data);
            return $arr;
            //$this->mergeFileSell();
        }else{
            echo json_encode($this->data);
            exit();
        }
    }

    /**
     * 获取前台传输的数据
     * @param type $str
     * @return type
     */
    private function getPostData($str) {
        if (isset($_POST[$str])) {
            return $_POST[$str];
        }
    }

    //给$file_name和$file_extension赋值
    private function setFileNameAndFileExtension() {
        //将文件名与文件后缀分离成数组
        $names = explode('.', $this->name);
        $arrlen = sizeof($names);
        if ($arrlen == 2) {
            $this->file_name = $names[0];
            $this->file_extension = $names[1];
        } else if ($arrlen > 2) {
            for ($i = 0; $i < $arrlen - 1; $i++) {
                $this->file_name .= $names[$i] . ".";
                if ($i == $arrlen - 3) {
                    $this->file_name .= $names[$i + 1];
                    break;
                }
            }
            $this->file_extension = $names[$arrlen - 1];
        } else {
            $this->data['data'] = "error";
        }
    }

    /**
     * 将上传的文件保存到指定目录
     */
    private function moveFile() {
        //形成有规律的文件块名称	  		
        $newname = $this->file_name . $this->index . "." . $this->file_extension;
        if (!file_exists($this->upload_dir)) {
            mkdir($this->upload_dir);
        }
        $upload_path = $this->upload_dir . "/" . $newname;
        $upload_path = iconv("UTF-8", "GB2312", $upload_path); //解决文件名中文乱码问题
        move_uploaded_file($_FILES['file']['tmp_name'], $upload_path);
    }

    /**
     * 合并文件片
     */
    private function mergeFile() {
        //文件传输完，进行文件合并
        $mergeFileSrc = $this->upload_dir . "/" . $this->file_name . "." . $this->file_extension;
        $mergeFile = fopen(iconv("UTF-8", "GB2312", $mergeFileSrc), "a+");
        if (!$mergeFile) {
            $this->data['data'] = "error";
        } else {

            for ($i = 1; $i <= $this->total; $i++) {
                $filesrc = $this->upload_dir . "/" . $this->file_name . $i . "." . $this->file_extension;
                $filesrc = iconv("UTF-8", "GB2312", $filesrc); //解决文件名中文乱码问题
                $getfile = fopen($filesrc, "r");
                $temp = fread($getfile, filesize($filesrc));
                fwrite($mergeFile, $temp);
                fclose($getfile);
                //删除已合并文件片
                unlink($filesrc);
            }
            fclose($mergeFile);
            
            //准备存入数据库的信息
            date_default_timezone_set('PRC');   /*把时间调到北京时间,php5默认为格林威治标准时间*/
            $uploaddate=date("Y-m-d H:i:s");
            $filesize= round(filesize(iconv("UTF-8", "GB2312", $mergeFileSrc))/(1024));
            $arr=array("file_name"=>$this->name,"file_size"=>$filesize,"file_extension"=>$this->file_extension,"content_type"=>$this->content_type,"upload_date"=>$uploaddate);
            return $arr;
            
        }
    }

    /**废止
     * shell合并文件片
     */
    private function mergeFileSell() {    
        //文件传输完，进行文件合并
        $mergeFileSrc = $this->upload_dir . "\\" . $this->file_name . "." . $this->file_extension;
        $mergeFileSrc = iconv("UTF-8", "GB2312", $mergeFileSrc);
        $filesrc = $this->upload_dir . "\\" . $this->file_name . "*" . "." . $this->file_extension;
        $filesrc = iconv("UTF-8", "GB2312", $filesrc); //解决文件名中文乱码问题
        $command = "copy /b  {$filesrc} {$mergeFileSrc}";
        shell_exec($command);
       
    }

}