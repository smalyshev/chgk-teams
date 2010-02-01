<?php
/**
 *
 * @author stas
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * ActionLink helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_actionLink
{
    
    /**
     * @var Zend_View_Interface 
     */
    public $view;

    /**
     * 
     */
    public function actionLink($content, $controller, $action, $data = array())
    {
        $data["controller"] = $controller;
        $data["action"] = $action;
        return "<a href=\"".$this->view->url($data)."\">$content</a>"; 
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

