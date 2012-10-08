<?php

/**
 * 28/09/2012
 * @file           getActionName.php
 * @author         Fabio Pratta <fabiobrotas@hotmail.com>
 * @license        default 
 * @copyright      Copyright - SIGP | 28/09/2012
 * @version        Release: 1.0
 */
class Sigp_View_Helper_getActionName extends Zend_View_Helper_Abstract {
    
    public function getActionName(){    
      return Zend_Controller_Front::getInstance()->getRequest()->getActionName();
    }
    
}

