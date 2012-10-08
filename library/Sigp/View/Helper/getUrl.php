<?php

/**
 * 28/09/2012
 * @file           getUrl.php
 * @author         Fabio Pratta <fabiobrotas@hotmail.com>
 * @license        default 
 * @copyright      Copyright - SIGP | 28/09/2012
 * @version        Release: 1.0
 */

class Sigp_View_Helper_getUrl extends Zend_View_Helper_Abstract {

    
    /**
     *
     * @param type $urlOptions
     * @param type $name
     * @param type $reset
     * @param type $encode
     * @return type 
     */
    public function getUrl($urlOptions, $name = null, $reset = false, $encode = true) {
        $front = Zend_Controller_Front::getInstance();
        $router = $front->getRouter();
        if (is_string($urlOptions)) {
            $urlOptions = '/' . ltrim($urlOptions, '/'); // Case the first character is a '?
            $request = new Zend_Controller_Request_Http(); // Creates a cleaned instance of request http
            $request->setBaseUrl($front->getBaseUrl());
            $request->setRequestUri($urlOptions);
            $route = $router->route($request); // Return the request route with params modifieds
            $urlOptions = $route->getParams();
        }
        return $router->assemble((array) $urlOptions, $name, $reset, $encode);
    }

}

