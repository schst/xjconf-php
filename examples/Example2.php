<?php
/**
 * Example that shows how to use ArrayList and the keyAttribute.
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
 * Example that shows how to use ArrayList and the keyAttribute.
 * 
 * @package     XJConf
 * @subpackage  examples
 */
class Example2
{

	public static function main()
	{
        $tagParser = new DefinitionParser();
        $defs      = $tagParser->parse(getcwd() . '/xml/defines2.xml');

        echo 'Number of defined tags: ';
        var_dump($defs->countTagDefinitions());

        $conf = new XmlParser();
        try {
            $conf->setTagDefinitions($defs);
    
            $conf->parse(getcwd() . '/xml/test2.xml');
        } catch (Exception $e) {
            echo $e->getTraceAsString();
            exit(0);
        }
        
        $one = $conf->getConfigValue('one');
        echo 'One:';
        var_dump($one);
        
        $two = $conf->getConfigValue('two');
        echo 'Two:';
        var_dump($two);
        
        $three = $conf->getConfigValue('three');
        echo 'Three:';
        var_dump($three);

        $colors = $conf->getConfigValue('colors');
        echo 'Colors:';
        var_dump($colors);
	}
}
Example2::main();
?>