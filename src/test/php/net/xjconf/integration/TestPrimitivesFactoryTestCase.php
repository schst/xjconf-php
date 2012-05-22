<?php
/**
 * Integration test with TestPrimitivesFactory.
 *
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  test_integration
 */
use net\xjconf\DefinitionParser;
use net\xjconf\XmlParser;
require_once EXAMPLES_DIR . '/ColorPrimitives.php';
require_once EXAMPLES_DIR . '/ColorPrimitivesFactory.php';
/**
 * Integration test with TestPrimitivesFactory.
 *
 * @package     XJConf
 * @subpackage  test_integration
 */
class TestPrimitivesFactoryTestCase extends UnitTestCase
{
    /**
     * test if factory method works
     */
    public function testPrimitivesFactory()
    {
        $tagParser = new DefinitionParser();
        $defs      = $tagParser->parse(EXAMPLES_DIR . '/xml/defines-primitives-factory.xml');
        
        $conf      = new XmlParser();
        $conf->setTagDefinitions($defs);
        $conf->parse(EXAMPLES_DIR . '/xml/test-primitives.xml');
        $this->assertEqual($conf->getConfigValue('color')->getRGB(), '#643214');
        $this->assertEqual($conf->getConfigValue('color')->getName(), 'My color');
        $this->assertTrue($conf->getConfigValue('bool'));
        $this->assertEqual($conf->getConfigValue('zahl'), 453);
    }
}
?>