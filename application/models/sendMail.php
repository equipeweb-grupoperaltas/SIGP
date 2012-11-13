<?php

/**
 * 31/10/2012
 * @file           sendMail.php
 * @author         Fabio Pratta <fabiobrotas@hotmail.com>
 * @license        default 
 * @copyright      Copyright - SIGP | 31/10/2012
 * @version        Release: 1.0
 */
class Application_Model_sendMail {
    
    private $email;
    private $usuario;
    private $msg;

    
    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }
    
    public function getMsg() {
        return $this->msg;
    }

    public function setMsg($msg) {
        $this->msg = $msg;
    }

    

    /**
     * Send Mail 
     */
    public function sendMail(){
        
    }
}

