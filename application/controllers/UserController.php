<?php

class UserController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
        $this->initView();
    }

    public function indexAction()
    {
        return $this->_helper->redirector('index', 'index');
    }

    public function loginAction()
    {
    	$form = $this->view->loginForm = $this->_helper->getForm('login');
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $adapter = $this->getAuthAdapter($form->getValues());
                $auth    = Zend_Auth::getInstance();
                $result  = $auth->authenticate($adapter);
                if (!$result->isValid()) {
                    // Invalid credentials
                    //$this->_helper->getHelper('FlashMessenger')->addMessage($result->getMessages());
                    $this->_helper->getHelper('FlashMessenger')->addMessage('Неверный код доступа');
                } else {
                    $auth->getStorage()->write($result->getIdentity());
                    //var_dump($request);
                    /* reroute this requets again */
                    return $this->_redirect($request->getPathInfo());
                }
            }
        }
        $this->view->messages = $this->_flashMessenger->getCurrentMessages();
    }

    public function logoutAction()
	{
		Zend_Auth::getInstance()->clearIdentity();
		Zend_Session::destroy(true);
		$this->_redirect('index');
	}
	
	protected function getAuthAdapter($data)
	{
	    return new Reg2_Auth_Adapter($data);
	}
    

}

