<?php
/**
 * Example that shows how to use the cdata setter.
 *
 * @author  Stephan Schmidt <stephan.schmidt@schlund.de>
 * @author  Frank Kleine <mikey@xjconf.net>
 */
require_once '../XJConf/XJConf.php';
use net\xjconf\DefinitionParser;
use net\xjconf\XmlParser;
require 'Complex2.php';
/**
 * Example that shows how to use the cdata setter.
 *
 * @package     XJConf
 * @subpackage  examples
 */
class TestCDataSetter
{
    public static function main()
    {
        $tagParser = new DefinitionParser();
        $defs      = $tagParser->parse(getcwd() . '/xml/defines-set-cdata.xml');
        $conf      = new XmlParser();
        $conf->setTagDefinitions($defs);

        try {
            $conf->parse(getcwd() . '/xml/test-set-cdata.xml');
        } catch (Exception $e) {
            echo $e->getTraceAsString();
            exit(0);
        }

        $c = $conf->getConfigValue('complex');
        var_dump($c);
    }
}
TestCDataSetter::main();
?>