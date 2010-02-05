<?php

class MembersController extends Zend_Controller_Action
{
    
    protected $_role = null;
    
    protected $_isAdmin = false;

    public function preDispatch()
    {
        $acl = Zend_Registry::get('acl');
        $this->_role = Zend_Registry::get('role');
        if (! $acl->isAllowed(Zend_Registry::get('role'), 'members', $this->getRequest()->action)) {
            if (! Zend_Auth::getInstance()->hasIdentity()) {
                $this->_forward('noauth', 'error');
            } else {
                $this->_forward('noacl', 'error');
            }
        }
        $this->_isAdmin = ($this->_role == 'admin');
    }

    /**
     * Admin menu
     * 
     */
    public function postDispatch()
    {
        if ($this->_isAdmin) {
            $this->view->placeholder('nav')->set(
                $this->view->render("admin/nav.phtml"));
        }
    }

    /**
     * Check if captain belongs to the team which is being edited 
     * 
     */
    protected function _checkKap($tid)
    {
        if ($this->_role == 'kap') {
            $kap_tid = Zend_Auth::getInstance()->getIdentity()->tid;
            if ($kap_tid != $uid) {
                $this->_forward('noacl', 'error');
            }
        }
    }

    public function indexAction()
    {
        $this->view->teams = Reg2_Model_Data::getModel()->getTeams();
        $this->view->turnir = Reg2_Model_Data::TURNIR;
    }

    public function turnirAction()
    {
        $id = (int) $this->_getParam('id', Reg2_Model_Data::TURNIR);
        $model = Reg2_Model_Data::getModel();
        $this->view->teams = $model->getTeamsWithData($id);
        $this->view->turnir = $model->findTurnir($id);
    }

    public function teamAction()
    {
        if (! $id = (int) $this->_getParam('id', false)) {
            return $this->_helper->redirector('index');
        }
        $model = Reg2_Model_Data::getModel();
        $this->view->team = $model->getTeamData($id);
        if ($this->view->team["turnir"] <= 0) {
            // not a registered team
            return $this->_helper->redirector('index');
        }
        $this->view->turnir = $model->findTurnir($this->view->team["turnir"]);
        if (! empty($this->view->team["oldid"])) {
            $this->view->turs = $model->getTurs($this->view->team["oldid"]);
        }
        $this->view->maxplayers = $model->getMaxPlayers();
    }

    public function teameditAction()
    {
        if (! $id = (int) $this->_getParam('id', false)) {
            return $this->_helper->redirector('index');
        }
        $this->_checkKap($id);
        
        $this->view->form = $form = $this->_helper->getForm('teamedit', 
            array("tid" => $id, "admin" => $this->_isAdmin));
        $model = Bootstrap::get('model');
        $this->view->maxplayers = $model->getMaxPlayers();
        $this->view->tid = $id;
        $request = $this->getRequest();
        $this->view->isadmin = $this->_isAdmin;
        
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $values = $form->getValues();
                if ($form->save->isChecked()) {
                    $result = $model->saveTeamData($values, $this->_isAdmin);
                    $form->reset();
                    $form->populate($model->getTeamData($id));
                    $this->view->error = $result;
                } elseif ($this->_isAdmin && $form->delete->isChecked()) {
                    $model->deleteTeam($id);
                    return $this->_helper->redirector('index', 'admin');
                }
            }
        } else {
            $form->populate($model->getTeamData($id));
        }
        if ($this->_isAdmin)
            $this->view->data_errors = $model->checkTeamData($form->getValues());
    }

    public function playerAction()
    {
        if (! $id = (int) $this->_getParam('id', false)) {
            return $this->_helper->redirector('index');
        }
        
        $model = Reg2_Model_Data::getModel();
        $this->view->player = $model->findPlayer($id);
        if(empty($this->view->player->foto)) {
            $this->view->player->foto = "Nofoto.jpg";
            $this->view->fotoalt = "Нет фотографии";
        } else {
            $this->view->fotoalt = $this->player->famil." ".$this->player->imia;
        }
        $this->view->turs = $model->findPlayerTeams($id);
        $this->view->turnir = Reg2_Model_Data::TURNIR;
    }

}



