<?php
class Reg2_Form_PlayerData extends Zend_Dojo_Form_SubForm 
{
	public function init()
    {
    	$this->addElementPrefixPath('Reg2_Decorator', APPLICATION_PATH. '/../library/Decorator/', 'decorator');
    	
    	for($i=0; $i<Reg2_Model_Data::MAX_PLAYERS; $i++) {
    		$val = new Reg2_Validate_PlayerFieldsRequired($i);
        	$this->addElement('checkbox', "pold$i", array(
        		'decorators' => array('DijitElement')
        	));
        	
    		$this->addElement('text', "pname$i", array(
    	        'filters'    => array('StringTrim'),
        	    'required'   => true,
	    		'allowEmpty' => $i!=0,
	    		'autoInsertNotEmptyValidator' => $i==0,
    			'decorators' => array('ViewHelper'),
        		'class'		=> "player-req",
	    	    'validators' => array(
                	new Reg2_Validate_OldName($i),
             	),
    		));

        	$this->addElement('text', "pfamil$i", array(
            	'filters'    => array('StringTrim'),
        	    'required'   => true,
	    		'allowEmpty' => $i!=0,
        		'autoInsertNotEmptyValidator' => $i==0,
        		'class'		=> "player-req",
        		'decorators' => array('ViewHelper'),
	    	    'validators' => array(
                	$val,
             	),
        	));
        	$this->addElement('text', "pcity$i", array(
            	'filters'    => array('StringTrim'),
        	    'required'   => true,
	    		'allowEmpty' => $i!=0,
        		'autoInsertNotEmptyValidator' => $i==0,
        		'class'		=> "player-req",
	    	    'validators' => array(
                	$val,
        	   	),
        		'decorators' => array('ViewHelper')
        	));
        	$this->addElement('text', "pcountry$i", array(
            	'filters'    => array('StringTrim'),
        	    'required'   => true,
	    		'allowEmpty' => $i!=0,
        		'autoInsertNotEmptyValidator' => $i==0,
        		'class'		=> "player-req",
	    	    'validators' => array(
                   	new Reg2_Validate_PlayerFieldsRequired($i, true)
             	),
        		'decorators' => array('ViewHelper')
        	));
        	// optional - пол, дата рождения, адрес email
        	$this->addElement('select', "psex$i", array(
            	'filters'    => array('StringTrim'),
            	'required'   => false,
        		'multiOptions' => array("" => "", "m" => "М", "f" => "Ж"),
    			'decorators' => array('ViewHelper'),
        		'class'		=> "short"
        	));
        	$this->addElement('DateTextBox', "pbirth$i", array(
            	'filters'    => array('StringTrim'),
            	'required'   => false,
        		'invalidMessage' => 'Неверная дата',
        		'formatLength'   => 'short',
        		'class'		=> "player",
        		'decorators' => array('DijitElement'),
        		"value"	=> "1970-01-01",
        		"datePattern" => 'yyyy-MM-dd',
        	));
        	$this->addElement('text', "pemail$i", array(
            	'filters'    => array('StringTrim'),
            	'required'   => false,
        		'validators' => array(
                		array('EmailAddress', true),
                ),
        		'class'		=> "player",
                'decorators' => array('ViewHelper')
        	));
        	$this->addDisplayGroup(array( "pold$i", "pname$i", "pfamil$i", "pcity$i", "pcountry$i", "psex$i", "pbirth$i", "pemail$i"),
        		"player$i",
        		array('legend' => $i?"Игрок $i":"Капитан")
        	);
    	}
		$this->setDisplayGroupDecorators(array(
    		'FormElements',
    		'Fieldset'
		));
    }
}