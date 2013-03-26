<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
//define('APPLICATION_ENV', isset($_SERVER['APPLICATION_ENV'])?$_SERVER['APPLICATION_ENV']:'development');
define('APPLICATION_ENV', isset($_SERVER['APPLICATION_ENV'])?$_SERVER['APPLICATION_ENV']:'production');

// Ensure library/ is on include_path
if(isset($_SERVER['ZF_PATH'])) {
  define('ZF_PATH', $_SERVER['ZF_PATH']);
} else {
  define('ZF_PATH',  dirname(__FILE__)."/../../zf");
}
set_include_path(implode(PATH_SEPARATOR, array(
	ZF_PATH."/library",
    ".",
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';  

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV, 
    APPLICATION_PATH . '/configs/application.ini'
);
Zend_Loader_PluginLoader::setIncludeFileCache(APPLICATION_PATH."/../data/pluginsCache.php");

$application->bootstrap()
            ->run();
