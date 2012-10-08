<?php

class Webdesk_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->_redirect('/webdesk/tickets/unfinished');
    }


}

