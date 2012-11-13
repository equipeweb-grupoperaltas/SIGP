<?php

/**
 * 01/11/2012
 * @file           sendSMS.php
 * @author         Fabio Pratta <fabiobrotas@hotmail.com>
 * @license        default 
 * @copyright      Copyright - SIGP | 01/11/2012
 * @version        Release: 1.0
 */
class Application_Model_sendSMS {

    /**
     * set params
     * @var type 
     */
    private $telephone;
    private $msg;

    public function setTelephone($telephone) {
        $this->telephone = $telephone;
    }

    public function getTelephone() {
        return $this->telephone;
    }

    public function getMsg() {
        return $this->msg;
    }

    public function setMsg($msg) {
        $this->msg = $msg;
    }

    public function send(array $telefones) {
        //Instance
        $telnet = new Application_Model_PHPTelnet();
        //Connect
        $result = $telnet->Connect("192.168.5.254", "voip", "1234");
        //select module 1
        $telnet->DoCommand("module1", $result);
        //ate1 command
        $telnet->DoCommand("ate1", $result);
        //configs
        $telnet->DoCommand("at+cmgf=1", $result);

        foreach ($telefones as $telefone) {
            //1497563723
            $telnet->DoCommand('at+cmgs="' . $telefone . '"', $result);
            //send msg 
            $telnet->DoCommand($this->msg, $result);
            //Ctrl + Z
            $telnet->DoCommand(chr(26), $result);
            
        }
        ///echo $result;
        $telnet->DoCommand("logout", $result);

        //$telnet->Disconnect();
    }

}

