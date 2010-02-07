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
        $this->_mailer = new Zend_Mail('koi8-r');
        $this->_view = new Zend_View();
        $this->_template = $template;
        $this->_view->setScriptPath(APPLICATION_PATH. '/views/scripts/email');
        $config = Bootstrap::get('config');
        $this->_mailer->addCc($config["mail"]["kadavr"]);
        $this->_mailer->addCc($config["mail"]["cc"]);
    }
    function getMailer ()
    {
        return $this->_mailer;
    }
    function getView ()
    {
        return $this->_view;
    }
    function setTemplate($template)
    {
        $this->_template = $template;
    }
    function send ()
    {
    	Zend_Registry::get('log')->info("Sending email {$this->_template}");
        $this->_mailer->setBodyText($this->_view->render($this->_template . ".phtml"), 'koi8-r');
        $this->_mailer->send();
    }
}
