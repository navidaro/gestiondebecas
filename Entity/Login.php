<?php
/*
 * @author IvánDarío
 */
class Login {

    private $user;
    private $pass;

    public function __construct($user, $pass) {
        $this->user = $user;
        $this->pass = $pass;
    }

    public function getUser() {
        return $this->user;
    }

    public function getPass() {
        return $this->pass;
    }

    public function setUser($user) {
        $this->user = $user;
    }

    public function setPass($pass) {
        $this->pass = $pass;
    }

}
