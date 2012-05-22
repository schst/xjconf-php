<?php
/**
 * Example that shows how to use class loaders.
 * 
 * @author  Frank Kleine <mikey@xjconf.net>
 */
require_once '../XJConf/XJConf.php';
use net\xjconf\DefinitionParser;
use net\xjconf\XmlParser;
use net\xjconf\XJConfClassLoader;
require 'ClassLoader.php';
/**
 * Example that shows how to use class loaders.
 * 
 * @package     XJConf
 * @subpackage  examples
 */
class ExampleClassLoader
{
	public static function main()
	{
        $tagParser = new DefinitionParser(array('http://xjconf.net/example/ClassLoader' => new ClassLoader()));
        $defs      = $tagParser->parse(getcwd() . '/xml/defines-classloader.xml');
        
        $conf      = new XmlParser();
        $conf->setTagDefinitions($defs);
        try {
            $conf->parse(getcwd() . '/xml/test-classloader.xml');
        } catch (Exception $e) {
            echo $e->getTraceAsString();
            exit(0);
        }
        
        $nestedClass = $conf->getConfigValue('nestedClass');
        echo 'nestedClass:';
        var_dump($nestedClass);
        
        $otherClass = $conf->getConfigValue('otherClass');
        echo 'otherClass:';
        var_dump($otherClass);
	}
}
ExampleClassLoader::main();
?>