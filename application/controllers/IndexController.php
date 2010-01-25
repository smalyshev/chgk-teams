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
		$this->view->maxplayers = Bootstrap::get('model')->getMaxPlayers();
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
        	switch($values["kadres"]) {
        		case "kap":
        			$contact = sprintf("%s %s <%s>", $values["pname0"], $values["pfamil0"], $values["pemail0"]);
        			break;
        		case "reg":
        			$contact = $values["email"];
        			break;
        		case "list":
        			$contact = $values["tlist"];
        			break;
        		case "other":
        			$contact = $values["dradr"];
        			break;
        		default: 
        			$contact = '';
        	}
        	$mail = new Reg2_Mail('newreg');
        	$view = $mail->getView();
        	$view->contact = $contact;
        	$view->maxplayers = Bootstrap::get('model')->getMaxPlayers();
        	$view->data = $values;
        	$config = Bootstrap::get('config');
        	$mail->getMailer()
        		->addTo($config['mail']['register'])
        		->setSubject('ICHB-2010 - New Registration');
        	$mail->send();
        	
        	if($values["klist"] == 'n' || $values["zlist"] == 'n') {
	        	$mail = new Reg2_Mail('subscribe');
	        	$view = $mail->getView();
	        	$mail->getMailer()
	        		->addTo($config['mail']['pochta'])
	        		->setSubject('ICHB-2010 - Subscribe');
	        	$view->name = $data["name"];
	        	if($values["klist"] == 'n') {
	        		$view->list = "Совета Капитанов";
	        		$view->kod = $values["tsubs_kod"];
	        		$view->addr = $values["tsubs"];
	        		$mail->send();
	        	}
	        	if($values["zlist"] == 'n') {
	        		$view->list = $values["zsubs_list"];
	        		$view->kod = $values["zsubs_kod"];
	        		$view->addr = $values["zsubs"];
	        		$mail->send();
	        	}
	        	$this->view->list_desc = 1;
	        	$this->view->pochta = $config['mail']['pochta'];
        	}
        } else {
        	$this->view->error = $result;	
        }
    }
}

