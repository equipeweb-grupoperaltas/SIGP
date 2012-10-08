<?php

/**
 * 28/09/2012
 * @file           getControllerName.php
 * @author         Fabio Pratta <fabiobrotas@hotmail.com>
 * @license        default 
 * @copyright      Copyright - SIGP | 28/09/2012
 * @version        Release: 1.0
 */
class Sigp_View_Helper_getControllerName extends Zend_View_Helper_Abstract {
    
    public function getControllerName(){    
      return Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
    }
    
}