<?php
/**
 * Integration test with TestInterfaces.
 *
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  test_integration
 */
use net\xjconf\DefinitionParser;
use net\xjconf\XmlParser;
require_once EXAMPLES_DIR . '/MyClass.php';
/**
 * Integration test with TestInterfaces.
 *
 * @package     XJConf
 * @subpackage  test_integration
 */
class TestInterfacesTestCase extends UnitTestCase
{
    /**
     * test if same classes with differant tags works
     */
    public function testInterfaces()
    {
        $tagParser = new DefinitionParser();
        $defs      = $tagParser->parse(EXAMPLES_DIR . '/xml/defines-interfaces.xml');
        
        $conf      = new XmlParser();
        $conf->setTagDefinitions($defs);
        $conf->parse(EXAMPLES_DIR . '/xml/test-interfaces.xml');
        $this->assertIsA($conf->getConfigValue('foo'), 'MyClass');
        $this->assertIsA($conf->getConfigValue('foo')->getBar(), 'MyClass');
    }
}
?>