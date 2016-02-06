<?php

class Reg2_Validate_UniqueKapEmail extends Zend_Validate_Abstract
{
    protected $_tid; /* team id */
    protected $_id; /* team id */

    public $team;

    const MAIL_ALREADY = 'player-already';

    protected $_messageTemplates = array(
        self::MAIL_ALREADY => "Мейл %value% уже зарегистрирован капитаном команды %team%",
    );
    protected $_messageVariables = array(
        'team' => 'team',
    );
    public function __construct($id, $tid)
    {
        $this->_tid = $tid;
        $this->_id = $id;
    }

    public function isValid($value, $context = null)
    {
        $this->_setValue($value);
        if($this->_id > 0) {
            return true;
        }
		Zend_Registry::get('log')->info("Unique kap: $value {$this->_tid}.");
    	if($value) {
    		$user = Reg2_Model_Data::getModel()->findUserByEmail($value);
    		if($user && $user->tid != $this->_tid && $user->tid != 0) {
    		    $team = Reg2_Model_Data::getModel()->findTeam($user->tid);
    		    $this->team = $team->imia;
    			if(!empty($context["pold0"]) || !empty($context['pid0']) &&
    					($context['name'] == $team->imia || $context['oldid'] == $team->regno)) {
    				return true;
    			}
    			Zend_Registry::get('log')->info("Unique kap fail: $value {$this->_tid} team: {$user->tid} ");

               	$this->_error(self::MAIL_ALREADY);
       	        return false;
    		}
    	}
        return true;
    }
}

