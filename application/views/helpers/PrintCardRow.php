<?php
/**
 * printCardRow helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_printCardRow
{
    
    /**
     * @var Zend_View_Interface 
     */
    public $view;

    /**
     * 
     */
    public function printCardRow($name, $data, $bold = true)
    {
        if(empty($data)) return null;
        if($bold) $name = "<B>$name</B>";
        return "<TR class=\"cardrow\"><TD>$name</TD><TD class=\"datacell\">$data</TD></TR>";
    }

    /**
     * Sets the view field 
     * @param $view Zend_View_Interface
     */
    public function setView(Zend_View_Interface $view)
    {
        $this->view = $view;
    }
}

