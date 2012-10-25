<?php

/**
 * 25/10/2012
 * @file           ParceirosController.php
 * @author         Fabio Pratta <fabiobrotas@hotmail.com>
 * @license        default 
 * @copyright      Copyright - SIGP | 25/10/2012
 * @version        Release: 1.0
 */
class Webdesk_ParceirosController extends Zend_Controller_Action {

    /**
     * Insert Action
     */
    public function indexAction() {
        $form = new Sigp_Form_cadParceiro();
        if ($this->_request->isPost()) {
            $data = $this->_request->getParams();
            if ($form->isValid($data)) {
                $insert = $form->getValues();
                try {
                    $parceiro = new Application_Model_DbTable_Parceiros();
                    $parceiro->insert($insert);
                    $this->_redirect("/webdesk/parceiros/list");
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
        $parceiros = new Application_Model_Parceiros();
        $parceiros = $parceiros->fetchAll();
        $this->view->assign('paginator', $parceiros);
    }

    /**
     * Delete Action
     */
    public function deleteAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $id = $this->_request->getParam("id");

        try {
            $db = new Application_Model_DbTable_Parceiros();
            $where = $db->getDefaultAdapter()->quoteInto("id = ?", $id);
            $db->delete($where);
            $this->_redirect("/webdesk/parceiros/list");
        } catch (Zend_Exception $e) {
            echo "<div class='error'>Ocorreu um erro ao deletar:<br/> " . $e->getMessage() . " </div> ";
        }
    }

    /**
     * Edit Action
     */
    public function editAction() {
        $id = $this->_request->getParam("id");
        $form = new Sigp_Form_altParceiro();
        $tabela = new Application_Model_DbTable_Parceiros();
        $select = $tabela->find($id)->toArray();
        $form->populate($select[0]);
        if ($this->_request->isPost()) {
            $data = $this->_request->getParams();
            if ($form->isValid($data)) {
                $update = $form->getValues();
                try {
                   $tabela->update($update, "id = ".$id);
                   $this->_redirect("/webdesk/parceiros/list");
                } catch (Zend_Exception $e) {
                     echo "<div class='error'>Ocorreu um erro ao editar:<br/> " . $e->getMessage() . " </div> ";
                }
            }
        }
        $this->view->formulario = $form;
    }
    
    
}

