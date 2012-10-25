<?php

/**
 * 25/10/2012
 * @file           Parceiros.php
 * @author         Fabio Pratta <fabiobrotas@hotmail.com>
 * @license        default 
 * @copyright      Copyright - SIGP | 25/10/2012
 * @version        Release: 1.0
 */
class Application_Model_Parceiros {

    public function fetchAll() {
        $tabela = new Application_Model_DbTable_Parceiros();
        $select = $tabela->select()
                ->setIntegrityCheck(false)
                ->from("parceiros",array('id as idp','*'))
                ->joinInner("departamentos", "parceiros.id_departamento = departamentos.id");
        return $tabela->fetchAll($select);
    }

}

