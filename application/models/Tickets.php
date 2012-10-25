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

    /**
     * Closed Ticket or Duplicate 
     * @param type $numero
     */
    public function closeTicket($numero) {

        $tickets = self::getUsersTicket($numero);

        foreach ($tickets as $ticket) {
            $data = $ticket->data;
            $datalimite = $ticket->datalimite;
            $repeat = $ticket->duplicar;
        }

        $data = Zend_Date::now();
        $dataL = new Zend_Date($datalimite);
        //Semanal
        if ($repeat == "d") {
            $newDate = $data->addDay("1");
            $newLimit = $dataL->addDay("1");
        } else if ($repeat == "s") {
            $newDate = $data->addDay("7");
            $newLimit = $dataL->addDay("7");
        } else if ($repeat == "m") {
            $newDate = $data->addDay("30");
            $newLimit = $dataL->addDay("30");
        } else if ($repeat == "a") {
            $newDate = $data->addDay("365");
            $newLimit = $dataL->addDay("365");
        } else {
            
        }

        $db = $this->db;
        $dataT = array('status' => 2, 'data' => date("Y-m-d H-i-s"));
        $db->update($dataT, 'numero =' . $numero);

        self::duplicateTicket($data, $newLimit, $numero);
    }

    /**
     * Duplicate Ticket
     * @param type $datacricao
     * @param type $datalimite
     * @param type $numero
     */
    public function duplicateTicket($datacricao, $datalimite, $numero) {

        $tickets = self::getUsersTicket($numero);

        
        $data = Zend_Date::now();
        $data = $data->get('YYYY-MM-dd HH:mm:ss');
        
        $datacricao = new Zend_Date($datacricao);
        $datacricao = $datacricao->get('YYYY-MM-dd HH:mm:ss');
        
        
        $datalimite = new Zend_Date($datalimite);
        $datalimite = $datalimite->get('YYYY-MM-dd HH:mm:ss');
        
        $tick['numero'] = rand();
        
        foreach ($tickets as $ticket) {
            $tick['departamento'] = $ticket->departamento;
            $tick['usuario'] = $ticket->usuario;
            $tick['proprietario'] = $ticket->proprietario;
            $tick['prioridade'] = $ticket->prioridade;
            $tick['assunto'] = $ticket->assunto;
            $tick['descricao'] = $ticket->descricao;
            $tick['arquivo'] = $ticket->arquivo;
            $tick['data'] = $data;
            $tick['datalimite'] = $datalimite;
            $tick['datacriacao'] = $data;
            $tick['status'] = 0;
            $tick['expirado'] = 0;
            $tick['duplicar'] = $ticket->duplicar;

            $insT = new Application_Model_DbTable_Tickets();
            $insT->insert($tick);
        }
    }

}

