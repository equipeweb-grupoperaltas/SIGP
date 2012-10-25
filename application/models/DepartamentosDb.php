<?php

/**
 * 25/10/2012
 * @file           DepartamentosDb.php
 * @author         Fabio Pratta <fabiobrotas@hotmail.com>
 * @license        default 
 * @copyright      Copyright - SIGP | 25/10/2012
 * @version        Release: 1.0
 */
class Application_Model_DepartamentosDb {

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
        $this->db = new Application_Model_DbTable_Departamento();
    }
    
    
    public function fetchPairs(){
        $db = $this->db->getDefaultAdapter();
        $select = $db->select()
                     ->from("departamentos");
        return $db->fetchPairs($select);
    }

}

