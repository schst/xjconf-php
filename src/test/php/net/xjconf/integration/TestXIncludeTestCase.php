<?php
/**
 * Integration test with TestXInclude.
 *
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  test_integration
 */
use net\xjconf\DefinitionParser;
use net\xjconf\XmlParser;
use net\xjconf\ext\xinc\XInclude;
require_once EXAMPLES_DIR . '/ColorPrimitives.php';
/**
 * Integration test with TestXInclude.
 *
 * @package     XJConf
 * @subpackage  test_integration
 */
class TestXIncludeTestCase extends UnitTestCase
{
    /**
     * test if xinclude works
     */
    public function testXInclude()
    {
        $tagParser = new DefinitionParser();
        $defs      = $tagParser->parse(EXAMPLES_DIR . '/xml/defines-primitives.xml');
        
        $conf      = new XmlParser();
        $conf->addExtension(new XInclude());
        $conf->setTagDefinitions($defs);
        $conf->parse(EXAMPLES_DIR . '/xml/test-xinclude.xml');
        $this->assertEqual($conf->getConfigValue('color')->getRGB(), '#643214');
        $this->assertEqual($conf->getConfigValue('color')->getName(), 'My color');
        $this->assertTrue($conf->getConfigValue('bool'));
        $this->assertEqual($conf->getConfigValue('zahl'), 453);
    }
}
?>