<?php
/**
 *
 * @author stas
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * PrintErrors helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_PrintErrors
{
	
	/**
	 * @var Zend_View_Interface 
	 */
	public $view;
	
	/**
	 *  
	 */
	public function printErrors($data) 
	{
		foreach($data as $key => $value) {
			list($errno, $errmsg) = each($value);
			if(is_array($errmsg)) {
				$this->printErrors($value);
			} else {
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

