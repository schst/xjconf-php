<?php
/**
 * Integration test with TestStaticClass.
 *
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  test_integration
 */
use net\xjconf\DefinitionParser;
use net\xjconf\XmlParser;
require_once EXAMPLES_DIR . '/Registry.php';
/**
 * Integration test with TestStaticClass.
 *
 * @package     XJConf
 * @subpackage  test_integration
 */
class TestStaticClassTestCase extends UnitTestCase
{
    /**
     * test if setting values of a static class works
     */
    public function testStaticClass()
    {
        $tagParser = new DefinitionParser();
        $defs      = $tagParser->parse(EXAMPLES_DIR . '/xml/defines-static.xml');
        
        $conf      = new XmlParser();
        $conf->setTagDefinitions($defs);
        $conf->parse(EXAMPLES_DIR . '/xml/test-static.xml');
        $values = Registry::export();
        $this->assertEqual($values, array('foo' => 'This has been set statically!', 'bar' => 2536));
    }
}
?>