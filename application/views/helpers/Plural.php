<?php
class Zend_View_Helper_Plural
{
	
	/**
	 * @var Zend_View_Interface 
	 */
	public $view;
	
	/**
	 *  
	 */
	public function Plural($num, $word, $one, $two, $many)
	{
		switch($num%10) {
			case 1:
				if($num%100 > 20 || $num%100 < 10) {
					return $num.$word.$one;
				} else {
					return $num.$word.$many;
				}
			case 2:
			case 3:
			case 4:
				if($num%100 > 20 || $num%100 < 10) {
					return $num.$word.$two;
				} else {
					return $num.$word.$many;
				}
			default:
				return $num.$word.$many;
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

