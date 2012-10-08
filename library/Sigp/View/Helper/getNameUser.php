<?php

/**
 * 03/10/2012
 * @file           getNameUser.php
 * @author         Fabio Pratta <fabiobrotas@hotmail.com>
 * @license        default 
 * @copyright      Copyright - SIGP | 03/10/2012
 * @version        Release: 1.0
 */
class Sigp_View_Helper_getNameUser extends Zend_View_Helper_Abstract {

    /**
     *
     * @var type 
     */
    private static $_usuario = null;
    private static $_username = null;

    public function getNameUser($usuario) {
        $userData = new Application_Model_UsuariosAd();
        $userData = $userData->getUser($usuario);
        return $userData;
    }

}

