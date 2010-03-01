<?php
class Reg2_Form_Player extends Zend_Form
{
	/**
	 * user ID - for editing
	 * 
	 * @var int
	 */
	protected $_uid;
	
	public function __construct($options = null) {
		if(isset($options['uid'])) {
			$this->setUID($options['uid']);
			unset($options['uid']);
		}
		parent::__construct($options);
	}
	
	public function setUID($uid) 
	{
		$this->_uid = $uid;
	}
	
    public function init()
    {
    	$this->setName("player");
    	$this->setAction("");
    	$this->setMethod("POST");
    	$this->addElementPrefixPath('Reg2_Validate', APPLICATION_PATH. '/../library/Validate/', 'validate');
    	$this->addElementPrefixPath('Reg2_Decorator', APPLICATION_PATH. '/../library/Decorators/', 'decorator');
    	$this->addPrefixPath('Reg2_Form_Element', APPLICATION_PATH. '/../library/Elements/', 'element');
    	
    	$this->setElementDecorators(array(
    		'ViewHelper',
    		'TableRow',
    	));

    	
        $this->addElement('text', "pname", array(
   	        'filters'    => array('StringTrim'),
       	    'required'   => true,
       		"label" => "���",
        ));

        $this->addElement('text', "pfamil", array(
           	'filters'    => array('StringTrim'),
       	    'required'   => true,
       		"label" => "�������",
        ));
        $this->addElement('text', "pcity", array(
            	'filters'    => array('StringTrim'),
        	    'required'   => true,
        	   	"label" => "�����",
        ));
       	$this->addElement('text', "pcountry", array(
           	'filters'    => array('StringTrim'),
       	    'required'   => false,
          	"label" => "������",
       	));
       	// optional - ���, ���� ��������, ����� email
       	$this->addElement('select', "psex", array(
           	'filters'    => array('StringTrim'),
           	'required'   => false,
       		'multiOptions' => array("" => "", "m" => "�", "f" => "�"),
       		'class'		=> "short",
       		"label" => "���",
       	));
		$this->addElement('Date', "pborn", array(
        	    'required'   => false,
				'validators' => array(
                	array('Date', true),
            	),
				"decorators" => array(
    				'Date',
    				'TableRow',
    			),
    			'label' => "���� ��������",
        ));
       	$this->addElement('text', "pemail", array(
           	'filters'    => array('StringTrim'),
        	 'required'   => false,
      		 'validators' => array(
                		array('EmailAddress', true),
              ),
                "label" => "E-mail",
         ));
        
        $this->addElement('submit', 'edit', array(
            'required' => false,
            'ignore'   => true,
            'label'    => '���������',
        	'decorators' => array('ViewHelper')
        ));
    }
}

