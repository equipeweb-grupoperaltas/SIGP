<?php

class Authenticate_LoginController extends Zend_Controller_Action {

    
    /**
     *
     * @var type 
     */
    private $module;
    private $controller;
    private $action;
    

    public function init() {
        $this->_options = $this->getInvokeArg('bootstrap')->getOptions();
    }
    
    
    
    public function indexAction() {
        //Init FlashMessenger 
        $this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
        $this->view->messages = $this->_flashMessenger->getMessages();

        //Pass this form for View
        $form = new Sigp_Form_loginUsers();
        $this->view->formulario = $form;
        
        
        
        $request = $this->getRequest()->getParams();
        
        $this->module = $request['module'];
        $this->controller = $request['controller'];
        $this->action = $request['action'];

        
       
        
        
        //If send data Post
        if ($this->getRequest()->isPost()) {

            //return this data post em var
            $data = $this->getRequest()->getPost();

            //if this form is valid
            if ($form->isValid($data)) {
                //get username and password data form
                $usuario = $form->getValue('usuLogin');
                $senha = $form->getValue('usuSenha');
                //instance
                $authAd = new Application_Model_Auth($usuario, $senha);
                //Autenthicate in Domain
                $authAd = $authAd->authAd();
                
               
                 
                //check instance
                if (!$authAd) {
                    $this->_helper->FlashMessenger("Usuario ou senha Invalidos!");
                    $this->_helper->redirector('index');
                    
                  
                    
                } else {
                    
                    if ($this->module == "authenticate") {

                          $request = $this->getRequest();
                          $request->setModuleName('default');
                          $request->setControllerName('index');
                          $request->setActionName('index');
       
                    } else {
                        
                          $request = $this->getRequest();
                          $request->setModuleName($this->module);
                          $request->setControllerName($this->controller);
                          $request->setActionName($this->action);
                        
                    }
                }
            } else {
                //Formulário preenchido de forma incorreta
                $form->populate($data);
            }
        }
    }

    public function logoutAction() {
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        return $this->_helper->redirector('index');
    }

}

