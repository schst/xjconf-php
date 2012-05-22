<?php
/**
 * Example that shows the differant ways of using the constructor definitions.
 * 
 * @author  Stephan Schmidt <stephan.schmidt@schlund.de>
 * @author  Frank Kleine <mikey@xjconf.net>
 */
require_once '../XJConf/XJConf.php';
use net\xjconf\DefinitionParser;
use net\xjconf\XmlParser;
require 'ConstructorColor.php';
require 'CDataColor.php';
/**
 * Example that shows the differant ways of using the constructor definitions.
 * 
 * @package     XJConf
 * @subpackage  examples
 */
class TestConstructor
{
    public static function main()
    {
        $tagParser = new DefinitionParser();
        $defs      = $tagParser->parse(getcwd() . '/xml/defines-constructor.xml');

        $conf      = new XmlParser();
        $conf->setTagDefinitions($defs);

        try {
            $conf->parse(getcwd() . '/xml/test-constructor.xml');
        } catch (Exception $e) {
            echo $e->getTraceAsString();
            exit(0);
        }
        
        $color = $conf->getConfigValue('color');
        var_dump($color);
        $color = $conf->getConfigValue('color-no-atts');
        var_dump($color);
        $color = $conf->getConfigValue('color2');
        var_dump($color);
        $color = $conf->getConfigValue('color3');
        var_dump($color);
    }
}
TestConstructor::main();
?>