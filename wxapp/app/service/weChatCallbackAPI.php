<?php

class weChatCallbackAPI {

    public function valid() {
        $echoStr = getDataByGET("echostr");
        appLogs("接口验证请求！");
        if ($this->checkSignature()) {
            header("Content-type:text/html;charset=utf-8");
            appLogs("接口验证请求通过！");
            echo $echoStr;
            exit;
        }
        appLogs("接口验证请求未通过！");
    }

    private function checkSignature() {
        $signature = getDataByGET("signature");
        $timestamp = getDataByGET("timestamp");
        $nonce = getDataByGET("nonce");
        $token = TOKEN;

        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStrs = sha1($tmpStr);
        return ($tmpStrs === $signature) ? true : false;
    }

    public function responseMsg() {
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        if (!empty($postStr)) {
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            appLogs("服务请求：请求者微信id[" . $fromUsername . "]");
            $keyword = trim($postObj->Content);
            $time = time();
            $textTpl = "<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[%s]]></MsgType><Content><![CDATA[%s]]></Content></xml>";
            if ($keyword == "?" || $keyword == "？") {
                $msgType = "text";
                $contentStr = "<a href='http://www.kinglbx.cn/wxapp/'>app</a>\n<a href='http://www.kinglbx.cn/wxapp/online/'>online</a>";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            }
            if (strpos($keyword, "小梅") === 0) {
                $msgType = "text";
                $contentStr = "小耀超爱的！";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            }
            if (strpos($keyword, "s") === 0) {
            $textTpl = "<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[%s]]></MsgType><Image><MediaId><![CDATA[%s]]></MediaId></Image></xml>";
                $msgType = "image";
                $contentStr = "https://gss0.baidu.com/-4o3dSag_xI4khGko9WTAnF6hhy/zhidao/pic/item/c8ea15ce36d3d5397207aab63c87e950352ab089.jpg";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;       
            }
        } else {
            appLogs("服务请求失败！");
            exit;
        }
    }

}
