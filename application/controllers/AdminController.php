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
        // action body
    }


}

