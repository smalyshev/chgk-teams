<?php

class Reg2_Validate_PlayerFieldsRequired extends Zend_Validate_Abstract
{
    protected $_id; /* player number */
    protected $_oldok; /* should allow old? */
    const REQUIRED = 'player-required';   

    protected $_messageTemplates = array(   
        self::REQUIRED => "Поле не должно быть пустым",   
    );   
	
    public function __construct($id, $oldok = false)
    {   
        $this->_id = $id;
        $this->_oldok = $oldok;
    }   

    public function isValid($value, $context = null)
    {   
    	$this->_setValue($value);
    	if(!empty($value)) {
    		return true;
    	}
    	if($this->_oldok && is_array($context) && isset($context["pold".$this->_id]) && $context["pold".$this->_id] == 1) {
    		/* old one, ok */
    		return true;
    	}
    	if (is_array($context) && !empty($context["pname".$this->_id])) {   
    		$this->_error(self::REQUIRED);   
            return false;   
		}
        return true;   
    }   
}
	