<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {
    #AutoLoader

    protected function _initAutoloader() {
        $autoloader = Zend_Loader_Autoloader::getInstance()->setFallbackAutoloader(true);
        $autoloader->registerNamespace("Sigp");
        $autoloader->registerNamespace("ZendX");
        return $autoloader;
    }

    #Plugins

    protected function _initPlugins() {
        $bootstrap = $this->getApplication();
        if ($bootstrap instanceof Zend_Application) {
            $bootstrap = $this;
        }
        
        $bootstrap->bootstrap('FrontController');
        $front = $bootstrap->getResource('FrontController');
        
        //get Plugin Layout
        $plugin = new Sigp_Plugins_Layout();
        $front->registerPlugin($plugin);
        
        //get Plugin Auth
        $checkAuth = new Sigp_Plugins_CheckAuth();
        $front->registerPlugin($checkAuth);
    
    }

    #Databases
    protected function _initConnection() {
        $config = new Zend_Config_Ini('../application/configs/application.ini', APPLICATION_ENV);
        try {
            $db = Zend_Db::factory($config->resources->db->bd);
            // Registra o banco de dados
            $registry = Zend_Registry::getInstance();
            $registry->set('db', $db);

            Zend_Db_Table::setDefaultAdapter($db);
        } catch (Zend_Db_Exception $e) {
            echo "Não foi possível realizar a conexão com o banco de dados.";
            exit;
        }
    }

    #view

    protected function _initViews() {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->addHelperPath("Sigp/View/Helper/", "Sigp_View_Helper");
        $view->addHelperPath("ZendX/JQuery/View/Helper", "ZendX_JQuery_View_Helper");
        $view->doctype('XHTML1_STRICT');
        $view->headTitle('Grupo Peraltas - SIGP')->setSeparator("|");
        $view->headMeta()->appendHttpEquiv("Content-type", "text/html; charset=UTF-8");
        Zend_Registry::set("view", $view);
        return $view;
    }

    
    #Zend DEbug

    protected function _initZFDebug() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');

        $config = new Zend_Config_Ini('../application/configs/application.ini', APPLICATION_ENV);
        $ZFDebugConfig = $config->zfdebug;

        if ($ZFDebugConfig->enabled) {
            $options = array('plugins' => array('Variables'
                    , 'Database' => array('adapter' => array('standard' => $db))
                    , 'File' => array('basePath' => '/'), 'Memory'
                    , 'Time'
                    , 'Registry'
                    , 'Exception'));

            $debug = new ZFDebug_Controller_Plugin_Debug($options);
            $this->bootstrap('frontController');
            $frontController = $this->getResource('frontController');
            $frontController->registerPlugin($debug);
        }
    }

}

