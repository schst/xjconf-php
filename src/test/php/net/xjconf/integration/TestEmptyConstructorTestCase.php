<?php
/**
 * Integration test with TestEmptyConstructor.
 *
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  test_integration
 */
use net\xjconf\DefinitionParser;
use net\xjconf\XmlParser;
require_once EXAMPLES_DIR . '/EmptyConstructorClass.php';
/**
 * Integration test with TestEmptyConstructor.
 *
 * @package     XJConf
 * @subpackage  test_integration
 */
class TestEmptyConstructorTestCase extends UnitTestCase
{
    /**
     * test if empty constructor works
     */
    public function testEmptyConstructor()
    {
        $tagParser = new DefinitionParser();
        $defs      = $tagParser->parse(EXAMPLES_DIR . '/xml/defines-empty-constructor.xml');
        
        $conf      = new XmlParser();
        $conf->setTagDefinitions($defs);
        $conf->parse(EXAMPLES_DIR . '/xml/test-empty-constructor.xml');
        $this->assertNull($conf->getConfigValue('foo')->getDataFromConstructor());
    }
}
?>