<?php
/**
 * Example that shows how to use a setter method that's dynamically
 * created from an attribute of a tag.
 *
 * @author  Stephan Schmidt <stephan.schmidt@schlund.de>
 */
require_once '../XJConf/XJConf.php';
use net\xjconf\DefinitionParser;
use net\xjconf\XmlParser;

require_once 'AnotherClass.php';
require_once 'MyClass.php';
require_once 'MyCollector.php';

/**
 * Example that shows how to use same classes with differant tags.
 *
 * @package     XJConf
 * @subpackage  examples
 */
class TestDynamicTypes
{
    public static function main()
    {
        $tagParser = new DefinitionParser();
        $defs      = $tagParser->parse(getcwd() . '/xml/defines-dynamic-types.xml');

        $conf      = new XmlParser();
        $conf->setTagDefinitions($defs);

        try {
            $conf->parse(getcwd() . '/xml/test-dynamic-types.xml');
        } catch (Exception $e) {
            echo $e->getMessage();
            var_dump($e->getTrace());
            exit(0);
        }

        $foo = $conf->getConfigValue('foo');
        var_dump($foo);
    }
}
TestDynamicTypes::main();
?>