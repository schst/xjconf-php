<?php
require_once '../XJConf/XJConf.php';
use net\xjconf\DefinitionParser;
use net\xjconf\XmlParser;
error_reporting(E_ALL | E_STRICT);

require 'ColorPrimitives.php';
/**
 * @author Stephan Schmidt <stephan.schmidt@schlund.de>
 */
class TestPrimitives
{

    public static function main()
    {

        $tagParser = new DefinitionParser();
        $defs = $tagParser->parse(getcwd() . '/xml/defines-primitives.xml');

        $conf = new XmlParser();
        $conf->setTagDefinitions($defs);

        try {
            $conf->parse(getcwd() . '/xml/test-primitives.xml');
        } catch (Exception $e) {
            throw $e;
            exit();
        }

        $color = $conf->getConfigValue('color');
        echo $color->getRGB();
        var_dump($color);

        var_dump($conf->getConfigValue('bool'));
        var_dump($conf->getConfigValue('zahl'));

    }
}
TestPrimitives::main();
?>