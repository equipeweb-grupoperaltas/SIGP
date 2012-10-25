<?php

/**
 * 25/10/2012
 * @file           UsuariosDb.php
 * @author         Fabio Pratta <fabiobrotas@hotmail.com>
 * @license        default 
 * @copyright      Copyright - SIGP | 25/10/2012
 * @version        Release: 1.0
 */
class Application_Model_UsuariosDb {

    /**
     * get Users of departament
     * @param type $departamento
     */
    public function getUsersDepartament($departamento) {
        $tabela = new Application_Model_DbTable_Parceiros();
        $select = $tabela->select()
                ->from("parceiros",array("optionValue"=>"id","optionDisplay"=>"nome"))
                ->where("id_departamento = ?", $departamento);
        return $tabela->fetchAll($select);
    }

}

