<?php
/**
 * Integration test with TestDynamicTypes.
 *
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  test_integration
 */
use net\xjconf\DefinitionParser;
use net\xjconf\XmlParser;
require_once EXAMPLES_DIR . '/AnotherClass.php';
require_once EXAMPLES_DIR . '/MyClass.php';
require_once EXAMPLES_DIR . '/MyCollector.php';
/**
 * Integration test with TestDynamicTypes.
 *
 * @package     XJConf
 * @subpackage  test_integration
 */
class TestDynamicTypesTestCase extends UnitTestCase
{
    /**
     * test if the same tag can be used with differant classes works
     */
    public function testDynamicTypes()
    {
        $tagParser = new DefinitionParser();
        $defs      = $tagParser->parse(EXAMPLES_DIR . '/xml/defines-dynamic-types.xml');
        
        $conf      = new XmlParser();
        $conf->setTagDefinitions($defs);
        $conf->parse(EXAMPLES_DIR . '/xml/test-dynamic-types.xml');
        $bar = $conf->getConfigValue('foo')->getBar();
        $this->assertIsA($bar[0], 'MyClass');
        $this->assertIsA($bar[1], 'AnotherClass');
    }
}
?>