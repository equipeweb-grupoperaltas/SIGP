<?php

/**
 * @author Fabio Pratta <fabiobrotas@hotmail.com> 
 * @copyright Copyright (c) 2012 - 2018 Grupo Peraltas LTDA. (http://www.grupoperaltas.com.br)
 * @version 1.0 
 */
class Sigp_Form_loginUsers extends Sigp_Form_modelFormTable {

    public function init() {

        $this->setName("frmUsuario");

        //$usuCodigo = new Zend_Form_Element_Hidden("usuCodigo");
        //$usuCodigo->addFilter(new Zend_Filter_Int());

        $usuLogin = new Zend_Form_Element_Text("usuLogin");
        $usuLogin->setLabel("Login")
                ->addFilter(new Zend_Filter_StringTrim())
                ->setRequired(true)
                ->setAttrib("size", "30")
                ->addValidator(new Zend_Validate_NotEmpty())
                ->addValidator(new Zend_Validate_StringLength(0, 100));

        $usuSenha = new Zend_Form_Element_Password("usuSenha");
        $usuSenha->setLabel("Senha")
                ->addFilter(new Zend_Filter_StringTrim())
                ->setRequired(true)
                ->setAttrib("size", "30")
                ->addValidator(new Zend_Validate_StringLength(0, 255));

        /*
        $usuConfirmacaoSenha = new Zend_Form_Element_Password("usuConfirmacaoSenha");
        $usuConfirmacaoSenha->setLabel("Confirmação da Senha")
                ->addFilter(new Zend_Filter_StringTrim())
                ->setAttrib("size", "50")
                //->setAttrib("readonly","readonly")
                
                ->addValidator(new Zend_Validate_StringLength(0, 255));

        $gruusuCodigo = new Zend_Form_Element_Select('gruusuCodigo');
        $gruusuCodigo->setLabel("Grupo")
                ->addFilter(new Zend_Filter_Int())
                ->setRequired(true);

        $grupoUsuarios = new Grupousuarios();
        foreach ($grupoUsuarios->getGruposUsuarios() as $grpusu) {
            $gruusuCodigo->addMultiOption($grpusu->gruusuCodigo, $grpusu->gruusuDescricao);
        }

        */
        $btnEntrar = new Zend_Form_Element_Submit("btnEntrar");
        $btnEntrar->setLabel("Entrar");

        //$btnVoltar = new Zend_Form_Element_Submit("btnVoltar");
        //$btnVoltar->setLabel("Voltar");

        $this->addElements(array($usuLogin, $usuSenha ,$btnEntrar));

        $this->addDisplayGroup(array("btnEntrar"), "botoes");

        parent::init();
    }

}

