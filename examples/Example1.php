<?php
/**
 * First example to show how XJConf has to be used and what it does.
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
 * First example to show how XJConf has to be used and what it does.
 * 
 * @package     XJConf
 * @subpackage  examples
 */
class Example1
{

	public static function main()
	{
        $tagParser = new DefinitionParser();
        $defs      = $tagParser->parse(getcwd() . '/xml/defines.xml');

        echo 'Number of defined tags: ';
        var_dump($defs->countTagDefinitions());

        $conf = new XmlParser();
        try {
            $conf->setTagDefinitions($defs);
    
            $conf->parse(getcwd() . '/xml/test.xml');
        } catch (Exception $e) {
            echo $e->getTraceAsString();
            exit(0);
        }
        
        echo 'foo:';
        $foo = $conf->getConfigValue('foo');
        var_dump($foo);
        
        echo 'zahl:';
        $zahl = $conf->getConfigValue('zahl');
        var_dump($zahl);
        
        echo 'schst:';
        $schst = $conf->getConfigValue('schst');
        var_dump($schst->getString());
        
        echo 'complex:';
        $bar = $conf->getConfigValue('complex');
        var_dump($bar->render());
        
        echo 'complex2:';
        $bar2 = $conf->getConfigValue('complex2');
        var_dump($bar2->render());
        
        echo 'array:';
        $arr = $conf->getConfigValue('array');
        var_dump($arr);
        
        echo 'complex3:';
        // with default values
        $bar3 = $conf->getConfigValue('complex3');
        var_dump($bar3->render());
    }
}
Example1::main();
?>