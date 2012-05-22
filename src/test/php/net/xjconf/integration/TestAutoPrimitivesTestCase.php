<?php
/**
 * Integration test with TestAutoPrimitives.
 *
 * @author      Stephan Schmidt <schst@xjconf.net>
 * @package     XJConf
 * @subpackage  test_integration
 */
use net\xjconf\DefinitionParser;
use net\xjconf\XmlParser;
/**
 * Integration test with TestPrimitives.
 *
 * @package     XJConf
 * @subpackage  test_integration
 */
class TestAutoPrimitivesTestCase extends UnitTestCase
{
    /**
     * test if primitives and keyAttribute works
     */
    public function testAutoPrimitives()
    {
        $tagParser = new DefinitionParser();
        $defs      = $tagParser->parse(EXAMPLES_DIR . '/xml/defines-auto-primitives.xml');

        $conf      = new XmlParser();
        $conf->setTagDefinitions($defs);
        $conf->parse(EXAMPLES_DIR . '/xml/test-auto-primitives.xml');

        $this->assertIdentical($conf->getConfigValue('string'), 'string');
        $this->assertIdentical($conf->getConfigValue('integer'), 42);
        $this->assertIdentical($conf->getConfigValue('double'), 42.564);
        $this->assertTrue($conf->getConfigValue('bool-true'));
        $this->assertFalse($conf->getConfigValue('bool-false'));
        $this->assertNull($conf->getConfigValue('null'));
    }
}
?>