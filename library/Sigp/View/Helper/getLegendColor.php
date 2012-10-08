<?php

/**
 * 08/10/2012
 * @file           getLegendColor.php
 * @author         Fabio Pratta <fabiobrotas@hotmail.com>
 * @license        default 
 * @copyright      Copyright - SIGP | 08/10/2012
 * @version        Release: 1.0
 */
class Sigp_View_Helper_getLegendColor extends Zend_View_Helper_Abstract {

    /**
     *
     * @var type 
     */
    private $class = null;

    /**
     * return class os CSS
     * @param type $prioridade
     * @param type $datalimite
     * @return boolean
     */
    public function getLegendColor($prioridade, $datalimite) {

        if ($datalimite == "0000-00-00 00:00:00") {
            return false;
        } else {
            //Urgente + 2 dias
            if ($prioridade == "0" && $this->diferencaDias($datalimite) > 3) {
                $this->class = "urgm3";
            } else if ($prioridade == "0" && $this->diferencaDias($datalimite) <= 2) {
                $this->class = "urgm2";
            } else if ($prioridade == "1" && $this->diferencaDias($datalimite) > 3) {
                $this->class = "norm3";
            } else if ($prioridade == "1" && $this->diferencaDias($datalimite) <= 2) {
                $this->class = "norm2";
            } else if ($prioridade == "2" && $this->diferencaDias($datalimite) > 3) {
                $this->class = "baim3";
            } else if ($prioridade == "2" && $this->diferencaDias($datalimite) <= 2) {
                $this->class = "baim2";
            }
            return $this->class;
        }
    }

    /**
     * get Diff Date
     * @param type $final
     * @return type
     */
    function diferencaDias($final) {

        $dateNow = Zend_Date::now();
        $dateEnd = new Zend_Date($final);

        $diff = $dateEnd->sub($dateNow)->toValue();

        $days = ceil($diff / 60 / 60 / 24) + 1;

        return $days;
    }

}

