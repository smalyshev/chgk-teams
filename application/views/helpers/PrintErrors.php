<?php
class Zend_View_Helper_PrintErrors
{
	
	/**
	 * @var Zend_View_Interface 
	 */
	public $view;
	
	/**
	 *  
	 */
	public function printErrors($data, $form) 
	{
		foreach($data as $key => $value) {
			list($errno, $errmsg) = each($value);
			if(is_array($errmsg)) {
				$this->printErrors($value);
			} else {
				$element = $form->getElement($key);
				if($element) {
					$label = $element->getLabel();
					if($label) {
						$key = $label;
					}
				}
				echo "$key: $errmsg<br>";
			}
		}
	}
	
	/**
	 * Sets the view field 
	 * @param $view Zend_View_Interface
	 */
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}

