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
		
		$text = "";
		foreach($data[$item] as $err) {
			if(is_array($err)) {
				$txt = $err[0];
				$js = $err[1];
				$text .= $txt." <a href=\"\" onClick=\"$js; return false;\">[fix]</a><br/>\n";
			} else {
				$text .= $err."<br/>\n";
			}
		}
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

