<?php
class Reg2_Form_Login extends Zend_Form
{
    public function init()
    {
        $this->addElement('hash', '_confhash', array(
            'required'   => true,
            'ignore'   => true,
        ));
        $this->addElement('text', 'email', array(
            'required' => true,
            'ignore'   => false,
            'label'    => 'Email:',
        )); 
        $this->addElement('password', 'code', array(
            'required' => true,
            'ignore'   => false,
            'label'    => 'Код доступа:',
        )); 
        $this->addElement('submit', 'login', array(
            'required' => false,
            'ignore'   => true,
            'label'    => 'Войти',
        )); 
    }
}