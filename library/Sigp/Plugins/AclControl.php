<?php

/**
 * @author Fabio Pratta <fabiobrotas@hotmail.com> 
 * @copyright Copyright (c) 2012 - 2018 Grupo Peraltas LTDA. (http://www.grupoperaltas.com.br)
 * @version 1.0 
 */
class Sigp_Plugins_AclControl extends Zend_Controller_Plugin_Abstract {

    const CONTROLLER_NO_AUTH = 'login';

    private $_controller;
    private $_module;
    private $_action;
    private $_role;

    /**
     * preDispatch
     * 
     * @param Zend_Controller_Request_Abstract $request
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request) {

        $this->_controller = $this->getRequest()->getControllerName();
        $this->_module = $this->getRequest()->getModuleName();
        $this->_action = $this->getRequest()->getActionName();

        $auth = Zend_Auth::getInstance();

        $redirect = true;

        if ($this->_controller != self::CONTROLLER_NO_AUTH) {
            if ($this->_isAuth($auth)) {

                $user = $auth->getStorage()->read();
                $this->_role = $user->id_role;

                $acl = new Application_Model_Acl($this->_role);

                if ($this->_isAllowed($auth, $acl)) {
                    $redirect = false;
                }
            }
        } else {
            $redirect = false;
        }

        if ($redirect) {
            $request->setModuleName('default');
            $request->setControllerName('login');
            $request->setActionName('index');
            if($auth->hasIdentity()){
                $request->setParam("semacesso", "semacesso");
            }
        }
    }

    /**
     * Check user identity using Zend_Auth
     * 
     * @param Zend_Auth $auth
     * @return boolean
     */
    private function _isAuth(Zend_Auth $auth) {
        if (!empty($auth) && ($auth instanceof Zend_Auth)) {
            return $auth->hasIdentity();
        }
        return false;
    }

    /**
     * Check permission using Zend_Auth and Zend_Acl
     * 
     * @param Zend_Auth $auth
     * @param Zend_Acl $acl
     * @return boolean
     */
    private function _isAllowed(Zend_Auth $auth, Zend_Acl $acl) {

        if (empty($auth) || empty($acl) ||
                !($auth instanceof Zend_Auth) ||
                !($acl instanceof Zend_Acl)) {
            return false;
        }

        $resources = array(
            '*/*/*',
            $this->_module . '/*/*',
            $this->_module . '/' . $this->_controller . '/*',
            $this->_module . '/' . $this->_controller . '/' . $this->_action
        );

        $result = false;

        foreach ($resources as $res) {
            if ($acl->has($res)) {
                $result = $acl->isAllowed($this->_role, $res);
            }
        }
        return $result;
    }

}

