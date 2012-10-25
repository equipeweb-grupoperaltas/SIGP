<?php

class Webdesk_FunctionsController extends Zend_Controller_Action {

    public function init() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function indexAction() {
        
    }

    /**
     * get Users os departments 
     */
    public function getusersjsonAction() {
        $usuarios = new Application_Model_UsuariosAd();
        $ou = $this->_request->getParam("id");
        echo Zend_Json::encode($usuarios->getUsersOfDepartment($ou));
    }

    /**
     * get Users of Departaments in Databases
     */
    public function getusersdbjsonAction() {
        $usuarios = new Application_Model_UsuariosDb();
        $idDepartamento = $this->_request->getParam("id");
        echo Zend_Json::encode($usuarios->getUsersDepartament($idDepartamento));
    }

}

