<?php
/**
 * Integration test with ExampleExtension.
 *
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  test_integration
 */
use net\xjconf\DefinitionParser;
use net\xjconf\XmlParser;
use net\xjconf\ext\Extension;
require_once EXAMPLES_DIR . '/MathExtension.php';
/**
 * Integration test with ExampleExtension.
 *
 * @package     XJConf
 * @subpackage  test_integration
 */
class ExampleExtensionTestCase extends UnitTestCase
{
    /**
     * test if extensions work
     */
    public function testExampleExtension()
    {
        $tagParser = new DefinitionParser();
        $defs      = $tagParser->parse(EXAMPLES_DIR . '/xml/defines-extension.xml');
        
        $conf      = new XmlParser();
        $extension = new MathExtension();
        $conf->addExtension($extension);
        $conf->setTagDefinitions($defs);
        $conf->parse(EXAMPLES_DIR . '/xml/test-extension.xml');
        
        $this->assertEqual($conf->getConfigValue('map'), array('foo' => 47, 'bar' => 138.5));
        $this->assertEqual($conf->getConfigValue('array'), array(138.5, 153.5321));
    }
}
?>