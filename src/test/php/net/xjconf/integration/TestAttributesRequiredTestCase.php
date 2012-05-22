<?php
/**
 * Integration test with TestAttributesRequired.
 *
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  test_integration
 */
use net\xjconf\DefinitionParser;
use net\xjconf\XmlParser;
require_once EXAMPLES_DIR . '/Color.php';
/**
 * Integration test with TestAttributesRequired.
 *
 * @package     XJConf
 * @subpackage  test_integration
 */
class TestAttributesRequiredTestCase extends UnitTestCase
{
    /**
     * test that a non-set required attribute throws a MissingAttributeException
     */
    public function testAttributesRequired()
    {
        $tagParser = new DefinitionParser();
        $defs      = $tagParser->parse(EXAMPLES_DIR . '/xml/defines-attributes-required.xml');
        
        $conf      = new XmlParser();
        $conf->setTagDefinitions($defs);
        $this->expectException('net\xjconf\exceptions\MissingAttributeException');
        $conf->parse(EXAMPLES_DIR . '/xml/test-attributes-required.xml');
    }
}
?>