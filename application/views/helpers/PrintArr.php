<?php
/**
 *
 * @author stas
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * PrintArr helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_PrintArr 
{
	
	/**
	 * @var Zend_View_Interface 
	 */
	public $view;
	
	/**
	 * Print value as string or series of strings
	 */
	public function printArr($value) 
	{
		if(is_array($value)) {
			return join("<br/>\n", $value);
		}
		return (string)$value;
	}
	
	/**
	 * Sets the view field 
	 * @param $view Zend_View_Interface
	 */
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}

