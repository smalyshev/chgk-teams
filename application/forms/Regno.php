<?php

class Reg2_Form_Regno extends Zend_Form
{
    /**
     * team list
     * @var array
     */
    protected $_teams;
    
    public function __construct($options = null)
    {
        if(isset($options['teams'])) {
            $this->_teams = $options['teams'];
            unset($options['teams']);
        }
        parent::__construct($options);
    }

    public function init()
    {
        $this->setName("regno");
    	$this->setAction("");
    	$this->setMethod("POST");
    	$this->addElementPrefixPath('Reg2_Validate', APPLICATION_PATH. '/../library/Validate/', 'validate');
    	$this->addElementPrefixPath('Reg2_Decorator', APPLICATION_PATH. '/../library/Decorators/', 'decorator');
    	$this->addPrefixPath('Reg2_Form_Element', APPLICATION_PATH. '/../library/Elements/', 'element');
    	
    	$this->setElementDecorators(array(
    		'ViewHelper',
    		'TableRow',
    	));
    
    	$i = 0;
    	foreach($this->_teams as $team) {
            $this->addElement('text', "regno$i", array(
       	        'filters'    => array('StringTrim'),
           	    'required'   => false,
       	    	"label" => $team,
            ));
            $this->addElement('hidden', "tid$i", array(
       	        'filters'    => array('StringTrim'),
           	    'required'   => false,
                'decorators' => array('ViewHelper')
            ));
            $i++;
        }
        $this->addElement('submit', 'regsubmit', array(
            'required' => false,
            'ignore'   => true,
            'label'    => 'Сохранить',
        	'decorators' => array('ViewHelper')
        ));
    }
}