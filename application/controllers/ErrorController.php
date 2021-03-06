<?php

class ErrorController extends Zend_Controller_Action
{

    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');
        
        switch ($errors->type) { 
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
        
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $this->view->message = 'Page not found';
                break;
            default:
                // application error 
                $this->getResponse()->setHttpResponseCode(500);
                $this->view->message = 'Application error';
                break;
        }
        
        $this->view->exception = $errors->exception;
        $this->view->request   = $errors->request;
        Zend_Registry::get('log')->err("Exception: ". $errors->exception."\nRequest: ".$errors->request->getRequestUri());
    }

    public function noaclAction()
    {
        Zend_Registry::get('log')->info("Denied access to ".$this->getRequest()->getRequestUri());
    	/* display it */
    }
    
    public function noauthAction()
    {
		$this->_helper->getHelper('FlashMessenger')->addMessage('Эта секция требует кода доступа');
		return $this->_forward('login', 'user');
    }

}

