<?php
/**
 * Integration test with TestCDataSetter.
 *
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  test_integration
 */
use net\xjconf\DefinitionParser;
use net\xjconf\XmlParser;
require_once EXAMPLES_DIR . '/Complex2.php';
/**
 * Integration test with TestCDataSetter.
 *
 * @package     XJConf
 * @subpackage  test_integration
 */
class TestCDataSetterTestCase extends UnitTestCase
{
    /**
     * test if setting cdata works
     */
    public function testCDataSetter()
    {
        $tagParser = new DefinitionParser();
        $defs      = $tagParser->parse(EXAMPLES_DIR . '/xml/defines-set-cdata.xml');
        
        $conf      = new XmlParser();
        $conf->setTagDefinitions($defs);
        $conf->parse(EXAMPLES_DIR . '/xml/test-set-cdata.xml');
        $this->assertEqual($conf->getConfigValue('complex')->render(), '<font color="red" size="15"></font>');
    }
}
?>