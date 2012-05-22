<?php
/**
 * Example that shows how to call methods on objects
 *
 * @author  Stephan Schmidt <schst@xjconf.net>
 */

require_once '../XJConf/XJConf.php';
use net\xjconf\DefinitionParser;
use net\xjconf\XmlParser;

class Properties {
    protected $props = array();

    public function setProperty($name, $value) {
        $this->props[$name] = $value;
    }
}

$tagParser = new DefinitionParser();
$defs = $tagParser->parse(getcwd() . '/xml/defines-method.xml');

$conf = new XmlParser();
$conf->setTagDefinitions($defs);

$conf->parse(getcwd() . '/xml/test-method.xml');

print_r($conf->getConfigValue('props'));
?>