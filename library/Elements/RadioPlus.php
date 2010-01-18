<?php

class Reg2_Form_Element_RadioPlus extends Zend_Form_Element_Radio 
{
	public $helper = "radioPlus"; 
	
    public function loadDefaultDecorators()
    {
        if ($this->loadDefaultDecoratorsIsDisabled()) {
            return;
        }
        
        $decorators = $this->setDecorators(array('RadioPlus', 'TableRow'));
    }
}
