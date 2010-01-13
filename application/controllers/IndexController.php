<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    	$urlHelper = $this->_helper->getHelper('url');
		$this->view->form = $form = $this->_helper->getForm('register');
		$form->setAction($urlHelper->url(array(
            'controller' => 'index' , 
            'action' => 'register'
            ))
            );
    }
    
    public function registerAction()
    {
    	$request = $this->getRequest();

        if (!$request->isPost()) {
            return $this->_helper->redirector('index');
        }
        $form = $this->_helper->getForm('register');
        if(!$form->isValid($request->getPost())) {
        	return $this->_forward('index');
        }
        $values = $form->getValues();
        $result = Bootstrap::get('model')->addTeamData($values);
        if($result === true) {
        	// success
        	$mail = new Reg2_Mail('newreg');
        	$mail->getView()->data = $values;
        	$config = Bootstrap::get('config');
        	$mail->getMailer()
        		->addTo($config['mail']['register'])
        		->setSubject('ICHB-2010 - New Registration');
        	$mail->send();
        } else {
        	$this->view->error = $result;	
        }
    }
}

