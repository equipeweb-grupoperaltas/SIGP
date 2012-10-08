<?php

/**
 * 01/10/2012
 * @file           cadTicket.php
 * @author         Fabio Pratta <fabiobrotas@hotmail.com>
 * @license        default 
 * @copyright      Copyright - SIGP | 01/10/2012
 * @version        Release: 1.0
 */
class Sigp_Form_cadTicket extends Zend_Form {

    public function init() {

        $this->setName("frmCadTicket");

        /**
         * Departaments 
         */
        $departamento = new Zend_Form_Element_Select('departamento');
        $departamento->setLabel("Departamento (Obrigatório):")->setRequired(true);
        //Model       
        $departamentos = new Application_Model_DepartamentosAd();
        $departamento->addMultiOptions($departamentos->getDepartaments());


        /**
         * Users of Departaments 
         */
        $usuario = new Zend_Form_Element_Multiselect("usuario");
        $usuario->setLabel("Usuario(s): ")->setRegisterInArrayValidator(false);
        $usuario->addMultiOption("", "Selecione o departamento");

        /**
         * Priority 
         */
        $prioridade = new Zend_Form_Element_Select("prioridade");
        $prioridade->setLabel("Prioridade:")->setRequired(true);

        $arrayP = array("" => "Selecione a prioridade", "0" => "Urgente", "1" => "Normal", "2" => "Baixa");
        $prioridade->addMultiOptions($arrayP);

        /**
         * Date expire 
         */
        $datalimite = new Zend_Form_Element_Text("datalimite");
        $datalimite->setLabel("Data Limite:");


        /*
         * Duplicar Eventos
         */
        
        $duplicar = new Zend_Form_Element_Radio("duplicar");
        $duplicar->setLabel("Duplicar Evento:");
        $duplicar->addMultiOptions(
                array("d" => "Diaramente",
                    "s" => "Semanalmente",
                    "m" => 'Mensalmente',
                    "a" => "Anualmente")
        )->setSeparator("");


        /**
         * Title 
         */
        $assunto = new Zend_Form_Element_Text("assunto");
        $assunto->setLabel("Assunto:")->setRequired(true)
                ->addFilter(new Zend_Filter_StripTags())
                ->addFilter(new Zend_Filter_StringTrim())
                ->addValidator(new Zend_Validate_NotEmpty())
                ->addValidator(new Zend_Validate_StringLength(0, 70));

        /**
         * Description
         */
        $descricao = new Zend_Form_Element_Textarea("descricao");
        $descricao->setLabel("Descrição:")->setRequired(true)
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
                ->addValidator('ExcludeExtension', false, array('php', 'exe', 'js', 'html'))
                ->setDestination("Uploads/Webdesk/");

        $btnAdd = new Zend_Form_Element_Submit("btnAdd");
        $btnAdd->setLabel("Adicionar")->setAttrib("class", "blue");


        $this->addElements(array($departamento, $usuario, $prioridade, $datalimite, $duplicar, $assunto, $descricao, $arquivo, $btnAdd));
        parent::init();
    }

}

