<?php

/**
 * @author Fabio Pratta <fabiobrotas@hotmail.com> 
 * @copyright Copyright (c) 2012 - 2018 Grupo Peraltas LTDA. (http://www.grupoperaltas.com.br)
 * @version 1.0 
 */


class Sigp_Plugins_Layout extends Zend_Controller_Plugin_Abstract {
    
    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request) {
        $layout = Zend_Layout::startMvc();
        $layout->setLayout("layout")
               ->setLayoutPath( APPLICATION_PATH .'/modules/layouts/' );
        
    }
    
}

