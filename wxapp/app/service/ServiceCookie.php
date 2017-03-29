<?php

class ServiceCookie {

    /**
     *   注册cookie,维护cookie的生存期
     *   $name: cookie的名称
     *   $value: 所赋予值
     *   $time: cookie的生存周期
     */
    public function registerCookie($name, $value, $time) {
        setcookie($name, $value, time() + $time);
    }

    /**
     *  获取cookie
     *  $name: cookie的名称
     */
    public function getCookie($name) {
        if(isset($_COOKIE[$name])){
           return $_COOKIE[$name];
        }else{
           return FALSE;
        }
    }

    /**
     *   销毁cookie
     *    $name: cookie的名称
     */
    public function destroyCookie($name) {
        setcookie($name, "", time() - 3600);
    }

}

?>