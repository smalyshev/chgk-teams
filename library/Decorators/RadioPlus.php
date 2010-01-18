<?php
class Reg2_Decorator_RadioPlus extends Zend_Form_Decorator_ViewHelper
{
    public function render($content)
    {
        $element = $this->getElement();
        $view = $element->getView();
        $helper        = $this->getHelper();
        $helperObject  = $view->getHelper($helper);
      //  var_dump($element);
		$helperObject->setForm($view->form);
		return parent::render($content);
    }
}

