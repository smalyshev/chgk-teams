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
        "А" => "A",
        "Б" => "B",
        "В" => "V",
        "Г" => "G",
        "Д" => "D",
        "Е" => "E",
        "Ё" => "YO",
        "Ж" => "ZH",
        "З" => "Z",
        "И" => "I",
        "Й" => "J",
        "К" => "K",
        "Л" => "L",
        "М" => "M",
        "Н" => "N",
        "О" => "O",
        "П" => "P",
        "Р" => "R",
        "С" => "S",
        "Т" => "T",
        "У" => "U",
        "Ф" => "F",
        "Х" => "H",
        "Ц" => "TS",
        "Ч" => "CH",
        "Ш" => "SH",
        "Щ" => "SCH", 
        "Э" => "E",
        "Ъ" => "`",
        "Ь" => "'",        
        "Ы" => "YI",
        "Ю" => "YU",
        "Я" => "YA",
        "а" => "a",
        "б" => "b",
        "в" => "v",
        "г" => "g",
        "д" => "d",
        "е" => "e",
        "ё" => "yo",
        "ж" => "zh",
        "з" => "z",
        "и" => "i",
        "й" => "j",
        "к" => "k",
        "л" => "l",
        "м" => "m",
        "н" => "n",
        "о" => "o",
        "п" => "p",
        "р" => "r",
        "с" => "s",
        "т" => "t",
        "у" => "u",
        "ф" => "f",
        "х" => "h",
        "ц" => "ts",
        "ч" => "ch",
        "ш" => "sh",
        "щ" => "sch",
        "э" => "e",
        "ъ" => "`",
        "ь" => "'",
        "ы" => "yi",
        "ю" => "yu",
        "я" => "ya",
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

