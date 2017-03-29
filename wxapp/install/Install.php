  <?php
            header("Content-type: text/html; charset=utf-8");
            /**
             * 初始化安装类
             * 建立数据库，添加超级管理信息
             */
            class Install {

                private $host = "";
                private $port = "";
                private $db = "";
                private $user = "";
                private $pwd = "";
                private $superUser = "";
                private $superpPwd = "";
                private $pdo = null;

                function __construct($conf) {
                    $this->host = $conf['host'];
                    $this->port = $conf['port'];
                    $this->db = $conf['db'];
                    $this->user = $conf['user'];
                    $this->pwd = $conf['pwd'];
                    $this->superUser = $conf['superUser'];
                    $this->superpPwd = $conf['superPwd'];
                    /* 获取初级数据库pdo */
                    try {
                        $mysalset = "mysql:host={$this->host};port={$this->port}";
                        $this->pdo = new PDO($mysalset, $this->user, $this->pwd);
                    } catch (PDDException $e) {
                        echo"连接数据库失败！{$e}";
                    }
                }

                public function run() {
                    $this->createBaseData();
                    if ($this->createTable()) {
                        $this->createConfiuge();
                        echo "<br/>配置文件写入成功！";
                        exit;
                    }
                }

                /**
                 * 创建系统所需的数据库
                 * database:runcheng
                 */
                private function createBaseData() {
                     //将原有数据库清除掉$this->destroyDatabase();
                    $rs = $this->pdo->exec("CREATE DATABASE {$this->db} DEFAULT CHARSET utf8 COLLATE utf8_general_ci");
                    echo "建立数据库[{$this->db}]......";
                    if ($rs === 1) {
                        echo "成功！";
                        try {
                            $mysalset = "mysql:host={$this->host};port={$this->port};dbname={$this->db}";
                            $this->pdo = new PDO($mysalset, $this->user, $this->pwd);
                        } catch (PDDException $e) {
                            echo"连接指定数据库失败！{$e}";
                        }
                    } else {
                        exit("失败！");
                    }
                }

                /**
                 * 创建系统所需的数据库表
                 * table:privilege_level、user_info、file_info
                 * 
                 */
                private function createTable() {
                    //创建用户权限表
                    $this->createTableLevel();
                    //创建用户的信息表
                    $this->createTableUseInfo();
                    //创建文件的允许后缀表限制表
                    $this->createTableFileType();
                    //创建文件资源信息表file_info  
                    $this->createTableFileInfo();
                    $this->createConfiuge();
                }

                private function createTableLevel() {
                    //创建用户权限等级划分表privilege_level
                    $sql = "CREATE TABLE privilege_level(
                        pid INT NOT NULL PRIMARY KEY,
                        level_name VARCHAR(64) NOT NULL
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8;";
                    $rs = $this->pdo->exec($sql);
                    echo "<br/>创建用户权限等级划分表[privilege_level]......";
                    if ($rs == 0) {
                        echo "成功";
                        //权限等级设定等级
                        $rs = $this->pdo->exec("INSERT INTO privilege_level (pid,level_name) VALUES('99','超级管理员'),('1','管理员'),('2','普通用户')");
                        echo "<br/>创建用户权限等级划分表初始化......";
                        if ($rs) {
                            echo "成功！";
                        } else {
                            echo "失败！";
                            exit;
                        }
                    } else {
                        echo "失败！";
                        exit;
                    }
                }

                private function createTableFileType() {
                    //文件类别表file_type

                    $rs = $this->pdo->exec("
                        CREATE TABLE file_type(
                        tid INT NOT NULL PRIMARY KEY,
                        type_name VARCHAR(32) NOT NULL,
                        suffix text
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8;");
                    echo "<br/>创建文件类别表[file_type]......";
                    if ($rs == 0) {
                        echo "成功";
                        //权限等级设定等级
                        $insetStr1 = "'1','文档','1.txt.docx.doc.pdf.wpd.rtf.xls.ppt.'";
                        $insetStr2 = "'2','视频','2.mp4.rmvb.avi.rm.3gp.flv.'";
                        $insetStr3 = "'3','音频','3.flac.ape.wav.mp3.aac.ogg.wma.'";
                        $insetStr4 = "'4','图片','4.jpg.jpeg.gif.png.bmp.'";
                        $insetStr5 = "'5','压缩包','5.tar.zip.rar.jar.7-zip.'";
                        $insetStr6 = "'6','软件','6.exe.'";
                        $insetStr7 = "'99','其他',''";
                        $rs = $this->pdo->exec("INSERT INTO file_type (tid,type_name,suffix) VALUES({$insetStr7}),({$insetStr1}),({$insetStr2}),({$insetStr3}),({$insetStr4}),({$insetStr5}),({$insetStr6})");
                        echo "<br/>创建文件类别表初始化......";
                        if ($rs) {
                            echo "成功！";
                        } else {
                            echo "失败！";
                            exit;
                        }
                    } else {
                        echo "失败！";
                        exit;
                    }
                }

                private function createTableFileInfo() {
                    $rs = $this->pdo->exec("
                        CREATE TABLE file_info(
                        fid INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                        file_name VARCHAR(128) NOT NULL,
                        file_size float NOT NULL,
                        file_type INT NOT NULL,
                        content_type VARCHAR(128),
                        upload_date  date,
                        upload_user INT NOT NULL,
                        CONSTRAINT file_ibfk_1 FOREIGN KEY (file_type) REFERENCES file_type (tid),
                        CONSTRAINT file_ibfk_2 FOREIGN KEY (upload_user) REFERENCES user_info (uid)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8;");
                    echo "<br/>文件资源信息表[file_info]创建......";
                    if ($rs == 0) {
                        echo "成功！";
                        return true;
                    } else {
                        echo "失败！";
                        exit;
                    }
                }

                private function createTableUseInfo() {
                    //创建用户信息表user_info  
                    $rs = $this->pdo->exec("
                        CREATE TABLE user_info(
                        uid INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                        login_name VARCHAR(32) NOT NULL,
                        password CHAR(32) NOT NULL,
                        privilege_level INT NOT NULL,
                        real_name VARCHAR(64),
                        department VARCHAR(64),
                        space_size INT,
                        use_space_size INT,
                        activitive char(1) NOT NULL,
                        CONSTRAINT user_ibfk_1 FOREIGN KEY (privilege_level) REFERENCES privilege_level (pid)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8;");
                    echo "<br/>用户信息表[user_info]创建......";
                    if ($rs == 0) {
                        echo "成功！";
                        //添加超级管理员
                        $admin_pwd = md5($this->superpPwd . md5("king" . $this->superpPwd)); //密码处理，扩展到32位字符
                        $rs = $this->pdo->exec("INSERT INTO user_info (login_name,password,privilege_level,real_name,department,space_size,use_space_size,activitive) VALUES('{$this->superUser}','{$admin_pwd}','1','','','4096','0','1')");
                        echo "<br/>向用户信息表user_info添加超级管理员......";
                        if ($rs == 1) {
                            echo "成功！<br/><h3 style=\"color:red\">超级管理员登录账号：{$this->superUser} <br/> 密码：{$this->superpPwd}</h3>";
                        } else {
                            echo "失败！";
                            exit;
                        }
                    } else {
                        echo "失败！";
                        exit;
                    }
                }

                private function createConfiuge() {
                    $conf_path = "../app/configue/sqlConfigue.php";
                    $conf_tpl = "<?php \r\n \$GLOBALS['db_conf']=array(\r\n'host'=>'%s',\r\n'db'=>'%s',\r\n'port'=>'%s',\r\n'user'=>'%s',\r\n'pwd'=>'%s');";
                    $conf_tpls = sprintf($conf_tpl, $this->host, $this->db, $this->port, $this->user, $this->pwd);
                    $conf_file = fopen($conf_path, "w");
                    fwrite($conf_file, $conf_tpls);
                    fclose($conf_file);
                }

                /*
                 * 摧毁整个原始数据库
                 * 慎用危险级别高！；
                 */

                public function destroyDatabase() {
                    return $this->pdo->exec("drop database {$this->db}");
                }

                /**
                 * 关闭pdo连接
                 */
                function __destruct() {
                    $this->pdo = null;
                }

            }

//            if (!is_string($_GET) && !isset($_GET['host']) && !isset($_GET['port']) && !isset($_GET['db']) && !isset($_GET['user']) && !isset($_GET['pwd'])) {
//                echo "<h2 style='text-align:center;'>数据库配置信息</h2><form  method='get'>";
//                echo "<table border='0'>";
//                echo "<tr><td>主机地址：</td><td><input type=\"text\" name=\"host\" value='localhost'></td></tr>";
//                echo "<tr><td>端口号：</td><td><input type=\"text\" name=\"port\" value='3306'></td></tr>";
//                echo "<tr><td>数据库名：</td><td><input type=\"text\" name=\"db\" value='qdm164809401_db'></td></tr> ";
//                echo "<tr><td>数据库用户：</td><td><input type=\"text\" name=\"user\" value='qdm164809401'></td></tr>";
//                echo "<tr><td>数据库密码：</td><td><input type=\"text\" name=\"pwd\" value='15994551509'></td></tr>";
//                echo "<tr><td>系统超级管理员：</td><td><input type=\"text\" name=\"superuser\" value='admin'></td></tr>";
//                echo "<tr><td>系统超级管理员密码：</td><td><input type=\"text\" name=\"superpwd\" value='admin'></td><tr><td colspan='2'></td></tr></tr>";
//                echo "<tr><td colspan='2' style='text-align:center;'><input type=\"submit\" value=\"创建\"></td></tr>";
//                echo "</table></form>";
//                exit;
//            } else {
//                if (is_array($_GET)) {
//                    $conf = array(
//                        "host" => $_GET['host'],
//                        "port" => $_GET['port'],
//                        "db" => $_GET['db'],
//                        "user" => $_GET['user'],
//                        "pwd" => $_GET['pwd'],
//                        "superUser" => $_GET['superuser'],
//                        "superPwd" => $_GET['superpwd']);
//                    // print_r($conf);
//                }
//                //$install = new Install($conf);
//               // $install->run();
//            }
 ?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>安装微信webApp系统</title>
    </head>
    <script type="text/javascript" src="/wxapp/js/jquery-3.1.0.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#main").hide(); 
        });
    </script>
    <body style="background-color:#CCCCCC;">
        <div id="main" style="width:350px; background-color:#FFFFFF; margin-left: auto; margin-right: auto;">
            <h1>1234567890</h1>
        </div>
    </body>
</html>