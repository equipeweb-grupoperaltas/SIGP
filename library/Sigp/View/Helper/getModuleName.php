<?php

/**
 * 28/09/2012
 * @file           getModuleName.php
 * @author         Fabio Pratta <fabiobrotas@hotmail.com>
 * @license        default 
 * @copyright      Copyright - SIGP | 28/09/2012
 * @version        Release: 1.0
 */
class Sigp_View_Helper_getModuleName extends Zend_View_Helper_Abstract {
    
    public function getModuleName(){    
      return Zend_Controller_Front::getInstance()->getRequest()->getModuleName();
    }
    
}

