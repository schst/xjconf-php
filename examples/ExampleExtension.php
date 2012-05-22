<?php
/**
 * Example that shows how to use extension.
 * 
 * @author  Stephan Schmidt <stephan.schmidt@schlund.de>
 * @author  Frank Kleine <mikey@xjconf.net>
 */
require_once '../XJConf/XJConf.php';
use net\xjconf\DefinitionParser;
use net\xjconf\XmlParser;
use net\xjconf\ext\Extension;
require 'MathExtension.php';
/**
 * Example that shows how to use extension.
 * 
 * @package     XJConf
 * @subpackage  examples
 */
class ExampleExtension
{
	public static function main()
	{
        $tagParser = new DefinitionParser();
        $defs      = $tagParser->parse(getcwd() . '/xml/defines-extension.xml');
        
        $conf      = new XmlParser();
        $extension = new MathExtension();
        $conf->addExtension($extension);
        try {
            $conf->setTagDefinitions($defs);
    
            $conf->parse(getcwd() . '/xml/test-extension.xml');
        } catch (Exception $e) {
            echo $e->getTraceAsString();
            exit(0);
        }
        
        $map = $conf->getConfigValue('map');
        echo 'Map:';
        var_dump($map);
        
        $array = $conf->getConfigValue('array');
        echo 'Array:';
        var_dump($array);
	}
}
ExampleExtension::main();
?>