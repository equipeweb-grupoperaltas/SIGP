<?php

/**
 * 03/10/2012
 * @file           getDate.php
 * @author         Fabio Pratta <fabiobrotas@hotmail.com>
 * @license        default 
 * @copyright      Copyright - SIGP | 03/10/2012
 * @version        Release: 1.0
 */
class Sigp_View_Helper_FormatDate extends Zend_View_Helper_Abstract {

    /**
     * Manipulador de Datas
     * @var Zend_Date
     */
    protected static $_date = null;

    /**
     * Método Principal
     * @param string $value Valor para Formatação
     * @param string $format Formato de Saída
     * @return string Valor Formatado
     */
    public function FormatDate($value, $format = Zend_Date::DATETIME_MEDIUM) {
        $date = $this->getDate();
        return $date->set($value)->get($format);
    }

    /**
     * Acesso ao Manipulador de Datas
     * @return Zend_Date
     */
    public function getDate() {
        if (self::$_date == null) {
            self::$_date = new Zend_Date();
        }
        return self::$_date;
    }

}

