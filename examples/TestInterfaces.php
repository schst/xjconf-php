<?php
/**
 * Example that shows how to use same classes with differant tags.
 * 
 * @author  Stephan Schmidt <stephan.schmidt@schlund.de>
 * @author  Frank Kleine <mikey@xjconf.net>
 */
require_once '../XJConf/XJConf.php';
use net\xjconf\DefinitionParser;
use net\xjconf\XmlParser;
require 'MyClass.php';
/**
 * Example that shows how to use same classes with differant tags.
 * 
 * @package     XJConf
 * @subpackage  examples
 */
class TestInterfaces
{
    public static function main()
    {
        $tagParser = new DefinitionParser();
        $defs      = $tagParser->parse(getcwd() . '/xml/defines-interfaces.xml');

        $conf      = new XmlParser();
        $conf->setTagDefinitions($defs);

        try {
            $conf->parse(getcwd() . '/xml/test-interfaces.xml');
        } catch (Exception $e) {
            echo $e->getMessage();
            var_dump($e->getTrace());
            exit(0);
        }
        
        $foo = $conf->getConfigValue('foo');
        var_dump($foo);
        var_dump($foo->getBar());
    }
}
TestInterfaces::main();
?>