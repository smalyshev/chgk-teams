<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /**
     * @var Zend_Log
     */
    protected $_logger;

    public static function get($resource)
    {
    	return Zend_Controller_Front::getInstance()->getParam('bootstrap')->getResource($resource);
    }

    protected function _initLoader()
    {
    	$resourceLoader = new Zend_Loader_Autoloader_Resource(array(
   			 'basePath'  => APPLICATION_PATH,
    		 'namespace' => 'Reg2',
		));
		$resourceLoader->addResourceType('model', 'models/', 'Model');
		$resourceLoader->addResourceType('validate', '../library/Validate', 'Validate');
		$resourceLoader->addResourceType('plugin', 'plugins/', 'Plugin');
		$resourceLoader->addResourceType('form', 'forms/', 'Form');
		return $resourceLoader;
    }

    /**
     * Setup the logging
     */
    protected function _initLogging()
    {
        $this->bootstrap('frontController');
        $this->bootstrap('config');
        $logger = new Zend_Log();

//        $writer = 'production' == $this->getEnvironment() ?
//			new Zend_Log_Writer_Stream(APPLICATION_PATH . '/../data/logs/app.log') :
//			new Zend_Log_Writer_Firebug();
//        $logger->addWriter($writer);
        $config = $this->getResource('config');
        $writer = new Zend_Log_Writer_Stream($config["log"]["file"]);
        $writer->setFormatter(new Reg2_Log_Formatter($config["log"]["format"]));
		$logger->addWriter($writer);

		if ('production' == $this->getEnvironment()) {
			$filter = new Zend_Log_Filter_Priority(Zend_Log::INFO);
			$logger->addFilter($filter);
		}

        $this->_logger = $logger;
        Zend_Registry::set('log', $logger);
        $logger->debug("Start logging");
        return $logger;
    }

	/**
     * Add the config to the registry
     */
    protected function _initConfig()
    {
        $config = $this->getOptions();
        Zend_Registry::set('config', $config);
        return $config;
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
        $this->bootstrap('view');

        $this->_view = $this->getResource('view');

        // add global helpers
        $this->_view->addHelperPath(APPLICATION_PATH . '/views/helpers', 'Zend_View_Helper');
        Zend_Dojo::enableView($this->_view);
		//$this->_view->addHelperPath('Zend/Dojo/View/Helper/', 'Zend_Dojo_View_Helper');

        // set encoding and doctype
        $this->_view->setEncoding('UTF-8');
        $this->_view->doctype('XHTML1_STRICT');

        $config = $this->getResource('config');
        $prefix = $config["urlprefix"];
        // set css links and a special import for the accessibility styles
//        $this->_view->headStyle()->setStyle('@import "/css/access.css";');
//        $this->_view->headLink()->appendStylesheet('/reg2/css/reset.css');
        $this->_view->headLink()->appendStylesheet($prefix.'/css/form.css');
        $this->_view->headLink()->appendStylesheet($prefix.'/css/reg2.css');

        // setting the site in the title
        $this->_view->headTitle('ИЧБ-10');

        // setting a separator string for segments:
        $this->_view->headTitle()->setSeparator(' - ');

        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
        $viewRenderer->setView($this->_view);
        return $this->_view;
    }

    protected function _initDb()
    {
    	$db = $this->getPluginResource('db')->getDbAdapter();
    	Zend_Db_Table_Abstract::setDefaultAdapter($db);
    	Zend_Registry::set('db', $db);
    	return $db;
    }

    protected function _initLang()
    {
	$cache = Zend_Cache::factory('Core',
                             'File',
                             array('automatic_serialization' => true),
                             array('cache_dir' => APPLICATION_PATH.'/../data/cache'));
	Zend_Translate::setCache($cache);
        $translator = new Zend_Translate(
          'array',
          ZF_PATH.'/resources/languages',
          'ru-utf8',
	  array("scan" => Zend_Translate::LOCALE_DIRECTORY)
      );
      Zend_Validate_Abstract::setDefaultTranslator($translator);
    }

    protected function _initModel()
    {
    	$model = new Reg2_Model_Data();
    	Zend_Registry::set('model', $model);
    	return $model;
    }

}

