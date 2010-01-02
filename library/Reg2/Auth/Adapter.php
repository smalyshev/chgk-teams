<?php
class Reg2_Auth_Adapter implements Zend_Auth_Adapter_Interface
{
    protected $_data;
    /**
     * Authenticated identity
     * 
     * @var Reg2_Model_Identity
     */
    protected $identity;
    /**
     * Db auth adapter
     * 
     * @var Zend_Auth_Adapter_DbTable
     */
    protected $_dbauth;
    
    /**
     * 
     */
    function __construct ($data)
    {
        $this->_data = $data;
        $this->_dbauth = new Zend_Auth_Adapter_DbTable(
    			Zend_Registry::get('db'),
    			'users',
		    	'email',
    			'password'
		);
    }
    /**
     * 
     * @throws Zend_Auth_Adapter_Exception If authentication cannot be performed 
     * @return Zend_Auth_Result 
     * @see Zend_Auth_Adapter_Interface::authenticate()
     */
    public function authenticate ()
    {
        $result = array(
            'code'  => Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND,
            'identity' => null,
            'messages' => array()
            );
        /** @var Zend_Config */
		$config = Zend_Registry::get('config');
		
		if(isset($config['admin']['pass']) &&
			 $this->_data['code'] == $config['admin']['pass'] && $this->_data['email'] == 'admin') {
        	$result['code'] = Zend_Auth_Result::SUCCESS;
        	$result['identity'] = new Reg2_Model_Identity('admin');
        	return new Zend_Auth_Result($result['code'], $result['identity'], $result['messages']);
        }
        
        $this->_dbauth->setIdentity($this->_data['email'])->setCredential($this->_data['code']);
        $dbresult = $this->_dbauth->authenticate();
        if($dbresult->isValid()) {
        	$result['code'] = Zend_Auth_Result::SUCCESS;
        	$user = $this->_dbauth->getResultRowObject();
        	$result['identity'] = new Reg2_Model_Identity($user->role, $user);
        } else {
        	$result['code'] = $dbresult->getCode();
        	$result['messages'] = $dbresult->getMessages();
        }
        
        return new Zend_Auth_Result($result['code'], $result['identity'], $result['messages']);
    }
}
