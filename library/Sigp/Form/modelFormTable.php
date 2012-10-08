<?php

/**
 * @author Fabio Pratta <fabiobrotas@hotmail.com> 
 * @copyright Copyright (c) 2012 - 2018 Grupo Peraltas LTDA. (http://www.grupoperaltas.com.br)
 * @version 1.0 
 */
class Sigp_Form_modelFormTable extends Zend_Form {
    
        //atributo utilizado para setar o label no class da propria td
	private $_classeLabel;
	
	public function init(){

		foreach ($this->getElements() as $elemento) {

			//verifica se o objeto não é um botão
			if((!$elemento instanceof  Zend_Form_Element_Submit) && (!$elemento instanceof  Zend_Form_Element_File)){

				$elemento->setDecorators(array(
                   'ViewHelper',
                   'Description',
				//'Errors',
				array(array('data'=>'HtmlTag'), array('tag' => 'td')),
				array('Label', array('tag' => 'td','class' => $this->_classeLabel)),
				array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
				));

				
				//remove a tag erros de cada objeto de formulário
				$elemento->removeDecorator("Errors");
			}else{
				if($elemento instanceof  Zend_Form_Element_Submit){
					//remove o dt e o dd
					$elemento->removeDecorator("DtDdWrapper");
				}else if($elemento instanceof  Zend_Form_Element_File){
					$elemento->setDecorators(array(
			'File',
					'Description',
					array(array('data'=>'HtmlTag'), array('tag' => 'td')),
					array('Label', array('tag' => 'td')),
					array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
					));
				}
			}
		}


		$this->setDisplayGroupDecorators(array('FormElements',
		//'Fieldset',
		//'FormErrors',
		array(array('data'=>'HtmlTag'), array('tag' => 'td', 'align' => 'center', 'colspan' => '2')),
		array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
		));

		$this->setDecorators(array(

		'FormErrors' ,

		'FormElements',

		array(array('data'=>'HtmlTag'),array('tag'=>'table', 'width'=>'100%', 'cellspacing' => '2', 'cellpadding'=>'2')),

		'Form',
		));


	}
	
	public function setClasseLabel($classe){
		$this->_classeLabel = $classe;
	}
 
        //retorna o valor trando erros do form.
	public function getValue($name){
		$valor = parent::getValue($name);
		$novoValor = $this->retiraErrosForm($valor);
		$this->getElement($name)->setValue($novoValor);
		return $novoValor;
	}


	public function setDefault($name, $value){
		$novoValor = $this->retiraErrosForm($value);
		return parent::setDefault($name, $novoValor);
	}
        
        //retira erros de barras do formulário
	private function retiraErrosForm($valor){
		//substitui o \' que o form adiciona automáticamente por '
		$novoValor = str_replace("\\'", "'", $valor);
		//substitui o \" que o form adiciona automáticamente por "
		$novoValor = str_replace('\\"', '"', $novoValor);
		//substitui o \\ que o form adiciona automáticamente por \
		$novoValor = str_replace("\\\\", "\\", $novoValor);
		return $novoValor;
	}
        
}

