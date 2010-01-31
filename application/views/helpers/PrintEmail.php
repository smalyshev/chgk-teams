<?php
/**
 * PrintEmail helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_printEmail {
	
	/**
	 * @var Zend_View_Interface 
	 */
	public $view;
	
	/**
	 * 
	 */
	public function printEmail($email) 
	{
		return preg_replace('|(.+)@(.+)|', '$1 <b><small>AT</small></b> $2', $email);  
	}
	
	/**
	 * Sets the view field 
	 * @param $view Zend_View_Interface
	 */
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}

