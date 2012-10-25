<?php

/**
 * 25/10/2012
 * @file           cadParceiro.php
 * @author         Fabio Pratta <fabiobrotas@hotmail.com>
 * @license        default 
 * @copyright      Copyright - SIGP | 25/10/2012
 * @version        Release: 1.0
 */
class Sigp_Form_altParceiro extends Zend_Form {

    public function init() {

        $this->setName("frmCadTicket");

        //Departamento
        $departamento = new Zend_Form_Element_Select('id_departamento');
        $departamento->setLabel("Departamento (Obrigatório):")->setRequired(true);

        $departamentosDb = new Application_Model_DepartamentosDb();
        $departamento->addMultiOptions($departamentosDb->fetchPairs());

        
        //Parceiro
        $nome = new Zend_Form_Element_Text("nome");
        $nome->setLabel("Nome: (Obrigatório):")->setRequired(true);
        
        $email = new Zend_Form_Element_Text("email");
        $email->setLabel("Email:")
              ->addValidator(new Zend_Validate_EmailAddress());
        
        $telefone = new Zend_Form_Element_Text("telefone");
        $telefone->setLabel("Telefone")->setRequired(false);



        //Add Button
        $btnAdd = new Zend_Form_Element_Submit("btnAdd");
        $btnAdd->setLabel("Alterar")->setAttrib("class", "blue");


        $this->addElements(array($departamento,$nome,$email,$telefone, $btnAdd));
        parent::init();
    }

}

