<?php

class Zend_View_Helper_A
{
    
    /**
     * @var Zend_View_Interface 
     */
    public $view;

    /**
     * 
     */
    public function a($href, $content)
    {
        return "<a href=\"$href\">$content</a>";
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

