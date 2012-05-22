<?php
require_once '../XJConf/XJConf.php';
use net\xjconf\DefinitionParser;
use net\xjconf\XmlParser;
error_reporting(E_ALL | E_STRICT);
require 'Registry.php';
/**
 * @author Stephan Schmidt <stephan.schmidt@schlund.de>
 */
class TestStaticClass
{

    public static function main()
    {
        $tagParser = new DefinitionParser();
        $defs = $tagParser->parse(getcwd() . '/xml/defines-static.xml');

        $conf = new XmlParser();
        $conf->setTagDefinitions($defs);

        try {
            $conf->parse(getcwd() . '/xml/test-static.xml');
        } catch (Exception $e) {
            throw $e;
            exit();
        }

        var_dump(Registry::export());
    }
}
TestStaticClass::main();
?>