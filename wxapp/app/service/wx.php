<?php
header("Content-type: text/html; charset=utf-8"); 
define("TOKEN", "weixin");
$wechatObj = new wechatCallbackapiTest();

if (isset($_GET['echostr'])) {
    mylog("验证！");
    $wechatObj->valid();
}else{
   $ip = $_SERVER["REMOTE_ADDR"];
   $fh = file_get_contents("http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip={$ip}");
   $arr = json_decode($fh, true);
   mylog("请求信息： 所属地：".$arr["country"].$arr["province"].$arr["city"]." ip地址： ".$ip);
   $wechatObj->responseMsg();
   mylog("请求！");
}

class wechatCallbackapiTest
{
    public function valid()
    {
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
            header('content-type:text');
            echo $echoStr;
            exit;
        }
    }

    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }
    

    public function responseMsg()
    {
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        if (!empty($postStr)){
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            mylog("请求者id:".$fromUsername);
            $keyword = trim($postObj->Content);
            $time = time();
            $textTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                        <FuncFlag>0</FuncFlag>
                        </xml>";
            if($keyword == "?" || $keyword == "？")
            {
                $msgType = "text";
                $contentStr = "<a href='http://www.kinglbx.cn/wxapp/'>app</a>\n<a href='http://www.kinglbx.cn/wxapp/online/'>online</a>";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;           
            }
        }else{
            echo "失败！";
            exit;
        }
    }
}

function mylog($str){
	$myfile = fopen("mylog.txt", "a+") or die("Unable to open file!");
	$txt = date("Y-m-d H:i:s")." [{$fromUser}]msg:  ".$str."\r\n";
	fwrite($myfile,$txt);
	fclose($myfile);
}
?>﻿