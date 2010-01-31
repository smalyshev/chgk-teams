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
	
	/**
	 * Admin menu
	 */
    public function indexAction()
    {
        $this->view->teams = Bootstrap::get('model')->countPendingTeams();
    }

    /**
     * List of pending teams
     */
    public function pendingAction()
    {
        $this->view->teams = Bootstrap::get('model')->getPendingTeams();
    }
    
    /**
     * List of registered teams
     */
    public function teamAction()
    {
        $this->view->teams = Bootstrap::get('model')->getTeams();
    }
    
    /**
     * Edit/confirm pending team
     */
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
			 		 $result = $model->saveTeamData($values);
			 		 if($result === true) {
			 		 	$model->confirmTeam($id);
			 		 	$config = Bootstrap::get('config');
			 		 	// send confirmation mail
			 		 	$mail = new Reg2_Mail('confirmed');
			 		 	$team = $model->findTeam($id);
			 		 	$mail->getMailer()
			        		->addTo($team->list)
	    		    		->setSubject('ICHB-2010 - Confirmed');
			 		 	if(!empty($team->second_email)) {
			 		 		$mail->getMailer()->addCC($team->second_email);
			 		 	}
			 		 	$mail->getView()->team = $team;
			 		 	$mail->getView()->kadavr = $config['mail']['kadavr'];
	    		    	$mail->send();
	    		    	// send kap's pwd mail
	    		    	$mail = new Reg2_Mail('cappwd');
	    		    	$kap = $model->findPlayer($team->kap);
	    		    	$mail->getMailer()
			        		->addTo($kap->email)
			        		->setSubject('ICHB-2010 - Captain\'s Access');
			        	$mail->getView()->pwd = $model->createUserPassword($kap->email, $team->tid);
			 		 	$mail->getView()->kadavr = $config['mail']['kadavr'];
			        	return $this->_helper->redirector('pending');
			 		 } else {
			 		 	$this->view->error = $result;
			 		 }
			 	}
			 }
        } else {
			$form->populate($model->getTeamData($id));
        }
        $this->view->data_errors = $model->checkTeamData($form->getValues()); 
    }
    
}

