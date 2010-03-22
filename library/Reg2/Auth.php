<?php
class Reg2_Auth extends Zend_Controller_Plugin_Abstract
{
    protected $_acl;
    private $_noauth = array(
						'controller' => 'error',
						'action' => 'noauth'
						);
	
	private $_noacl = array(
						'controller' => 'error',
						'action' => 'noacl'
						);
        
    /**
     * Dispatch loop startup plugin: get identity and acls
     * 
     * @param Zend_Controller_Request_Abstract $request 
     * @return void
     */
    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $identity = $auth->getIdentity();
            $role = empty($identity->role) ? 'guest' : $identity->role;
        } else {
            $role = 'guest';
        }

        Zend_Registry::set('acl', $this->getAcl());
        Zend_Registry::set('role', $role);
    }

	/**
     * Get ACL lists
     * 
     * @return Zend_Acl
     */
    public function getAcl()
    {
        if (null === $this->_acl) {
            $acl = new Zend_Acl();
            $acl->add(new Zend_Acl_Resource('admin'))
                ->add(new Zend_Acl_Resource('kap'))
                ->add(new Zend_Acl_Resource('members'))
                ->addRole(new Zend_Acl_Role('guest'))
                ->addRole(new Zend_Acl_Role('kap'), 'guest')
                ->addRole(new Zend_Acl_Role('admin'), 'kap')
                ->deny()
                ->allow('admin', 'admin')
                ->allow('admin', 'members')
                ->allow('admin', 'kap')
                ->allow('kap', 'kap')
                ->allow('kap', 'members')
                ->allow('guest', 'members', array('index','team','player','turnir','old', 'regno'))
                ;
            $this->_acl = $acl;
        }
        return $this->_acl;
    }

}
