<?php

class Reg2_Validate_UniqueTeamEmail extends Zend_Validate_Abstract
{
    protected $_tid; /* team ID for edit */
    const NAME_EXIST = 'team-emailExists';   

    protected $_messageTemplates = array(   
        self::NAME_EXIST => "Команда с адресом '%value%' уже зарегистрирована",   
    );   
	
    public function __construct($tid = null)
    {   
        $this->_tid = $tid;
    }   

    public function isValid($value)
    {   
    	$this->_setValue($value);
    	$team = Reg2_Model_Data::getModel()->findTeamByEmail($value);
        if ($team && $team->tid != $this->_tid) {   
            $this->_error(self::NAME_EXIST);   
            return false;   
		}
        return true;   
    }   
}
	