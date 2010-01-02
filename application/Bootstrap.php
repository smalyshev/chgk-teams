<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /**
     * @var Zend_Log
     */
    protected $_logger;
	
    protected function _initLoader()
    {
    	$resourceLoader = new Zend_Loader_Autoloader_Resource(array(
   			 'basePath'  => APPLICATION_PATH,
    		 'namespace' => 'Reg2',
		));
		$resourceLoader->addResourceType('model', 'models/', 'Model');
		$resourceLoader->addResourceType('validate', '../library/validate', 'Validate');
		$resourceLoader->addResourceType('plugin', 'plugins/', 'Plugin');
    }
    
    /**
     * Setup the logging
     */
    protected function _initLogging()
    {
        $this->bootstrap('frontController');
        $logger = new Zend_Log();

//        $writer = 'production' == $this->getEnvironment() ?
//			new Zend_Log_Writer_Stream(APPLICATION_PATH . '/../data/logs/app.log') :
//			new Zend_Log_Writer_Firebug();
//        $logger->addWriter($writer);
		$logger->addWriter(new Zend_Log_Writer_Stream(APPLICATION_PATH . '/../data/logs/reg2.log'));

//		if ('production' == $this->getEnvironment()) {
//			$filter = new Zend_Log_Filter_Priority(Zend_Log::CRIT);
//			$logger->addFilter($filter);
//		}

        $this->_logger = $logger;
        Zend_Registry::set('log', $logger);
    }
	
	/**
     * Add the config to the registry
     */
    protected function _initConfig()
    {
        $this->_logger->info('Bootstrap ' . __METHOD__);
        Zend_Registry::set('config', $this->getOptions());
    }

    /**
     *  Initialize controller helpers
     */
    protected function _initHelper()
    {
    	Zend_Controller_Action_HelperBroker::addPath(APPLICATION_PATH .'/helpers', 'Reg2_Helper');
    }
    
    /**
     * Setup the view
     */
    protected function _initViewSettings()
    {
        $this->_logger->info('Bootstrap ' . __METHOD__);

        $this->bootstrap('view');

        $this->_view = $this->getResource('view');

        // add global helpers
        $this->_view->addHelperPath(APPLICATION_PATH . '/views/helpers', 'Zend_View_Helper');
        Zend_Dojo::enableView($this->_view);
		//$this->_view->addHelperPath('Zend/Dojo/View/Helper/', 'Zend_Dojo_View_Helper');
		
        // set encoding and doctype
        $this->_view->setEncoding('UTF-8');
        $this->_view->doctype('XHTML1_STRICT');

        // set css links and a special import for the accessibility styles
//        $this->_view->headStyle()->setStyle('@import "/css/access.css";');
//        $this->_view->headLink()->appendStylesheet('/reg2/css/reset.css');
        $this->_view->headLink()->appendStylesheet('/reg2/css/form.css');
        $this->_view->headLink()->appendStylesheet('/reg2/css/reg2.css');
        
        // setting the site in the title
        $this->_view->headTitle('ИЧБ-2010');

        // setting a separator string for segments:
        $this->_view->headTitle()->setSeparator(' - ');
        
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
        $viewRenderer->setView($this->_view);
        return $this->_view;
    }
    
    protected function _initDb()
    {
    	$this->_logger->info('Bootstrap ' . __METHOD__);
    	$db = $this->getPluginResource('db')->getDbAdapter();
    	Zend_Db_Table_Abstract::setDefaultAdapter($db);
    	Zend_Registry::set('db', $db);
    }
    
    protected function _initModel()
    {
    	Zend_Registry::set('model', new Reg2_Model_Data());
    }
    
}

