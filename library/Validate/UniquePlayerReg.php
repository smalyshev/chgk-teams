<?php

class Reg2_Validate_UniquePlayerReg extends Zend_Validate_Abstract
{
    protected $_id; /* player id */
    protected $_tid; /* team id */
    
    public $team;
    
    const PLAYER_ALREADY = 'player-already';   

    protected $_messageTemplates = array(   
        self::PLAYER_ALREADY => "Игрок по имени %value% уже зарегистрирован на этот турнир за команду %team%",   
    );   
    protected $_messageVariables = array(
        'team' => 'team',
    );	
    public function __construct($id, $tid)
    {   
        $this->_id = $id;
        $this->_tid = $tid;
    }   

    public function isValid($value, $context = null)
    {   
    	if(is_array($context) &&
    		!empty($context["pname".$this->_id]) && !empty($context["pfamil".$this->_id])) {
    		$regs = Reg2_Model_Data::getModel()->findRegByName($context["pname".$this->_id], $context["pfamil".$this->_id]);
    		foreach($regs as $reg) {
    		    if($context["poldid".$this->_id] == $reg["uid"]) continue;
    		    if($context["pid".$this->_id] == $reg["uid"]) continue;
    		    if($this->_tid == $reg["tid"]) continue;
    		    
    		    $this->team = $reg["tname"];
       			$this->_setValue($context["pname".$this->_id]." ".$context["pfamil".$this->_id]);
               	$this->_error(self::PLAYER_ALREADY);
       	        return false;   
    		}	
    	}
        return true;   
    }   
}
	