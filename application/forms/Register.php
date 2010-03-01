<?php
class Reg2_Form_Register extends Zend_Form
{
	/**
	 * team ID - for editing
	 * 
	 * @var int
	 */
	protected $_tid;
	
	public function __construct($options = null) {
		if(isset($options['tid'])) {
			$this->setTeamID($options['tid']);
			unset($options['tid']);
		}
		parent::__construct($options);
	}
	
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
    	$this->addElementPrefixPath('Reg2_Decorator', APPLICATION_PATH. '/../library/Decorators/', 'decorator');
    	$this->addPrefixPath('Reg2_Form_Element', APPLICATION_PATH. '/../library/Elements/', 'element');
    	
    	$this->setElementDecorators(array(
    		'ViewHelper',
    		'TableRow',
    	));

    	if(APPLICATION_ENV == 'production') {
    	    $this->addElement('hash', '_confhash', array(
            	'required'   => true,
            	'ignore'   => true,
            ));
    	}
    	
    	$this->addElement('text', 'name', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(1, 50)),
                array('UniqueTeamName', true, $this->_tid),
             ),
            'required'   => true,
            'label'      => '�������� �������',
        ));
        $this->addElement('text', 'email', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('EmailAddress', true),
            ),
            'required'   => true,
            'label'      => 'E-mail ���������������',
        ));
        $this->addElement('text', 'remail', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('EmailAddress', true),
            ),
            'required'   => false,
            'label'      => '��������� ���������� e-mail',
        ));

        $this->addElement('RadioPlus', 'sezon2008', array(
			    'multioptions'   => array(
                            'y' => '������� ������ � ������ 2008 ����',
                            'n' => '���, ������� �� ������ � ������� ������',
                           ),
            'value' => 'n',
            'required'   => true,
            'label'      => '����� 2008',
            'links'		=> array('y' => 'oldid'),
        ));
        
        $this->addElement('text', 'oldid', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('Digits'),
                array('ValidRegno', $this->_tid)
            ),
            'trim' 		 => true,
            'required'   => false,
            'label'      => '��������������� ����� �������:',
            'decorators' => array(array('Label', array("class" => "required")), 'ViewHelper', array("HtmlTag", array("tag" => "br"))),
        ));
        $this->addElement('text', 'url', array(
            'filters'    => array('StringTrim'),
            'required'   => false,
            'label'      => 'URL ��������� ��������',
        ));
        $this->addElement('RadioPlus', 'kadres', array(
			    'multioptions'   => array(
                            'kap' => '������� �������',
                            'reg' => '��������������',
                            'list' => '��������� ����:',
                            'other' => '������ �����:',
        	),
        	'value' => 'kap',
            'required'   => true,
            'label'      => '���������� �����',
            'links'		=> array('list' => 'tlist', 'other' => 'dradr'),
        ));
        $this->addElement('text', 'tlist', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('EmailAddress', true),
            ),
            'trim' 		 => true,
            'required'   => false,
            'decorators' => array('ViewHelper'),
        ));
        $this->addElement('text', 'dradr', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('EmailAddress', true),
            ),
            'trim' 		 => true,
            'required'   => false,
            'decorators' => array('ViewHelper'),
        ));
        $this->addElement('RadioPlus', 'klist', array(
			    'multioptions'   => array(
                            'y' => '������� �������� �� ����',
                            'n' => '������� �� �������� �� ����',
        	),
        	'value' => 'y',
            'required'   => true,
            'label'      => '���� ������ ���������',
            'links'		=> array('n' => array('tsubs', 'tsubs_kod')),
        ));
        $this->addElement('text', 'tsubs', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('EmailAddress', true),
            ),
            'label' => '������� ��������� �����',
            'trim' 		 => true,
            'required'   => false,
            'decorators' => array('Label', 'ViewHelper', array("HtmlTag", array("tag" => "br"))),
        ));
        $this->addElement('Select', 'tsubs_kod', array(
			    'multioptions'   => array(
                            'koi8' => '���8',
                            'translite' => 'translite',
        	),
        	'value' => 'koi8',
            'required'   => false,
            'label'      => '�',
        	'decorators' => array('Label', 'ViewHelper'),
        ));
        
        $this->addElement('RadioPlus', 'zlist', array(
			    'multioptions'   => array(
                            'y' => '��, ������� ����� ������ � ���������� ������',
                            'n' => '���,',
        	),
        	'value' => 'y',
            'required'   => true,
            'label'      => '����� �����',
            'links'		=> array('n' => array('zsubs', 'zsubs_kod', 'zsubs_list')),
        ));
        $this->addElement('text', 'zsubs', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('EmailAddress', true),
            ),
            'label' => '������� ��������� �����',
            'trim' 		 => true,
            'required'   => false,
            'decorators' => array('Label', 'ViewHelper', array("HtmlTag", array("tag" => "br"))),
        ));
        $this->addElement('Select', 'zsubs_kod', array(
			    'multioptions'   => array(
                            'koi8' => '���8',
                            'translite' => 'translite',
        	),
        	'value' => 'koi8',
            'required'   => false,
            'label'      => '�',
        	'decorators' => array('Label', 'ViewHelper'),
        ));
        $this->addElement('Select', 'zsubs_list', array(
			    'multioptions'   => array(
                            'ZNATOK' => 'ZNATOK',
                            'Z-INFO' => 'Z-INFO',
        	),
        	'value' => 'znatok',
            'required'   => false,
            'label'      => '�� ����',
        	'decorators' => array('Label', 'ViewHelper'),
        ));
        $this->addElement('Textarea','comment', array(
            'required'   => false,
            'label'      => '�����������',
    		'cols' => '100',
        ));
              
        
        /// Players
    	$decorators = array(
    		'ViewHelper',
    		array("HtmlTag", array("tag" => "td"))
    	);
    	
    	$max = Bootstrap::get('model')->getMaxPlayers();
        for($i=0;$i<$max;$i++) {
        	$who = $i?"������ $i":"��������";
        	
        	$this->addElement('checkbox', "pold$i", array(
//        		'decorators' => array('DijitElement')
				"decorators" => $decorators, 
        	));
        	
    		$this->addElement('text', "pname$i", array(
    	        'filters'    => array('StringTrim'),
        	    'required'   => true,
	    		'allowEmpty' => $i!=0,
	    		'autoInsertNotEmptyValidator' => $i==0,
        		'class'		=> "player-req",
	    	    'validators' => array(
                	new Reg2_Validate_OldName($i),
                	new Reg2_Validate_UniquePlayerReg($i, $this->_tid)
             	),
				"decorators" => $decorators, 
        		"label" => "��� $who",
            ));
			$val = new Reg2_Validate_PlayerFieldsRequired($i);
    		
        	$this->addElement('text', "pfamil$i", array(
            	'filters'    => array('StringTrim'),
        	    'required'   => true,
	    		'allowEmpty' => $i!=0,
        		'autoInsertNotEmptyValidator' => $i==0,
        		'class'		=> "player-req",
	    	    'validators' => array(
                	$val,
             	),
				"decorators" => $decorators, 
        		"label" => "������� $who",
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
				"decorators" => $decorators, 
        	   	"label" => "����� $who",
        	   	));
        	$this->addElement('text', "pcountry$i", array(
            	'filters'    => array('StringTrim'),
        	    'required'   => false,
				'class' => 'player',
    	    	'validators' => array(
                   	new Reg2_Validate_PlayerFieldsRequired($i, true)
             	),
				"decorators" => $decorators, 
        		"label" => "������ $who",
             	));
        	// optional - ���, ���� ��������, ����� email
        	$this->addElement('select', "psex$i", array(
            	'filters'    => array('StringTrim'),
            	'required'   => false,
        		'multiOptions' => array("" => "", "m" => "�", "f" => "�"),
        		'class'		=> "short",
        		"decorators" => $decorators, 
        		"label" => "��� $who",
        	));
//        	$this->addElement('DateTextBox', "pbirth$i", array(
//            	'filters'    => array('StringTrim'),
//            	'required'   => false,
//        		'invalidMessage' => '�������� ����',
//        		'formatLength'   => 'short',
//        		'class'		=> "player",
//        		'decorators' => array('DijitElement'),
//        		"value"	=> "1970-01-01",
//        		"datePattern" => 'yyyy-MM-dd',
//        	));
			$this->addElement('Date', "pborn$i", array(
				'validators' => array(
                	array('Date', true),
            	),
				"value"	=> "1970-01-01",
				"decorators" => array(
    				'Date',
    				array("HtmlTag", array("tag" => "td"))
    			),
    			'label' => "���� �������� $who",
    			
            ));
        	$this->addElement('text', "pemail$i", array(
            	'filters'    => array('StringTrim'),
        	    'required'   => $i == 0,
	    		'allowEmpty' => $i!=0,
	    		'autoInsertNotEmptyValidator' => $i==0,
        		'validators' => array(
                		array('EmailAddress', true),
                		new Reg2_Validate_UniqueKapEmail($i, true)
                ),
        		'class'		=> "player",
				"decorators" => $decorators, 
                "label" => "E-mail $who",
                ));
        	
        }
        
        //$form_factory = Zend_Controller_Action_HelperBroker::getExistingHelper('getForm');
       	//$players = $form_factory->getForm('PlayerData');
        //$this->addSubForm($players, 'players');
        
//        $this->setSubFormDecorators(array(
//        	array('ViewScript', array("viewScript" => "playerheader.phtml")),
//   			 'FormElements',
//    	 	array('HtmlTag', array('tag' => 'p', 'id' => 'players'))
//		));
        
        $this->addElement('submit', 'register', array(
            'required' => false,
            'ignore'   => true,
            'label'    => '����������������!',
        	'decorators' => array('ViewHelper')
        ));
    }
}

