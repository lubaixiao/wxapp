<?php

class ScoreData {

    private $url = array("http://online.gxut.edu.cn/kebiao/doAction.php?act=login",
        "http://online.gxut.edu.cn/kebiao/chengji.php");
    private $post_data = array("userName" => "201300406179",
        "password" => "15994551509"
    );
    private $set_cookie = "";

    public function run() {
        $loginOutput = $this->curlLogin($this->url[0], $this->post_data);
        $fp = fopen("1234.txt", "a");fwrite($fp, $loginOutput);fclose($fp);
        $cookie_start = strpos($loginOutput, "PHPSESSID");
        $cookie_len = strpos($loginOutput, "path=/") + 6 - $cookie_start;
        $this->set_cookie = substr($loginOutput, $cookie_start, $cookie_len);
        
        $dataOutput =  $this->curlGetData($this->url[1], $this->set_cookie);
        $outputCopy = $dataOutput;
        $jidian_start = strpos($outputCopy, "<!--jidian-start-->");
        $jidian_end = strpos($outputCopy, "<!--jidian-end-->");
        $jidian = substr($outputCopy, $jidian_start + 19, $jidian_end - $jidian_start - 19);
        $start = strpos($dataOutput, "学时</td></tr><tr><td>");
        $end = strpos($dataOutput, "</td></tr>		   </tbody>");
        $score_output = substr($dataOutput, $start + 24, $end - $start - 24);
        $score_data = explode("</td></tr><tr><td>", $score_output);
        foreach ($score_data as $key => $value) {
            $value = explode("</td><td>", $value);
            $score_data[$key] = $value;
        }
        return array($jidian, $score_data);
    }
    
    /**
     * post登录成绩查询系统
     * @param type $url
     * @param type $data
     * @return type
     */
    function curlLogin($url = "", $data = array()){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); //要访问的地址
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //执行结果是否被返回，0是返回，1是不返回
        curl_setopt($ch, CURLOPT_POST, 1); // 发送一个常规的POST请求
        curl_setopt($ch, CURLOPT_HEADER, 1); //不包含头部
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data); //POST提交的数据包
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); //设置超时
        $output = curl_exec($ch); //执行并获取数据
        curl_close($ch);
        return $output;
       
    }
    
    /**
     * 在登陆后的成绩显示界面获取数据
     * @param type $url
     * @param type $set_cookie
     * @return type
     */
    function curlGetData($url = "", $set_cookie = array()){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); //要访问的地址
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //执行结果是否被返回，0是返回，1是不返回
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); //设置超时
        curl_setopt($ch, CURLOPT_COOKIE, $set_cookie);
        $output = curl_exec($ch); //执行并获取数据
        curl_close($ch);
        return $output;
    }
}
