<?php
/**
 * Example that shows how to use arrays.
 * 
 * @author  Stephan Schmidt <stephan.schmidt@schlund.de>
 * @author  Frank Kleine <mikey@xjconf.net>
 */
require_once '../XJConf/XJConf.php';
use net\xjconf\DefinitionParser;
use net\xjconf\XmlParser;
require 'Color.php';
require 'Complex.php';
require 'UpperString.php';
/**
 * Example that shows how to use arrays.
 * 
 * @package     XJConf
 * @subpackage  examples
 */
class ExampleCollection
{
    public static function main()
    {
        $tagParser = new DefinitionParser();
        $defs      = $tagParser->parse(getcwd() . '/xml/defines-collection.xml');

        $conf = new XmlParser();
        try {
            $conf->setTagDefinitions($defs);
    
            $conf->parse(getcwd() . '/xml/test-collection.xml');
        } catch (Exception $e) {
            echo $e->getTraceAsString();
            exit(0);
        }
        
        $list = $conf->getConfigValue('list');
        var_dump($list);
    }
}
ExampleCollection::main();
?>