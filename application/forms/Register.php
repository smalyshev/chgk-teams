<?php
class Reg2_Form_Register extends Zend_Dojo_Form
{
	/**
	 * team ID - for editing
	 * 
	 * @var int
	 */
	protected $_tid;
	
	public function setTeamID($tid) 
	{
		$this->_tid = $tid;
	}
	
    public function init()
    {
    	$this->setName("register");
    	$this->setAction("");
    	$this->setMethod("POST");
    	$this->addElementPrefixPath('Reg2_Validate', APPLICATION_PATH. '/../library/Validate/', 'validate');
    	
    	$this->addElement('text', 'name', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(1, 30)),
                array('UniqueTeamName', true, $this->_tid),
             ),
            'required'   => true,
            'label'      => 'Название команды:',
             'class'	=> 'fm'
        ));
        $this->addElement('text', 'email', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('EmailAddress', true),
                array('UniqueTeamEmail', true, $this->_tid),
            ),
            'required'   => true,
            'label'      => 'E-mail для связи:',
        ));
        $this->addElement('text', 'oldid', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('Digits'),
            ),
            'trim' 		 => true,
            'required'   => false,
            'regExp' => '[0-9]+',
            'label'      => 'Прошлогодний номер:',
        ));
        $this->addElement('text', 'url', array(
            'filters'    => array('StringTrim'),
            'required'   => false,
            'label'      => 'URL командной страницы:',
        ));
        /// Players
        $form_factory = Zend_Controller_Action_HelperBroker::getExistingHelper('getForm');
       	$players = $form_factory->getForm('PlayerData');
        $this->addSubForm($players, 'players');
        
        $this->setSubFormDecorators(array(
        	array('ViewScript', array("viewScript" => "playerheader.phtml")),
   			 'FormElements',
    	 	array('HtmlTag', array('tag' => 'p', 'id' => 'players'))
		));
        
        $this->addElement('submit', 'register', array(
            'required' => false,
            'ignore'   => true,
            'label'    => 'Зарегистрировать!',
        	'decorators' => array('ViewHelper', array('HtmlTag', array('tag' => 'dd', 'id' => 'register-element')))
        ));
    }
}

