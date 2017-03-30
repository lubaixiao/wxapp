<?php

class ServiceController implements IServiceController {

    private $jsonData = null; //前台提交的数据

    /**
     * 使用的构造方法初始化服务所需的数据
     */

    function __construct($jsonData) {
        $this->jsonData = $jsonData;
        // $this->checkOrLoadConfigue();
    }

    /**
     * 获取指定的html页面数据
     */
    public function getHtml() {
        return rJsonArray($this->jsonData);
    }

    /**
     * 微信API接口
     */
    public function weChat() {
        header("Content-type: text/xml; charset=utf-8");
        define("TOKEN", "weixin");
        if (is_string($_SERVER["REMOTE_ADDR"])) {
            $ip = $_SERVER["REMOTE_ADDR"];
            $clientMsg = file_get_contents("http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip={$ip}");
            $arr = json_decode($clientMsg, true);
            appLogs("请求信息： 所属地：" . $arr["country"] . $arr["province"] . $arr["city"] . " ip地址： " . $ip);
        }
        $wechatAPI = new weChatCallbackAPI();
        if (getDataByGET("echostr")) {
            $wechatAPI->valid(); //token验证
        } else {
            $wechatAPI->responseMsg();//服务
        }
    }

    /**
     * 加载数据库配置信息
      private function checkOrLoadConfigue() {
      $conf_path = "app/configue/configue.php";
      if (file_exists($conf_path)) {
      include($conf_path);
      } else {
      rJsonMsg("未创建系统所需数据库!");
      }
      }
     *   public function getUserList() {
      $userInfoDao = new UserInfoDao();
      return rJsonArray($userInfoDao->getAllData());
      }
     */
    /* public function getLiveOnline() {
      $serviceCookie = new ServiceCookie();
      $liveOnlineDao = new LiveOnlineDao();

      //直播地址
      $new_time = time();
      $url = "http://live.kinglbx.cn/AppName/StreamName.m3u8?auth_key=1478189745-0-0-6603c0b72176b46af30bf09a3928b3b4";
      $online = $liveOnlineDao->getCount();
      //检查是否有过期的链接
      $count = $liveOnlineDao->getMax("count");
      $liveOnlineDao->deleteSomeByGreater("time_char", ($new_time - 10));
      //检查是否到达负载极限

      if ($online < 100) {
      //检查登录状态，没有登录取时间置为登录
      $user_id = $serviceCookie->getCookie("time_char");
      if (!$user_id) {
      //新增数据库的time_char
      //echo "新增";
      $serviceCookie->registerCookie("time_char", $new_time, $new_time + 3600);
      $liveOnlineDao->setInsertOneData(array($new_time, $new_time, ($count + 1)));
      $liveOnlineDao->addOne();
      } else {
      //新增、更新数据库的time_char
      if ($liveOnlineDao->getOneBykey("online_id", $user_id) == null) {
      //echo "有cookie新增";
      $liveOnlineDao->setInsertOneData(array($user_id, $new_time, ($count + 1)));
      $liveOnlineDao->addOne();
      } else {
      //echo "有cookie更改";
      $liveOnlineDao->modifyOneByKey("time_char", $new_time, "online_id", $user_id);
      $liveOnlineDao->modifyOneByKey("count", $count, "online_id", $user_id);
      }
      }
      return rJsonArray(array("url" => $url, "online" => $online, "count" => $count));
      } else {
      return rJsonArray(array("url" => 100, "online" => $online, "count" => $count));
      }
      }
     *  public function userRegister() {
      $userInfoDao = new UserInfoDao();
      $arr = array("kingw2", "1234567", "n", "张三", "http://www.htamg.com/img.jpg", "2016-10-04", "12345678909", "0", "2016-10-11");
      $userInfoDao->setInsertOneData($arr);
      $userInfoDao->addOne();
      }
     */



//  /**
//   * 用户登录
//   *  $this->data["name"]：前台post过来的用户名
//   *  $this->data["password"]：前台post过来的用户密码
//   * 描述：根据前台的数据查询数据库，
//   * 如果用户存在，启动cookie保存用户信息，并用json前台传输
//   * 用户信息，失败返回识别码
//   */
//  public function userLogin() {
//
//      $userInfo = new UserInfoDao();
//      $name = $this->data["name"];
//      $password = $this->data["password"];
//      $user = $userInfo->getOneBykey("login_name", $name);
//      $password = md5($password) . md5("king" . $password);
//      if ($user != NULL && $user["password"] === $password) {
//          $cookie = new ServiceCookie();
//          $cookie->registerCookie("user", $name, 3600);
//          rJsonMsg($name);
//      } else {
//          rJsonMsg(1);
//      }
//  }
//
//  /**
//   * 获取用户的注销
//   * 清空cookie数据
//   */
//  public function userLogout() {
//      $cookie = new ServiceCookie();
//      $cookie->destroyCookie("user");
//      rJsonMsg(0);
//  }
//
//  /**
//   * 上传文件处理
//   * 当文件上传完毕，
//   * 向数据库存入文件上传的基本信息
//   */
//  public function uploadFile() {
//      $uploadfile = new UploadFile();
//      $arr = $uploadfile->run();
//      $fileInfoDao = new FileInfoDao();
//      $fileInfoDao->setInsertOneData($this->dealDataOfInsertFileInfo($arr[0]));
//      $fileInfoDao->addOne();
//      rJsonArray($arr[1]);
//  }
//
//  /**
//   * 文件下载处理
//   */
//  public function loadFile() {
//      $load = new LoadFile("xampp_5_2_2.exe", "application/octet-stream");
//      $load->runLoadFile();
//  }
//
//  public function deleteFile() {
//      $val = $this->data['fid'];
//      $fileInfoDao = new FileInfoDao();
//      if ($fileInfoDao->deleteOneByKey("fid", $val)) {
//          rJsonMsg(0);
//      } else {
//          rJsonMsg(1);
//      }
//  }
//
//  /**
//   * 获取已登录用户的cookie数据
//   */
//  public function getUserMessage() {
//      $cookie = new ServiceCookie();
//      $msg = $cookie->getCookis("user");
//      if ($msg == FALSE) {
//          rJsonMsg(1);
//      } else {
//          rJsonMsg($msg);
//      }
//
//  }
//
//  /**
//   * 获取已上传的文件信息列表
//   * $this->data['page']:获取的页码
//   * $this->data['pageSize']:获取的页码大小（记录的条数）
//   * 
//   */
//  public function getFileList() {
//      $fileInfoDao = new FileInfoDao();
//      $index = $this->data['page'];
//      $pageSize = $this->data['pageSize'];
//      $arr = $fileInfoDao->getArrayBykeyLimit("uploaddate", $index, $pageSize);
//      rJsonArray($arr);
//  }
//
//  /**
//   * 用于测试时设置data的参数
//   * 平时状态屏蔽
//   */
//  public function setData($data) {
//      $this->data = $data;
//  }
//
//  /*
//   * 对文件上传结束后返回的数据处理成可以被数据库存储的数据格式
//   */
//
//  private function dealDataOfInsertFileInfo($arr) {
//      //处理前$arr=array("file_name"=>$this->name,"file_size"=>$filesize,"file_extension"=>$this->file_extension,"content_type"=>$this->content_type,"upload_date"=>$uploaddate);
//      //处理后$newArr=array("file_name"=>?,"file_size"=>?,"file_type"=>?,"content_type"=>?,"upload_date"=>?,"upload_user"=>?);
//      $newArr['file_name'] = $arr['file_name'];
//      $newArr['file_size'] = $arr['file_size'];
//      $newArr['file_type'] = $this->getTypeByExtension($arr['file_extension']);
//      $newArr['content_type'] = $arr['content_type'];
//      $newArr['upload_date'] = $arr['upload_date'];
//      $userInfo = $this->getUserInfo();
//      if($userInfo==NUll){
//          rJsonMsg("error");
//      }else{
//          $newArr['upload_user'] = $userInfo['uid'];
//      } 
//  }
//
//  /*
//   * 根据文件的扩展名进行查表比对，确定文件的类型【文本，文档】【视频】【音频】【图片】【压缩包】【软件】......
//   * return tid;
//   * 在ServiceControllerTest.php测试时，需将函数属性由私有改为公用
//   */
//
//  private function getTypeByExtension($extension) {
//      $fileTypeDAO = new FileTypeDao();
//      $rsArr = $fileTypeDAO->getAllData();
//      $extension = "." . $extension . ".";
//      foreach ($rsArr as $data) {
//          $pos = stripos($data['suffix'], $extension);
//          //print_r($data); echo "<br/>.......".$pos."<br/>";
//          if ($pos && $data['tid'] != 99) {
//              $extension = $data['tid'];
//              break;
//          } else {
//              if ($data['tid'] == 99) {
//                  $extension = $data['tid'];
//                  break;
//              }
//          }
//      }
//      return $extension;
//  }
//  
//  
//  
//   /**
//   * 获取已登录用户的数据
//   */
//  private function getUserInfo() {
//      $cookie = new ServiceCookie();
//      $name = $cookie->getCookis("user");
//      if ($msg == FALSE) {
//          return NULL;
//      } else {
//          $userInfo = new UserInfoDao();
//          $user = $userInfo->getOneBykey("login_name", $name);
//          return $user;
//      }
//
//  }
//  
}
