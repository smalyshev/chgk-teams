<?php

class KapController extends Zend_Controller_Action
{

    public function preDispatch()
    {
        $acl = Zend_Registry::get('acl');
        $role = Zend_Registry::get('role');
        if (! $acl->isAllowed(Zend_Registry::get('role'), 'kap', $this->getRequest()->action)) {
            if (! Zend_Auth::getInstance()->hasIdentity()) {
                $this->_forward('noauth', 'error');
            } else {
                $this->_forward('noacl', 'error');
            }
        }
        if($role == 'admin') {
            $this->_forward('index', 'admin');
        }
        $this->_tid = Zend_Auth::getInstance()->getIdentity()->tid;
    }
    
    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->_forward('team','members', 'default', array("id" => $this->_tid));
    }


}

