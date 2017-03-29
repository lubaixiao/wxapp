<?php

header("Content-type: text/html; charset=utf-8");
$url = "http://online.gxut.edu.cn/kebiao/doAction.php?act=login";
$post_data = array ( "userName" => "201300406179",
    "password" => "15994551509"
);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);//要访问的地址
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//执行结果是否被返回，0是返回，1是不返回
curl_setopt($ch, CURLOPT_POST, 1);// 发送一个常规的POST请求
curl_setopt($ch, CURLOPT_HEADER, 1);//不包含头部
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);//POST提交的数据包
curl_setopt($ch, CURLOPT_TIMEOUT, 30);//设置超时
$output = curl_exec($ch);//执行并获取数据
curl_close($ch);
$fp = fopen("1234.txt","a");
fwrite($fp,$output);
fclose($fp);
$start = strpos($output,"PHPSESSID");
$len =  strpos($output,"path=/")+6  - $start;
$set_cookie = substr($output, $start,$len);
//echo  $set_cookie;

$url = "http://online.gxut.edu.cn/kebiao/chengji.php";
$ch1 = curl_init();
curl_setopt($ch1, CURLOPT_URL, $url);//要访问的地址
curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);//执行结果是否被返回，0是返回，1是不返回
curl_setopt($ch1, CURLOPT_TIMEOUT, 30);//设置超时
curl_setopt($ch1, CURLOPT_COOKIE, $set_cookie);
$output = curl_exec($ch1);//执行并获取数据
curl_close($ch1);


$outputCopy = $output ;
$jidian_start =  strpos($outputCopy,"<!--jidian-start-->") ;
$jidian_end =  strpos($outputCopy,"<!--jidian-end-->") ; 
$jidian = substr($outputCopy, $jidian_start+19,$jidian_end-$jidian_start-19);       

$start =  strpos($output,"学时</td></tr><tr><td>") ;
$end =  strpos($output,"</td></tr>		   </tbody>") ;
$output = substr($output, $start+24,$end-$start-24);
$output = explode("</td></tr><tr><td>",$output);
foreach ($output as $key => $value) {
  $value = explode("</td><td>",$value);
  $output[$key] = $value;
}

echo json_encode(array($jidian,$output));

?>
