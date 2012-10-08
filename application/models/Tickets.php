<?php

/**
 * 01/10/2012
 * @file           Tickets.php
 * @author         Fabio Pratta <fabiobrotas@hotmail.com>
 * @license        default 
 * @copyright      Copyright - SIGP | 01/10/2012
 * @version        Release: 1.0
 */
class Application_Model_Tickets {

    /**
     * @var type 
     */
    private $usuario;
    private $db;

    /**
     * Set user of class 
     * Set Db Zend_Table_Abstract
     */
    public function __construct() {
        $auth = Zend_Auth::getInstance();
        $user = $auth->getStorage()->read();
        $this->usuario = $user->samaccountname;
        $this->db = new Application_Model_DbTable_Tickets();
    }

    /**
     * Get Tickts for User Logged Unfinisheds
     * @return type 
     */
    public function getTicketsUserUnfinished() {

        $db = $this->db;

        $select1 = $db->select()
                ->from("tickets")
                ->where("usuario = ? ", $this->usuario)
                ->where("status < ?", "2");

        $select2 = $db->select()
                ->from("tickets")
                ->where("proprietario = ? ", $this->usuario)
                ->where("status < ?", "2")
                ->group("numero");


        $select = $db->select()->union(array($select1, $select2));

        return $db->fetchAll($select);
    }

    /**
     * Get Tickts for User Logged finisheds
     * @return type 
     */
    public function getTicketsUserFinished() {
        $db = $this->db;

        $select1 = $db->select()
                ->from("tickets")
                ->where("usuario = ? ", $this->usuario)
                ->where("status = ?", "2");
        
        $select2 = $db->select()
                ->from("tickets")
                ->where("proprietario = ? ", $this->usuario)
                ->where("status = ?", "2")
                ->group("numero");

        $select = $db->select()->union(array($select1, $select2));
        return $db->fetchAll($select);
    }


    /**
     * Get Tickts CLosed for User Logged finisheds
     * @return type 
     */
    public function getTicketsClosed() {
        $db = $this->db;
        
        $select1 = $db->select()
                ->from("tickets")
                ->where("usuario = ? ", $this->usuario)
                ->where("status = ?", "3");
        
        $select2 = $db->select()
                ->from("tickets")
                ->where("proprietario = ? ", $this->usuario)
                ->where("status = ?", "3")
                ->group("numero");
        
        $select = $db->select()->union(array($select1, $select2));
        
        return $db->fetchAll($select);
      
    }

    

    /**
     * Get All Tikets for User Logged finisheds
     * @return type 
     */
    public function getAllTickets() {
        $db = $this->db;
        $select = $db->select()
                ->from("tickets")
                ->where("usuario = ? ", $this->usuario)
                ->orWhere("proprietario = ? ", $this->usuario)
                ->group("numero")
                ->order("tickets.prioridade ASC");
        return $db->fetchAll($select);
    }

    /**
     * Get Ticker Number
     * @param type $number
     * @return type 
     */
    public function getTickerNumber($number) {
        $db = $this->db;
        $select = $db->select()
                ->from("tickets")
                ->where("numero = ?", $number);
        return $db->fetchRow($select);
    }

    /**
     * Get Users of Ticket number
     * @param type $number
     * @return type 
     */
    public function getUsersTicket($number) {
        $db = $this->db;
        $select = $db->select()
                ->from("tickets")
                ->where("numero = ?", $number);
        return $db->fetchAll($select);
    }

    /**
     * Update Status 
     * @param type $numero
     * @param type $status 
     */
    public function updateStatus($numero, $status) {
        $db = $this->db;
        $data = array('status' => $status, 'data' => date("Y-m-d H-i-s"));
        $db->update($data, 'numero =' . $numero);
    }

}

