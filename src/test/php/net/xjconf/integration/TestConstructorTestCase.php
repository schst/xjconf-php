<?php
/**
 * Integration test with TestConstructor.
 *
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  test_integration
 */
use net\xjconf\DefinitionParser;
use net\xjconf\XmlParser;
require_once EXAMPLES_DIR . '/ConstructorColor.php';
require_once EXAMPLES_DIR . '/CDataColor.php';
/**
 * Integration test with TestConstructor.
 *
 * @package     XJConf
 * @subpackage  test_integration
 */
class TestConstructorTestCase extends UnitTestCase
{
    /**
     * test if using a constructor works
     */
    public function testConstructor()
    {
        $tagParser = new DefinitionParser();
        $defs      = $tagParser->parse(EXAMPLES_DIR . '/xml/defines-constructor.xml');
        
        $conf      = new XmlParser();
        $conf->setTagDefinitions($defs);
        $conf->parse(EXAMPLES_DIR . '/xml/test-constructor.xml');
        $this->assertEqual($conf->getConfigValue('color')->getRed(), 100);
        $this->assertEqual($conf->getConfigValue('color')->getGreen(), 25);
        $this->assertEqual($conf->getConfigValue('color')->getBlue(), 10);
        
        $this->assertNull($conf->getConfigValue('color-no-atts')->getRed());
        $this->assertNull($conf->getConfigValue('color-no-atts')->getGreen());
        $this->assertNull($conf->getConfigValue('color-no-atts')->getBlue());
        
        $this->assertEqual($conf->getConfigValue('color2')->getRed(), 111);
        $this->assertEqual($conf->getConfigValue('color2')->getGreen(), 222);
        $this->assertEqual($conf->getConfigValue('color2')->getBlue(), 333);
        
        $this->assertEqual($conf->getConfigValue('color3')->getHex(), '#999999');
    }
}
?>