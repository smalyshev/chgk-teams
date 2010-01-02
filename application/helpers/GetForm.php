<?php
class Reg2_Helper_GetForm extends Zend_Controller_Action_Helper_Abstract
{
    protected $_loader;
    protected $_forms = array();
    
    /**
     * 
     */
    function __construct ()
    {
        $this->_loader = new Zend_Loader_PluginLoader(array('Reg2_Form' => APPLICATION_PATH . '/forms'));
    }
    public function getForm ($form, $config = null)
    {
    	if(isset($this->_forms[$form])) {
    		return $this->_forms[$form];
    	}
        $class = $this->_loader->load($form);
        $this->_forms[$form] = new $class($config);
        return $this->_forms[$form];
    }
    public function direct ($form, $config = null)
    {
        return $this->getForm($form, $config);
    }
}
?>