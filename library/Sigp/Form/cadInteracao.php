<?php

/**
 * 03/10/2012
 * @file           cadInteracao.php
 * @author         Fabio Pratta <fabiobrotas@hotmail.com>
 * @license        default 
 * @copyright      Copyright - SIGP | 03/10/2012
 * @version        Release: 1.0
 */
class Sigp_Form_cadInteracao extends Zend_Form {

    public function init() {
        
        $this->setName("frmCadInteracao");

        
        /**
         * Description
         */
        $descricao = new Zend_Form_Element_Textarea("descricao");
        $descricao->setLabel("Nova resposta:")->setRequired(true)
                ->addFilter(new Zend_Filter_StripTags())
                ->addFilter(new Zend_Filter_StringTrim())
                ->addValidator(new Zend_Validate_NotEmpty())
                ->addValidator(new Zend_Validate_StringLength(0, 100));

        /**
         * File 
         */
        $arquivo = new Zend_Form_Element_File("anexo");
        $arquivo->setLabel("Anexo (Tamanho máximo 20mb):");
        $arquivo->addValidator('Count', false, 1)
                ->addValidator('Size', false, 2097152) //20MB = 20.971,520 bytes
                ->setMaxFileSize(2097152)
                ->addValidator('ExcludeExtension', false, array('php', 'exe','js','html'))
                ->setDestination("Uploads/Webdesk/");

        
        $btnAdd = new Zend_Form_Element_Submit("btnAdd");
        $btnAdd->setLabel("Salvar")->setAttrib("class", "blue");
        
      
        $this->addElements(array($descricao, $arquivo, $btnAdd));
        parent::init();
    }

}

