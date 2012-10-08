<?php

/**
 * 03/10/2012
 * @file           Interacao.php
 * @author         Fabio Pratta <fabiobrotas@hotmail.com>
 * @license        default 
 * @copyright      Copyright - SIGP | 03/10/2012
 * @version        Release: 1.0
 */
class Application_Model_Interacao {

    /**
     *
     * @var type 
     */
    private $db;

    /**
     * Set user of class 
     * Set Db Zend_Table_Abstract
     */
    public function __construct() {
        $auth = Zend_Auth::getInstance();
        $user = $auth->getStorage()->read();
        $this->usuario = $user->samaccountname;
        $this->db = new Application_Model_DbTable_Interacao();
    }

    /**
     * get Interacao of tickets
     * @param type $numero
     * @return type 
     */
    public function getInteracao($numero) {
        $db = $this->db;
        $select = $db->select()
                ->from("interacao")
                ->where("numero = ?", $numero);
        return $db->fetchAll($select);
    }

}

