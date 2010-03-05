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
        "á" => "A",
        "â" => "B",
        "÷" => "V",
        "ç" => "G",
        "ä" => "D",
        "å" => "E",
        "³" => "YO",
        "ö" => "ZH",
        "ú" => "Z",
        "é" => "I",
        "ê" => "J",
        "ë" => "K",
        "ì" => "L",
        "í" => "M",
        "î" => "N",
        "ï" => "O",
        "ğ" => "P",
        "ò" => "R",
        "ó" => "S",
        "ô" => "T",
        "õ" => "U",
        "æ" => "F",
        "è" => "H",
        "ã" => "TS",
        "ş" => "CH",
        "û" => "SH",
        "ı" => "SCH", 
        "ü" => "E",
        "ÿ" => "`",
        "ø" => "'",        
        "ù" => "YI",
        "à" => "YU",
        "ñ" => "YA",
        "Á" => "a",
        "Â" => "b",
        "×" => "v",
        "Ç" => "g",
        "Ä" => "d",
        "Å" => "e",
        "£" => "yo",
        "Ö" => "zh",
        "Ú" => "z",
        "É" => "i",
        "Ê" => "j",
        "Ë" => "k",
        "Ì" => "l",
        "Í" => "m",
        "Î" => "n",
        "Ï" => "o",
        "Ğ" => "p",
        "Ò" => "r",
        "Ó" => "s",
        "Ô" => "t",
        "Õ" => "u",
        "Æ" => "f",
        "È" => "h",
        "Ã" => "ts",
        "Ş" => "ch",
        "Û" => "sh",
        "İ" => "sch",
        "Ü" => "e",
        "ß" => "`",
        "Ø" => "'",
        "Ù" => "yi",
        "À" => "yu",
        "Ñ" => "ya",
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

