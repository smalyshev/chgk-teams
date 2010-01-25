<?php
class Reg2_Mail
{
    /**
     * @var Zend_Mail
     */
    protected $_mailer;
    /**
     * @var Zend_View
     */
    protected $_view;
    protected $_template;
    function __construct ($template)
    {
        $this->_mailer = new Zend_Mail('utf-8');
        $this->_view = new Zend_View();
        $this->_template = $template;
        $this->_view->setScriptPath(APPLICATION_PATH. '/views/scripts/email');
        $config = Bootstrap::get('config');
        $this->_mailer->addCc($config["mail"]["kadavr"]);
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
    	Zend_Registry::get('log')->info("Sending email {$this->_template}");
        $this->_mailer->setBodyText($this->_view->render($this->_template . ".phtml"), 'UTF-8');
        $this->_mailer->send();
    }
}
