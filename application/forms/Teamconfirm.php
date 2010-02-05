<?php
class Reg2_Form_Teamconfirm extends Reg2_Form_Register
{
    public function init()
    {
    	parent::init();
    	$this->setName("teamconfirm");
    	
    	$this->removeElement("email");
    	$this->removeElement("kadres");
    	$this->removeElement("klist");
    	$this->removeElement("zlist");
    	$this->removeElement("sezon2008");
   		$this->getElement("oldid")->setDecorators(array(
    		'ViewHelper',
    		'TableRow',
    	));
    	
    	$max = Bootstrap::get('model')->getMaxPlayers();
    	$decorators = array(
    		'ViewHelper',
    		array("HtmlTag", array("tag" => "td"))
    	);
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
        $this->addElement('submit', 'confirm', array(
            'required' => false,
            'label'    => 'Утвердить регистрацию!',
        	'decorators' => array('ViewHelper')
        ));
        $this->addElement('submit', 'delete', array(
            'required' => false,
            'label'    => 'Удалить!',
        	'decorators' => array('ViewHelper')
        ));
    }
}

