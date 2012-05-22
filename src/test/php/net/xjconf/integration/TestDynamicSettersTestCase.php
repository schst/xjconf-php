<?php
/**
 * Integration test with TestDynamicSetters.
 *
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  test_integration
 */
use net\xjconf\DefinitionParser;
use net\xjconf\XmlParser;
require_once EXAMPLES_DIR . '/DynamicSetterClass.php';
/**
 * Integration test with TestDynamicSetters.
 *
 * @package     XJConf
 * @subpackage  test_integration
 */
class TestDynamicSettersTestCase extends UnitTestCase
{
    /**
     * test if using dynamic setters works
     */
    public function testDynamicSetters()
    {
        $tagParser = new DefinitionParser();
        $defs      = $tagParser->parse(EXAMPLES_DIR . '/xml/defines-dynamic-setters.xml');
        
        $conf      = new XmlParser();
        $conf->setTagDefinitions($defs);
        $conf->parse(EXAMPLES_DIR . '/xml/test-dynamic-setters.xml');
        $this->assertEqual($conf->getConfigValue('class')->getFoo(), 'Use setFoo()');
        $this->assertEqual($conf->getConfigValue('class')->getBar(), 'Use setBar()');
    }
}
?>