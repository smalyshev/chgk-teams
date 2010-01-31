<?php
class Reg2_Form_Teamedit extends Reg2_Form_Register
{
	protected $_isAdmin = false;
	
	public function __construct($options = null) {
		if(isset($options["admin"])) {
			$this->_isAdmin = $options["admin"];
			unset($options["admin"]);
		}
		parent::__construct($options);
	}
	
	public function init()
    {
    	parent::init();
    	$this->setName("teamedit");
    	
    	$this->removeElement("email");
    	$this->removeElement("kadres");
    	$this->removeElement("klist");
    	$this->removeElement("zlist");
   		$this->removeElement("sezon2008");
    	
    	$max = Bootstrap::get('model')->getMaxPlayers();
    	$decorators = array(
    		'ViewHelper',
    		array("HtmlTag", array("tag" => "td"))
    	);
   		$this->getElement("oldid")->setDecorators(array(
    		'ViewHelper',
    		'TableRow',
    	));
    	$this->addElement('hidden', 'tid', array(
    		'required'   => true,
    		'decorators' => array('ViewHelper')
    	));
        $this->addElement('text', 'contact', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('EmailAddress', true),
            ),
            'required'   => true,
            'label'      => 'E-mail для контакта',
        ));
    	for($i=0;$i<$max;$i++) {
    		$this->addElement('text', "pid$i", array(
	            'filters'    => array('StringTrim'),
	            'validators' => array(
	                array('Digits'),
	            ),
	            'required'   => false,
	            'class' => 'short',
	            'decorators' => $decorators,
        	));
    		$this->addElement('hidden', "oldpid$i", array(
	            'required'   => false,
	            'decorators' => array('ViewHelper')
        	));
        }
        $this->addElement('submit', 'save', array(
            'required' => false,
            'label'    => 'Записать',
        	'decorators' => array('ViewHelper')
        ));
        if($this->_isAdmin) {
	        $this->addElement('submit', 'delete', array(
	            'required' => false,
	            'label'    => 'Удалить!',
	        	'decorators' => array('ViewHelper')
	        ));
        }
    }
}

