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

require_once 'DynamicSetterClass.php';

/**
 * Example that shows how to use same classes with differant tags.
 *
 * @package     XJConf
 * @subpackage  examples
 */
class TestDynamicSetters
{
    public static function main()
    {
        $tagParser = new DefinitionParser();
        $defs      = $tagParser->parse(getcwd() . '/xml/defines-dynamic-setters.xml');

        $conf      = new XmlParser();
        $conf->setTagDefinitions($defs);

        try {
            $conf->parse(getcwd() . '/xml/test-dynamic-setters.xml');
        } catch (Exception $e) {
            echo $e->getMessage();
            var_dump($e->getTrace());
            exit(0);
        }

        $foo = $conf->getConfigValue('class');
        var_dump($foo);
    }
}
TestDynamicSetters::main();
?>