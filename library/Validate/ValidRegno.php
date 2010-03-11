<?php

class Reg2_Validate_ValidRegno extends Zend_Validate_Abstract
{
    protected $_tid; /* team ID for edit */
    const REGNO_MISSING = 'regno-missing';   
    const REGNO_REGISTERED = 'regno-registered';   
    
    protected $_messageTemplates = array(   
        self::REGNO_MISSING => "В прошлых турнирах нет команды с номером %value%",   
        self::REGNO_REGISTERED => "Команда с номером %value% уже зарегистрирована",   
    );   
	
    public function __construct($tid = null)
    {   
        $this->_tid = $tid;
    }   

    public function isValid($value, $context = null)
    {   
    	$this->_setValue($value);
    	if(!$value) {
    	    return true;
    	}
    	// find new teams by regno
    	$team = Reg2_Model_Data::getModel()->findTeamByRegno($value, true);
        if ($team && $team->tid != $this->_tid) {   
            $this->_error(self::REGNO_REGISTERED);   
            return false;   
		}
		
		if(is_array($context) && isset($context["sezon2008"]) && $context["sezon2008"] == 'y') {
			// find old team by regno
	    	$team = Reg2_Model_Data::getModel()->findTeamByRegno($value, false);
	        if(!$team) {
	            $this->_error(self::REGNO_MISSING);   
	            return false;   
	        }
		}
		    	
		return true;   
    }   
}
	