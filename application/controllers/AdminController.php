<?php

class AdminController extends Zend_Controller_Action
{

	public function preDispatch()
	{
		$acl = Zend_Registry::get('acl');

		if (!$acl->isAllowed(Zend_Registry::get('role'), 'admin', $this->getRequest()->action)) {
			if (!Zend_Auth::getInstance()->hasIdentity()) {
			    $this->_forward('noauth', 'error');
			} else {
			    $this->_forward('noacl', 'error');
			}
		}
	}
	
	public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->view->teams = Bootstrap::get('model')->countPendingTeams();
    }

    public function pendingAction()
    {
        $this->view->teams = Bootstrap::get('model')->getPendingTeams();
    }
    
    public function teamAction()
    {
    	if (! $id = (int) $this->_getParam('id', false)) {
            return $this->_helper->redirector('index');
        }
        
        $this->view->form = $form = $this->_helper->getForm('teamedit', array("tid" => $id));
        $model = Bootstrap::get('model');
		$this->view->maxplayers = $model->getMaxPlayers();
		$this->view->tid = $id;
		$request = $this->getRequest();
		
		if ($request->isPost()) {
			 if($form->isValid($request->getPost())) {
			 	$values = $form->getValues();
			 	if($form->save->isChecked()) {
		        	$result = $model->saveTeamData($values);
		        	$form->reset();
		        	$form->populate($model->getTeamData($id));
		        	$this->view->error = $result;	
			 	} elseif($form->confirm->isChecked()) {
			 		 // confirm data
			 	}
			 }
        } else {
			$form->populate($model->getTeamData($id));
        }
        $this->view->data_errors = $model->checkTeamData($form->getValues()); 
    }
    
}

