<?php

/**
 * 24/09/2012
 * @file           Auth.php
 * @author         Fabio Pratta <fabiobrotas@hotmail.com>
 * @license        default 
 * @copyright      Copyright - SIGPNEW | 24/09/2012
 * @version        Release: 1.0
 */
class Application_Model_Auth {

    /**
     *
     * @var type 
     */
    public static $instance;
    private $_username = null;
    private $_password = null;

    /**
     *
     * @param type $username
     * @param type $password 
     */
    public function __construct($username, $password) {
        self::$instance = false;
        $this->_password = $password;
        $this->_username = $username;
    }

    /**
     * Auth User BD 
     * @return boolean 
     */
    public function authDb() {
        $dbAdapter = Zend_Db_Table::getDefaultAdapter();
        //Inicia o adaptador Zend_Auth para banco de dados
        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
        $authAdapter->setTableName('usuarios')
                ->setIdentityColumn('usuario')
                ->setCredentialColumn('senha')
                ->setCredentialTreatment('SHA1(?)');

        //Define os dados para processar o login
        $authAdapter->setIdentity($this->_username)
                ->setCredential($this->_password);

        //Efetua o login
        $auth = Zend_Auth::getInstance();
        $result = $auth->authenticate($authAdapter);

        //Verifica se o login foi efetuado com sucesso
        if ($result->isValid()) {
            //Recupera o objeto do usuário, sem a senha
            $info = $authAdapter->getResultRowObject(null, 'senha');
            $storage = $auth->getStorage();
            $storage->write($info);
            self::$instance == true;
            return true;
        }
        
        
    }

    /**
     * Auth User of Active Directory Domain
     * @return boolean 
     */
    public function authAd() {

        $config = new Zend_Config_Ini('../application/configs/application.ini', 'production');
        $options = $config->ldap->toArray();
        $adapter = new Zend_Auth_Adapter_Ldap($options, $this->_username, $this->_password);
        //Instance Auth
        $auth = Zend_Auth::getInstance();
        //Result Autethicate
        $result = $auth->authenticate($adapter);
        //Verifica se o login foi efetuado com sucesso
        if ($result->isValid()) {
            $array =  $adapter->getAccountObject();    
            $storage = $auth->getStorage();
            $storage->write($array);
            self::$instance == true;
            return true;
        }
    }

}

