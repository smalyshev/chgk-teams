<?php
/**
 * PrintDataErrors helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_PrintDataErrors {
	
	/**
	 * @var Zend_View_Interface 
	 */
	public $view;
	
	/**
	 * 
	 */
	public function printDataErrors($data, $item, $span) 
	{
		if(empty($data[$item])) {
			return null;
		}
		
		$text = is_array($data[$item])?join("<br/>", $data[$item]):$data[$item];
		return "<tr><td colspan=\"$span\" class=\"errors\">$text</td></tr>";
	}
	
	/**
	 * Sets the view field 
	 * @param $view Zend_View_Interface
	 */
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}

