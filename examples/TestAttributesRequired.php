<?php
/**
 * Example that shows the effect of required attributes that have not been set.
 *
 * @author  Stephan Schmidt <stephan.schmidt@schlund.de>
 * @author  Frank Kleine <mikey@xjconf.net>
 */
require_once '../XJConf/XJConf.php';
use net\xjconf\DefinitionParser;
use net\xjconf\XmlParser;
require 'Color.php';
/**
 * Example that shows the effect of required attributes that have not been set.
 *
 * @package     XJConf
 * @subpackage  examples
 */
class TestAttributesRequired
{
    public static function main()
    {
        $tagParser = new DefinitionParser();
        $defs      = $tagParser->parse(getcwd() . '/xml/defines-attributes-required.xml');

        $conf      = new XmlParser();
        try {
            $conf->setTagDefinitions($defs);
            $conf->parse(getcwd() . '/xml/test-attributes-required.xml');
            $color = $conf->getConfigValue('red');
            var_dump($color);
        } catch (Exception $e) {
            echo 'Caught expected Exception with message: "' . $e->getMessage() . '", showing trace: ';
            var_dump($e->getTrace());
            exit(0);
        }
    }
}
TestAttributesRequired::main();
?>