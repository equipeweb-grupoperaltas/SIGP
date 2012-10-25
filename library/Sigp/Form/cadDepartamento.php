<?php

/**
 * 16/10/2012
 * @file           cadDepartamento.php
 * @author         Fabio Pratta <fabiobrotas@hotmail.com>
 * @license        default 
 * @copyright      Copyright - SIGP | 16/10/2012
 * @version        Release: 1.0
 */
class Sigp_Form_cadDepartamento extends Zend_Form {

    public function init() {
        
        $this->setName("frmCadTicket");
        
        //Departamento
        $departamento = new Zend_Form_Element_Text("departamento");
        $departamento->setLabel("Departamento (Obrigatório):")->setRequired(true);
        
        
        //Add Button
        $btnAdd = new Zend_Form_Element_Submit("btnAdd");
        $btnAdd->setLabel("Adicionar")->setAttrib("class", "blue");


        $this->addElements(array($departamento, $btnAdd));
        parent::init();
    }

}

