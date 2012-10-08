<?php

/**
 * 28/09/2012
 * @file           CheckAuth.php
 * @author         Fabio Pratta <fabiobrotas@hotmail.com>
 * @license        default 
 * @copyright      Copyright - SIGP | 28/09/2012
 * @version        Release: 1.0
 */
class Sigp_Plugins_CheckAuth extends Zend_Controller_Plugin_Abstract{
    
    
     public function preDispatch(Zend_Controller_Request_Abstract $request) {
        /* Verifica se o usuário não está logado */
        if (!Zend_Auth::getInstance()->hasIdentity()){
            $request->setModuleName('authenticate');
            $request->setControllerName('login');
            $request->setActionName('index');
        }
    }
    
}

