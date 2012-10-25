<?php

/**
 * 16/10/2012
 * @file           DepartamentosController.php
 * @author         Fabio Pratta <fabiobrotas@hotmail.com>
 * @license        default 
 * @copyright      Copyright - SIGP | 16/10/2012
 * @version        Release: 1.0
 */
class Webdesk_DepartamentosController extends Zend_Controller_Action {

    
    /**
     * Insert Action
     */
    public function indexAction() {
        $form = new Sigp_Form_cadDepartamento();
        if ($this->_request->isPost()) {
            $data = $this->_request->getParams();
            if ($form->isValid($data)) {
                $insert = $form->getValues();
                try {
                    $departamento = new Application_Model_DbTable_Departamento();
                    $departamento->insert($insert);
                    $this->_redirect("/webdesk/departamentos/list");
                } catch (Zend_Exception $e) {
                    echo "<div class='error'>Ocorreu um erro ao inserir:<br/> " . $e->getMessage() . " </div> ";
                }
            }
        }
        $this->view->formulario = $form;
    }

    /**
     * List Action
     */
    public function listAction() {
        $departamentos = new Application_Model_DbTable_Departamento();
        $departamentos = $departamentos->fetchAll();
        $this->view->assign('paginator', $departamentos);
    }

    
    /**
     * Delete Action
     */
    public function deleteAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $id = $this->_request->getParam("id");
        try {
            $departamento = new Application_Model_DbTable_Departamento();
            $where = $departamento->getAdapter()->quoteInto("id = ?", $id);
            $departamento->delete($where);
            $this->_redirect("/webdesk/departamentos/list");
        } catch (Zend_Exception $e) {
            Zend_Debug::dump($e->getMessage());
            echo "<div class='error'>Ocorreu um erro ao deletar: " . $e->getMessage() . " </div>";
        }
    }

}

