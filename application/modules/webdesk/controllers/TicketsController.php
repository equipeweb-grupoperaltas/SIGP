<?php

class Webdesk_TicketsController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    /**
     * View Ticket Infos 
     *
     *
     *
     */
    public function indexAction() {

        $numero = $this->_request->getParam('ticket');

        //Get Data Ticket
        $ticket = new Application_Model_Tickets();
        $ticket = $ticket->getTickerNumber($numero);
        $this->view->assign("ticket", $ticket);

        //Get Users
        $users = new Application_Model_Tickets();
        $users = $users->getUsersTicket($numero);
        $this->view->assign("users", $users);


        //Get interacao
        $interacao = new Application_Model_Interacao();
        $interacao = $interacao->getInteracao($numero);
        $this->view->assign("interacoes", $interacao);


        //Form New
        $form = new Sigp_Form_cadInteracao();
        if ($this->getRequest()->isPost()) {
            //return this data post em var
            $data = $this->getRequest()->getPost();
            //if this form is valid
            if ($form->isValid($data)) {

                //Number of Ticket
                $dataIn['numero'] = $numero;

                //Rename File
                $upload = new Zend_File_Transfer_Adapter_Http();

                if ($upload->isValid()) {

                    $extension = explode(".", $upload->getFileName());

                    $fileName = $dataIn['numero'] . "-" . rand() . '.' . $extension[1];
                    $upload->addFilter('Rename', APPLICATION_PATH . '/../public/Uploads/Webdesk/' . $fileName);
                }

                if (!$upload->receive()) {
                    $fileName = "";
                }

                //Receiveed Form
                $dataIn['descricao'] = $form->getValue("descricao");
                $dataIn['data'] = date("Y-m-d H-i-s");
                $dataIn['anexo'] = $fileName;
                $auth = Zend_Auth::getInstance();
                $user = $auth->getStorage()->read();
                $dataIn['usuario'] = $user->samaccountname;


                $insInteracao = new Application_Model_DbTable_Interacao();
                $insInteracao->insert($dataIn);

                $alterSta = new Application_Model_Tickets();
                $alterSta->updateStatus($numero, 1);

                $this->_redirect('/webdesk/tickets/unfinished');
            }
        }


        $this->view->formulario = $form;
    }

    public function allAction() {
        $ticketsModel = new Application_Model_Tickets();
        $tickets = $ticketsModel->getAllTickets();
        $this->view->assign('paginator', $tickets);
    }

    /**
     * Ticket no Finished 
     *
     *
     *
     */
    public function unfinishedAction() {
        $ticketsModel = new Application_Model_Tickets();
        $tickets = $ticketsModel->getTicketsUserUnfinished();
        $this->view->assign('paginator', $tickets);
    }

    /**
     * Tickets Finishid 
     *
     */
    public function finishedAction() {
        $ticketsModel = new Application_Model_Tickets();
        $tickets = $ticketsModel->getTicketsUserFinished();
        $this->view->assign('paginator', $tickets);
    }

    /**
     * Tickets Finishid 
     *
     */
    public function canceledAction() {
        $ticketsModel = new Application_Model_Tickets();
        $tickets = $ticketsModel->getTicketsClosed();
        $this->view->assign('paginator', $tickets);
    }

    /**
     * Add Ticket Action 
     *
     *
     *
     */
    public function newAction() {
        $formCad = new Sigp_Form_cadTicket();
        if ($this->getRequest()->isPost()) {
            //return this data post em var
            $data = $this->getRequest()->getPost();
            //if this form is valid
            if ($formCad->isValid($data)) {

                //Number of Ticket
                $dataIn['numero'] = rand();

                //Rename File
                $upload = new Zend_File_Transfer_Adapter_Http();
                @$extension = explode(".", $upload->getFileName());

                $fileName = "";
                $upload->addFilter('Rename', APPLICATION_PATH . '/../public/Uploads/Webdesk/' . $dataIn['numero'] . '.' . $extension[1]);
                if ($upload->receive()) {
                    $fileName = $dataIn['numero'] . '.' . $extension[1];
                }

                //Receiveed Form
                $dataIn['departamento'] = $formCad->getValue("departamento");
                $dataIn['prioridade'] = $formCad->getValue("prioridade");
                $dataIn['assunto'] = $formCad->getValue("assunto");
                $dataIn['descricao'] = $formCad->getValue("descricao");
                $dataIn['data'] = date("Y-m-d H-i-s");
                $dataIn['arquivo'] = $fileName;


                $exPlodeDate = explode(" ", $formCad->getValue("datalimite"));
                $dataLimite = "";


                if (count($exPlodeDate) > 1) {

                    $exDate = explode("/", $exPlodeDate[0]);

                    $dataLimite = $exDate[2] . "-" . $exDate[1] . "-" . $exDate[0] . " " . $exPlodeDate[1];
                }


                $dataIn['datalimite'] = $dataLimite;
                
                $dataIn['datacriacao'] = date("Y-m-d H:i:s");
                
                $dataIn['duplicar'] = "".$formCad->getValue("duplicar");
                
                // 0 nao | 1 Sim
                $dataIn['expirado'] = 0;

                $auth = Zend_Auth::getInstance();
                $user = $auth->getStorage()->read();
                $dataIn['proprietario'] = $user->samaccountname;
                // 0 Pendente | 1 = Aguarando Interação  | 2 = Finalizado | 3 Cancelado
                $dataIn['status'] = 0;

                $users = $formCad->getValue("usuario");

                foreach ($users as $user) {
                    $insTicket = new Application_Model_DbTable_Tickets();
                    $dataIn['usuario'] = $user; 
                    $insTicket->insert($dataIn);
                }


                $this->_redirect('/webdesk/tickets/unfinished');
            }
        }


        $this->view->formulario = $formCad;
    }

    public function closedAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);


        $numero = $this->_request->getParam('ticket');
        $alterSta = new Application_Model_Tickets();
        $alterSta->updateStatus($numero, 2);

        $this->_redirect('/webdesk/tickets/finished');
    }

    public function closeAction() {

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);


        $numero = $this->_request->getParam('ticket');
        $alterSta = new Application_Model_Tickets();
        $alterSta->updateStatus($numero, 3);

        $this->_redirect('/webdesk/tickets/canceled');
    }

    public function myticketsAction() {
        // action body
    }

}

