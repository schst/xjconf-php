<?php
require_once '../XJConf/XJConf.php';
use net\xjconf\DefinitionParser;
use net\xjconf\XmlParser;
error_reporting(E_ALL | E_STRICT);

require 'Dog.php';

/**
 * @author  Frank Kleine <mikey@xjconf.net>
 */
class Test__setImplicit
{

    public static function main()
    {

        $tagParser = new DefinitionParser();
        $defs = $tagParser->parse(getcwd() . '/xml/defines-__setImplicit.xml');

        $conf = new XmlParser();
        $conf->setTagDefinitions($defs);

        try {
            $conf->parse(getcwd() . '/xml/test-__set.xml');
        } catch (Exception $e) {
            throw $e;
            exit();
        }

        $dog = $conf->getConfigValue('dog');
        var_dump($dog->getProperties());
    }
}
Test__setImplicit::main();
?>