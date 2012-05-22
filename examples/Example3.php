<?php
/**
 * Example that shows how to use differant namespaces with same tags.
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
 * Example that shows how to use differant namespaces with same tags.
 * 
 * @package     XJConf
 * @subpackage  examples
 */
class Example3
{

	public static function main()
	{
        $tagParser = new DefinitionParser();
        $defs      = $tagParser->parse(getcwd() . '/xml/defines3.xml');

        echo 'Defined namespaces: ';
        foreach ($defs->getDefinedNamespaces() as $namespace) {
            var_dump($namespace->getNamespaceURI());
        }

        $conf = new XmlParser();
        try {
            $conf->setTagDefinitions($defs);
    
            $conf->parse(getcwd() . '/xml/test3.xml');
        } catch (Exception $e) {
            echo $e->getTraceAsString();
            exit(0);
        }
        
        $zahl = $conf->getConfigValue('zahl');
        echo 'Zahl:';
        var_dump($zahl);
        
        $text = $conf->getConfigValue('text');
        echo 'Text:';
        var_dump($text);
	}
}
Example3::main();
?>