<?php
header("Content-type: text/html; charset=utf-8"); 
$servername = "166.62.10.36";
$username = "luking";
$password = "15994551509bai";
$dbname = "wxapp";
$pwd = md5("123456");
echo "更改了7";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // 设置 PDO 错误模式，用于抛出异常
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO user_info(name, password)
    VALUES ('king4','$pwd')";
    // 使用 exec() ，没有结果返回 
    $conn->exec($sql);
    echo "新记录插入成功";
}
catch(PDOException $e)
{
    echo $sql . "<br>" . $e->getMessage();
}

$conn = null;

echo "<br/><hr/><h1>声明：该网站，将用于个人毕业设计展示，非商业用途，遵守有关法律法规！</h1><br/>";
$ip = $_SERVER["REMOTE_ADDR"];
$fh = file_get_contents("http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip={$ip}");
$arr = json_decode($fh, true);
var_dump($arr);
echo "<br/>你的请求来自： ".$arr["country"].$arr["province"].$arr["city"]." : ".$ip;

phpinfo();
?>