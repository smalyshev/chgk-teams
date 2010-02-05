<?php

class Reg2_Validate_UniqueKapEmail extends Zend_Validate_Abstract
{
    protected $_tid; /* team id */
    
    public $team;
    
    const MAIL_ALREADY = 'player-already';   

    protected $_messageTemplates = array(   
        self::MAIL_ALREADY => "Мейл %value% уже зарегистрирован капитаном команды %team%",   
    );   
    protected $_messageVariables = array(
        'team' => 'team',
    );	
    public function __construct($tid)
    {   
        $this->_tid = $tid;
    }   

    public function isValid($value, $context = null)
    {   
        $this->_setValue($value);
    	if($value) {
    		$user = Reg2_Model_Data::getModel()->findUserByEmail($value);
    		if($user && $user->tid != $this->_tid) {
    		    $this->team = Reg2_Model_Data::getModel()->findTeam($user->tid)->imia;
               	$this->_error(self::MAIL_ALREADY);
       	        return false;   
    		}	
    	}
        return true;   
    }   
}
	