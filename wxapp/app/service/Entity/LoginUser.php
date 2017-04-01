<?php

class LoginUser {

    private $sid;
    private $login_name;
    private $real_name;
    private $pwd;

    function __construct($arr) {
        list($this->sid, $this->login_name, $this->real_name, $this->pwd) = $arr;
    }

    public function getSid() {
        return $this->sid;
    }

    public function getLoginName() {
        return $this->login_name;
    }

    public function getRealName() {
        return $this->real_name;
    }

    public function getPassword() {
        return $this->pwd;
    }

}
