<?php

class Reg2_Validate_OldName extends Zend_Validate_Abstract
{
    protected $_id; /* player id */
    const NAME_NOT_OLD = 'player-noOldName';   

    protected $_messageTemplates = array(   
        self::NAME_NOT_OLD => "В базе нет игрока по имени %value% (имя перед фамилией)",   
    );   
	
    public function __construct($id = null)
    {   
        $this->_id = $id;
    }   

    public function isValid($value, $context = null)
    {   
    	if(is_array($context) &&
    		!empty($context["pold".$this->_id]) &&  $context["pold".$this->_id] == 1 && 
    		!empty($context["pname".$this->_id]) && !empty($context["pfamil".$this->_id])) {
    		$p = Reg2_Model_Data::getModel()->findPlayerByName($context["pname".$this->_id], $context["pfamil".$this->_id]);
    		if(!$p) {
    			$this->_setValue($context["pname".$this->_id]." ".$context["pfamil".$this->_id]);
            	$this->_error(self::NAME_NOT_OLD);
            	return false;   
    		}	
    	}
        return true;   
    }   
}
	