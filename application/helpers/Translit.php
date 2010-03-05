<?php
/**
 *
 * @author stas
 * @version 
 */
require_once 'Zend/Loader/PluginLoader.php';
require_once 'Zend/Controller/Action/Helper/Abstract.php';

/**
 * Translit Action Helper 
 * 
 * @uses actionHelper Zend_Controller_Action_Helper
 */
class Zend_Controller_Action_Helper_Translit extends Zend_Controller_Action_Helper_Abstract
{
    /**
     * @var Zend_Loader_PluginLoader
     */
    public $pluginLoader;

    /**
     * Constructor: initialize plugin loader
     * 
     * @return void
     */
    public function __construct()
    {
        // TODO Auto-generated Constructor
        $this->pluginLoader = new Zend_Loader_PluginLoader();
    }

        
    public function translit($str)
    {
        $translit = array(
        "�" => "A",
        "�" => "B",
        "�" => "V",
        "�" => "G",
        "�" => "D",
        "�" => "E",
        "�" => "YO",
        "�" => "ZH",
        "�" => "Z",
        "�" => "I",
        "�" => "J",
        "�" => "K",
        "�" => "L",
        "�" => "M",
        "�" => "N",
        "�" => "O",
        "�" => "P",
        "�" => "R",
        "�" => "S",
        "�" => "T",
        "�" => "U",
        "�" => "F",
        "�" => "H",
        "�" => "TS",
        "�" => "CH",
        "�" => "SH",
        "�" => "SCH", 
        "�" => "E",
        "�" => "`",
        "�" => "'",        
        "�" => "YI",
        "�" => "YU",
        "�" => "YA",
        "�" => "a",
        "�" => "b",
        "�" => "v",
        "�" => "g",
        "�" => "d",
        "�" => "e",
        "�" => "yo",
        "�" => "zh",
        "�" => "z",
        "�" => "i",
        "�" => "j",
        "�" => "k",
        "�" => "l",
        "�" => "m",
        "�" => "n",
        "�" => "o",
        "�" => "p",
        "�" => "r",
        "�" => "s",
        "�" => "t",
        "�" => "u",
        "�" => "f",
        "�" => "h",
        "�" => "ts",
        "�" => "ch",
        "�" => "sh",
        "�" => "sch",
        "�" => "e",
        "�" => "`",
        "�" => "'",
        "�" => "yi",
        "�" => "yu",
        "�" => "ya",
        );
        return str_replace(array_keys($translit), array_values($translit), $str);
    }
    
    /**
     * Strategy pattern: call helper as broker method
     */
    public function direct($str)
    {    
        return $this->translit($str);
    }
}

