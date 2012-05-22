<?php
require_once '../XJConf/XJConf.php';
use net\xjconf\DefinitionParser;
use net\xjconf\XmlParser;
error_reporting(E_ALL | E_STRICT);

require 'EmptyConstructorClass.php';
/**
 * @author Stephan Schmidt <stephan.schmidt@schlund.de>
 */
class TestEmptyConstructor
{

    public static function main() {
        $tagParser = new DefinitionParser();
        $defs = $tagParser->parse(getcwd() . '/xml/defines-empty-constructor.xml');

        $conf = new XmlParser();
        $conf->setTagDefinitions($defs);

        try {
            $conf->parse(getcwd() . '/xml/test-empty-constructor.xml');
        } catch (Exception $e) {
            throw $e;
            exit();
        }

        $foo = $conf->getConfigValue('foo');
        echo 'This should be null: ';
        var_dump($foo->getDataFromConstructor());
    }
}
TestEmptyConstructor::main();
?>