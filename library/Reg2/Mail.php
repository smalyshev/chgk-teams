<?php
class Reg2_Mail
{
    protected $_mailer;
    protected $_view;
    protected $_template;
    function __construct ($template)
    {
        $this->_mailer = new Zend_Mail('utf-8');
        $this->_view = new Zend_View();
        $this->_template = $template;
        $this->_view->setScriptPath(APPLICATION_PATH. '/views/scripts/email');
    }
    function getMailer ()
    {
        return $this->_mailer;
    }
    function getView ()
    {
        return $this->_view;
    }
    function send ()
    {
        $this->_mailer->setBodyText($this->_view->render($this->_template . ".phtml"), 'UTF-8');
        $this->_mailer->send();
    }
}
