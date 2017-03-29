<?php
	/**
	 * 返回请求的html界面
	 */
header("Content-type: text/html; charset=utf-8");
  if (is_array($_POST) && count($_POST) > 0) {//先判断是否通过Post传值了
            if (isset($_POST["jsonData"])) {//是否存在"id"的参数
                $jsonData = $_POST["jsonData"];
                $need = "html/". $jsonData["need"].".html"; //存在
            }
    }
    if(file_exists($need)){
        $content = file_get_contents($need);
        rJsonArray(array("data"=>$content));
    }
            
?>
